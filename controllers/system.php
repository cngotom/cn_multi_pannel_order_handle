<?php
/**
 * @brief 系统模块
 * @class System
 * @note  后台
 */
class System extends IController
{
	protected $checkRight  = array('check' => 'all','uncheck' => array('default','navigation','navigation_update','navigation_del','navigation_edit','navigation_recycle','navigation_recycle_del','navigation_recycle_restore'));
	public $layout      = 'admin';
	public $except      = array('.','..','.svn','.htaccess');
	public $defaultConf = 'config.php';
	private $data = array();

	function init()
	{
		$checkObj = new CheckRights($this);
		$checkObj->checkAdminRights();
	}

	//邮件发送测试
	function test_sendmail()
	{
		$site_config                 = array();
		$site_config['email_type']   = IReq::get('email_type');
		$site_config['mail_address'] = IReq::get('mail_address');
		$site_config['smtp']         = IReq::get('smtp');
		$site_config['smtp_user']    = IReq::get('smtp_user');
		$site_config['smtp_pwd']     = IReq::get('smtp_pwd');
		$site_config['smtp_port']    = IReq::get('smtp_port');
		$test_address                = IReq::get('test_address');

		$smtp = new SendMail($site_config);
		if($error = $smtp->getError())
		{
			$result = array('isError'=>true,'message' => $error);
		}
		else
		{
			$title    = 'email test';
			$content  = 'success';
			if($smtp->send($test_address,$title,$content))
			{
				$result = array('isError'=>false,'message' => '恭喜你！测试通过');
			}
			else
			{
				$result = array('isError'=>true,'message' => '测试失败，请确认您的邮箱已经开启的smtp服务并且配置信息均填写正确');
			}
		}
		echo JSON::encode($result);
	}

	//列出控制器
	function list_controller()
	{
		$planPath = $this->module->config['basePath'].'controllers';
		$planList = array();
		$dirRes   = opendir($planPath);

		while($dir = readdir($dirRes))
		{
			if(!in_array($dir,array('.','..','.svn')))
			{
				$planList[] = basename($dir,'.php');
			}
		}
		echo JSON::encode($planList);
	}

	//列出某个控制器的action动作和视图
	function list_action()
	{
		$ctrlId     = IReq::get('ctrlId');
		if($ctrlId != '')
		{
			$baseContrl = get_class_methods('IController');
			$advContrl  = get_class_methods($ctrlId);
			$diffArray  = array_diff($advContrl,$baseContrl);
			echo JSON::encode($diffArray);
		}
	}

	/**
	 * @brief 配送方式修改
	 */
    public function delivery_edit()
	{
		$data = array();
        $id = IFilter::act(IReq::get('id'),'int');

        if($id)
        {
            $delivery = new IModel('delivery');
            $data = $delivery->getObj('id = '.$id);
		}

		//获取省份
		$areaData = array();
		$areaDB = new IModel('areas');
		$areaList = $areaDB->query('parent_id = 0');
		foreach($areaList as $val)
		{
			$areaData[$val['area_id']] = $val['area_name'];
		}
		$this->areaList  = $areaList;
		$this->data_info = $data;
		$this->area      = $areaData;
        $this->redirect('delivery_edit');
	}

	public function delivery_operate()
	{
		$id = IReq::get('id');
		$op = IReq::get('op');
        if(is_array($id)) $id = implode(',',$id);

        if(empty($id))
        {
        	if($op == 'del' || $op == 'recover')
        	{
        		$this->redirect('delivery_recycle',false);
        	}
        	else
        	{
        		$this->redirect('delivery',false);
        	}
        	Util::showMessage('请选择要操作的选项');
        	exit;
        }

		$delivery     =  new IModel('delivery');
		$deliveryData = $delivery->query('id in ('.$id.')','name');
		$deliveryName = array();
		foreach($deliveryData as $val)
		{
			$deliveryName[] = $val['name'];
		}

		$logObj = new log('db');

		//物理删除
		if($op=='del')
		{
			$delivery->del('id in('.$id.')');

			$logObj->write('operation',array("管理员:".$this->admin['admin_name'],"删除了回收站中的配送方式","被删除的配送方式为：".join(',',$deliveryName)));

			$this->redirect('delivery_recycle');
		}
		else if($op =='recover')//还原
		{
			$delivery->setData(array('is_delete'=>0));
			if($delivery->update('id in('.$id.')'))
			{
				$logObj->write('operation',array('管理员:'.$this->admin['admin_name'],'恢复了回收站中的配送方式','被恢复的配送方式为：'.join(',',$deliveryName)));
			}

			$this->redirect('delivery_recycle');
		}
		else//逻辑删除
		{
			$delivery->setData(array('is_delete'=>1));
			if($delivery->update('id in('.$id.')'))
			{
				$logObj->write('operation',array("管理员:".$this->admin['admin_name'],"把配送方式移除到回收站中","被移除到回收站中的配送方式为：".join(',',$deliveryName)));
			}

			$this->redirect('delivery');
		}
	}

