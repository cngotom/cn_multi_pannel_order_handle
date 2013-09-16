<?php
/**
 * @copyright (c) 2011 jooyea.cn
 * @file controllerbase_class.php
 * @brief 控制器基础类
 * @author chendeshan
 * @date 2010-12-3
 * @version 0.6
 */

/**r
 * @class IControllerBase
 * @brief 控制器基础类
 */
class IControllerBase extends IObject
{
    
        protected $templateFiles = array();                //所有影响Action显示的模板文件

        /**
	 * @brief 添加影响render的所有视图文件
	 * @param string $viewContent view代码
	 * @return string 解释后的view和layout代码
	 */
        
        public function addTemplate($templateFile)
        {
            
            if(!in_array($templateFile, $this->templateFiles))
                  $this->templateFiles[] = $templateFile;
            
//            if(!key_exists($viewFile, $this->templateFiles))
//                    $this->templateFiles[$viewFile] = array();
//            
//            if(!in_array($templateFile, $this->templateFiles[$viewFile]))
//                    $this->templateFiles[$viewFile][] = $templateFile;
        }
	/**
	 * @brief 渲染layout
	 * @param string $viewContent view代码
	 * @return string 解释后的view和layout代码
	 */
	public function renderLayout($layoutFile,$viewContent)
	{
		if(file_exists($layoutFile))
		{
			//在layout中替换view
			$layoutContent = file_get_contents($layoutFile);
			$content = str_replace('{viewcontent}',$viewContent,$layoutContent);
			return $content;
		}
		else
			return $viewContent;
	}

	/**
	 * @brief 渲染处理
	 * @param string $viewFile 要渲染的页面
	 * @param string or array $rdata 要渲染的数据
	 * @param bool 渲染的方式 值: true:缓冲区; false:直接渲染;
	 */
	public function renderView($viewFile,$rdata=null)
	{
                //清空template
                if(!empty($this->templateFiles ))
                    throw new Exception('Can not execute renderView more than once '.$viewFile);
                $this->templateFiles = array();

		//要渲染的视图
		$renderFile = $viewFile.$this->extend;

		//添加viewfile到影响缓存的template中
        $this->addTemplate($renderFile);

		//检查视图文件是否存在
		if(file_exists($renderFile))
		{
			//控制器的视图(需要进行编译编译并且生成可以执行的php文件)
			if(stripos($renderFile,IWEB_PATH.'web/view/')===false)
			{
				//生成文件路径
				$runtimeFile = str_replace($this->getViewPath(),$this->module->getRuntimePath(),$viewFile.$this->defaultExecuteExt);
				//layout文件
				$layoutFile = $this->getLayoutFile().$this->extend;
                                //判断layout是否修改 
                                $layoutChanged = false;
                                $layoutHierarchy = explode(',',$this->layout);
                                foreach($layoutHierarchy as $layoutFile)
                                {
                                    
                                    $layoutFile = $this->getViewPath().$this->defaultLayoutPath.DIRECTORY_SEPARATOR.$layoutFile.$this->extend;
                                    
                                    //添加到templates中
                                    $this->addTemplate($layoutFile);
                                    if( (file_exists($layoutFile) &&  file_exists($runtimeFile) && (filemtime($layoutFile) > filemtime($runtimeFile))))
                                        $layoutChanged = true;
                                    
                                }
                              
				if(!file_exists($runtimeFile) || (filemtime($renderFile) > filemtime($runtimeFile)) || $layoutChanged)
				{
                                    
					//获取view内容
					$viewContent = file_get_contents($renderFile);
                                        foreach($layoutHierarchy as $layoutFile)
                                        {   
                                            $layoutFile = $this->getViewPath().$this->defaultLayoutPath.DIRECTORY_SEPARATOR.$layoutFile.$this->extend;

                                            if(file_exists($layoutFile))
                                            {
                                                //处理layout
                                                $viewContent = $this->renderLayout($layoutFile,$viewContent);
                                            }
                                        }
                                        //编译widget
                                        $viewContent = $this->widgetResolve($viewContent);
                                        //标签编译
                                        $inputContent = $this->tagResolve($viewContent);

                                        
                                        
                                        $dir = dirname($runtimeFile);
                                        if(!file_exists($dir))
                                            mkdir ($dir);
                                        //创建runtime文件
                                        $fileObj  = new IFile($runtimeFile,'w+');
                                        $fileObj->write($inputContent);
                                        $fileObj->save();
                                        unset($fileObj);
//                                        
//                                        
//                                        //引入编译后的视图文件 
//                                        ob_start();
//                                        $this->requireFile($runtimeFile,$rdata);
//                                        $output = ob_get_clean();
//                                        //创建temp文件
//                                        $fileObj  = new IFile($tempFile,'w+');
//                                        $fileObj->write($output);
//                                        $fileObj->save();
//                                        unset($fileObj);
//                                        
//                                        
//                                        echo file_get_contents($tempFile);
                                }
                                
			}
			else
			{
				$runtimeFile = $renderFile;
			}
                      
			//引入编译后的视图文件
			$this->requireFile($runtimeFile,$rdata);
		}
		else
		{
			return false;
		}
	}

	/**
	 * @brief 引入编译后的视图文件
	 * @param string $__runtimeFile 视图文件名
	 * @param mixed  $rdata         渲染的数据
	 * @return string 编译后的视图数据
	 */
	public function requireFile($__runtimeFile,$rdata)
	{
		//渲染的数据
		if(is_array($rdata))
			extract($rdata,EXTR_OVERWRITE);
		else
			$data=$rdata;

		unset($rdata);

		//渲染控制器数据
		$__controllerRenderData = $this->getRenderData();
		extract($__controllerRenderData,EXTR_OVERWRITE);
		unset($__controllerRenderData);

		//渲染module数据
		$__moduleRenderData = $this->module->getRenderData();
		extract($__moduleRenderData,EXTR_OVERWRITE);
		unset($__moduleRenderData);

		require($__runtimeFile);
	}

	/**
	 * @brief 编译标签
	 * @param string $content 要编译的标签
	 * @return string 编译后的标签
	 */
	public function tagResolve($content)
	{
		$tagObj = new ITag();
		return $tagObj->resolve($content);
	}

        /**
	 * @brief 编译组件
	 * @param string $content 要编译的标签
	 * @return string 编译后的标签
	 */
	public function widgetResolve($content)
	{
                $widgetObj = new IWidget($this);
		return $widgetObj->resolve($content);
        
        }
}
?>
