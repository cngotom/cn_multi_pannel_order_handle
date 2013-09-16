<?php
/**
 * @brief 公共模块
 * @class Block
 */
class Block extends IController
{
	public $layout='';

	public function init()
	{
		$checkObj = new CheckRights($this);
		$checkObj->checkUserRights();
	}

	/**
	 * 生成商品货号
	 */
	public static function createGoodsNo()
	{
		$config = new Config('site_config');
		return $config->goods_no_pre.time().rand(10,99);
	}

 	/**
	 * @brief Ajax获取规格值
	 */
	function spec_value_list()
	{
		// 获取POST数据
		$spec_id = IFilter::act( IReq::get('id') );

		//初始化spec商品模型规格表类对象
		$specObj = new IModel('spec');
		//根据规格编号 获取规格详细信息
		$specData = $specObj->getObj("id = $spec_id");
		if($specData)
		{
			echo JSON::encode($specData);
		}
		else
		{
			//返回失败标志
			echo '';
		}
	}

	//列出筛选商品
	function goods_list()
	{
		//商品检索条件
		$show_num    = IFilter::act( IReq::get('show_num'),'int');
		$keywords    = IFilter::act( IReq::get('keywords') );
		$cat_id      = IFilter::act( IReq::get('category_id'),'int' );
		$min_price   = IFilter::act( IReq::get('min_price'),'float' );
		$max_price   = IFilter::act( IReq::get('max_price'),'float' );
		$goods_no    = IFilter::act( IReq::get('goods_no') );
		$is_products = IFilter::act( IReq::get('is_products'),'int' );

		//查询条件
		$where      = 'go.is_del = 0';
		$table_name = 'goods as go';
		$fields     = 'go.id as goods_id,go.small_img,go.name,go.list_img,go.img,go.store_nums';

		//分类筛选
		if($cat_id)
		{
			$table_name .= ' ,category_extend as ca ';
			$where      .= " and ca.category_id = {$cat_id} and go.id = ca.goods_id ";
		}

		//货品存在
		if($is_products)
		{
			$fields     .= ' ,pro.id as product_id,pro.products_no as goods_no,pro.spec_array,pro.sell_price';
			$table_name .= ' ,products as pro ';
			$where      .= ' and pro.goods_id = go.id and go.spec_array != "" ';

			$where      .= $goods_no  ? ' and pro.goods_no     = "'.$goods_no.'"' : '';
			$where      .= $min_price ? ' and pro.sell_price  >= '.$min_price     : '';
			$where      .= $max_price ? ' and pro.sell_price  <= '.$max_price     : '';
		}
		else
		{
			$fields     .= ' ,go.goods_no,go.sell_price';
			$where      .= ' and go.spec_array = "" ';
			$where      .= $goods_no  ? ' and go.goods_no     = "'.$goods_no.'"' : '';
			$where      .= $min_price ? ' and go.sell_price  >= '.$min_price     : '';
			$where      .= $max_price ? ' and go.sell_price  <= '.$max_price     : '';
		}
		$where.= $keywords  ? ' and go.name like "%'.$keywords.'%"': '';

		$goodsDB    = new IModel($table_name);
		$this->data = $goodsDB->query($where,$fields,'go.id','desc',$show_num);
		$this->type = IReq::get('type');
		$this->redirect('goods_list');
	}
	/**
	 * @brief 获取地区
	 */
	public function area_child()
	{
		$parent_id = intval(IReq::get("aid"));
		$areaDB    = new IModel('areas');
		$data      = $areaDB->query("parent_id=$parent_id",'*','sort','asc');
		echo JSON::encode($data);
	}

    //[公共方法]通过解析products表中的spec_array转化为格式：key:规格名称;value:规格值
    public static function show_spec($specJson)
    {
    	$specArray = JSON::decode($specJson);
    	$spec      = array();

    	foreach($specArray as $val)
    	{
    		if($val['type'] == 1)
    		{
    			$spec[$val['name']] = $val['value'];
    		}
    		else
    		{
    			$spec[$val['name']] = '<img src="'.IUrl::creatUrl().$val['value'].'" class="img_border" style="width:15px;height:15px;" />';
    		}
    	}
    	return $spec;
    }

