<?php
class YhdClient{

	//排序函数
	private function sort( array $allParam) {
		ksort($allParam);
		reset($allParam);
		return $allParam;
	}
	
	//sign签名算法
	private function sign($allParam, $secret) {
		$allParam = $this->sort($allParam);
		$sign_str = '';
		foreach ( $allParam as $key => $val) {
			$sign_str .= $key.$val;
		}
		$sign_str = $secret . $sign_str . $secret;
	#	print_r($sign_str);
		return md5($sign_str);
	}
	public function send($url,$paramArray,$secret)
	{
		$paramArray['sign'] = $this->sign($paramArray, $secret);//签名生成sign
		$postData = "";
			
		foreach ($paramArray as $k => $v) {
			$postData .=  "$k=".$v."&"; 
		}
		$postData=substr($postData,0,-1);

		$cl = curl_init($url);
		curl_setopt($cl,CURLOPT_POST,true);

		curl_setopt($cl,CURLOPT_POSTFIELDS,$postData);
		curl_setopt($cl,CURLOPT_RETURNTRANSFER,true);
		$content = curl_exec($cl);
		curl_close($cl);
		return $content;

	}
	public function sendByPost($url, $paramArray, $filePathArray, $secret) {
		
		$paramArray['sign'] = $this->sign($paramArray, $secret);//签名生成sign
		
		$boundary   = md5(time());
		
		//设置参数信息
		$postData = $this->addFormData($paramArray, $boundary);
		
		$cl = curl_init($url);
		curl_setopt($cl,CURLOPT_POST,true);
		curl_setopt($cl,CURLOPT_POSTFIELDS,$postData);
		curl_setopt($cl,CURLOPT_RETURNTRANSFER,true);
		$content = curl_exec($cl);
		curl_close($cl);
		echo $content;
	
	}


	//把参数添加到post请求流里面
	private function addFormData($paramArray, $boundary) {
		$postInfo  = "";

		if(paramArray == null){
			return postInfo;
		}
		
		foreach ($paramArray as $key => $value) {
			
			$postInfo .= "--".$boundary."\r\n";
			$postInfo .= "Content-Disposition: form-data; name=\"" . $key . "\"\r\n\r\n" . $paramArray[$key];
			unset($paramArray[$key]);
		}
		return $postInfo;
	}


	//把文件添加到post请求流里面
	private function addFileInfo($filePathArray, $boundary) {
		$postFileInfo = "";

		if(count($filePathArray) == 0){
			return $postFileInfo;
		}
		
		foreach ($filePathArray as $filePath) {
			$uploadFile = file_get_contents($filePath);
			$postFileInfo .="--".$boundary."\r\n";
			$postFileInfo .="Content-Disposition: form-data; name=\"". rawurlencode($filePath) ."\"; filename=\"" . rawurlencode(basename($filePath)) . "\"\r\n";
			$postFileInfo .="Content-Type: application/octet-stream\r\n\r\n";
			$postFileInfo .=$uploadFile."\r\n";
		}
		//print_r($postFileInfo);
		return $postFileInfo;
	}


}
?>
