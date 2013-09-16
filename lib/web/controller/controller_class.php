<?php
/**
 * @copyright (c) 2011 jooyea.cn
 * @file controller_class.php
 * @brief 控制器类,控制action动作,渲染页面
 * @author chendeshan
 * @date 2010-12-16
 * @version 0.6
 */

/**
 * @class IController
 * @brief 控制器
 */
class IController extends IControllerBase
{
	public $theme                = 'default';          //主题方案
	public $skin                 = 'default';          //风格方案
	public $layout               = 'main';             //布局文件
	public $extend               = '.html';            //模板扩展名

	protected $checkRight        = array();            //需要校验的action动作
	protected $lang              = '';                 //语言包方案
	protected $module            = null;               //隶属于模块的对象
	protected $ctrlId            = null;               //控制器ID标识符
	protected $title             = null;               //控制器标题

	protected $defaultViewPath   = 'views';            //默认视图目录
	protected $defaultLayoutPath = 'layouts';          //默认布局目录
	protected $defaultLangPath   = 'language';         //默认语言目录
	protected $defaultSkinPath   = 'skin';             //默认皮肤目录
	public $defaultExecuteExt = '.php';             //默认编译后文件扩展名
        //缓存注册
        public  $tempRegister = array();

	private $action;                                   //当前action对象
	private $defaultAction = 'index';                  //默认执行的action动作
	private $renderData    = array();                  //渲染的数据

	/**
	 * @brief 构造函数
	 * @param string $ctrlId 控制器ID标识符
	 * @param string $module 控制器所包含的模块
	 */
	public function __construct($module,$controllerId)
	{
		$this->module = $module;
		$this->ctrlId = $controllerId;

		//初始化theme方案
		if(isset($this->module->config['theme']))
		{
			$this->theme = $this->module->config['theme'];
		}

		//初始化skin方案
		if(isset($this->module->config['skin']))
		{
			$this->skin = $this->module->config['skin'];
		}

		//初始化lang方案
		$this->lang = $this->module->language;
	}

	/**
	 * @brief 生成验证码
	 * @return image图像
	 */
	public function getCaptcha()
	{
		//清空布局
		$this->layout = '';

		//配置参数
		$width      = intval(IReq::get('w')) == 0 ? 130 : IReq::get('w');
		$height     = intval(IReq::get('h')) == 0 ? 45  : IReq::get('h');
		$wordLength = intval(IReq::get('l')) == 0 ? 5   : IReq::get('l');
		$fontSize   = intval(IReq::get('s')) == 0 ? 25  : IReq::get('s');

		//创建验证码
		$ValidateObj = new Captcha();
		$ValidateObj->width  = $width;
		$ValidateObj->height = $height;
		$ValidateObj->maxWordLength = $wordLength;
		$ValidateObj->minWordLength = $wordLength;
		$ValidateObj->fontSize      = $fontSize;
		$ValidateObj->CreateImage($text);

		//设置验证码
		ISafe::set('Captcha',$text);
	}

	/**
	 * @brief 权限校验拦截
	 * @param string $ownRight 用户的权限码
	 * @return bool true:校验通过; false:校验未通过
	 */
	public function checkRight($ownRight)
	{
		$actionId = IReq::get('action');

		//是否需要权限校验 true:需要; false:不需要
		$isCheckRight = false;
		if($this->checkRight == 'all')
		{
			$isCheckRight = true;
		}
		else if(is_array($this->checkRight))
		{
			if(isset($this->checkRight['check']) && ( ($this->checkRight['check'] == 'all') || ( is_array($this->checkRight['check']) && in_array($actionId,$this->checkRight['check']) ) ) )
			{
				$isCheckRight = true;
			}

			if(isset($this->checkRight['uncheck']) && is_array($this->checkRight['uncheck']) && in_array($actionId,$this->checkRight['uncheck']))
			{
				$isCheckRight = false;
			}
		}

		//需要校验权限
		if($isCheckRight == true)
		{
			$rightCode = $this->ctrlId.'@'.$actionId; //拼接的权限校验码
			$ownRight  = ','.trim($ownRight,',').',';

			if(stripos($ownRight,','.$rightCode.',') === false)
				return false;
			else
				return true;
		}
		else
			return true;
	}

	/**
	 * @brief 获取当前控制器的id标识符
	 * @return 控制器的id标识符
	 */
	public function getId()
	{
		return $this->ctrlId;
	}

	/**
	 * @brief 初始化controller对象
	 */
	public function init()
	{

	}

	/**
	 * @brief 过滤函数
	 * @return array 初始化
	 */
	public function filters()
	{
		return array();
	}

