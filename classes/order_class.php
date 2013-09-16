<?php
/**
 * @copyright (c) 2011 jooyea.cn
 * @file Order_Class.php
 * @brief 订单中相关的
 * @author relay
 * @date 2011-02-24
 * @version 0.6
 */
class Order_Class
{
	/**
	 * 添加评论商品的机会
	 * @param $order_id 订单ID
	 */
	public static function addGoodsCommentChange($order_id)
	{
		//获取订单对象
		$orderDB  = new IModel('order');
		$orderRow = $orderDB->getObj('id = '.$order_id);

		//获取此订单中的商品种类
		$orderGoodsDB        = new IQuery('order_goods');
		$orderGoodsDB->where = 'order_id = '.$order_id;
		$orderGoodsDB->group = 'goods_id';
		$orderList           = $orderGoodsDB->find();

		//可以允许进行商品评论
		$commentDB = new IModel('comment');

		//对每类商品进行评论开启
		foreach($orderList as $val)
		{
			$attr = array(
				'goods_id' => $val['goods_id'],
				'order_no' => $orderRow['order_no'],
				'user_id'  => $orderRow['user_id'],
				'time'     => date('Y-m-d H:i:s')
			);
			$commentDB->setData($attr);
			$commentDB->add();
		}
	}

	/**
	 * 支付成功后修改订单状态
	 * @param $orderNo  string 订单编号
	 * @param $admin_id int    管理员ID
	 * @param $note     string 收款的备注
	 * @return false or int order_id
	 */
	public static function updateOrderStatus($orderNo,$admin_id = '',$note = '')
	{
		//获取订单信息
		$orderObj  = new IModel('order');
		$orderRow  = $orderObj->getObj('order_no = "'.$orderNo.'"');

		if(empty($orderRow))
		{
			return false;
		}

		if($orderRow['pay_status'] == 1)
		{
			return $orderRow['id'];
		}
		else if($orderRow['pay_status'] == 0)
		{
			$dataArray = array(
				'status'     => 2,
				'pay_time'   => ITime::getDateTime(),
				'pay_status' => 1,
			);
			$orderObj->setData($dataArray);
			$is_success = $orderObj->update('order_no = "'.$orderNo.'"');
			if($is_success == '')
			{
				return false;
			}

			//删除订单中使用的道具
			$ticket_id = trim($orderRow['prop']);
			if($ticket_id != '')
			{
				$propObj  = new IModel('prop');
				$propData = array('is_userd' => 1);
				$propObj->setData($propData);
				$propObj->update('id = '.$ticket_id);
			}

			if(intval($orderRow['user_id']) != 0)
			{
				$user_id = $orderRow['user_id'];

				//获取用户信息
				$memberObj  = new IModel('member');
				$memberRow  = $memberObj->getObj('user_id = '.$user_id,'prop,group_id');

				//(1)删除订单中使用的道具
				if($ticket_id != '')
				{
					$finnalTicket = str_replace(','.$ticket_id.',',',',','.trim($memberRow['prop'],',').',');
					$memberData   = array('prop' => $finnalTicket);
					$memberObj->setData($memberData);
					$memberObj->update('user_id = '.$user_id);
				}

				if($memberRow)
				{
					//(2)进行促销活动奖励
			    	$proObj = new ProRule($orderRow['real_amount']);
			    	$proObj->setUserGroup($memberRow['group_id']);
			    	$proObj->setAward($user_id);

			    	//(3)增加经验值
			    	$memberData = array(
			    		'exp'   => 'exp + '.$orderRow['exp'],
			    	);
					$memberObj->setData($memberData);
					$memberObj->update('user_id = '.$user_id,'exp');

					//(4)增加积分
					$pointConfig = array(
						'user_id' => $user_id,
						'point'   => $orderRow['point'],
						'log'     => '成功购买了订单号：'.$orderRow['order_no'].'中的商品,奖励积分'.$orderRow['point'],
					);
					$pointObj = new Point();
					$pointObj->update($pointConfig);
				}
			}

			//插入收款单
			$collectionDocObj = new IModel('collection_doc');
			$collectionData   = array(
				'order_id'   => $orderRow['id'],
				'user_id'    => $orderRow['user_id'],
				'amount'     => $orderRow['order_amount'],
				'time'       => ITime::getDateTime(),
				'payment_id' => $orderRow['pay_type'],
				'pay_status' => 1,
				'if_del'     => 0,
				'note'       => $note,
				'admin_id'   => $admin_id ? $admin_id : 0
			);

			$collectionDocObj->setData($collectionData);
			$collectionDocObj->add();

			/*同步数据*/
			//同步团购的数据
			if($orderRow['type'] == 1)
			{
				$regimentUserObj = new IModel('regiment_user_relation');
				$regimentUserObj->setData(array('is_over' => 1));
				$regimentUserObj->update("order_no = '".$orderRow['order_no']."'");
			}

			//更改购买商品的库存数量
			Block::updateStore($orderRow['id'] , 'reduce');

			return $orderRow['id'];
		}
		else
		{
			return false;
		}
	}

