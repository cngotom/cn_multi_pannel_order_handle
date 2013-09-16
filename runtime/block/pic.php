<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="overflow-y:auto">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/admin.css";?>" />
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/jquery/jquery-1.9.0.min.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/jquery/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/systemjs/artdialog/skins/default.css" />
</head>
<body style="_overflow-y:auto">
<ul class="tab" name="menu">
	<li class="selected"><a href='javascript:void(0)' hidefocus="true">本地上传</a></li>
	<li><a href='javascript:void(0)' hidefocus="true">使用图库</a></li>
</ul>
<div id='uploadMain' class="clearfix">
	<?php $specIndex = IReq::get('specIndex')?>
	<form action='<?php echo IUrl::creatUrl("/pic/uploadFile/specIndex/$specIndex");?>' method='post' enctype='multipart/form-data'>
		<div id='uploadBox_0' class="uploadbox">
			<input class="file" size="45" type="file" name="attach[]" />
			<div class="tips">提示：选择的文件大小不超过3M，支持JPG、GIF和BMP格式。</div>
		</div>
		<div id='uploadBox_1' class="uploadbox" style="display:none">
			从下面图库中选择：<input type="hidden" name="selectPhoto" />
			<div class="list_photo">
				<ul class="clearfix" name="menu">
				</ul>
			</div>
			<div class="tips">提示：选择的文件大小不超过3M，支持JPG、GIF和BMP格式。</div>
		</div>
		<div id='uploadBox_2' class="uploadbox" style="display:none">
			网络图片地址：<input type="text" class="normal" name="outerSrc" />
			<div class="tips">提示：您只需要找到网络图片的网络地址，复制到下面的输入框<br />例如：http://www.example.com/images/pic.jpg</div>
		</div>
		<button class='submit' type='submit'><span>保 存</span></button>
		<button class='submit' type='button' onclick="art.dialog.close();"><span>取 消</span></button>
	</form>
</div>
</body>
</html>
<script type='text/javascript'>
jQuery(function(){
	$("[name='menu']>li").each(
		function(i){
			$(this).click(
				function(){
					$(this).siblings().removeClass("selected");
					$(this).addClass("selected");
					$(".uploadbox").hide();
					$("#uploadBox_"+i).show();
					if(i==1)
					{
						$.getJSON('<?php echo IUrl::creatUrl("/pic/getPhotoList");?>','',
							function(dataVal)
							{
								var dataStr = '';
								for(step=0;step<dataVal.length;step++)
								{
									dataStr+="<li><img onclick='appandVal(this);' width='50px' height='50px' src='<?php echo IUrl::creatUrl("")."";?>"+dataVal[step]['address']+"' title='"+dataVal[step]['address']+"' /></li>";
								}
								$('.list_photo ul').html(dataStr);
							}
						);
					}
				}
			);
		}
	);
});

//动态增加图片的selected类
function appandVal(obj)
{
	//获取当前
	var imgSrc = $(obj).attr('title');

	//获取上一次的图片元素
	var inputSrc = $("input[name='selectPhoto']").val();

	if(imgSrc != inputSrc)
	{
		$('img[title="'+inputSrc+'"]').parent().removeClass('selected');
	}

	$('img[title="'+imgSrc+'"]').parent().addClass('selected');
	$("input[name='selectPhoto']").val(imgSrc);
}
</script>