	/**
	 * @brief 获取当前action对象
	 * @return object 返回当前action对象
	 */
	public function getAction()
	{
		return $this->action;
	}

	/**
	 * @brief 设置当前action对象
	 * @param object $actionObj 对象
	 */
	public function setAction($actionObj)
	{
		$this->action = $actionObj;
	}
      
        
        /**
	 * @brief 执行action方法
	 */
	public function run()
	{
                $actionId = IUrl::getInfo('action');
                //设置默认的action动作
		if($actionId===null) $actionId = $this->defaultAction;
                
                
                $controller_cache = new ControllerCache;
                 //初始化控制器
                $this->init();

               
                if( $controller_cache->need_cache($this, $actionId)    //判断该action是否需要缓存 注册在tempRegister中才需要
                    && $controller_cache->is_cache($this,$actionId) ) //判断缓存是否在有效期内 
                {
                    echo $controller_cache->template_out;

                }
                else{
                    //开启缓冲区
                    ob_start();
                    ob_implicit_flush(false);

                    header("content-type:text/html;charset=".$this->module->charset);
                    //初始化控制器
                   // $this->init();
                    //@TODO:$this->init(); 需要修改  如果$this->init();有输出代码  则会报错 
                    //创建action对象
                    IInterceptor::run("onCreateAction");
                    $actionObj = $this->createAction();
                    $actionObj->run();
                    IInterceptor::run("onFinishAction");
                    $output = ob_get_clean();
                    echo $output;
                    
                    if($controller_cache->need_cache($this, $actionId) )
                    {
                        $controller_cache->update_cache($this, $actionId,$output) ;
                    }
                        
                        
                }
		IWeb::$app->end(0);
	}

	/**
	 * @brief 创建action动作
	 * @return object 返回action动作对象
	 */
	public function createAction()
	{
		//获取action的标识符
		$actionId = IUrl::getInfo('action');

		//设置默认的action动作
		if($actionId===null) $actionId = $this->defaultAction;

		/*创建action对象流程
		 *1,控制器内部动作
		 *2,配置动作
		 *3,视图动作*/

		//1,控制器内部动作
		if(method_exists($this,$actionId))
			$this->action = new IInlineAction($this,$actionId);

		//2,配置动作
		else if(($actions = $this->actions()) && isset($actions[$actionId]))
		{
			//自定义类名
			$className = $actions[$actionId]['class'];
			$this->action = new $className($this,$actionId);
		}

		//3,视图动作
		else
			$this->action = new IViewAction($this,$actionId);

		return $this->action;
	}

	/**
	 * @brief 预定义的action动作
	 * @return array 动作信息
	 */
	public function actions()
	{
		return array();
	}

	/**
	 * @brief 渲染
	 * @param string $view 要渲染的视图文件
	 * @param string or array 要渲染的数据
	 * @param bool $return 渲染类型
	 * @return 渲染出来的数据
	 */
	public function render($view,$data=null,$return=false)
	{
		$output = $this->renderView($view,$data);
		if($return)
			return $output;
		else
			echo $output;
	}
        
        /**
	 * @brief 渲染
	 * @param string $view 要渲染的视图文件
	 * @param string or array 要渲染的数据
	 * @param bool $return 渲染类型
	 * @return 渲染出来的数据
	 */
	public function fetch($view,$data=null)
	{
            $viewFile = $this->getViewPath().$view;
            $viewContent = '';
            if(file_exists($viewFile))
            {
                $viewContent = file_get_contents($viewFile);
                //编译widget
                $viewContent = $this->widgetResolve($viewContent);
                //标签编译
                $viewContent = $this->tagResolve($viewContent);
                

                extract($data);
                ob_start();
                eval('?>'.trim($viewContent));
                $viewContent = ob_get_contents();
                ob_end_clean();

                return $viewContent;
            }
            return $viewContent;
	}

	/**
	 * @brief 渲染出静态文字
	 * @param string $text 要渲染的静态数据
	 * @param bool $return 输出方式 值: true:返回; false:直接输出;
	 * @return string 静态数据
	 */
	public function renderText($text,$return=false)
	{
		$text = $this->tagResolve($text);
		if($return)
			return $text;
		else
			echo $text;
	}

	/**
	 * @brief 获取当前主题下的视图路径
	 * @return string 视图路径
	 */
	public function getViewPath()
	{
		if(!isset($this->_viewPath))
		{
			$viewPath        = isset($this->module->config['viewPath']) ? $this->module->config['viewPath'] : $this->defaultViewPath;
			$this->_viewPath = $this->module->getBasePath().$viewPath.DIRECTORY_SEPARATOR.$this->theme.DIRECTORY_SEPARATOR;
		}
		return $this->_viewPath;
	}

