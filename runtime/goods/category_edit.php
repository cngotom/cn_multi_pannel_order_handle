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
<div class="headbar">
	<div class="position"><span>商品</span><span>></span><span>商品分类管理</span><span>></span><span><?php if(isset($category['id'])){?>编辑<?php }else{?>添加<?php }?>分类</span></div>
</div>
<div class="content_box">
	<div class="content form_content">
		<form action="<?php echo IUrl::creatUrl("/goods/category_save/");?>" method="post">
			<table class="form_table" cellpadding="0" cellspacing="0">
				<col width="150px" />
				<col />
				<tr>
					<th>分类名称：</th>
					<td>
						<input class="normal" name="name" type="text" value="<?php echo isset($category['name'])?$category['name']:"";?>" pattern="required" alt="分类名称不能为空" /><label>* 必选项</label>
						<input name="category_id" value="<?php echo isset($category['id'])?$category['id']:"";?>" type="hidden" />
					</td>
				</tr>
				<tr>
					<th>上级分类：</th>
					<td>
						<select class="normal" name="parent_id" onchange='update_model();'>
						<option value="0">顶级分类</option>
						<?php foreach($all_category as $key => $value){?>
						<option value="<?php echo isset($value['id'])?$value['id']:"";?>" <?php if($category['parent_id']==$value['id']){?> selected <?php }?> model_id="<?php echo isset($value['model_id'])?$value['model_id']:"";?>"><?php echo isset($value['name'])?$value['name']:"";?></option>
						<?php }?>
						</select>
					</td>
				</tr>
				<tr>
					<th>商品模型：</th>
					<td>
						<?php if($models){?>
						<select class="normal" name="model" pattern='required' alt='必需选择商品模型'>
							<option value=''>选择商品模型</option>
							<?php foreach($models as $key => $value){?>
							<option value="<?php echo isset($value['id'])?$value['id']:"";?>" <?php if(isset($category['model_id']) && $category['model_id']==$value['id']){?> selected <?php }?>><?php echo isset($value['name'])?$value['name']:"";?></option>
							<?php }?>
						</select>
						<label>* 必选项</label>
						<?php }else{?>
						系统暂无商品模型，<a href='<?php echo IUrl::creatUrl("/goods/model_edit");?>' class='orange'>请点击添加</a>
						<?php }?>
					</td>
				</tr>
				<tr>
					<th>首页是否显示：</th>
					<td>
						<label class='attr'><input name="visibility" type="radio" value="1" checked='checked' /> 是 </label>
						<label class='attr'><input name="visibility" type="radio" value="0" <?php if(isset($category['visibility']) && $category['visibility']==0){?> checked='checked' <?php }?> /> 否 </label>
					</td>
				</tr>
				<tr>
					<th>排序：</th><td><input class="normal" name="sort" pattern='int' empty alt='排序必须是一个数字' type="text" value="<?php echo isset($category['sort'])?$category['sort']:"";?>"/></td>
				</tr>
				<tr>
					<th>SEO标题：</th><td><input class="normal" name="title" type="text" value="<?php echo isset($category['title'])?$category['title']:"";?>" /></td>
				</tr>
				<tr>
					<th>SEO关键词：</th><td><input class="normal" name="keywords" type="text" value="<?php echo isset($category['keywords'])?$category['keywords']:"";?>" /></td>
				</tr>
				<tr>
					<th>SEO描述：</th><td><textarea name="descript" cols="" rows=""><?php echo isset($category['descript'])?$category['descript']:"";?></textarea></td>
				</tr>
				<tr>
					<td></td><td><button class="submit" type="submit"><span>确 定</span></button></td>
				</tr>
			</table>
		</form>
	</div>
</div>
<script type='text/javascript'>
	//修改分类同步模型
	function update_model()
	{
		var selectedOption = $('[name="parent_id"] option:selected');
		$('[name="model"]').val(selectedOption.attr('model_id'));
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