	/**
	 * 配送方式修改
	 */
    public function delivery_update()
    {
        $delivery = new IModel('delivery');
        //ID
        $id   = IReq::get('id');
		//配送方式名称
		$name = IReq::get('name');
		//类型
		$type = IReq::get('type');
        //首重重量
        $first_weight = IReq::get('first_weight');
        //续重重量
        $second_weight = IReq::get('second_weight');
        //首重价格
        $first_price = IReq::get('first_price');
        //续重价格
        $second_price = IReq::get('second_price');
        //是否支持物流保价
        $is_save_price = IReq::get('is_save_price');
        //地区费用类型
        $price_type = intval(IReq::get('price_type'));
        //启用默认费用
        $open_default = IReq::get('open_default');
        //支持的配送地区ID
        $area_groupid = serialize(IReq::get('area_groupid'));
        //配送地址对应的首重价格
        $firstprice = serialize(IReq::get('firstprice'));
        //配送地区对应的续重价格
        $secondprice = serialize(IReq::get('secondprice'));
        //排序
        $sort = IReq::get('sort');
        //状态
        $status = IReq::get('status');
        //描述
        $description = IReq::get('description');
        //保价费率
        $save_rate = IReq::get('save_rate');
        //最低保价
        $low_price = IReq::get('low_price');
        //物流公司id
        $freight_id = IReq::get('freight_id');

        $data = array(
        	'name'         => $name,
        	'type'         => $type,
        	'first_weight' => $first_weight,
        	'second_weight'=> $second_weight,
        	'first_price'  => $first_price,
        	'second_price' => $second_price,
        	'is_save_price'=> $is_save_price,
        	'price_type'   => $price_type,
        	'open_default' => $open_default,
        	'area_groupid' => $area_groupid,
        	'firstprice'   => $firstprice,
        	'secondprice'  => $secondprice,
        	'sort'         => $sort,
        	'status'       => $status,
        	'description'  => $description,
        	'save_rate'    => $save_rate,
        	'low_price'    => $low_price,
        	'freight_id'   => $freight_id
        );
        $delivery->setData($data);
        $logObj = new log('db');

		if($id=="")
		{
			if($delivery->add())
			{
				$logObj->write('operation',array("管理员:".$this->admin['admin_name'],"添加了配送方式",'添加的配送方式为：'.$name));
			}
		}
		else
		{
			if($delivery->update('id = '.$id))
			{
				$logObj->write('operation',array("管理员:".$this->admin['admin_name'],"修改了配送方式",'修改的配送方式为：'.$name));
			}
		}
		$this->redirect('delivery');
    }

   /**
    * 添加/修改支付方式插件
    */
    function payment_edit()
    {
        $payment_id = IReq::get("id");
        $paymentRow = array();

        //修改方式
        if($payment_id)
        {
            $paymentObj = new IModel('payment');
        	$paymentRow = $paymentObj->getObj("id = ".$payment_id);
        }
        $this->paymentRow = $paymentRow;
        $this->redirect('payment_edit');
    }

 	/**
     * @brief 更新支付方式插件
     */
    function payment_update()
    {
    	//获取Post数据
    	$payment_id    = IFilter::act(IReq::get("id"),'int');
    	$name          = IFilter::act(IReq::get("name"));
    	$poundage_type = IFilter::act(IReq::get("poundage_type"),'int');
    	$poundage      = IFilter::act(IReq::get("poundage"),'float');
        $order         = IFilter::act(IReq::get("order"),'int');
        $note          = IFilter::act(IReq::get('note'),'text');
        $status        = IFilter::act(IReq::get('status'),'int');
        $partner_id    = IFilter::act(IReq::get("partner_id"));
        $partner_key   = IFilter::act(IReq::get("partner_key"));

        $updateData = array(
        	'name'          => $name,
        	'poundage_type' => $poundage_type,
        	'poundage'      => $poundage,
        	'order'         => $order,
        	'note'          => $note,
        	'status'        => $status,
        	'partner_id'    => $partner_id,
        	'partner_key'   => $partner_key
        );

        if(!$payment_id)
        {
        	$this->redirect('payment_list',false);
        	Util::showMessage('该支付方式没有找到');
        	exit;
        }

        $paymentDB = new IModel('payment');
        $paymentDB->setData($updateData);
        $paymentDB->update('id = '.$payment_id);

        //日志记录
		$logObj = new log('db');
		$logObj->write('operation',array("管理员:".$this->admin['admin_name'],"修改了支付方式",'修改的支付方式为：'.$name));

		$this->redirect('payment_list');
    }
	/**
	 * @brief 保存地区排序
	 */
	function area_sort()
	{
		$area_id = IFilter::act(IReq::get('id'),'int');
		$sort = IFilter::act( IReq::get("sort") ,'int' );
		$flag = 0;
		if($area_id && $sort > 0)
		{
			$tb_area = new IModel('areas');
			$area_info = $tb_area->getObj('area_id='.$area_id);
			if($area_info)
			{
				if($area_info['sort']!=$sort)
				{
					$tb_area->setData(array('sort'=>$sort));
					if($tb_area->update('area_id='.$area_id))
					{
						$flag = 1;
					}
				}
				else
				{
					$flag = 2;
				}
			}
		}
		echo $flag;
	}

