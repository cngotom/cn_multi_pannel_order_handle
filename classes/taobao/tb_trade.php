<?php


class TB_Trade
{

	private static $tid_hash = array();

	private static $status_map = array(
		'WAIT_BUYER_PAY' => 1,
		'WAIT_SELLER_SEND_GOODS' =>2,
		'WAIT_BUYER_CONFIRM_GOODS' =>3,
 		'TRADE_FINISHED' => 4,
 		'TRADE_CLOSED'=>5 ,                    #(付款以后用户退款成功，交易自动关闭) 
 		'TRADE_CLOSED_BY_TAOBAO' =>6 ,         #(付款以前，卖家或买家主动关闭交易)
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

	public static function update($arr)
	{
			$trade_obj = new IModel('tb_trades');

			if(empty(self::$tid_hash))
			{
				$res = $trade_obj->query(false,'tid,id,modified_time',false,'DESC','all');
				foreach ($res as $r) {
					self::$tid_hash[$r['tid']] = array($r['id'] ,$r['modified_time']);
				}

			}

			$trade_obj->setData($arr);
			if(array_key_exists($arr['tid'], self::$tid_hash))
			{
				$id = self::$tid_hash[$arr['tid']][0];

				$modified_time = self::$tid_hash[$arr['tid']][1];
				if($modified_time < $arr['modified_time'])
				{

					self::$tid_hash[$arr['tid']][1] = $arr['modified_time'];
					$trade_obj->update('id = '.$id  );
				}

			}
			else
			{
				$id = $trade_obj->add();
				self::$tid_hash[$arr['tid']] = array($id,$arr['modified_time']);
			}

			#echo $arr['tid']."<br>";
			return $id;

	}






}

?>