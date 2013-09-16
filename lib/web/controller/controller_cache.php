<?php

/**
 * ECSHOP 模版类
 * ============================================================================
 * 版权所有 2005-2011 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: cls_template.php 17217 2011-01-19 06:29:08Z liubo $
 */

class ControllerCache
{
    public $caching = false;
    public $cache_dir = 'cache';
    public $template_out = ""; //缓存输出
    
    private $_nowtime;
 
    public function __construct()
    {
         $this->_nowtime    = time();

    }

    
    
    /**
        * @brief 判断Action 是否需要缓存
        */
    public function need_cache($controller,$action_id)
    {
        $res = array_key_exists($action_id,$controller->tempRegister);
        
        return $res;
    }

    /**
        * @brief 判断Action 缓存是否失效
        */
    public function is_cache($controller,$action_id)
    {        
        $cache_file = $this->get_cache_file($controller,$action_id);
        
        if(file_exists($cache_file))
        {
            $data = @file_get_contents($cache_file);
            $data = substr($data, 13);
            $pos  = strpos($data, '<');
            $paradata = substr($data, 0, $pos);

            //check for cache itself's expires
            $para     = @unserialize($paradata);
            if ($para === false || $this->_nowtime > $para['expires'])
            {
                return false;
            }
            $this->_expires = $para['expires'];


            //cheack for view template
            $this->template_out = substr($data, $pos);
            if(!empty($para['template']))
            {
                foreach ($para['template'] as $val)
                {
                    $stat = @stat($val);
                    if ($para['maketime'] < $stat['mtime'])
                    {
                        $this->caching = false;

                        return false;
                    }
                }
            }
            //cheack for controller file time
            $controller_file = $controller->getModule()->getBasePath()."controllers".DIRECTORY_SEPARATOR.strtolower(get_class($controller)).$controller->defaultExecuteExt;
            $stat = stat($controller_file);
            if ($para['maketime'] < $stat['mtime'])
            {
                $this->caching = false;
                return false;
            }



            return true;
        }
        else
        {
            return false;
        }

    }
     /**
    * @brief 更新 action对应的缓存文件
    */
    public function update_cache($controller,$action_id,$output)
    {
       if(!$this->need_cache($controller,$action_id))
            throw new Exception('get_cache_file should be called after need_cache');
        $cache_obj = $controller->tempRegister[$action_id];
        $cache_file = $this->get_cache_file($controller,$action_id);

        $data = serialize(array('template' => $controller->templateFiles, 'expires' =>   $this->_nowtime + intval( key_exists('cache_id', $cache_obj)?$cache_obj['lifetime']:3600*24) , 'maketime' => $this->_nowtime));
        
        if (file_put_contents($cache_file, '<?php exit;?>' . $data . $output, LOCK_EX) === false)
        {
                throw new Exception('can\'t write:' . $cache_file);
        }
        
      
    }
    /**
    * @brief 获取当前action对应的缓存文件
    */
    public function get_cache_file($controller,$action_id)
    {      
        if(!$this->need_cache($controller,$action_id))
            throw new Exception('get_cache_file should be called after need_cache');
        $cache_obj = $controller->tempRegister[$action_id];
        $cache_id = $cache_obj['cache_id'];
        $cachename = get_class ($controller). '_' . $action_id.'_'.$cache_id.'.php';

        
        $cache_dir = $controller->getModule()->getBasePath().$this->cache_dir;
        $hash_dir =  $cache_dir. DIRECTORY_SEPARATOR . substr(md5($cachename), 0, 1);
        if (!is_dir($hash_dir))
        {
            mkdir($hash_dir);
        }

        
        $cachefile = $cache_dir .DIRECTORY_SEPARATOR.$cachename;
        return $cachefile;
    }
  
}

?>