	//商品分类,等级共分为3级
	static function goods_category()
	{
		//获取商品分类缓存
		$cacheObj  = new ICache('file');
		$catResult = $cacheObj->get('goodsCategory');
		if($catResult)
		{
			return $catResult;
		}

		$catResult = array();
		$catObj    = new IModel('category');
		$catFirst  = $catObj->query('parent_id = 0','id,name,parent_id,visibility','sort','asc');
		$catOther  = $catObj->query('parent_id != 0','id,name,parent_id,visibility','sort','asc');

		foreach($catFirst as $first_key => $first)
		{
			foreach($catOther as $other_key => $other_val)
			{
				if($first['id'] == $other_val['parent_id'])
				{
					//拼接二级分类
					$first['second'][$other_key] = $other_val;

					//拼接二级以下所有分类
					$catMore = array();
					self::recursion_goods_category($other_val,$catOther,$catObj,$catMore);
					$first['second'][$other_key]['more'] = $catMore;
				}
			}

			$catResult[] = $first;
		}

		//写入缓存
		$cacheObj->set('goodsCategory',$catResult);
		return $catResult;
	}

	//递归获取分类
	static function recursion_goods_category($data,$catOther,$catObj,&$catMore = '')
	{
		if(!empty($data) && !empty($catOther))
		{
			foreach($catOther as $okey => $oval)
			{
				if($data['id'] == $oval['parent_id'])
				{
					unset($catOther[$okey]);
					$catMore[] = $oval;
					self::recursion_goods_category($oval,$catOther,$catObj,$catMore);
				}
			}
		}
	}

	//根据总分类查找所需分类的树结构
	public static function getCatTree($catList,$catId = '')
	{
		if(intval($catId) != 0)
		{
			foreach($catList as $firstKey => $firstVal)
			{
				if($firstVal['id'] == $catId)
				{
					return $catList[$firstKey];
				}
				else
				{
					if(!empty($firstVal['second']))
					{
						foreach($firstVal['second'] as $secondKey => $secondVal)
						{
							if($secondVal['id'] == $catId)
							{
								return $catList[$firstKey];
							}
							else
							{
								if(!empty($secondVal['more']))
								{
									foreach($secondVal['more'] as $moreKey => $moreVal)
									{
										if($moreVal['id'] == $catId)
										{
											return $catList[$firstKey];
										}
									}
								}
							}
						}
					}
				}
			}
		}
		return array();
	}

	//[条件检索url处理]对于query url中已经存在的数据进行删除;没有的参数进行添加
	public static function searchUrl($queryKey,$queryVal = '')
	{
		if(is_array($queryKey))
		{
			$concatStr = '';
			$fromStr   = array();
			$toStr     = array();

			foreach($queryKey as $k => $v)
			{
				$urlVal  = IReq::get($v);
				$tempVal = isset($queryVal[$k]) ? $queryVal[$k] : $queryVal;

				if($urlVal === null)
				{
					$concatStr.='&'.$v.'='.$tempVal;
				}
				else
				{
					$fromStr[] = '&'.$v.'='.$urlVal;
					$toStr[]   = '&'.$v.'='.$tempVal;
				}
			}
			return str_replace($fromStr,$toStr,'?'.$_SERVER['QUERY_STRING']).$concatStr;
		}
		else
		{
			/*URL变量 arg[key] 格式支持
			 *由于在 URL get方式传参时系统会把变量 arg[key] 直接判定为数组
			 *所以这里需要对此类参数进行特殊处理;
			 */
			preg_match('|(\w+)\[(\d+)\]|',$queryKey,$match);
			$urlVal = null;

			if(isset($match[2]))
			{
				$urlArray = IReq::get($match[1]);
				if(isset($urlArray[$match[2]]))
				{
					$urlVal = $urlArray[$match[2]];
				}
			}
			//考虑列表排序按钮的效果
			else
			{
				$urlVal = IReq::get($queryKey);
			}

			if($urlVal === null && $queryVal !== '')
			{
				return '?'.$_SERVER['QUERY_STRING'].'&'.$queryKey.'='.urlencode($queryVal);
			}
			else
			{
				$fromStr = '&'.$queryKey.'='.urlencode($urlVal);
				if($queryVal === '')
				{
					$toStr   = '';
				}
				else
				{
					$toStr   = '&'.$queryKey.'='.urlencode($queryVal);
				}
				return IFilter::act(str_replace($fromStr,$toStr,'?'.$_SERVER['QUERY_STRING']),'text');
			}
		}
	}
	/**
	 * @brief 获得配送方式ajax
	 */
	public function order_delivery()
    {
    	$province     = IFilter::act(IReq::get("province"),'int');
    	$weight       = IFilter::act(IReq::get('total_weight'),'float');
    	$goodsSum     = IFilter::act(IReq::get('goodsSum'),'float');
    	$distribution = IFilter::act(IReq::get("distribution"),'int');

    	//调入数据，获得配送方式结果
    	$data = Delivery::getDelivery($province,$weight,$goodsSum);

    	if($distribution)
    	{
    		echo JSON::encode($data[$distribution]);
    	}
    	else
    	{
    		echo JSON::encode($data);
    	}
    }
	/**
    * @brief 【重要】进行支付支付方法
    */
	public function doPay()
	{
		//获得相关参数
		$order_id   = IFilter::act(IReq::get('order_id'),'int');
		$recharge   = IReq::get('recharge');
		$payment_id = IFilter::act(IReq::get('payment_id'),'int');

		if($order_id)
		{
			//获取订单信息
			$orderDB  = new IModel('order');
			$orderRow = $orderDB->getObj('id = '.$order_id);

			if(empty($orderRow))
			{
				IError::show(403,'要支付的订单信息不存在');
			}
			$payment_id = $orderRow['pay_type'];
		}

		//获取支付方式类库
		$paymentInstance = Payment::createPaymentInstance($payment_id);

		//在线充值
		if($recharge !== null)
		{
			$paymentRow = Payment::getPaymentById($payment_id);

			//account:充值金额; paymentName:支付方式名字
			$reData   = array('account' => $recharge , 'paymentName' => $paymentRow['name']);
			$sendData = $paymentInstance->getSendData(Payment::getPaymentInfo($payment_id,'recharge',$reData));
		}
		//订单支付
		else if($order_id != 0)
		{
			$sendData = $paymentInstance->getSendData(Payment::getPaymentInfo($payment_id,'order',$order_id));
		}
		else
		{
			IError::show(403,'发生支付错误');
		}

		$this->paymentInstance = $paymentInstance;
		$this->sendData        = $sendData;
		$this->redirect('hidden_form',false);
	}

