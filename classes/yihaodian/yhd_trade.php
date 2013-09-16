<?php

	class YHD_Trade
	{

		private static $tid_hash = array();
		private static $status_map = array(
			'ORDER_WAIT_PAY' => 1,
			'ORDER_WAIT_SEND' =>2,
			'ORDER_TRUNED_TO_DO'=>2,
			'ORDER_ON_SENDING' =>3,
			'ORDER_OUT_OF_WH' =>3,
			'ORDER_SENDED_TO_LOGITSIC'=>3,
	 		'ORDER_FINISH' => 4,
	 		'ORDER_RECEIVED' => 4,
	 		'ORDER_CANCEL' =>6 ,         #(付款以前，卖家或买家主动关闭交易)
	 		'TRADE_BUYER_SIGNED' => 7, #(买家已签收,货到付款专用)
	 		#100 else
		);


		public static function get_status_id($status)
		{
			if(array_key_exists($status, self::$status_map))
				return self::$status_map[$status];
			else
				return 100;
		}

		public static  function update($arr)
		{
			$order_obj = new IModel('tb_trades');

			if(empty(self::$tid_hash))
			{
				$res = $order_obj->query(false,'tid,id',false,'DESC','all');
				foreach ($res as $r) {
					self::$tid_hash[$r['tid']] = $r['id'];
				}

			}

			$order_obj->setData($arr);
			if(array_key_exists($arr['tid'], self::$tid_hash))
			{
				#echo $arr['tid']."double exisits";
				$order_obj->update('id = '.self::$tid_hash[$arr['tid']]  );
			}
			else
			{
				$id = $order_obj->add();
				self::$tid_hash[$arr['tid']] = $id;
			}


		}






	}