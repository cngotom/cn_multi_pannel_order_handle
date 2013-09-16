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
			<div class="headbar">
	<div class="position"><span>系统</span><span>></span><span>权限管理</span><span>></span><span><?php if(isset($this->roleRow['id'])){?>编辑<?php }else{?>添加<?php }?>角色</span></div>
</div>
<div class="content_box">
	<div class="content form_content">
		<form action="<?php echo IUrl::creatUrl("/system/role_edit_act");?>" method="post" name="role_edit">
			<input type='hidden' name='id' />
			<table class="form_table">
				<col width="150px" />
				<col />
				<tr>
					<th>名称：</th>
					<td><input type='text' class='normal' name='name' pattern='required' alt='请填写角色名称' /><label>* 角色名称</label></td>
				</tr>
				<tr>
					<th valign="top">权限分配：</th>
					<td>
						<?php if(!empty($this->rightArray)){?>
						<?php foreach($this->rightArray as $rightKey => $groupRight){?>
						<div style='clear:both;padding-top:10px' class='bold'><?php echo isset($rightKey)?$rightKey:"";?> <label><input type='checkbox' id='checkbox_<?php echo isset($rightKey)?$rightKey:"";?>' onclick='checkGroupAll(this,"<?php echo isset($rightKey)?$rightKey:"";?>");' />全选</label></div>
						<ul class='attr_list' id='ul_<?php echo isset($rightKey)?$rightKey:"";?>' alt="<?php echo isset($rightKey)?$rightKey:"";?>">
							<?php foreach($groupRight as $key => $item){?>
							<?php $is_focus = false?>
							<?php if(stripos($this->roleRow['rights'],$item['right']) !== false){?>
							<?php $is_focus = true?>
							<?php }?>
							<li><label class='<?php if($is_focus == true){?>green<?php }else{?>attr<?php }?>'><input type='checkbox' value='<?php echo isset($item['id'])?$item['id']:"";?>' name='right[]' <?php if($is_focus == true){?>checked=checked<?php }?> onclick='checkItem("<?php echo isset($rightKey)?$rightKey:"";?>");' /><?php echo isset($item['name'])?$item['name']:"";?></label></li>
							<?php }?>
						</ul>
						<?php }?>
						<?php }?>

						<?php if(!empty($this->rightUndefined)){?>
						<ul class='attr_list'>
							<?php foreach($this->rightUndefined as $key => $item){?>
							<li><label class='<?php if($is_focus == true){?>green<?php }else{?>attr<?php }?>'><input type='checkbox' value='<?php echo isset($item['id'])?$item['id']:"";?>' name='right[]' <?php if($is_focus == true){?>checked=checked<?php }?> /><?php echo isset($item['name'])?$item['name']:"";?></label></li>
							<?php }?>
						</ul>
						<?php }?>
					</td>
				</tr>
				<tr><td></td><td><button class="submit" type='submit'><span>保 存</span></button></td></tr>
			</table>
		</form>
	</div>
</div>

<script type='text/javascript'>
	var formObj = new Form('role_edit');
	formObj.init({
		'id':'<?php echo isset($this->roleRow['id'])?$this->roleRow['id']:"";?>',
		'name':'<?php echo isset($this->roleRow['name'])?$this->roleRow['name']:"";?>'
	});

	//分组权限全选
	function checkGroupAll(obj,nameVal)
	{
		if(obj.checked == true)
		{
			$('#ul_'+nameVal+' [name="right[]"]').attr('checked',true);
		}
		else
		{
			$('#ul_'+nameVal+' [name="right[]"]').attr('checked',false);
		}
	}

	//选择权限
	function checkItem(nameVal)
	{
		var totalNum   = $('#ul_'+nameVal+' [name="right[]"]').length;
		var checkedNum = $('#ul_'+nameVal+' [name="right[]"]:checked').length;

		if(checkedNum >= totalNum)
		{
			$('#checkbox_'+nameVal).attr('checked',true);
		}
		else
		{
			$('#checkbox_'+nameVal).attr('checked',false);
		}
	}

	//预选择复选框
	jQuery(function(){
		$('ul.attr_list[alt]').each(
			function(i)
			{
				checkItem($(this).attr('alt'));
			}
		);
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
