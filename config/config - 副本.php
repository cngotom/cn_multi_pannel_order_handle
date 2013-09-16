<?php
return array(
	'logs'=>array(
		'path'=>'logs/log',
		'type'=>'file'
	),
	'DB'=>array(
		'type'=>'mysql',
        'tablePre'=>'iwebshop_',
		'read'=>array(
			array('host'=>'192.168.1.88:3306','user'=>'root','passwd'=>'50942757','name'=>'iwebshop'),
		),

		'write'=>array(
			'host'=>'192.168.1.88:3306','user'=>'root','passwd'=>'50942757','name'=>'iwebshop',
		),
	),
	'langPath' => 'language',
	'viewPath' => 'views',
    'classes' => 'classes.*',
    'rewriteRule' =>'url',
	'theme' => 'default',		//主题
	'skin' => 'default',		//风格
	'timezone'	=> 'Etc/GMT-8',
	'upload' => 'upload',
	'dbbackup' => 'backup/database',
	'safe' => 'cookie',
	'safeLevel' => 'none',
	'lang' => 'zh_sc',
	'debug'=> true,
	'configExt'=> array('site_config'=>'config/site_config.php'),
	'encryptKey'=>'7e7a4f36cc65b13956fe3b5c9a14d5dc',
);
?>