	/**
	 * @brief 添加、修改地区
	 */
	function area_edit()
	{
		$area_id = IFilter::string(IReq::get('aid'));
		$parent_id = IFilter::string(IReq::get('pid'));
		$parent_id = intval($parent_id) ? intval($parent_id) : null;
		if($area_id)
		{
			$tb_area = new IQuery('areas as a1');
			$tb_area->join = 'left join areas as b1 on a1.parent_id = b1.area_id';
			$tb_area->where = 'a1.area_id='.$area_id;
			$tb_area->fields = 'a1.area_id,a1.area_name,a1.parent_id,b1.area_name as parent_name,a1.sort';
			$area_info = $tb_area->find();
			if($area_info && is_array($area_info) && $info=$area_info[0])
			{
				$this->data['area'] = array('area_id'=>$info['area_id'],'area_name'=>$info['area_name'],'parent_id'=>$info['parent_id'],'parent_name'=>$info['parent_name'],'sort'=>$info['sort']);
				$this->setRenderData($this->data);
			}
			else
			{
				$this->redirect('area');
			}
		}
		elseif($parent_id!==null)
		{
			$tb_areas = new IModel('areas');
			$area_info = $tb_areas->query('area_id='.$parent_id);
			if($area_info && is_array($area_info) && $info=$area_info[0])
			{
				$this->data['area'] = array('parent_id'=>$info['area_id'],'parent_name'=>$info['area_name']);
				$this->setRenderData($this->data);
			}
			else
			{
				$this->redirect('area');
			}
		}
		$this->redirect('area_edit');
	}

	/**
	 * @brief 保存添加、修改地区
	 */
	function area_save()
	{
		$area_id = IFilter::string(IReq::get('area_id'));
		$area_name = IFilter::string(IReq::get('area_name'));
		$parent_id = IFilter::string(IReq::get('parent_id'));
		$sort = IFilter::string(IReq::get('sort'));
		$parent_id = $parent_id ? $parent_id : 0;
		$sort = intval($sort) ? intval($sort) : 50;
		if($area_name)
		{
			$tb_areas = new IModel('areas');
			$tb_areas->setData(array('parent_id'=>$parent_id, 'area_name'=>$area_name, 'sort'=>$sort));
			if($area_id)	//update
			{
				$tb_areas->update('area_id='.$area_id);
			}
			else			//add
			{
				$tb_areas->add();
			}
		}
		$this->redirect('area');
	}

	/**
	 * @brief 删除地区
	 */
	function area_del()
	{
		$aid = IFilter::string(IReq::get('aid'));
		$tb_areas = new IModel('areas');
		$areas_info = $tb_areas->query('parent_id='.$aid);
		if($areas_info)
		{
			echo '-1';
		}
		else
		{
			$tb_areas->del('area_id='.$aid);
			echo '1';
		}
	}

	//[网站管理][站点设置]保存
	function save_conf()
	{
		if(!$_POST)
		{
			$this->conf_base();
		}

		//错误信息
		$message = null;
		$form_index = IReq::get('form_index');
		switch($form_index)
		{
			case "base_conf":
			{
				if(isset($_FILES['logo']['name']) && $_FILES['logo']['name']!='')
				{
					$uploadObj = new PhotoUpload('image');
					$uploadObj->setIterance(false);
					$photoInfo = $uploadObj->run();

					if(!isset($photoInfo['logo']['img']) || !file_exists($photoInfo['logo']['img']))
					{
						$message = 'logo图片上传失败';
					}
					else
					{
						unlink('image/logo.gif');
						rename($photoInfo['logo']['img'],'image/logo.gif');
					}
				}
			}
			break;

			case "site_footer_conf":
			{
				$_POST['site_footer_code']=preg_replace('![\\r\\n]+!',"",$_POST['site_footer_code']);
			}
			break;

			case "index_slide":
			{
				$config_slide = array();
				if(isset($_POST['slide_name']))
				{
					foreach($_POST['slide_name'] as $key => $value)
					{
						$config_slide[$key]['name'] = $value;
						$config_slide[$key]['url']  = $_POST['slide_url'][$key];
						$config_slide[$key]['img']  = $_POST['slide_img'][$key];
					}
				}

				if( isset($_FILES['slide_pic']) )
				{
					$uploadObj = new PhotoUpload();
					$uploadObj->setIterance(false);
					$slideInfo = $uploadObj->run();

					if(isset($slideInfo['slide_pic']['flag']))
					{
						$slideInfo['slide_pic'] = array($slideInfo['slide_pic']);
					}

					if(isset($slideInfo['slide_pic']))
					{
						foreach($slideInfo['slide_pic'] as $key=>$value)
						{

							if($value['flag']==1)
							{
								$config_slide[$key]['img']=$value['img'];
							}
						}
					}

				}
				$_POST = array('index_slide' => serialize( $config_slide ));
			}
			break;

			case "guide_conf":
			{
				$guideName = IFilter::act(IReq::get('guide_name'));
				$guideLink = IFilter::act(IReq::get('guide_link'));
				$data      = array();

				$guideObj = new IModel('guide');

				if(!empty($guideName))
				{
					foreach($guideName as $key => $val)
					{
						if(!empty($val) && !empty($guideLink[$key]))
						{
							$data[$key]['name'] = $val;
							$data[$key]['link'] = $guideLink[$key];
						}
					}
				}

				//清空导航栏
				$guideObj->del('all');

				if(!empty($data))
				{
					//插入数据
					foreach($data as $order => $rs)
					{
						$dataArray = array(
							'order' => $order,
							'name'  => $rs['name'],
							'link'  => $rs['link'],
						);
						$guideObj->setData($dataArray);
						$guideObj->add();
					}

					//跳转方法
					$this->conf_base($form_index);
				}
			}
			break;

			case "shopping_conf":
			break;

			case "show_conf":
			{
				if( isset($_POST['auto_finish']) && $_POST['auto_finish']=="" )
				{
					$_POST['auto_finish']=="0";
				}
			}
			break;

			case "image_conf":
			break;
			case "mail_conf":
			break;
			case "system_conf":
			break;
		}

		//获取输入的数据
		$inputArray = $_POST;
		if($message == null)
		{
			if($form_index == 'system_conf')
			{
				//写入的配置文件
				$configFile = IWeb::$app->config['basePath'].'config/config.php';
				Config::edit($configFile,$inputArray);
			}
			else
			{
				$siteObj = new Config('site_config');
				$siteObj->write($inputArray);
			}

			//跳转方法
			$this->conf_base($form_index);
		}
		else
		{
			$inputArray['form_index'] = $form_index;
			$this->confRow = $inputArray;
			$this->redirect('conf_base',false);
			Util::showMessage($message);
		}
	}

