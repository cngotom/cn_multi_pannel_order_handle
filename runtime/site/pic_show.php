<?php $siteConfig=new Config("site_config");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $siteConfig->name;?></title>
<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/index.css";?>" />
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/jquery/jquery-1.9.0.min.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/jquery/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/systemjs/artdialog/skins/default.css" />
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/pic_zoom.js";?>"></script>
</head>
</head>
<body class="second">

<div class="container_2">
	<div class="header">
		<h1 class="logo"><a title="<?php echo $siteConfig->name;?>" href="<?php echo IUrl::creatUrl("");?>"><?php echo $siteConfig->name;?></a></h1>
	</div>

	<?php $id=intval(IReq::get('id'));?>
	<div class="wrapper clearfix">
		<div class="gray_box_2 showbox_s clearfix">
			<ul id="piclist" class="piclist_2 clearfix">
			<?php $query = new IQuery("goods_photo_relation AS a");$query->join = "left join goods_photo AS b ON a.photo_id = b.id";$query->where = "a.goods_id = $id";$query->order = "a.id DESC";$query->fields = "a.*,b.img";$items = $query->find(); foreach($items as $key => $item){?>
				<li><a href="javascript:void(0);"><img  onclick="pic_show(this);" class="small_img" big_src="<?php echo IUrl::creatUrl("")."";?><?php echo isset($item['img'])?$item['img']:"";?>" src="<?php echo Thumb::get($item['img'],66,66);?>" width="66" height="66" /></a></li>
			<?php }?>
			</ul>
			<a class="last" href="javascript:void(0);" onclick="pic_pre();"><span>上一个</span></a>
			<a class="next" href="javascript:void(0);" onclick="pic_next();"><span>下一个</span></a>
		</div>
	</div>

	<div class="showbox f14 m_10">
		<?php $query = new IQuery("goods");$query->where = "id = $id";$query->limit = "1";$items = $query->find(); foreach($items as $key => $item){?>
		<h2><a href="<?php echo IUrl::creatUrl("/site/products/id/$id/");?>"><?php echo isset($item['name'])?$item['name']:"";?></a></h2>
		<?php $seo_data=array();?>
		<?php $seo_data['title']="查看大图_".$item['name'].'_'.$siteConfig->name ?>
		<?php seo::set($seo_data);?>
		<?php }?>
		<p>
			<a href="javascript:void(0);" onclick="pic_pre();">上一页</a>
			<span id="view_info"></span>
			<a href="javascript:void(0);" onclick="pic_next();">下一页</a>
			<a href="<?php echo IUrl::creatUrl("");?>">返回首页</a>
		</p>
		<input class="submit_buy m_10" type="button" value="立即购买" onclick="window.location='<?php echo IUrl::creatUrl("/site/products/id/$id");?>';" />
	</div>

	<div class="showbox clearfix">
		<a class="last" href="javascript:void(0);" onclick="pic_pre();"><span>上一个</span></a>
		<a class="next" href="javascript:void(0);" onclick="pic_next();"><span>下一个</span></a>
		<div id="big_img" onclick="pic_next();" style="cursor:pointer"></div>
	</div>

	<div class="footer">
		<?php echo IFilter::stripSlash($siteConfig->site_footer_code);?>
	</div>
</div>

<script language="javascript">
//dom加载结束以后
$(function(){
	script_init();
	pic_next();
});

function script_init()
{
	$(".small_img").each(function(i)
	{
		var image=new Array();
		image[i]=new Image();
		image.src=$(this).attr("big_src");
	});
}

var pic_now=0;
var total=$(".small_img").length;

function pic_next()
{
	if($("#piclist li").length==0)
		return;

	var e=$("#piclist").children(".current");

	if(e.length==0)
	{
		$("#piclist li img:first").click();
	}
	else
	{
		if( $(e[0]).next("li").length==0   )
		{
			$("#piclist li img:first").click();
		}
		else
		{
			$(e[0]).next("li").find("img").click();
		}
	}
}
function pic_pre()
{
	if($("#piclist li").length==0)
		return;

	var e=$("#piclist").children(".current");

	if(e.length==0)
	{
		$("#piclist li img:first").click();
	}
	else
	{
		if( $(e[0]).prev("li").length==0   )
		{
			$("#piclist li img:last").click();
		}
		else
		{
			$(e[0]).prev("li").find("img").click();
		}
	}
}

function pic_show(_self)
{
	$(_self).parents("ul").find("li").removeClass("current");
	$(_self).parent("a").parent("li").addClass("current");

	var e = new Image;
	e.src=$(_self).attr("big_src");

	img_load=function()
	{
		var width = parseInt(e.width);
		var height = parseInt(e.height);
		if(width>900)
		{
			e.width=910;
			e.height=parseInt(910*height/width);
		}
		$("#big_img").html("");
		$("#big_img").append($(e));
	};

	if(e.complete)
	{
		img_load();
	}
	else
	{
		$(e).load(img_load);
	}

	var position=$(_self).parent("a").parent("li").prev("li").length+1;
	$("#view_info").html(position+"/"+total+"页");
}
</script>
</body>
</html>

