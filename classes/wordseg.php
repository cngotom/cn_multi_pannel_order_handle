<?php
/**
 * 调用远程接口进行分词
 */
class wordseg
{
	public static function run($title,$key)
	{
		set_time_limit(0);

		$data = array("data"=>$title,"respond"=>"json","ignore"=>'yes');
		$data = http_build_query($data);

		$re = IFile::socket("http://www.ftphp.com/scws/api.php",0,$data);
		if(!$re)
		{
			return array('words'=>array());
		}
		
		return JSON::decode($re);
	}
}