	/**
     * @brief 【重要】支付回调[同步]
	 */
	public function callback()
	{
		//从URL中获取支付方式
		$payment_id      = IFilter::act(IReq::get('_id'),'int');
		$paymentInstance = Payment::createPaymentInstance($payment_id);

		if(!is_object($paymentInstance))
		{
			IError::show(403,'支付方式不存在');
		}

		//初始化参数
		$money   = '';
		$message = '支付失败';
		$orderNo = '';

		//执行接口回调函数
		$callbackData = array_merge($_POST,$_GET);
		unset($callbackData['controller']);
		unset($callbackData['action']);
		unset($callbackData['_id']);
		$return = $paymentInstance->callback($callbackData,$payment_id,$money,$message,$orderNo);

		//支付成功
		if($return == 1)
		{
			//充值方式
			if(stripos($orderNo,'recharge_') !== false)
			{
				$tradenoArray = explode('_',$orderNo);
				$recharge_no  = isset($tradenoArray[1]) ? $tradenoArray[1] : 0;
				if(payment::updateRecharge($recharge_no))
				{
					$this->redirect('/site/success/message/'.urlencode("充值成功").'/?callback=/ucenter/account_log');
					exit;
				}
				IError::show(403,'充值失败');
			}
			else
			{
				$order_id = Order_Class::updateOrderStatus($orderNo);
				if($order_id)
				{
					$url  = '/site/success/message/'.urlencode("支付成功");
					$url .= ISafe::get('user_id') ? '/?callback=/ucenter/order_detail/id/'.$order_id : '';
					$this->redirect($url);
					exit;
				}
				IError::show(403,'订单修改失败');
			}
		}
		//支付失败
		else
		{
			$message = $message ? $message : '支付失败';
			IError::show(403,$message);
		}
	}

	/**
     * @brief 【重要】支付回调[异步]
	 */
	function server_callback()
	{
		//从URL中获取支付方式
		$payment_id      = IFilter::act(IReq::get('_id'),'int');
		$paymentInstance = Payment::createPaymentInstance($payment_id);

		if(!is_object($paymentInstance))
		{
			die('fail');
		}

		//初始化参数
		$money   = '';
		$message = '支付失败';
		$orderNo = '';

		//执行接口回调函数
		$callbackData = array_merge($_POST,$_GET);
		unset($callbackData['controller']);
		unset($callbackData['action']);
		unset($callbackData['_id']);
		$return = $paymentInstance->callback($callbackData,$payment_id,$money,$message,$orderNo);

		//支付成功
		if($return == 1)
		{
			//充值方式
			if(stripos($orderNo,'recharge_') !== false)
			{
				$tradenoArray = explode('_',$orderNo);
				$recharge_no  = isset($tradenoArray[1]) ? $tradenoArray[1] : 0;
				if(payment::updateRecharge($recharge_no))
				{
					$paymentInstance->notifyStop();
					exit;
				}
			}
			else
			{
				$order_id = Order_Class::updateOrderStatus($orderNo);
				if($order_id)
				{
					$paymentInstance->notifyStop();
					exit;
				}
			}
		}
		//支付失败
		else
		{
			$paymentInstance->notifyStop();
			exit;
		}
	}

