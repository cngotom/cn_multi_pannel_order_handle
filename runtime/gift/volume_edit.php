<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>后台管理</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/admin.css";?>" />
	<link rel="shortcut icon" href="favicon.ico" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/jquery/jquery-1.9.0.min.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/jquery/jquery-migrate-1.1.1.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/systemjs/artdialog/skins/default.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artTemplate/artTemplate-plugin.js"></script>
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/common.js";?>"></script>
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/admin.js";?>"></script>
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/menu.js";?>"></script>
</head>
<body>
	<div class="container">
		<div id="header">
			<div class="logo">
				<a href="<?php echo IUrl::creatUrl("/system/default");?>"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/logo.gif";?>" width="303" height="43" /></a>
			</div>
			<div id="menu">
				<ul name="menu">
				</ul>
			</div>
			<p><a href="<?php echo IUrl::creatUrl("/systemadmin/logout");?>">退出管理</a> <a href="<?php echo IUrl::creatUrl("/system/default");?>">后台首页</a> <a href="<?php echo IUrl::creatUrl("");?>" target='_blank'>商城首页</a> <span>您好 <label class='bold'><?php echo isset($this->admin['admin_name'])?$this->admin['admin_name']:"";?></label>，当前身份 <label class='bold'><?php echo isset($this->admin['admin_role_name'])?$this->admin['admin_role_name']:"";?></label></span></p>
		</div>
		<div id="info_bar">
			<label class="navindex"><a href="<?php echo IUrl::creatUrl("/system/navigation");?>">快速导航管理</a></label>
			<span class="nav_sec">
			<?php $adminId = $this->admin['admin_id']?>
			<?php $query = new IQuery("quick_naviga");$query->where = "admin_id = $adminId and is_del = 0";$items = $query->find(); foreach($items as $key => $item){?>
			<a href="<?php echo isset($item['url'])?$item['url']:"";?>" class="selected"><?php echo isset($item['naviga_name'])?$item['naviga_name']:"";?></a>
			<?php }?>
			</span>
		</div>

		<div id="admin_left">
			<ul class="submenu"></ul>
			<div id="copyright"></div>
		</div>

		<div id="admin_right">
			<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/editor/kindeditor-min.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/editor/lang/zh_CN.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/my97date/wdatepicker.js"></script>
<?php $swfloadObject = new Swfupload();$swfloadObject->show();?>
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/event.js";?>"></script>

<div class="headbar clearfix">
	<div class="position"><span>商品</span><span>></span><span>礼册管理</span><span>></span><span><?php if(isset($id)){?>礼册修改<?php }else{?>礼册添加<?php }?></span></div>
</div>

<div class="content_box">
	<div class="content form_content">
		<form action="<?php echo IUrl::creatUrl("/gift/volume_update");?>" name="volumesForm" method="post">
			<input type="hidden" name="id" value="<?php echo isset($volumes_id)?$volumes_id:"";?>" />
                                            <input type='hidden' name="img" value="" />
			<input type='hidden' name="_imgList" value="" />
			<div id="table_box_1">
				<table class="form_table">
					<col width="150px" />
					<col />
					<tr>
						<th>礼册名称：</th>
						<td>
							<input class="normal" name="volume_title" type="text" value="" pattern="required" alt="礼册名称不能为空" /><label>*</label>
						</td>
					</tr>
                                                                        <tr>
						<th>节日：</th>
						<td>  	
                                                                                            <select class="auto" name="festival_id" pattern="required" alt="节日名称不能为空">
								<?php $query = new IQuery("festival");$items = $query->find(); foreach($items as $key => $item){?>
                                                                                                                        <option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></option>
								<?php }?>
                                                                                            </select>
						</td>
					</tr>
                                                
					<tr>
						<th>价格：</th>
						<td>
							<input type='text' class='middle' pattern="float" name='volume_price' value=''  alt="价格格式不正确"  />
						</td>
					</tr>
                                                                         <tr>
						<th>排序：</th>
						<td>
							<input type='text' class='middle' pattern="int" name='volume_sort' value='99'  alt="排序格式不正确"  />
						</td>
					</tr>
                                             		<tr>
						<th>产品描述：</th>
						<td><textarea id="content" name="volume_desc" style="width:700px;height:300px;"></textarea></td>
					</tr>
                                                                        <tr>
						<th>礼册图片：</th>
						<td>
							<input class="middle" type="text" disabled />
							<div class="upload_btn">
								<span id="uploadButton"></span>
							</div>
							<label>可以上传多张图片。</label>
						</td>
					</tr>
                                                                        <tr>
						<td></td>
						<td id="divFileProgressContainer"></td>
					</tr>
					<tr>
						<td></td>
						<td id="thumbnails"></td>

						<!--图片模板-->
						<script type='text/html' id='picTemplate'>
						<span class='pic'>
							<img onclick="defaultImage(this);" style="margin:5px; opacity:1;width:100px;height:100px" src="<?php echo IUrl::creatUrl("")."<%=picRoot%>";?>" alt="<%=picRoot%>" /><br />
							<a class='orange' href='javascript:void(0)' onclick="$(this).parent().remove();">删除</a>
						</span>
						</script>
					</tr>
                                             
				</table>
                                                          <table class="form_table">
                                                                    <col width="150px" />
                                                                    <col />
                                                                    <tr>
                                                                            <td></td>
                                                                            <td><button class="submit" type="submit" onclick="return checkForm()"><span>确认</span></button></td>
                                                                    </tr>
                                                        </table>
			</div>
		</form>
	</div>