	//[网站管理]展示站点管理配置信息[单页]
	function conf_base($form_index = null)
	{
		//配置信息
		$siteConfigObj = new Config("site_config");
		$site_config   = $siteConfigObj->getInfo();
		$main_config   = include(IWeb::$app->config['basePath'].'config/config.php');

		$configArray   = array_merge($main_config,$site_config);

		$configArray['form_index'] = $form_index;

		$this->confRow = $configArray;

		$this->redirect('conf_base',false);

		if($form_index != null)
		{
			Util::showMessage('保存成功');
		}
	}

	//[权限管理][管理员]管理员添加，修改[单页]
	function admin_edit()
	{
		$id =IFilter::act( IReq::get('id') );
		if($id)
		{
			$adminObj = new IModel('admin');
			$where = 'id = '.$id;
			$this->adminRow = $adminObj->getObj($where);
		}
		$this->redirect('admin_edit');
	}

	//[权限管理][管理员]检查admin_user唯一性
	function check_admin($name = null,$id = null)
	{
		//php校验$name!=null , ajax校验 $name == null
		$admin_name = ($name==null) ? IReq::get('admin_name','post') : $name;
		$admin_id   = ($id==null)   ? IReq::get('admin_id','post')   : $id;
		$admin_name = IFilter::act($admin_name);
		$admin_id = intval($id);


		$adminObj = new IModel('admin');
		if($admin_id)
		{
			$where = 'admin_name = "'.$admin_name.'" and id != '.$admin_id;
		}
		else
		{
			$where = 'admin_name = "'.$admin_name.'"';
		}

		$adminRow = $adminObj->getObj($where);

		if(!empty($adminRow))
		{
			if($name != null)
			{
				return false;
			}
			else
			{
				echo '-1';
			}
		}
		else
		{
			if($name != null)
			{
				return true;
			}
			else
			{
				echo '1';
			}
		}
	}

	//[权限管理][管理员]管理员添加，修改[动作]
	function admin_edit_act()
	{
		$id = IFilter::act( IReq::get('id','post') );
		$adminObj = new IModel('admin');

		//错误信息
		$message = null;

		$dataArray = array(
			'id'         => $id,
			'admin_name' => IFilter::string( IReq::get('admin_name','post') ),
			'role_id'    => IFilter::act( IReq::get('role_id','post') ),
			'email'      => IFilter::string( IReq::get('email','post') ),
		);

		//检查管理员name唯一性
		$isPass = $this->check_admin($dataArray['admin_name'],$id);
		if($isPass == false)
		{
			$message = $dataArray['admin_name'].'管理员已经存在,请更改名字';
		}

		//提取密码 [ 密码设置 ]
		$password   = IReq::get('password','post');
		$repassword = IReq::get('repassword','post');

		//修改操作
		if($id)
		{
			if($password != null || $repassword != null)
			{
				if($password == null || $repassword == null || $password != $repassword)
				{
					$message = '密码不能为空,并且二次输入的必须一致';
				}
				else
					$dataArray['password'] = md5($password);
			}

			//有错误
			if($message != null)
			{
				$this->adminRow = $dataArray;
				$this->redirect('admin_edit',false);
				Util::showMessage($message);
			}
			else
			{
				$where = 'id = '.$id;
				$adminObj->setData($dataArray);
				$adminObj->update($where);

				//修改为自身密码时
				if($id == $this->admin['admin_id'])
				{
					//同步更新safe
					ISafe::set('admin_name',$dataArray['admin_name']);
					ISafe::set('admin_pwd',$dataArray['password']);
				}
			}
		}
		//添加操作
		else
		{
			if($password == null || $repassword == null || $password != $repassword)
			{
				$message = '密码不能为空,并且二次输入的必须一致';
			}
			else
				$dataArray['password'] = md5($password);

			if($message != null)
			{
				$this->adminRow = $dataArray;
				$this->redirect('admin_edit',false);
				Util::showMessage($message);
			}
			else
			{
				$dataArray['create_time'] = ITime::getDateTime();
				$adminObj->setData($dataArray);
				$adminObj->add();
			}
		}
		$this->redirect('admin_list');
	}

	//[权限管理][管理员]管理员更新操作[回收站操作][物理删除]
	function admin_update()
	{
		$id = IFilter::act( IReq::get('id') ,'int' );

		if($id == 1 || (is_array($id) && in_array(1,$id)))
		{
			$this->redirect('admin_list',false);
			Util::showMessage('不允许删除系统初始化管理员');
		}

		//是否为回收站操作
		$isRecycle = IReq::get('recycle');

		if(!empty($id))
		{
			$obj   = new IModel('admin');
			$where = Util::joinStr($id);

			if($isRecycle === null)
			{
				$obj->del($where);
				$this->redirect('admin_recycle');
			}
			else
			{
				//回收站操作类型
				$is_del = ($isRecycle == 'del') ? 1 : 0;
				$obj->setData(array('is_del' => $is_del));
				$obj->update($where);
				$this->redirect('admin_list');
			}
		}
		else
		{
			if($isRecycle == 'del')
				$this->redirect('admin_list',false);
			else
				$this->redirect('admin_recycle',false);

			Util::showMessage('请选择要操作的管理员ID');
		}
	}

