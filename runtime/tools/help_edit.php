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
<?php $id=IReq::get('id');?>
<div class="headbar">
	<div class="position"><span>工具</span><span>></span><span>帮助管理</span><span>></span><span><?php if(isset($id)){?>编辑<?php }else{?>添加<?php }?>帮助文档</span></div>
</div>
<div class="content_box">
	<div class="content form_content">
		<?php if($id!==null){?>
		<form action='<?php echo IUrl::creatUrl("/tools/help_edit_act/id/$id");?>' method='post' name='article'>
		<?php }else{?>
		<form action='<?php echo IUrl::creatUrl("/tools/help_edit_act");?>' method='post' name='article'>
		<?php }?>

			<table class="form_table">
				<col width="150px" />
				<col />
				<?php if($id!==null){?>
				<input type='hidden' name='id' value="<?php echo isset($id)?$id:"";?>" />
				<?php }?>
				<tr>
					<th>分类：</th>
					<td>
						<select name="cat_id" class="auto" pattern="required" alt="请选择分类值" >
						<?php $query = new IQuery("help_category");$query->order = "sort ASC";$items = $query->find(); foreach($items as $key => $item){?>
							<?php $checked=$this->help_row['cat_id']==$item['id']?" selected='selected' ":""?>
							<option value="<?php echo isset($item['id'])?$item['id']:"";?>" <?php echo isset($checked)?$checked:"";?> ><?php echo isset($item['name'])?$item['name']:"";?></option>
						<?php }?>
						</select>

						<label>*选择帮助所属分类（必填）</label>
					</td>
				</tr>
				<tr>
					<th>标题：</th>
					<td><input type='text' name='name' class='normal' value='<?php echo isset($this->help_row['name'])?$this->help_row['name']:"";?>' pattern='required' alt='标题不能为空' /></td>
				</tr>
				<tr>
					<th>排序：</th><td><input type='text' pattern="int" alt="请填写整数" class='small' name='sort' value='<?php echo isset($this->help_row['sort'])?$this->help_row['sort']:"";?>' /><label>数字越小位置越靠前</label></td>
				</tr>

				<tr>
					<th valign="top">内容：</th><td><textarea id="content" name='content' style='width:700px;height:300px' pattern='required' alt='内容不能为空'><?php echo htmlspecialchars($this->help_row['content']);?></textarea></td>
				</tr>
				<tr>
					<th></th><td><button class='submit' type='submit'><span>确 定</span></button></td>
				</tr>
			</table>
		</form>
	</div>
</div>

<script type='text/javascript'>
	KindEditor.ready(function(K){
		K.create('#content',{uploadJson:'<?php echo IUrl::creatUrl("/block/upload_img_from_editor");?>'});
	});
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
