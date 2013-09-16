<?php
/**
 * @brief 订单模块
 * @class Order
 * @note  后台
 */
class Order extends IController
{
	protected $checkRight  = 'all';
	public $layout='admin';
	function init()
	{
		$checkObj = new CheckRights($this);
		$checkObj->checkAdminRights();

		TB_Handle::do_incr();
		YHD_Handle::do_incr();	
		Amazon_Handle::do_incr();

	}
	

	function related()
	{
		
		$nowDay = date("Y-m-d 23:59:59");
		$startDay = date("Y-m-d H:i:s",time()- 3*60*60*24) ; //三天内已发货订单

		$order_obj = new IModel('tb_trades');
		$res = $order_obj->query("pay_time between '$startDay' and '$nowDay ' and status in (3)",$cols='*','pay_time','desc','all');

		$orders = array();
		$orders = $res;

		$this->setRenderData(array('orders' => $orders));
		$this->redirect('related');
	}


	function current()
	{
		$nowDay = date("Y-m-d 23:59:59");
		$startDay = date("Y-m-d H:i:s",time()- 3*60*60*24) ; //三天内未发货订单

		$order_obj = new IModel('tb_trades');
		$res = $order_obj->query("pay_time between '$startDay' and '$nowDay ' and status in (2)",$cols='*','pay_time','desc','all');

		$orders = array();
		$orders = $res;

		$this->setRenderData(array('orders' => $orders));
		$this->redirect('current');
	}
	function tongji()
	{
		$nowDay = date("Y-m-d 23:59:59");
		$startDay = date("Y-m") ."-01";

		$order_obj = new IModel('tb_trades');
		$res = $order_obj->query("pay_time between '$startDay' and '$nowDay ' and status in (2,3,4)",$cols='*','pay_time','desc','all');

		$orders = array();

		$sum = array('time' =>'总计','price' => 0 ,'onum' => 0);
		foreach($res as $r)
		{
			$pay_time = date('Y-m-d', strtotime($r['pay_time']));

			if(!array_key_exists($pay_time, $orders))
			{
				 $orders[$pay_time] = array('time' => $pay_time,'price' => $r['payment'] ,'onum' => 1);
			}
			else
			{
				$orders[$pay_time]['price'] +=  $r['payment'] ;
				$orders[$pay_time]['onum'] += 1;
			}

			$sum['price'] += $r['payment'];
			$sum['onum'] += 1 ;
		}

		$orders[] = $sum;


		$this->setRenderData(array('orders' => $orders));
		$this->redirect('tongji');
	}
}