	//[权限管理][角色] 角色更新操作[回收站操作][物理删除]
	function role_update()
	{
		$id = IFilter::act( IReq::get('id') );

		//是否为回收站操作
		$isRecycle = IReq::get('recycle');

		if(!empty($id))
		{
			$obj   = new IModel('admin_role');
			$where = Util::joinStr($id);

			if($isRecycle === null)
			{
				$obj->del($where);
				$this->redirect('role_recycle');
			}
			else
			{
				//回收站操作类型
				$is_del    = ($isRecycle == 'del') ? 1 : 0;
				$obj->setData(array('is_del' => $is_del));
				$obj->update($where);
				$this->redirect('role_list');
			}
		}
		else
		{
			if($isRecycle == 'del')
				$this->redirect('role_list',false);
			else
				$this->redirect('role_recycle',false);

			Util::showMessage('请选择要操作的角色ID');
		}
	}

	//[权限管理][角色] 角色修改,添加 [单页]
	function role_edit()
	{
		$id = IFilter::act( IReq::get('id') );
		if($id)
		{
			$adminObj = new IModel('admin_role');
			$where = 'id = '.$id;
			$this->roleRow = $adminObj->getObj($where);
		}

		//获取权限码分组形势
		$rightObj  = new IModel('right');
		$rightData = $rightObj->query('is_del = 0','*','name','asc');

		$rightArray     = array();
		$rightUndefined = array();
		foreach($rightData as $key => $item)
		{
			preg_match('/\[.*?\]/',$item['name'],$localPre);
			if(isset($localPre[0]))
			{
				$arrayKey = trim($localPre[0],'[]');
				$rightArray[$arrayKey][] = $item;
			}
			else
			{
				$rightUndefined[]      = $item;
			}
		}

		$this->rightArray     = $rightArray;
		$this->rightUndefined = $rightUndefined;

		$this->redirect('role_edit');
	}

	//[权限管理][角色] 角色修改,添加 [动作]
	function role_edit_act()
	{
		$id = IFilter::act( IReq::get('id','post') );
		$roleObj = new IModel('admin_role');

		//要入库的数据
		$dataArray = array(
			'id'     => $id,
			'name'   => IFilter::string( IReq::get('name','post') ),
			'rights' => null,
		);

		//检查权限码是否为空
		$rights = IFilter::act( IReq::get('right','post') );
		if(empty($rights) || $rights[0]=='')
		{
			$this->roleRow = $dataArray;
			$this->redirect('role_edit',false);
			Util::showMessage('请选择要分配的权限');
		}

		//拼接权限码
		$rightsArray = array();
		$rightObj    = new IModel('right');
		$rightList   = $rightObj->query('id in ('.join(",",$rights).')','`right`');
		foreach($rightList as $key => $val)
		{
			$rightsArray[] = trim($val['right'],',');
		}

		$dataArray['rights'] = empty($rightsArray) ? '' : ','.join(',',$rightsArray).',';
		$roleObj->setData($dataArray);
		if($id)
		{
			$where = 'id = '.$id;
			$roleObj->update($where);
		}
		else
		{
			$roleObj->add();
		}
		$this->redirect('role_list');
	}

	//[权限管理][权限] 权限修改，添加[单页]
	function right_edit()
	{
		$id = IFilter::act( IReq::get('id') );
		if($id)
		{
			$adminObj = new IModel('right');
			$where = 'id = '.$id;
			$this->rightRow = $adminObj->getObj($where);
		}

		$this->redirect('right_edit');
	}

	//[权限管理][权限] 权限修改，添加[动作]
	function right_edit_act()
	{
		$id    = IFilter::act( IReq::get('id','post') );
		$right = IFilter::act( array_unique(IReq::get('right')) );
		$name  = IFilter::act( IReq::get('name','post') );

		if(!$right)
		{
			$this->rightRow = array(
				'id'   => $id,
				'name' => $name,
			);
			$this->redirect('right_edit',false);
			Util::showMessage('权限码不能为空');
			exit;
		}

		$dataArray = array(
			'id'    => $id,
			'name'  => $name,
			'right' => join(',',$right),
		);

		$rightObj = new IModel('right');
		$rightObj->setData($dataArray);
		if($id)
		{
			$where = 'id = '.$id;
			$rightObj->update($where);
		}
		else
		{
			$rightObj->add();
		}
		$this->redirect('right_list');
	}

	//[权限管理][权限] 权限更新操作 [回收站操作][物理删除]
	function right_update()
	{
		$id = IFilter::act(IReq::get('id'),'int');

		//是否为回收站操作
		$isRecycle = IReq::get('recycle');

		if(!empty($id))
		{
			$obj   = new IModel('right');
			$where = Util::joinStr($id);

			if($isRecycle === null)
			{
				$obj->del($where);
				$this->redirect('right_recycle');
			}
			else
			{
				//回收站操作类型
				$is_del    = ($isRecycle == 'del') ? 1 : 0;
				$obj->setData(array('is_del' => $is_del));
				$obj->update($where);
				$this->redirect('right_list');
			}
		}
		else
		{
			if($isRecycle == 'del')
				$this->redirect('right_list',false);
			else
				$this->redirect('right_recycle',false);

			Util::showMessage('请选择要操作的权限ID');
		}
	}

