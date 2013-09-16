<?php

	class TB_Task{

		private static $task ;

		public static function is_enough_time($task)
		{
			$tobj = new IModel("tb_task");
			$r = $tobj->getObj("name = '$task'","time");

			$lastTime = strtotime($r['time']);
			return time() - $lastTime > 60 ;

		}

		public static function shuwdown_function()
		{
				$task = self::$task;
				$tobj = new IModel("tb_task");
				$tobj->setData(array('status'=>0));
				$tobj->update("name = '$task'");
		}

		public static function getTime($task)
		{
			$tobj = new IModel("tb_task");
			$r = $tobj->getObj("name = '$task'","time");
			return $r['time'];
		}

		public static function isStart($task)
		{

			$tobj = new IModel("tb_task");
			$r = $tobj->getObj("name = '$task'","status");

			return ($r['status'] == 1);
		}


		public static function markStart($task)
		{
				register_shutdown_function(array('TB_Task','shuwdown_function'));
				$tobj = new IModel("tb_task");
				$tobj->setData(array('status'=>1));
				$tobj->update("name = '$task'");
				self::$task = $task;
		}


		public static function markEnd($task,$updateTime = true)
		{
				$tobj = new IModel("tb_task");
				$data = array('status'=>0,'time'=>date("Y-m-d H:i:s"));
				if(!$updateTime)
					unset($data['time']);
				$tobj->setData($data);
				
				$tobj->update("name = '$task'");
		}

	}


?>