	/**
    * @brief 根据省份名称查询相应的privice
    */
	public function searchPrivice()
	{
		$province = IFilter::act(IReq::get('province'));

		$tb_areas = new IModel('areas');
		$areas_info = $tb_areas->getObj('parent_id = 0 and area_name = "'.$province.'"','area_id');
		$result = array('flag' => 'fail','area_id' => 0);
		if($areas_info)
		{
			$result = array('flag' => 'success','area_id' => $areas_info['area_id']);
		}
		echo JSON::encode($result);
	}

	//产生订单ID
	static public function createOrderNum()
	{
		return date('YmdHis').rand(100000,999999);
	}

	/**
	 * 订单商品数量更新操作[公共]
	 * @param $order_id 订单ID
	 * @param $type 增加或者减少 add 或者 reduce
	 */
	public static function updateStore($order_id,$type = 'add')
	{
		$newStoreNums  = 0;
		$updateGoodsId = array();
		$orderGoodsObj = new IModel('order_goods');
		$goodsObj      = new IModel('goods');
		$productObj    = new IModel('products');
		$goodsList     = $orderGoodsObj->query('order_id = '.$order_id,'goods_id,product_id,goods_nums');

		foreach($goodsList as $key => $val)
		{
			//货品库存更新
			if($val['product_id'] != 0)
			{
				$productsRow = $productObj->getObj('id = '.$val['product_id'],'store_nums');
				$localStoreNums = $productsRow['store_nums'];

				//同步更新所属商品的库存量
				if(in_array($val['goods_id'],$updateGoodsId) == false)
				{
					$updateGoodsId[] = $val['goods_id'];
				}

				$newStoreNums = ($type == 'add') ? $localStoreNums + $val['goods_nums'] : $localStoreNums - $val['goods_nums'];
				$newStoreNums = $newStoreNums > 0 ? $newStoreNums : 0;

				$productObj->setData(array('store_nums' => $newStoreNums));
				$productObj->update('id = '.$val['product_id'],'store_nums');
			}
			//商品库存更新
			else
			{
				$goodsRow = $goodsObj->getObj('id = '.$val['goods_id'],'store_nums');
				$localStoreNums = $goodsRow['store_nums'];

				$newStoreNums = ($type == 'add') ? $localStoreNums + $val['goods_nums'] : $localStoreNums - $val['goods_nums'];
				$newStoreNums = $newStoreNums > 0 ? $newStoreNums : 0;

				$goodsObj->setData(array('store_nums' => $newStoreNums));
				$goodsObj->update('id = '.$val['goods_id'],'store_nums');
			}
		}

		//更新统计goods的库存
		if($updateGoodsId)
		{
			foreach($updateGoodsId as $val)
			{
				$totalRow = $productObj->getObj('goods_id = '.$val,'SUM(store_nums) as store');
				$goodsObj->setData(array('store_nums' => $totalRow['store']));
				$goodsObj->update('id = '.$val);
			}
		}
	}

	/**
	 * 用户在编辑器里上传图片
	 */
	public function upload_img_from_editor()
	{
		$checkRight = new checkRights($this);
		$checkRight->checkAdminRights();

		$photoUpload = new PhotoUpload();
		$photoUpload->setIterance(false);
		$re = $photoUpload->run();

		if(isset($re['imgFile']['flag']) && $re['imgFile']['flag']==1 )
		{
			$filePath = IUrl::creatUrl().$re['imgFile']['dir'].$re['imgFile']['name'];
			echo JSON::encode(array('error' => 0, 'url' => $filePath));
			exit;
		}
		else
		{
			$this->alert("上传失败");
		}
	}

