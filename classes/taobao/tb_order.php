<?php

class TB_Order
{

	private static $oid_hash = array();


	public static  function update($arr)
	{
		$order_obj = new IModel('tb_orders');

		if(empty(self::$oid_hash))
		{
			$res = $order_obj->query(false,'oid,id',false,'DESC','all');
			foreach ($res as $r) {
				self::$oid_hash[$r['oid']] = $r['id'];
			}

		}

		$order_obj->setData($arr);
		if(array_key_exists($arr['oid'], self::$oid_hash))
		{
			#echo $arr['oid']."double exisits";
			$order_obj->update('id = '.self::$oid_hash[$arr['oid']]  );
		}
		else
		{
			$id = $order_obj->add();
			self::$oid_hash[$arr['oid']] = $id;
		}


	}


}


?>