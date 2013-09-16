<?php
/**
 * @copyright Copyright(c) 2010 jooyea.cn
 * @file webapplication_class.php
 * @brief web应用类
 * @author webning
 * @date 2010-12-10
 * @version 0.6
 * @note
 */
/**
 * @brief IWebApplication 应用类
 * @class IWebApplication
 * @note
 */
class IWebApplication extends IApplication
{
	private $defaultController = 'site';
    public  $controller;

    /**
     * @brief 请求执行方法，是application执行的入口方法
     */
    public function execRequest()
    {
        IUrl::beginUrl();
		IInterceptor::run("onCreateController");
        $this->controller =  $this->createController();
        $this->controller->run();
		IInterceptor::run("onFinishController");
    }
    /**
     * @brief 创建当前的Controller对象
     * @return object Controller对象
     */
    public function createController()
    {
        $controller = IUrl::getInfo("controller");
        if($controller === null) $controller = $this->defaultController;
        if(class_exists($controller)) $controllerClass = new $controller($this,$controller);
        else $controllerClass = new IController($this,$controller);
        $this->controller = $controllerClass;
        return $controllerClass;
    }
    /**
     * @brief 取得当前的Controller
     * @return object Controller对象
     */
    public function getController()
    {
        return $this->controller;
    }
}
?>
