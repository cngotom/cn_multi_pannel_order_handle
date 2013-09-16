<?php
/**
 * @copyright Copyright(c) 2010 jooyea.cn
 * @file tag_class.php
 * @brief 标签解析类文件
 * @author webning
 * @date 2010-12-17
 * @version 0.6
 */
 /**
  * @brief ITag 系统标签处理文件
  * @class ITag
  */
class IWidget
{
    //视图路径
	private $viewPath;
        private $viewFile; //对应renderfile
        private $ctrl; //对应controller
    /**
     * @brief  解析给定的字符串
     * @param string $content 要解析的字符串
     * @param mixed $path 视图文件的路径
     * @return String 解析处理的字符串
     */
        
        public function __construct($ctrl)
        {
            $this->ctrl = $ctrl;
        }
        
	public function resolve($content,$path=null)
	{
	    $this->viewPath = $path;
            $max_limit = 20;
            $preg_exp = '/{(\/?)(widget)\s*(:?)([^}]*)}/i';
            while(preg_match($preg_exp,$content,$match) > 0 && --$max_limit >0)
            {
                $content = preg_replace_callback($preg_exp, array($this,'translate'), $content);
            }
            
            if($max_limit  == 0)
                throw new Exception('widget 文件交叉引用'.$match[0]);
            
            return $content;
            
         }
    /**
     * @brief 处理设定的每一个标签
     * @param array $matches
     * @return String php代码
     */
	public function translate($matches)
	{
		 if($matches[1]!=='/')
		{
			switch($matches[2].$matches[3])
			{
				case 'widget:':
				{
					$fileName=trim($matches[4]);
					$viewfile = IWeb::$app->controller->getViewPath().'widget'.DIRECTORY_SEPARATOR.$fileName;
                                        
                                        $this->ctrl->addTemplate($viewfile);
					return file_get_contents($viewfile);
				}
				default:
				{
					 return $matches[0];
				}
			}
		}
		else
		{
			if($matches[2] =='code') return '?>';
			else return '<?php }?>';
		}
	}

}
