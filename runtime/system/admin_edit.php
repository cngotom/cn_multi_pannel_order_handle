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
	<div class="position"><span>系统</span><span>></span><span>权限管理</span><span>></span><span>管理员<?php if(isset($this->adminRow['id'])){?>编辑<?php }else{?>添加<?php }?></span></div>
</div>
<div class="content_box">
	<div class="content form_content">
		<form action="<?php echo IUrl::creatUrl("/system/admin_edit_act");?>"  method="post" name="admin_edit">
			<input type='hidden' name='id' />
			<table class="form_table">
				<col width="150px" />
				<col />
				<tr>
					<th>用户名：</th>
					<td>
						<input type='text' name='admin_name' class='normal' pattern='^\w{4,20}$' alt='请填写英文字母，数字或下划线，在4-20个字符之间' onblur="checkName();" />
						<label id='unique'>* 管理员登录后台的用户名，请填写英文字母，数字或下划线，在4-20个字符之间</label>
					</td>
				</tr>

				<?php if($this->adminRow['id']){?>
				<tr name="reset_pwd">
					<th>密码重设：</th>
					<td><button type='button' class='btn' onclick="reset_pwd();"><span>重 设</span></button></td>
				</tr>
				<?php }?>

				<tr name="pwd">
					<th>密码：</th>
					<td>
						<input type='password' class='normal' name='password' pattern='^\w{6,32}$' alt='请填写英文字母，数字或下划线，在6-32个字符之间' />
						<label>* 管理员登录后台的密码，请填写英文字母，数字或下划线，在6-32个字符之间</label>
					</td>
				</tr>

				<tr name="pwd">
					<th>重复密码：</th>
					<td>
						<input type='password' class='normal' name='repassword' pattern='^\w{6,32}$' alt='重复输入管理员登录后台的密码' bind='password' />
						<label>* 重复输入管理员登录后台的密码</label>
					</td>
				</tr>

				<tr>
					<th>角色：</th>
					<td>
						<?php if($this->adminRow['id'] == 1 && $this->adminRow['role_id'] == 0){?>
						超级管理员
						<?php }else{?>
						<select class='normal' name='role_id' pattern='required' alt='请选择一个角色'>
							<option value=''>请选择</option>
							<option value='0'>超级管理员</option>
							<?php $query = new IQuery("admin_role");$items = $query->find(); foreach($items as $key => $item){?>
							<option value='<?php echo isset($item['id'])?$item['id']:"";?>'><?php echo isset($item['name'])?$item['name']:"";?></option>
							<?php }?>
						</select>
						<label>*为管理员分配一个角色</label>
						<?php }?>

						<label class='attr'><button id="specAddButton" class="btn" type="button" onclick="window.location.href='<?php echo IUrl::creatUrl("/system/role_edit");?>'"><span class="add">添加角色</span></button></label>
					</td>
				</tr>
				<tr>
					<th>Email:</th>
					<td>
						<input type='text' name='email' class='normal' pattern='email' empty alt='请填写正确的email格式' />
						<label>联系此管理员的email邮箱地址</label>
					</td>
				</tr>
				<tr><td></td><td><button class="submit" type="submit"><span>保 存</span></button></td></tr>
			</table>
		</form>
	</div>
</div>

<script type='text/javascript'>

	//ajax检查admin_name唯一性
	function checkName()
	{
		var nameVal = $('[name="admin_name"]').val(); //获取登录名
		var idVal   = $('[name="id"]').val();         //获取id

		jQuery.post(
			'<?php echo IUrl::creatUrl("/system/check_admin");?>',{admin_name:nameVal,admin_id:idVal},function(content)
			{
				var content = $.trim(content);
				if(content == -1)
				{
					$('[name="admin_name"]').removeClass('valid-text');
					$('#unique').removeClass('valid-msg');

					$('[name="admin_name"]').addClass('invalid-text');
					$('#unique').addClass('invalid-msg');

					$('#unique').html(nameVal+'用户名已经存在，请重新更换一个');
				}
			}
		);
	}

	//展示密码重设
	function reset_pwd()
	{
		$('[name="reset_pwd"]').hide();

		$('[name="pwd"]').each(
			function (i)
			{
				$('[name="pwd"]:eq('+i+') *').show();
			}
		);
	}

	//修改信息时自动隐藏
	<?php if($this->adminRow['id']){?>
		$('[name="pwd"] *').hide();
	<?php }?>

	//表单回填
	var formObj = new Form('admin_edit');
	formObj.init
	({
		'id':'<?php echo isset($this->adminRow['id'])?$this->adminRow['id']:"";?>',
		'admin_name':'<?php echo isset($this->adminRow['admin_name'])?$this->adminRow['admin_name']:"";?>',
		'role_id':'<?php echo isset($this->adminRow['role_id'])?$this->adminRow['role_id']:"";?>',
		'email':'<?php echo isset($this->adminRow['email'])?$this->adminRow['email']:"";?>'
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