	/**
	 * @brief 获取语言包,主题,皮肤的方案
	 * @param string $type  方案类型: theme:主题; skin:皮肤; lang:语言包;
	 * @param string $theme 此参数只有$type为skin时才有用，获取任意theme下的skin方案;
	 * @return string 方案的路径
	 */
	function getSitePlan($type,$theme = null)
	{
		$planPath  = null;    //资源方案的路径
		$planList  = array(); //方案列表
		$configKey = array('name','version','author','time','thumb','info');

		//根据不同的类型设置方案路径
		switch($type)
		{
			case "theme":
			$planPath = self::getViewPath().'../';
			break;

			case "skin":
			{
				if($theme == null)
					$planPath = self::getSkinPath().'../';
				else
				{
					$skinStr  = basename(dirname(self::getSkinPath()));
					$planPath = dirname(self::getViewPath()).'/'.$theme.'/'.$skinStr.'/';
				}
			}

			break;

			case "lang":
			$planPath = self::getLangPath().'../';
			break;
		}

		if($planPath != null)
		{
			$planList = array();
			$dirRes   = opendir($planPath);

			while($dir = readdir($dirRes))
			{
				if(!in_array($dir,$this->except))
				{
					$fileName = $planPath.$dir.'/'.$this->defaultConf;
					$tempData = file_exists($fileName) ? include($fileName) : array();
					if(!empty($tempData))
					{
						//拼接系统所需数据
						foreach($configKey as $val)
						{
							if(!isset($tempData[$val]))
							{
								$tempData[$val] = null;
							}
						}
						$planList[$dir] = $tempData;
					}
				}
			}
		}
		return $planList;
	}

	//皮肤管理页面
	function conf_skin()
	{
		$theme = IFilter::string( IReq::get('theme') );
		if($theme == null)
		{
			$this->redirect('conf_ui');
		}
		else
		{
			$isLocal = ($this->theme == $theme) ? true : false;
			$dataArray = array(
				'theme'   => $theme,
				'isLocal' => $isLocal,
			);

			$this->setRenderData($dataArray);
			$this->redirect('conf_skin');
		}
	}

	//清理缓存
	function clearCache()
	{
		$runtimePath = $this->module->getRuntimePath();
		$result      = IFile::clearDir($runtimePath);

		if($result == true)
			echo 1;
		else
			echo -1;
	}