</div>

<script language="javascript">
//创建表单实例
var formObj = new Form('volumesForm');
$(function()
{
	//商品分类回填
	<?php if(isset($volumes_id)){?>
                    var volumes = <?php echo JSON::encode($volumes);?>;
                    formObj.setValue('volume_title',volumes.title);
                    formObj.setValue('volume_price',volumes.price);
                    formObj.setValue('volume_desc',volumes.desc);     
                    formObj.setValue('volume_sort',volumes.sort);   
	<?php }?>

	//商品图片的回填
	<?php if(isset($volumes['thumb'])){?>
                var goodsPhoto = <?php echo JSON::encode($volumes['thumb']);?>;
                for(var item in goodsPhoto)
                {
                        var picHtml = template.render('picTemplate',{'picRoot':goodsPhoto[item]});
                        $('#thumbnails').append(picHtml);
                }
	<?php }?>

	//商品默认图片
	<?php if(isset($form['img']) && $form['img']){?>
	$('#thumbnails img[alt="<?php echo $form['img'];?>"]').addClass('current');
	<?php }?>

	//编辑器载入
	KindEditor.ready(function(K){
		K.create('#content',{uploadJson:'<?php echo IUrl::creatUrl("/block/upload_img_from_editor");?>'});
	});
});

//提交表单前的检查
function checkForm()
{
	//整理商品图片
	var goodsPhoto = [];
	$('#thumbnails img').each(function(){
		goodsPhoto.push(this.alt);
	});
	if(goodsPhoto.length > 0)
	{
		$('input[name="_imgList"]').val(goodsPhoto.join(','));
		$('input[name="img"]').val($('#thumbnails img[class="current"]').attr('alt'));
	}
	return true;
}

/**
 * 图片上传回调,handers.js回调
 * @param picJson => {'flag','img','list','show'}
 */
function uploadPicCallback(picJson)
{
	var picHtml = template.render('picTemplate',{'picRoot':picJson.img});
	$('#thumbnails').append(picHtml);

	//默认设置第一个为默认图片
	if($('#thumbnails img[class="current"]').length == 0)
	{
		$('#thumbnails img:first').addClass('current');
	}
}

/**
 * 设置商品默认图片
 */
function defaultImage(_self)
{
	$('#thumbnails img').removeClass('current');
	$(_self).addClass('current');
}
</script>

		</div>
		<div id="separator"></div>
	</div>

	<script type='text/javascript'>
		//DOM加载完毕执行
		$(function(){
			//隔行换色
			$(".list_table tr:nth-child(even)").addClass('even');
			$(".list_table tr").hover(
				function () {
					$(this).addClass("sel");
				},
				function () {
					$(this).removeClass("sel");
				}
			);

			//后台菜单创建
			<?php $menu = new Menu();?>
			var data = <?php echo $menu->submenu();?>;
			var current = '<?php echo $menu->current;?>';
			var url='<?php echo IUrl::creatUrl("/");?>';
			initMenu(data,current,url);
		});
	</script>
</body>
</html>
