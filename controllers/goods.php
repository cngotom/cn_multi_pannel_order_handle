<?php
/**
 * @brief 商品模块
 * @class Goods
 * @note  后台
 */
class Goods extends IController
{
	protected $checkRight  = 'all';
    public $layout = 'admin';
    private $data = array();

	function init()
	{
		if(IReq::get('action') == 'goods_img_upload')
		{
			$admin_name = IFilter::act(IReq::get('admin_name'));
			$admin_pwd  = IFilter::act(IReq::get('admin_pwd'));

			$adminObj = new IModel('admin');
			$adminRow = $adminObj->getObj("admin_name = '".$admin_name."'",'password');
			if(empty($adminRow) || ($adminRow['password'] != $admin_pwd))
			{
				exit;
			}
		}
		else
		{
			$checkObj = new CheckRights($this);
			$checkObj->checkAdminRights();
		}
	}
	/**
	 * 产品列表
	 */
	function goods_list()
	{
		$goods_obj = new IModel('tb_goods'); 
		$goods = $goods_obj->query("",$cols='*','num_iid','asc','all');
		$this->setRenderData(array('goods'=>$goods));
		$this->redirect('goods_list');
	}

	function do_init()
	{

		$order_obj = new IModel('tb_orders');
		$orders = $order_obj->query("",$cols='distinct num_iid,title,pic_path','num_iid','asc','all');

		foreach ($orders as $order) {

			TB_Goods::update($order);
		}

	}

	function ajaxUpdate()
	{
		$gid = IFilter::act(IReq::get('gid'),'int');
		$value = IFilter::act(IReq::get('value'),'float');
		$type = IReq::get('type');

		$arr = array();
		if($type == "weight")
			$arr['weight'] = $value;
		else
			$arr['pprice'] = $value;


		$goods_obj = new IModel('tb_goods'); 

		$goods_obj->setData($arr);
		$goods_obj->update('id = '.$gid  );
	}
	
}
