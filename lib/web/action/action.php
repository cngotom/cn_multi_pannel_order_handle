<?php
/**
 * @copyright (c) 2009-2011 jooyea.cn
 * @file action.php
 * @brief action 基类文件
 * @author Ben
 * @date 2010-12-16
 * @version 0.6
 */

/**
 * @class IAction
 * @brief action 基类文件
 */
class IAction
{
	protected $id;
	protected $controller;

	/**
	 * @brief IAction的构造函数
	 * @param object $controller 控制器对象
	 * @param string $id         动作名称
	 */
	function __construct($controller, $id)
	{
		$this->controller = $controller;
		$this->id = $id;
	}

	/**
	 * @brief 获取当前动作的controller
	 * @return object 当前的控制器对象
	 */
	function getController()
	{
		return $this->controller;
	}

	/**
	 * @brief 获取当前动作Id
	 * @return string 动作名称
	 */
	function getId()
	{
		return $this->id;
	}
}
?>
