<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>单据打印</title>
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/jquery/jquery-1.9.0.min.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/jquery/jquery-migrate-1.1.1.min.js"></script>
<link rel="shortcut icon" href="favicon.ico" />
<style media="print" type="text/css">.noprint{display:none}</style>
<style media="screen,print" type="text/css">
body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td,button{padding:0;margin:0;font-size:100%;}
body{font:12px/1.5 "宋体", Arial, Helvetica, sans-serif;color:#404040;background-color:#fff;text-align:center}
table{border-collapse:collapse;}
.container{width:90%;margin:20px auto}
.v_m{vertical-align: middle}
.ml_20{margin-left:20px;}
.m_10{ margin-bottom:10px;}
.f14{font-size:14px;}
.f18{font-size:18px;}
.f30{font-size:30px;}
.bold{font-weight:bold}
.gray{color:#979797}
.orange{color:#f76f10;}
table.table{border-top:2px solid #b0b0b0;}
table.table tr{_background-image:none}
table.table thead th{height:35px;padding:0 15px;}
table.table tbody th{height:35px;background:#f8f8f8;border-top:1px solid #d0d0d0;border-bottom:1px solid #d0d0d0;}
table.table tbody td{padding:12px 10px}
table.table tbody td img.pic{float:left;padding:1px;border:1px solid #d2d2d2; vertical-align:middle;margin-right:10px;}
table.table tfoot{border-top:2px solid #b0b0b0;}
.btn_print{width:112px;height:31px;margin:20px auto;border:0;background: url(<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/submit_bg.gif";?>) -93px -402px no-repeat;}
</style>
<script type='text/javascript'>
	//更新打印状态
	function update_print_status(order_id,print_type)
	{
		var order_id   = order_id;
		var print_type = print_type;
		$.get('<?php echo IUrl::creatUrl("/order/update_print_status");?>',{order_id:order_id,print_type:print_type});
	}
</script>
</head>

<body>
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."plugins/expresswaybill/history/history.js";?>"></script>
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."plugins/expresswaybill/print_express.js";?>"></script>
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."plugins/expresswaybill/swfobject.js";?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo IUrl::creatUrl("")."plugins/expresswaybill/history/history.css";?>" />

<script type="text/javascript">
    var swfVersionStr = "10.0.0";
    var xiSwfUrlStr = "<?php echo IUrl::creatUrl("")."plugins/expresswaybill/playerProductInstall.swf";?>";
    var flashvars = {};
    var params = {};
    params.quality = "high";
    params.bgcolor = "#ffffff";
    params.allowscriptaccess = "sameDomain";
    params.allowfullscreen = "true";

    var attributes = {};
    attributes.id = "printExpress";
    attributes.name = "printExpress";
    attributes.align = "left";

    swfobject.embedSWF(
        "<?php echo IUrl::creatUrl("")."plugins/expresswaybill/main.swf";?>", "flashContent",
        "100%", "100%",
        swfVersionStr, xiSwfUrlStr,
        flashvars, params, attributes);

	swfobject.createCSS("#flashContent", "display:block;text-align:left;");
</script>

<div style='height:<?php echo isset($this->expressRow['height'])?$this->expressRow['height']:"";?>px;'>

	<div id='flashContent'></div>

	<div>
		<input type='button' class='btn_print noprint' onclick="update_print_status('<?php echo isset($this->order_id)?$this->order_id:"";?>','express');printObj.printStart();" value='开始打印' /> &nbsp;&nbsp;
		<input type='button' class='btn_print noprint' onclick='window.history.go(-1);' value='返回上一级' />
	</div>

</div>

<script type='text/javascript'>
	printObj = null;

	//初始化
	function init()
	{
		printObj = new printExpress();
		printObj.setModeByJS('scan');
		var elementObj = new Array(<?php echo join(',',$this->config_conver);?>);

		for(elementPro in elementObj)
		{
			printObj.createText(elementObj[elementPro]);
		}

		var backgroundPic = "<?php echo IUrl::creatUrl("")."";?><?php echo isset($this->expressRow['background'])?$this->expressRow['background']:"";?>";

		if(backgroundPic != '')
		{
			printObj.backgroundPic(backgroundPic);
		}
	}
</script>
</body>
</html>