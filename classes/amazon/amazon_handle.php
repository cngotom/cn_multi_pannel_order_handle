<?php


	function get_local_time($timeStr)
	{
		$time = strtotime($timeStr);
		return date('Y-m-d H:i:s',$time);
	}

	class Amazon_Handle{



		public static function  invokeListOrders(MarketplaceWebServiceOrders_Interface $service, $request) 
		{
		    try {
	            $response = $service->listOrders($request);
	              
	            if ($response->isSetListOrdersResult()) { 
	                    $listOrdersResult = $response->getListOrdersResult();

	                    if ($listOrdersResult->isSetOrders()) { 
	                        $orders = $listOrdersResult->getOrders();
	                        $orderList = $orders->getOrder();
	                        foreach ($orderList as $order) {


	                        	$arr = array( 
									'tid' => $order->getAmazonOrderId(),
									'status'=>100,
									'create_time' => get_local_time($order->getPurchaseDate()),
									'pay_time' => get_local_time($order->getPurchaseDate()),
									'modified_time' => get_local_time($order->getLastUpdateDate()),
									'from' => 'amazon',
							    );
	                        	if( $order->getOrderStatus() == "Pending") //未付款
	                        		 $arr['status'] = 1;
	                        	else if( $order->getOrderStatus() == "Shipped") //已发货
	                        		$arr['status'] = 3;
	                        	else if( $order->getOrderStatus() == "Unshipped") //等待发货
	                        	{
	                        		$arr['status'] = 2;
	                        	}		
	                        	else if ($order->getOrderStatus() == "Canceled")
	                        	{
	                        		$arr['status'] = 6;
	                        	}

	                        	if ($order->isSetOrderTotal()) { 
	                        		 $orderTotal = $order->getOrderTotal();
	                        		 $arr['payment'] = $orderTotal->getAmount();
	                        	}

	                        	
							    Amazon_Trade::update($arr);

	                        }
	                    } 
	            } 
		                

		     } catch (MarketplaceWebServiceOrders_Exception $ex) {
		         echo("Caught Exception: " . $ex->getMessage() . "\n");
		         echo("Response Status Code: " . $ex->getStatusCode() . "\n");
		         echo("Error Code: " . $ex->getErrorCode() . "\n");
		         echo("Error Type: " . $ex->getErrorType() . "\n");
		         echo("Request ID: " . $ex->getRequestId() . "\n");
		         echo("XML: " . $ex->getXML() . "\n");
		         echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
		     }
		}
		        




		public static function do_incr()
		{

				set_include_path(get_include_path() . PATH_SEPARATOR . 'classes/amazon/.');  
				/************************************************************************
				* REQUIRED
				* 
				* Access Key ID and Secret Acess Key ID, obtained from:
				* http://aws.amazon.com
				***********************************************************************/
				define('AWS_ACCESS_KEY_ID', 'AKIAJKO5PHMKVV2N5YVA');
				define('AWS_SECRET_ACCESS_KEY', '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');  

				/************************************************************************
				* REQUIRED
				* 
				* All MWS requests must contain a User-Agent header. The application
				* name and version defined below are used in creating this value.
				***********************************************************************/
				define('APPLICATION_NAME', 'order');
				define('APPLICATION_VERSION', '1');

				/************************************************************************
				* REQUIRED
				* 
				* All MWS requests must contain the seller's merchant ID and
				* marketplace ID.
				***********************************************************************/
				define ('MERCHANT_ID', 'A1187UKY4PVTVK');
				define ('MARKETPLACE_ID', 'AAHKV2X7AFYLW');
		    	$serviceUrl = "https://mws.amazonservices.com.cn/Orders/2011-01-01";
		    	$config = array (
				   'ServiceURL' => $serviceUrl,
				   'ProxyHost' => null,
				   'ProxyPort' => -1,
				   'MaxErrorRetry' => 3,
				 );
		    	$service = new MarketplaceWebServiceOrders_Client(
			        AWS_ACCESS_KEY_ID,
			        AWS_SECRET_ACCESS_KEY,
			        APPLICATION_NAME,
			        APPLICATION_VERSION,
		       	    $config);
		 
		    	$request = new MarketplaceWebServiceOrders_Model_ListOrdersRequest();
				$request->setSellerId(MERCHANT_ID);

				$task = "amazon_do_incr";

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

					$startTimeStr = date('Y-m-d H:i:s',$startTime - 15*60*60*24); //15天前

					$request->setCreatedAfter(new DateTime($startTimeStr, new DateTimeZone('UTC')));

					// Set the marketplaces queried in this ListOrdersRequest
					$marketplaceIdList = new MarketplaceWebServiceOrders_Model_MarketplaceIdList();
					$marketplaceIdList->setId(array(MARKETPLACE_ID));
					$request->setMarketplaceId($marketplaceIdList);
					TB_Task::markStart($task);
					self::invokeListOrders($service, $request);
					TB_Task::markEnd($task);
				}

		}


	}
