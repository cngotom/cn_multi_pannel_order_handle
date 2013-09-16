<?php
/**
 * @copyright (c) 2011 jooyea.cn
 * @file mess.php
 * @brief 站内消息的管理
 * @author relay
 * @date 2011-03-18
 * @version 0.6
 */
 /**
  * example:
  * $message = new Mess($data['user_id']);
  * $message->writeMessage('0',1);
  * $crr = $message->readMessage();
  * print_r($crr);
 */
class Mess
{
	//用户id
	private $user_id='';

	//新站内消息id
	private $message_id='';

	//老站内消息id
	private $old_message='';

	private  $old_ids = '';
	/**
	 * @brief 构造函数 用户id
	 * @param string $user_id 用户id
	 */
	function __construct($user_id)
	{
		$this->user_id = $user_id;
	}
	/**
	 * @param $message_id int 消息的id
	 * @param $read 0未读，1已读
	 * @return int or boolean
	 * @brief 将messageid写入member表中
	 */
	public function writeMessage($message_id,$read = 0)
	{
		$this->message_id = $message_id;
		$this->get_old_mess_ids();
		$message_ids = $this->old_message.$this->message_id.',';
		if($read==1)
		{
			$message_ids = '';
			$arr = explode(',',substr($this->old_message,0,-1));
			if(in_array($message_id,$arr))
			{
				$message_ids = preg_replace('/,'.$message_id.',/',',-'.$message_id.',',','.$this->old_message);
				$message_ids = substr($message_ids,1);
			}
		}
		$tb_member = new IModel('member');
		$tb_member->setData(array(
			'message_ids'=>$message_ids
		));
		return $tb_member->update('user_id='.$this->user_id);
	}
	/**
	 * @param $user_id string 用户的id
	 * @return array()
	 * @brief 获得member表中的messageid
	 */
	public function get_old_mess_ids()
	{
		$tb_member = new IModel('member');
		$member_info = $tb_member->query('user_id='.$this->user_id);
		if(count($member_info)>0)
		{
			$this->old_message = $member_info[0]['message_ids'];
		}
	}
	/**
	 * @param $user_id string 用户的id
	 * @return $message String 返回站内消息id的字符串
	 * @brief 获得member表中的messageid,去掉-的message的id
	 */
	public function get_mess_ids()
	{
		$tb_member = new IModel('member');
		$member_info = $tb_member->query('user_id='.$this->user_id);
		$message = null;
		$this->old_ids = $member_info[0]['message_ids'];
		if(count($member_info)>0)
		{
			$message = str_replace('-','',$member_info[0]['message_ids']);
		}
		return $message;
	}
	/**
	 * @param $mess_id int message的id
	 * @return $is_blog boolean 返回true为已读，false为未读
	 * @brief 判断messageid是否已经读过
	 */
	public function is_read($mess_id)
	{
		return !(bool)preg_match('/,'.$mess_id.',/',','.$this->old_ids.',');
	}
	/**
	 * @return array() //返回有多少未读的属性
	 * @brief 读取member表中的mess的数据
	 */
	public function readMessage()
	{
		$arr = array();
		$this->get_old_mess_ids();
		if(count($this->old_message)>0)
		{
			$this->old_message = substr($this->old_message,0,-1);
			$arr = explode(',',$this->old_message);
			foreach ($arr as $key =>$value) {
				if(stristr($value,"-")!=false)
				{
					unset ($arr[$key]);
				}
			}
		}
		return $arr;
	}

	/**
	 * @return array() //返回有多少未读的属性
	 * @brief 删除member表中的mess的数据
	 */
	public function delMessage($message_id)
	{
		$arr = array();
		$this->get_old_mess_ids();
		$message_ids = $this->old_message;
		if(count($this->old_message)>0)
		{
			$this->old_message = substr($this->old_message,0,-1);
			$arr = explode(',',$this->old_message);
			foreach ($arr as $key =>$value) {
				if($message_id==$value)
				{
					unset ($arr[$key]);
					break;
				}
				if('-'.$message_id==$value)
				{
					unset ($arr[$key]);
					break;
				}
			}
			if(count($arr)>0)
			{
				$message_ids = implode(',',$arr);
				$message_ids =$message_ids.',';
			}
			else
			{
				$message_ids = '';
			}
		}
		$tb_member = new IModel('member');
		$tb_member->setData(array(
			'message_ids'=>$message_ids
		));
		$tb_member->update('user_id='.$this->user_id);
	}


	/**
	 * 直接发站内信到用户
	 *
	 * 这个地方直接调用了Mysql的操作类
	 *
	 * @param $update_where where语句
	 * @param $content 信件内容
	 */
	public static function sendToUser($update_where,$content)
	{
		set_time_limit(0);

		//插入$content
		$arr = array();
		$arr['title'] = IFilter::act($content['title']);
		$arr['content'] = IFilter::act($content['content'],'text');
		$arr['time'] = date('Y-m-d H:i:s');
		$tb = new IModel("message");
		$tb->setData($arr);
		$id = $tb->add();
		if($id === false)
		{
			return false;
		}
		else
		{
			$db = IDBFactory::getDB();
			$tableName = IWeb::$app->config['DB']['tablePre']."member";
			$sql = "UPDATE `{$tableName}` SET message_ids = CONCAT( IFNULL(message_ids,'') ,'{$id},') WHERE {$update_where}";
			return $db->query($sql);
		}
	}


}