	/**
	 * @brief 获取订单基本数据资料
	 * @param $order_id int 订单的id
	 * @return array()
	 */
	public function getOrderShow($order_id)
	{
		$data = array();

		//获得对象
		$tb_order = new IModel('order');
 		$data = $tb_order->getObj('id='.$order_id);
 		if($data)
 		{
	 		$data['order_id'] = $order_id;

	 		//获取配送方式
	 		$tb_delivery = new IModel('delivery');
	 		$delivery_info = $tb_delivery->getObj('id='.$data['distribution']);
	 		if($delivery_info)
	 		{
	 			$data['delivery'] = $delivery_info['name'];
	 		}

	 		//获取支付方式
	 		$tb_payment = new IModel('payment');
	 		$payment_info = $tb_payment->getObj('id='.$data['pay_type']);
	 		if($payment_info)
	 		{
	 			$data['payment'] = $payment_info['name'];
	 		}

	 		//获取商品总重量和总金额
	 		$tb_order_goods = new IModel('order_goods');
	 		$order_goods_info = $tb_order_goods->query('order_id='.$order_id);
	 		$data['goods_amount'] = 0;
	 		$data['goods_weight'] = 0;

	 		if($order_goods_info)
	 		{
	 			foreach ($order_goods_info as $value)
	 			{
	 				$data['goods_amount'] += $value['real_price']   * $value['goods_nums'];
	 				$data['goods_weight'] += $value['goods_weight'] * $value['goods_nums'];
	 			}
	 		}

	 		//获取用户信息
	 		$query = new IQuery('user as u');
	 		$query->join = ' left join member as m on u.id=m.user_id ';
	 		$query->fields = 'u.username,u.email,m.mobile,m.contact_addr,m.true_name';
	 		$query->where = 'u.id='.$data['user_id'];
	 		$user_info = $query->find();
	 		if($user_info)
	 		{
	 			$user_info = $user_info[0];
	 			$data['username']     = $user_info['username'];
	 			$data['email']        = $user_info['email'];
	 			$data['u_mobile']     = $user_info['mobile'];
	 			$data['contact_addr'] = $user_info['contact_addr'];
	 			$data['true_name']    = $user_info['true_name'];
	 		}
 		}
 		return $data;
	}

	/**
	 * 获取订单信息
	 * @param $orderIdString string 订单ID序列
	 */
	public function getOrderInfo($orderIdString)
	{
		$orderObj    = new IModel('order');
		$areaIdArray = array();
		$orderList   = $orderObj->query('id in ('.$orderIdString.')');
		foreach($orderList as $val)
		{
			$areaIdArray[] = $val['province'];
			$areaIdArray[] = $val['city'];
			$areaIdArray[] = $val['area'];
		}
		$areaIdArray = array_unique($areaIdArray);

		$areaObj  = new IModel('areas');
		$areaList = $areaObj->query('area_id in ('.join(",",$areaIdArray).')');
		$areaData = array();

		foreach($areaList as $val)
		{
			$areaData[$val['area_id']] = $val['area_name'];
		}

		foreach($orderList as $key => $val)
		{
			$orderList[$key]['province_str'] = $areaData[$val['province']];
			$orderList[$key]['city_str']     = $areaData[$val['city']];
			$orderList[$key]['area_str']     = $areaData[$val['area']];
		}

		return $orderList;
	}

	//判断变量是数组还是单个变量
	public static function getWhere($id)
	{
		if(is_array($id) && isset($id[0]) && $id[0]!='')
		{
			$id = join(',',$id);
			$where = ' id in ('.$id.')';
		}
		else
		{
			$where = 'id = '.$id;
		}
		return $where;
	}

	/**
	 * @brief 把订单商品同步到order_goods表中
	 * @param $order_id 订单ID
	 * @param $goodsInfo 商品和货品信息（购物车数据结构,countSum 最终生成的格式）
	 */
	public function insertOrderGoods($order_id,$goodsResult = array())
	{
		$orderGoodsObj = new IModel('order_goods');

		//清理旧的关联数据
		$orderGoodsObj->del('order_id = '.$order_id);

		$goodsArray = array(
			'order_id' => $order_id
		);

		$findType = array('goods'=>'goodsList','product'=>'productList');

		foreach($findType as $key => $list)
		{
			if(isset($goodsResult[$list]) && count($goodsResult[$list]) > 0)
			{
				foreach($goodsResult[$list] as $k => $val)
				{
					//拼接商品名称和规格数据
					$specArray = array('name' => $val['name'],'value' => '');
					if($key == 'product')
					{
						$goodsArray['product_id']  = $val['id'];
						$goodsArray['goods_id']    = $val['goods_id'];

						$spec = block::show_spec($val['spec_array']);
						foreach($spec as $skey => $svalue)
						{
							$specArray['value'] .= $skey.':'.$svalue.' , ';
						}
					}
					else
					{
						$goodsArray['goods_id']  = $val['id'];
						$goodsArray['product_id']= 0;
					}
					$specArray = serialize($specArray);
					$goodsArray['goods_price'] = $val['sell_price'];
					$goodsArray['real_price']  = $val['sell_price'] - $val['reduce'];
					$goodsArray['goods_nums']  = $val['count'];
					$goodsArray['goods_weight']= $val['weight'];
					$goodsArray['goods_array'] = $specArray;
					$orderGoodsObj->setData($goodsArray);
					$orderGoodsObj->add();
				}
			}
		}
	}
}