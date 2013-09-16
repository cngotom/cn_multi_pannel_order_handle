<?php
/**
 * @copyright Copyright(c) 2010 jooyea.cn
 * @file iweb.php
 * @brief 引用内核入口文件
 * @author webning
 * @date 2010-12-02
 * @version 0.6
 */
//内核路径
define('IWEB_PATH',dirname(__file__).DIRECTORY_SEPARATOR);
/**
 * @brief iWeb内核的基类
 * @class IWeb
 */
class IWeb
{
	/**
	 * @brief 当前应用的对象
	 */
	public static $app;

	/**
	 * @brief 控制器所在位置
	 */
	public static $_classes = array('controllers'=>'controllers.*');
    /**
     * @brief 创建Application应用
     * @param string $className
     * @param array $config
     * @return object Application对象
     */
    public static function createApp($className, $config)
    {
        $app = new $className($config);
		return $app;
    }
    /**
     * @brief 创建WebApplication应用
     * @param array $config
     * @return object Application对象
     */
    public static function createWebApp($config = null)
    {
        self::$app = self::createApp('IWebApplication',$config);
        return self::$app;
    }
	/**
	 * @brief 实现系统类的自动加载
	 * @param String $className 类名称
	 * @return bool true
	 */
	public static function autoload($className)
	{
		if(!preg_match('|^\w+$|',$className))
		{
			die('the class name is inaccurate');
		}

		if(isset(self::$_coreClasses[$className]))
		{
			include(IWEB_PATH.self::$_coreClasses[$className]);
		}
		else if(isset(self::$_classes))
		{
            if(isset(self::$_classes[$className]))
            {
                include(IWeb::$app->getBasePath().DIRECTORY_SEPARATOR.$_coreClasses[$className]);
            }
            else
            {
                foreach(self::$_classes as $classPath)
                {
                    $filePath = self::$app->getBasePath().strtr(strtolower(trim($classPath,'*')),'.','/').strtolower( $className ) .'.php';
                   	$filePath2 = self::$app->getBasePath().strtr(trim($classPath,'*'),'.','/'). $className  .'.php';
                   	
                    if(is_file($filePath))
                    {
                        include($filePath);
                        return true;
                    }
                    else if(is_file($filePath2))
                    {
                        include($filePath2);
                        return true;
                    }
                }

                //添加amozon的自动加载类
                $filePath = str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

	            if(file_exists("classes/amazon/" . DIRECTORY_SEPARATOR . $filePath)){
	                require_once "classes/amazon/" . DIRECTORY_SEPARATOR . $filePath;
	                return;
	            }

            }
			return true;
		}
		return true;
	}
    /**
     * @brief 用户自定义类的注册入口
     * @param array $classes 如:array('system.net.load.*','system.net.ftp.*');
     */
    public static function setClasses($classes)
    {
        if(is_string($classes)) self::$_classes += array($classes);
        if(is_array($classes))  self::$_classes += $classes;

    }
    //系统内核所有类文件注册信息
	public static $_coreClasses = array(
		'IApplication'      =>  'core/application_class.php',
		'IWebApplication'   =>  'core/webapplication_class.php',
        'IObject'			=>	'core/object_class.php',
        'ITag'              =>  'core/tag_class.php',
            'IWidget'              =>  'core/widget_class.php',
        'IQuery'            =>  'core/query_class.php',
		'IError'			=>	'core/util/error_class.php',
		'IException'		=>	'core/util/exception_class.php',
		'IHttpException'	=>	'core/util/exception_class.php',
        'IPaging'			=>	'core/paging_class.php',
		'IHash'				=>	'core/util/hash_class.php',
		'ITime'				=>	'core/util/time_class.php',
		'IValidate'			=>	'core/util/validate_class.php',
		'IServer'			=>	'core/util/server_class.php',
		'IReq'			    =>	'core/util/req_class.php',
		'IFile'				=>	'core/util/file_class.php',
		'IUrl'				=>	'core/util/urlmanager_class.php',
		'IClient'			=>	'core/util/client_class.php',
		'IFilter'			=>	'core/util/filter_class.php',
		'IString'			=>	'core/util/string_class.php',
		'ISmtp'				=>	'core/util/smtp_class.php',
		'IXML'				=>	'core/util/xml_class.php',
		'IUpload'			=>	'core/util/upload_class.php',
		'ICookie'			=>	'core/util/cookie_class.php',
		'ISession'			=>	'core/util/session_class.php',
		'JSON'				=>	'core/util/json_class.php',
		'Captcha'	        =>	'core/util/captcha_class.php',
		'IImage'			=>	'core/util/image_class.php',
		'ILanguage'			=>	'core/util/language_class.php',
		'ISafe'             =>	'core/util/safe_class.php',
		'ICrypt'            =>	'core/util/crypt_class.php',
		'IFileLog'			=>	'log/filelog_class.php',
		'ILog'				=>	'log/log_inte.php',
		'IDBLog'			=>	'log/dblog_class.php',
		'ILogFactory'       =>  'log/log_factory_class.php',
		'IMysql'			=>  'db/driver/mysql_class.php',
		'IDBFactory' 		=>  'db/dbfactory_class.php',
        'IDB'               =>  'db/db_class.php',
        'IModel'			=>	'web/model/model_class.php',
        'IController'		=>	'web/controller/controller_class.php',
        'IControllerBase'	=>	'web/controller/controllerbase_class.php',
             'ControllerCache'	=>	'web/controller/controller_cache.php',
		'IAction'			=>	'web/action/action.php',
		'IInlineAction'     =>  'web/action/inline_action.php',
		'IViewAction'		=>	'web/action/view_action.php',
        'IJSPackage'        =>  'web/js/jspackage_class.php',
        'ICacheInte'        =>  'core/cache/cache_inte.php',
        'ICache'            =>  'core/cache/cache_class.php',
        'IFileCache'        =>  'core/cache/filecache_class.php',
        'IMemCache'         =>  'core/cache/memcache_class.php',
		'IInterceptor'		=>	'core/interceptor_class.php',
	);
}
/**
 * @brief 实现系统内容所有类的自动加载
 * @param String $className
 */
function __autoload($className)
{
	IWeb::autoload($className);
}