	//启用主题
	function applyTheme()
	{
		$theme = IFilter::string(IReq::get('theme'));
		$skin  = null;
		if($theme != '')
		{
			//获取$theme主题下皮肤方案
			$skinList = array_keys($this->getSitePlan('skin',$theme));

			if(!empty($skinList))
			{
				$skin = $skinList[0];
			}

			$data  = array(
				'theme' => $theme,
				'skin'  => $skin,
			);
			Config::edit('config/config.php',$data);
			$this->clearCache();
		}
		$this->redirect('conf_ui');
	}
	//启用皮肤
	function applySkin()
	{
		$skin  = IFilter::string( IReq::get('skin') );
		if($skin != null)
		{
			$data  = array(
				'skin'  => $skin,
			);
			Config::edit('config/config.php',$data);
		}
		$this->clearCache();
		$this->redirect('conf_ui');
	}
	//管理员快速导航
	function navigation()
	{
		$data = array();
		$ad_id = $this->admin['admin_id'];
		$data['ad_id'] = $ad_id;
		$this->setRenderData($data);
		$this->redirect('navigation');
	}
	//管理员添加快速导航
	function navigation_edit()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		if($id)
		{
			$navigationObj = new IModel('quick_naviga');
			$where = 'id = '.$id;
			$this->navigationRow = $navigationObj->getObj($where);
		}
		$this->redirect('navigation_edit');
	}
	//保存管理员添加快速导航
	function navigation_update()
	{
		$id = IFilter::act(IReq::get('id','post'),'int');
		$navigationObj = new IModel('quick_naviga');
		$navigationObj->setData(array(
			'admin_id'=>$this->admin['admin_id'],
			'naviga_name'=>IFilter::act(IReq::get('naviga_name')),
			'url'=>IFilter::act(IReq::get('url')),
		));
		if($id)
		{
			$navigationObj->update('id='.$id);
		}
		else
		{
			$navigationObj->add();
		}
		$this->redirect('navigation');
	}
	/**
	 * @brief 删除管理员快速导航到回收站
	 */
	function navigation_del()
	{
		$ad_id = $this->admin['admin_id'];
		$data['ad_id'] = $ad_id;
		$this->setRenderData($data);
		//post数据
    	$id = IFilter::act(IReq::get('id'),'int');
    	//生成order对象
    	$tb_order = new IModel('quick_naviga');
    	$tb_order->setData(array('is_del'=>1));
    	if(!empty($id))
		{
			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where = ' id in ('.$id_str.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$tb_order->update($where);
			$this->redirect('navigation');
		}
		else
		{
			$this->redirect('navigation',false);
			Util::showMessage('请选择要删除的数据');
		}
	}
	//管理员快速导航_回收站
	function navigation_recycle()
	{
		$data = array();
		$ad_id = $this->admin['admin_id'];
		$data['ad_id'] = $ad_id;
		$this->setRenderData($data);
		$this->redirect('navigation_recycle');
	}
	//彻底删除快速导航
	function navigation_recycle_del()
    {
    	$ad_id = $this->admin['admin_id'];
		$data['ad_id'] = $ad_id;
		$this->setRenderData($data);
    	//post数据
    	$id = IFilter::act(IReq::get('id'),'int');
    	//生成order对象
    	$tb_order = new IModel('quick_naviga');
    	if(!empty($id))
		{
			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where = ' id in ('.$id_str.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$tb_order->del($where);
			$this->redirect('navigation_recycle');
		}
		else
		{
			$this->redirect('navigation_recycle',false);
			Util::showMessage('请选择要删除的数据');
		}
    }
    //恢复快速导航
	 function navigation_recycle_restore()
    {
    	$ad_id = $this->admin['admin_id'];
		$data['ad_id'] = $ad_id;
		$this->setRenderData($data);
    	//post数据
    	$id = IFilter::act(IReq::get('id'),'int');
    	//生成order对象
    	$tb_order = new IModel('quick_naviga');
    	$tb_order->setData(array('is_del'=>0));
    	if(!empty($id))
		{
			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where = ' id in ('.$id_str.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$tb_order->update($where);
			$this->redirect('navigation_recycle');
		}
		else
		{
			$this->redirect('navigation_recycle',false);
			Util::showMessage('请选择要还原的数据');
		}
    }

    /*系统升级，一共三步*/
    public function upgrade_1()
    {
    	if(!class_exists("ZipArchive"))
    	{
    		$this->msg = "开启Zip扩展后才能使用在线升级。";
    	}
    	else
    	{
			//检测新版本
			$upgrade = new IWebUpgrade('shop');
			$version = $upgrade->check_latest_version();

			if(!$version)
			{
				$this->msg = "链接不到远程服务器";
			}
			else
			{
				$path = IWeb::$app->getBasePath()."docs/version.php";
				if(file_exists($path))
				{
					$current_version = include( IWeb::$app->getBasePath()."docs/version.php" );
					$num = explode(".",$current_version);
					$num = intval($num[2]);
					if($version['version_num'] > $num)
					{
						$this->version = $version;
					}
					else
					{
						$this->msg = "没有更新的版本可供升级";
					}
				}
				else
				{
					$this->msg = "没有更新的版本可供升级";
				}
			}
		}
    	$this->redirect('upgrade_1');
    }

    public function upgrade_2()
    {
    	$version = IReq::get('version');
    	if($version === null)
    	{
    		die();
    	}

    	$current_version = include( IWeb::$app->getBasePath()."docs/version.php" );
    	if($current_version == $version)
    	{
    		$this->redirect('/system/upgrade_1');
    	}

    	$upgrade = new IWebUpgrade('shop',$version);
    	$file_list = $upgrade->get_files_info($current_version);
    	$changed = false;
    	$chmod_file_list = array();
    	//对各个文件进行比对，注意当前工作目录是index.php所在目录
    	foreach($file_list as $key => $value)
    	{
    		$path = $value['path'];
    		if( file_exists($path) && strtolower(md5_file($path)) != $value['hash'] )
    		{
    			$file_list[$key]['changed'] = true;
    			$changed = true;
    		}
    		else
    		{
    			$file_list[$key]['changed'] = false;
    		}
    		$chmod_file_list[]=$value['path'];
    	}

    	//必要的文件权限检测
    	//docs/version.php、根目录是否可写、要替换的文件、backup/upgrade/文件夹
    	$chmod_file_list[]="docs/version.php";
    	$chmod_file_list[]="./";
    	$chmod_file_list[]="backup/upgrade";
    	$chmod_flag = true;
    	foreach($chmod_file_list as $key=>$value)
    	{
    		$flag = IWebUpgrade::can_write($value);
    		$chmod_flag = $chmod_flag && $flag;
    		$chmod_file_list[$key] = array('path' => $value,'flag' => $flag);
    	}
    	$this->chmod_flag = $chmod_flag;
    	$this->chmod_file_list = $chmod_file_list;

    	$this->file_list = $file_list;
    	$this->changed = $changed;
    	$this->version = $version;
    	$this->redirect('upgrade_2');
    }

    public function upgrade_3()
    {
    	$version = IReq::get('version');
    	if($version == null)
    	{
    		die();
    	}
    	$this->version=$version;

    	$current_version = include( IWeb::$app->getBasePath()."docs/version.php" );
    	if($current_version == $version)
    	{
    		$this->redirect('/system/upgrade_1');
    	}

    	$this->redirect('upgrade_3');
    }

    public function upgrade_4()
    {
    	$version = IReq::get('version');
    	if($version == null)
    	{
    		die();
    	}

    	$current_version = include( IWeb::$app->getBasePath()."docs/version.php" );
    	if($current_version == $version)
    	{
    		$this->redirect('/system/upgrade_1');
    	}

    	$upgrade = new IWebUpgrade('shop',$version);
    	$re = $upgrade->download($current_version);

    	echo $re?"success":"";

    	ISafe::set("upgrade_version",$version);
		ISafe::set("upgrade_zip_path",$re);
    	exit;
    }

    public function upgrade_5()
    {
    	//执行sql等清理
    	$version = ISafe::get("upgrade_version");
		$upgrade_zip_path = ISafe::get("upgrade_zip_path");

    	if($version == null || $upgrade_zip_path == null)
    	{
    		die();
    	}

		$upgrade_zip_path = realpath($upgrade_zip_path);

    	$upgrade = new IWebUpgrade('shop',$version);
    	$upgrade->upgrade($upgrade_zip_path);
    	echo "success";
    	exit;
    }
    /**
     * 添加物流公司
     * */
    public function freight_edit()
    {
    	$id = IFilter::act(IReq::get('id'),'int');
    	$data = array('id'=>'','freight_type'=>'','freight_name'=>'','url'=>'','sort'=>'');
    	if($id)
    	{
    		$tb_freight = new IModel('freight_company');
    		$data = $tb_freight->getObj('id='.$id);
    	}
    	$this->setRenderData($data);
    	$this->redirect('freight_edit');
    }
    /**
     * 保存添加或修改的物流公司
     * */
    public function freight_update()
    {
    	$id = IFilter::act(IReq::get('id'),'int');
    	$freight_type = IReq::get('freight_type');
    	$freight_name = IReq::get('freight_name');
    	$url = IReq::get('url');
    	$sort = IReq::get('sort');

    	$tb_freight = new IModel('freight_company');
    	$tb_freight->setData(array(
    		'freight_type' => $freight_type,
    		'freight_name' => $freight_name,
    		'url'		   => $url,
    		'sort'		   => $sort
    	));

    	if($id)
    	{
    		$tb_freight->update('id='.$id);
    	}
    	else
    	{
    		$tb_freight->add();
    	}
    	$this->redirect('freight_list');
    }
    /**
     * 逻辑删除物流公司
     * */
	function freight_del()
    {
    	$id = IReq::get('id');
		if(!empty($id))
		{
			$obj = new IModel('freight_company');
			$obj->setData(array('is_del'=>1));
			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where = ' id in ('.$id_str.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$obj->update($where);
			$this->redirect('freight_list');
		}
		else
		{
			$this->redirect('freight_list',false);
			Util::showMessage('请选择要删除的物流公司');
		}
    }
	/**
     * 物流公司回收站还原
     * */
    public function freight_recycle_restore()
    {
    	$id = IReq::get('id');
		if(!empty($id))
		{
			$obj = new IModel('freight_company');
			$obj->setData(array('is_del'=>0));
			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where = ' id in ('.$id_str.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$obj->update($where);
			$this->redirect('freight_recycle');
		}
		else
		{
			$this->redirect('freight_recycle',false);
			Util::showMessage('请选择要还原的物流公司');
		}
    }
	/**
     * 物流公司回收站彻底删除
     * */
    public function freight_recycle_del()
    {
    	$id = IReq::get('id');
		if(!empty($id))
		{
			$obj = new IModel('freight_company');
			$obj->setData(array('is_del'=>0));
			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where = ' id in ('.$id_str.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$obj->del($where);
			$this->redirect('freight_recycle');
		}
		else
		{
			$this->redirect('freight_recycle',false);
			Util::showMessage('请选择要删除的物流公司');
		}
    }
    /**
     * 快递跟踪
     */
	public function express()
	{
		//配置信息
		$siteConfigObj = new Config("site_config");
		$config_info   = $siteConfigObj->getInfo();
		$data = array();
		$data['express_key']  = isset($config_info['express_key'])  ? $config_info['express_key']  : '';
		$data['express_open'] = isset($config_info['express_open']) ? $config_info['express_open'] : '0';
		$this->setRenderData($data);
		$this->redirect('express');
	}
	//保存快递跟踪
	public function express_update()
	{
		$inputArray = array(
			'express_key'  => IFilter::act(IReq::get('express_key')),
			'express_open' => IFilter::act(IReq::get('express_open'))
		);
		$siteObj = new Config('site_config');
		$siteObj->write($inputArray);
		$this->express();
	}

    //修改oauth单页
    public function oauth_edit()
    {
    	$id = IFilter::act(IReq::get('id'));
    	if($id == 0)
    	{
    		$this->redirect('oauth_list',false);
    		Util::showMessage('请选择要修改的登录平台');exit;
    	}

    	$oauthDBObj = new IModel('oauth');
		$oauthRow = $oauthDBObj->getObj('id = '.$id);
		if(empty($oauthRow))
		{
    		$this->redirect('oauth_list',false);
    		Util::showMessage('请选择要修改的登录平台');exit;
		}

		//获取字段数据
		$oauthObj           = new Oauth($id);
		$oauthRow['fields'] = $oauthObj->getFields();

		$this->oauthRow = $oauthRow;
		$this->redirect('oauth_edit',false);
    }

    //修改oauth动作
    public function oauth_edit_act()
    {
    	$id = IFilter::act(IReq::get('id'));
    	if($id == 0)
    	{
    		$this->redirect('oauth_list',false);
    		Util::showMessage('请选择要修改的登录平台');exit;
    	}

    	$oauthDBObj = new IModel('oauth');
		$oauthRow = $oauthDBObj->getObj('id = '.$id);
		if(empty($oauthRow))
		{
    		$this->redirect('oauth_list',false);
    		Util::showMessage('请选择要修改的登录平台');exit;
		}

		$dataArray = array(
			'name'        => IFilter::act(IReq::get('name')),
			'is_close'    => IFilter::act(IReq::get('is_close')),
			'description' => IFilter::act(IReq::get('description')),
			'config'      => array(),
		);

		//获取字段数据
		$oauthObj    = new Oauth($id);
		$oauthFields = $oauthObj->getFields();

		if(!empty($oauthFields))
		{
			$parmsArray = array_keys($oauthFields);
			foreach($parmsArray as $val)
			{
				$dataArray['config'][$val] = IFilter::act(IReq::get($val));
			}
		}

		$dataArray['config'] = serialize($dataArray['config']);
		$oauthDBObj->setData($dataArray);
		$oauthDBObj->update('id = '.$id);
		$this->redirect('oauth_list');
    }
}
