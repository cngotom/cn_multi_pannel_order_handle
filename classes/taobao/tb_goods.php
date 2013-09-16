<?php

class TB_Goods
{

	private static $num_iid_hash = array();




	public static function update($arr)
	{
			$trade_obj = new IModel('tb_goods');

			if(empty(self::$num_iid_hash))
			{
				$res = $trade_obj->query(false,'num_iid,id',false,'DESC','all');
				foreach ($res as $r) {
					self::$num_iid_hash[$r['num_iid']] = $r['id'];
				}

			}

			$trade_obj->setData($arr);
			if(array_key_exists($arr['num_iid'], self::$num_iid_hash))
			{
					$id = self::$num_iid_hash[$arr['num_iid']];
					$trade_obj->update('id = '.$id  );
			}
			else
			{
				$id = $trade_obj->add();
				self::$num_iid_hash[$arr['num_iid']] = $id;
			}

			return $id;

	}






}

?>