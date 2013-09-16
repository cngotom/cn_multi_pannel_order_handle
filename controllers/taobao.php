<?php



class Taobao extends IController
{
	const APP_KEY = '21615995';

	#const SESSION_KEY='61007044dc2f153dfb1ebd20cd639760d574f0f1db981471646660459';
	                 #'61021098b8b8ced041e2bbdeab4795800d4f034189459d41646660459';

	private $client  ;
	
	function test()
	{
		header('Content-type: multipart/x-mixed-replace;boundary=endofsection'); 	
		ob_implicit_flush(true);	
		header( 'Content-type: text/html; charset=utf-8' );
		echo 'Begin ...<br />';
		for( $i = 0 ; $i < 10 ; $i++ )
		{
		    echo $i . '<br />';
		    ob_flush();
		    flush();
		    sleep(1);
		}
		echo 'End ...<br />';
	}

	

	function get_authon()
	{
		$appkey = self::APP_KEY;
		$url = "http://container.api.taobao.com/container?appkey=$appkey";
		echo "<script> window.location.href='$url'</script>";
	}


	function callback()
	{	
		$session_key = $_GET['top_session'];
		ISafe::set('sessionKey',$session_key);
		if($_GET['agreement'] == 'true' && $_GET['top_appkey'] == 21615995)
		{

			ISafe::set('admin_right','administrator');
			ISafe::set('admin_role_name','超级管理员');
			ISafe::set('admin_id',1);
			ISafe::set('admin_name','admin');
			ISafe::set('admin_pwd','47c4380ab6cb796e85ee8bf0c842fb5c');



			$this->redirect('/order/tongji');
		}
		{
			echo '非发入口';
		}

	}

	function show_list()
	{

			$session_key = ISafe::get('sessionKey');
			if(empty($session_key))
				$this->redirect('get_authon');

			require 'classes/TopClient.php';
			require 'classes/RequestCheckUtil.php';
			require 'classes/request/UserSellerGetRequest.php';

			$c = new TopClient;
			$c->appkey = self::APP_KEY;
			$c->secretKey = self::APP_SECRET;
			$sessionKey = $session_key;
			$req = new UserSellerGetRequest;
			$req->setFields("nick,sex");
			$resp = $c->execute($req, $sessionKey);


			echo $resp->user->nick;
	}




}











?>