    //添加实体代金券
    function add_download_ticket()
    {
    	$isError = true;

    	$ticket_num = IFilter::act(IReq::get('ticket_num'));
    	$ticket_pwd = IFilter::act(IReq::get('ticket_pwd'));

    	$propObj = new IModel('prop');
    	$propRow = $propObj->getObj('card_name = "'.$ticket_num.'" and card_pwd = "'.$ticket_pwd.'" and type = 0 and is_userd = 0 and is_send = 1 and is_close = 0 and NOW() between start_time and end_time');

    	if(empty($propRow))
    	{
    		$message = '代金券不可用，请确认代金券的卡号密码并且此代金券从未被使用过';
    	}
    	else
    	{
    		//登录用户
    		if($this->user['user_id'])
    		{
	    		$memberObj = new IModel('member');
	    		$memberRow = $memberObj->getObj('user_id = '.$this->user['user_id'],'prop');
	    		if(stripos($memberRow['prop'],','.$propRow['id'].',') !== false)
	    		{
	    			$message = '代金券已经存在，不能重复添加';
	    		}
	    		else
	    		{
		    		$isError = false;
		    		$message = '添加成功';

		    		if($memberRow['prop'] == '')
		    		{
		    			$propUpdate = ','.$propRow['id'].',';
		    		}
		    		else
		    		{
		    			$propUpdate = $memberRow['prop'].$propRow['id'].',';
		    		}

		    		$dataArray = array('prop' => $propUpdate);
		    		$memberObj->setData($dataArray);
		    		$memberObj->update('user_id = '.$this->user['user_id']);
	    		}
    		}
    		//游客方式
    		else
    		{
				$isError = false;
				$message = '添加成功';
    			ISafe::set("ticket_".$propRow['id'],$propRow['id']);
    		}
    	}

    	$result = array(
    		'isError' => $isError,
    		'data'    => $propRow,
    		'message' => $message,
    	);

    	echo JSON::encode($result);
    }

	private function alert($msg)
	{
		header('Content-type: text/html; charset=UTF-8');
		echo JSON::encode(array('error' => 1, 'message' => $msg));
		exit;
	}
	/**
     * 快递单
     * */
    function exdelivery()
    {
    	$id = IFilter::act(IReq::get('id'),'int');
    	$tb_delivery_doc = new IQuery('delivery_doc as dd');
    	$tb_delivery_doc->fields = 'd.name,dd.delivery_code,fc.freight_name';
    	$tb_delivery_doc->where = 'order_id='.$id;
    	$tb_delivery_doc->join = 'left join delivery as d on dd.delivery_type=d.id left join freight_company as fc on d.freight_id=fc.id';
    	$delivery_info = $tb_delivery_doc->find();
    	$get_content = '暂无相关信息!';

    	if($delivery_info)
    	{
    		//获得用户申请的id
	    	$config = new Config("site_config");
			$config_info = $config->getInfo();
			$express_key  = isset($config_info['express_key'])  ? $config_info['express_key']  : '';
			if($express_key)
			{
				//获得物流名称和物流单号
	    		$delivery_code = $delivery_info[0]['delivery_code'];
	    		$name          = $delivery_info[0]['freight_name'];
	    		$get_content   = '物流公司或者货运单号错误';
	    		$type = '1';
	    		if($delivery_code && $name)
	    		{
	    			$name          = trim($name);
	    			$delivery_code = trim($delivery_code);

	    			$sUrl = $this->module->getBasePath();
	    			include $sUrl.'plugins/freight/company.php';

	    			$company = new Company();
	    			$name = $company->getCompany($name);

	    			$AppKey = $express_key;
	    			$url ='http://api.kuaidi100.com/api?id='.$AppKey.'&com='.$name.'&nu='.$delivery_code.'&show=2&muti=1&order=asc';

	    			//优先使用curl模式发送数据
					if(function_exists('curl_init') == 1)
					{
						$curl = curl_init();
						curl_setopt ($curl, CURLOPT_URL, $url);
						curl_setopt ($curl, CURLOPT_HEADER,0);
						curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
						curl_setopt ($curl, CURLOPT_TIMEOUT,5);
						$get_content = curl_exec($curl);
						$type = '2';
						curl_close ($curl);
					}
					else
					{
						include $sUrl.'plugins/freight/snoopy.php';
						$snoopy = new snoopy();
						$snoopy->referer = 'http://www.google.com/';//伪装来源
						$snoopy->fetch($url);
						$get_content = $snoopy->results;
						$type = '2';
					}
	    		}
			}
			else
			{
				$get_content = '您还没有申请ID，请到<a href="http://kuaidi100.com" target="_blank">KuaiDi100.Com （快递100）</a>申请!';
			}
    	}
		$this->setRenderData(array('content'=>$get_content,'type'=>$type));
    	$this->redirect('exdelivery');
    }
    //递归获得商品分类及子类
    public static function getCategroy($category_id)
    {
    	$sub_category = '';
    	if($category_id)
    	{
    		$tb_category = new IModel('category');
    		$category_info = $tb_category->query('parent_id='.$category_id);
    		if(count($category_info)>0)
    		{
    			foreach ($category_info as $value)
    			{
    				$sub_category .= $value['id'].',';
    				$sub_category .= self::getCategroy($value['id']);
    			}
    		}
    	}
    	return $sub_category;
    }
}