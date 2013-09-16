<?php


	class TB_Handle{


		const APP_KEY = '21615995';
		const APP_SECRET = '1ec75ac09aff19314fe6d3bd43579659';

		private static $client;

		static public function init()
		{

			self::$client = new TopClient;
			self::$client->appkey = self::APP_KEY;
			self::$client->secretKey = self::APP_SECRET;
		}


		static public function do_init()
		{

			self::init();
			$req = new TradesSoldGetRequest;
			$req->setFields("tid,payment,receiver_name,modified,created,pay_time,status,orders");
			$req->setStartCreated("2013-08-01 00:00:00");
			$req->setEndCreated("2013-09-13 00:00:00");
			$req->setStatus("WAIT_BUYER_PAY,WAIT_SELLER_SEND_GOODS,WAIT_BUYER_CONFIRM_GOODS,TRADE_FINISHED,TRADE_CLOSED,TRADE_CLOSED_BY_TAOBAO");
			$req->setExtType("service");
			
			$req->setUseHasNext("true");

			
			self::_save_trade_orders($req);

			#print_r($orders);
		} 


		static private function _save_trade_orders($req)
		{

			$c = self::$client;
			$has_next = true;
			$orders = array();
			$page = 1;
			while($has_next)
			{	
				$req->setPageNo($page);
				$req->setPageSize(40);
				$resp = $c->execute($req,  ISafe::get('sessionKey'));
				$has_next =  ($resp->has_next == "true" );
				$page+=1;
				ISafe::set('init_progress_page',$page);
				#$orders = array_merge($orders,$resp->trades['trade']);
				$orders[] = $resp;
				#print_r($resp->trades);
				#print_r($resp);
				if(empty($resp->trades->trade )){
					return false;
					print_r($resp);
					echo "trade foreach error";exit();
				}
				else{
					foreach($resp->trades->trade as $tradXML)
					{
							$trade =  (array)$tradXML;

							$order =  (array)$trade['orders'];

							isset($trade['pay_time']) || $trade['pay_time'] = "";

							$arr = array(
								'tid' =>  $trade['tid'],
								'status'=> TB_Trade::get_status_id($trade['status']),
								'payment'=>$trade['payment'],
								'create_time'=> $trade['created'],
								'pay_time'=> $trade['pay_time'],
								'from' => 'taobao',
								'modified_time'=>$trade['modified']		
							);

							
							$tid = TB_Trade::update($arr);		


							#update order
							if(!is_array($order['order']))
								$order['order'] = array($order['order']);
							foreach( $order['order'] as $orderXML)
							{
								$o = (array)$orderXML;
								if(!array_key_exists('oid', $o))
								{
									print_r($order);
									print_r($orderXML);
									print_r($o);exit();
								}
								$arr = array(
									'oid' =>  $o['oid'],
									'num_iid' =>  $o['num_iid'],
									'num' =>  $o['num'],
									'payment'=>$o['payment'],
									'title'=>$o['title'],
									'tid' => $tid,
									'pic_path'=>$o['pic_path']
								);

								TB_Order::update($arr);
							}
					}
				}
			}
			return true;

		}
		static public function do_incr()
		{
			self::init();
			$task = "tb_do_incr";

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
				$endTime = time();


				TB_Task::markStart($task);

				$req = new TradesSoldIncrementGetRequest;
				$req->setFields("tid,payment,receiver_name,modified,created,pay_time,status,orders");



				$oneday = 60 * 60 * 24 ;
				$endTimeStr = date('Y-m-d H:i:s',$endTime);


				while(true)
				{

					$startTimeStr = date('Y-m-d H:i:s',$startTime);
					$nextDayStr =  date('Y-m-d H:i:s',$startTime + $oneday  );


					$req->setStartModified($startTimeStr);
					$req->setEndModified($nextDayStr);
					$req->setStatus("WAIT_BUYER_PAY,WAIT_SELLER_SEND_GOODS,WAIT_BUYER_CONFIRM_GOODS,TRADE_FINISHED,TRADE_CLOSED,TRADE_CLOSED_BY_TAOBAO");
					$req->setPageNo(1);
					$req->setPageSize(40);
					$req->setUseHasNext("true");
					$req->setIsAcookie("false");
					$res = self::_save_trade_orders($req);


					if($nextDayStr > $endTimeStr)
						break;

					$startTime += $oneday;
				}
				TB_Task::markEnd($task,$res);

			}
		}





	}
