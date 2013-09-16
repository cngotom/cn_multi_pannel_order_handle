<?php
/**
 * @copyright (c) 2011 [group]
 * @file CheckRight.php
 * @brief 权限校验类
 * @author chendeshan
 * @date 2011-7-8 14:12:32
 * @version 0.6
 */
class CheckRights
{
	private $ctrlObj = null;

	public function __construct($ctrlObj)
	{
		if(!is_object($ctrlObj))
		{
			IError::show('503','no permission to access');
			exit;
		}
		$this->ctrlObj = $ctrlObj;
	}

	//后台管理员权限校验
	public function checkAdminRights()
	{
		$object = $this->ctrlObj;

		$admin                    = array();
		$admin['admin_id']        = ISafe::get('admin_id');
		$admin['admin_name']      = ISafe::get('admin_name');
		$admin['admin_pwd']       = ISafe::get('admin_pwd');
		$admin['admin_role_name'] = ISafe::get('admin_role_name');

		if($admin['admin_name'] == null || $admin['admin_pwd'] == null)
		{
			$object->redirect('/taobao/get_authon');
			exit;
		}

		$adminObj = new IModel('admin');
		$adminRow = $adminObj->getObj("admin_name = '{$admin['admin_name']}'");
		if($adminRow && ($adminRow['password'] == $admin['admin_pwd']) && ($adminRow['is_del'] == 0))
		{
			//非超管角色
			if($adminRow['role_id'] != 0)
			{
				$roleObj = new IModel('admin_role');
				$where   = 'id = '.$adminRow["role_id"].' and is_del = 0';
				$roleRow = $roleObj->getObj($where);

				//角色权限校验
				if($object->checkRight($roleRow['rights']) == false)
				{
					IError::show('503','no permission to access');
					exit;
				}
			}
			$object->admin = $admin;
		}
		else
		{
			IError::show('503','no permission to access');
			exit;
		}
	}

	//注册会员身份校验
	public function checkUserRights()
	{
		$object = $this->ctrlObj;

		$user             = array();
		$user['user_id']  = intval(ISafe::get('user_id'));
		$user['username'] = ISafe::get('username');
		$user['head_ico'] = ISafe::get('head_ico');
		$user['user_pwd'] = ISafe::get('user_pwd');

		if(self::isValidUser($user['username'],$user['user_pwd']))
		{
			$object->user = $user;
		}
		else
		{
			ISafe::clear('user_id');
			ISafe::clear('user_pwd');
			ISafe::clear('username');
			ISafe::clear('head_ico');
		}
	}

	/**
	 * @brief  校验用户的合法性
	 * @param  string $login_info 用户名或者email
	 * @param  string $password   用户名的md5密码
	 * @return false or array 如果合法则返回用户数据;不合法返回false
	 */
	public static function isValidUser($login_info,$password)
	{
		$login_info = IFilter::act($login_info);
		$password   = IFilter::act($password);

		$userObj = new IModel('user as u,member as m');
		$where   = 'u.username = "'.$login_info.'" and m.status = 1 and u.id = m.user_id';
		$userRow = $userObj->getObj($where);

		if(empty($userRow))
		{
			$where   = 'email = "'.$login_info.'" and m.status = 1 and u.id = m.user_id';
			$userRow = $userObj->getObj($where);
		}

		if(empty($userRow) || ($userRow['password'] != $password))
		{
			return false;
		}
		else
		{
			return $userRow;
		}
	}
}
?>