	/**
	 * @brief 获取当前主题下的皮肤路径
	 * @return string 皮肤路径
	 */
	public function getSkinPath()
	{
		if(!isset($this->_skinPath))
		{
			$skinPath        = isset($this->module->config['skinPath']) ? $this->module->config['skinPath'] : $this->defaultSkinPath;
			$this->_skinPath = $this->getViewPath().$skinPath.DIRECTORY_SEPARATOR.$this->skin.DIRECTORY_SEPARATOR;
		}
		return $this->_skinPath;
	}

	/**
	 * @brief 获取当前语言包方案的路径
	 * @return string 语言包路径
	 */
	public function getLangPath()
	{
		if(!isset($this->_langPath))
		{
			$langPath        = isset($this->module->config['langPath']) ? $this->module->config['langPath'] : $this->defaultLangPath;
			$this->_langPath = $this->module->getBasePath().$langPath.DIRECTORY_SEPARATOR.$this->lang.DIRECTORY_SEPARATOR;
		}
		return $this->_langPath;
	}

	/**
	 * @brief 获取layout文件路径(无扩展名)
	 * @return string layout路径
	 */
	public function getLayoutFile()
	{
		if($this->layout == null)
			return false;

		return $this->getViewPath().$this->defaultLayoutPath.DIRECTORY_SEPARATOR.$this->layout;
	}

	/**
	 * @brief 取得视图文件路径(无扩展名)
	 * @param string $viewName 视图文件名
	 * @return string 视图文件路径
	 */
	public function getViewFile($viewName)
	{
		$path = $this->getViewPath().strtolower($this->ctrlId).DIRECTORY_SEPARATOR.$viewName;
		return $path;
	}

	/**
	 * @brief 设置页面标题
	 * @param string $value 标题值
	 */
	public function setTitle($value)
	{
		$this->title = $value;
	}

	/**
	 * @brief 获取页面标题
	 * @return string 页面标题
	 */
	public function getTitle()
	{
		if($this->title !==null)
		{
			return $this->title;
		}
		else
		{
			return $this->ctrlId;
		}
	}

	/**
	 * @brief 获取要渲染的数据
	 * @return array 渲染的数据
	 */
	public function getRenderData()
	{
		return $this->renderData;
	}

	/**
	 * @brief 设置要渲染的数据
	 * @param array $data 渲染的数据数组
	 */
	public function setRenderData($data)
	{
		if(is_array($data))
			$this->renderData = array_merge($this->renderData,$data);
	}
	/**
	 * @brief 获取Application 对象
	 */
	public function getModule()
	{
		return $this->module;
	}

	/**
	 * @brief 视图重定位
	 * @param string $next     下一步要执行的动作或者路径名,注:当首字符为'/'时，则支持跨控制器操作
	 * @param bool   $location 是否重定位 true:是 false:否
	 */
	public function redirect($nextUrl, $location = true, $data = null)
	{
		//获取当前的action动作
		$actionId = IReq::get('action');
		if($actionId === null)
		{
			$actionId = $this->defaultAction;
		}

		//分析$nextAction 支持跨控制器跳转
		$nextUrl = strtr($nextUrl,'\\','/');

		if($nextUrl[0] != '/')
		{
			//重定跳转定向
			if($actionId!=$nextUrl && $location == true)
			{
				$locationUrl = IUrl::creatUrl('/'.$this->ctrlId.'/'.$nextUrl);
				header('location: '.$locationUrl);
				IWeb::$app->end(0);
			}
			//非重定向
			else
			{
				$this->action = new IViewAction($this,$nextUrl);
				$this->action->run();
			}
		}
		else
		{
			$urlArray   = explode('/',$nextUrl,4);
			$ctrlId     = isset($urlArray[1]) ? $urlArray[1] : '';
			$nextAction = isset($urlArray[2]) ? $urlArray[2] : '';

			//重定跳转定向
			if($location == true)
			{
				//url参数
				if(isset($urlArray[3]))
				{
					$nextAction .= '/'.$urlArray[3];
				}
				$locationUrl = IUrl::creatUrl('/'.$ctrlId.'/'.$nextAction);
				header('location: '.$locationUrl);
				IWeb::$app->end(0);
			}
			//非重定向
			else
			{
				$nextCtrlObj = new $ctrlId($this->module,$ctrlId);

				//跨控制器渲染数据
				if($data != null)
				{
					$nextCtrlObj->setRenderData($data);
				}
				$nextCtrlObj->init();
				$nextViewObj = new IViewAction($nextCtrlObj,$nextAction);
				$nextViewObj->run();
			}
		}
	}
}
?>
