<?php


	class YHD_Handle{


		private static $client;
		private static $url;
		private static $param;
		const KEY =  "";


		static public function init()
		{

			self::$client = new YhdClient;
			self::$url ='http://openapi.1mall.com/forward/api/rest/router';
			self::$param =  array();

			//设置系统级参数
			self::$param['checkCode'] = "";
			self::$param['merchantId'] = "";
			self::$param['erp'] = "self";
			self::$param['erpVer'] = "1.0";
			self::$param['format'] = "json";
			self::$param['ver'] = "1.0";
			self::$param['method'] = "yhd.orders.get";
		}


		static public function do_incr()
		{

			self::init();
			$task = "yhd_do_incr";
			if(TB_Task::isStart($task))
			{
				echo "$task is already start";
			}
			else if(!TB_Task::is_enough_time($task)){

				#echo "$task is already start";
			}
			else {

				$lastIncr = TB_Task::getTime($task);
				$startTime =  strtotime($lastIncr);
			
				self::$param['orderStatusList'] = "ORDER_WAIT_SEND,ORDER_PAYED,ORDER_FINISH,ORDER_RECEIVED";
				$startTime = time()  - 15*60*60*24;
				$nowStr = date("Y-m-d H:i:s",time());
				$startTimeStr = date("Y-m-d H:i:s",$startTime);

				self::$param['startTime'] = $startTimeStr;
				self::$param['endTime'] = $nowStr;
				self::$param['curPage'] = 1;
				self::$param['pageRows'] = 100;
				
				TB_Task::markStart($task);		
				self::_save_trade_orders();

				#print_r($orders);
				TB_Task::markEnd($task);
			}
		} 


		static private function _save_trade_orders()
		{

			$result = self::$client->send(self::$url, self::$param,self::KEY);

			$res =  json_decode($result);

			if($res->response->errorCount == 0)
			{
				$orderList = $res->response->orderList->order;

				foreach ($orderList as $order){

					$arr = array( 
						'tid' => $order->orderCode,
						'status' =>YHD_Trade::get_status_id($order->orderStatus),
						'payment' => $order->orderAmount,
						'create_time' => $order->orderCreateTime,
						'pay_time' => $order->orderCreateTime,
						'modified_time' =>$order->updateTime,
						'from' => 'yhd',
				    );

				   YHD_Trade::update($arr);
				}
			}
		}
		static public function do_init()
		{
			self::init();
			
			self::$param['orderStatusList'] = "ORDER_WAIT_SEND,ORDER_PAYED,ORDER_FINISH,ORDER_RECEIVED";
			$now = time();
			$startTime = $now - 15*60*60*24;

			$nowStr = date("Y-m-d H:i:s",$now);
			$startTimeStr = date("Y-m-d H:i:s",$startTime);

			self::$param['startTime'] = $startTimeStr;
			self::$param['endTime'] = $nowStr;
			self::$param['curPage'] = 1;
			
			self::_save_trade_orders();
		}





	}
