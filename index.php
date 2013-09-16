<?php
$iweb = dirname(__FILE__)."/lib/iweb.php";
$config = dirname(__FILE__)."/config/config.php";
require($iweb);

Iweb::setClasses(array(
	'taobaoclass' =>'classes.taobao.*','taobaoapi'=>'classes.taobao.request.*',
	 'yihaodianclass' => 'classes.yihaodian.*',
	 'amazonclass' => 'classes.amazon.*', 
));
IWeb::createWebApp($config)->run();

?>