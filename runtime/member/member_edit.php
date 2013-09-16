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
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/artTemplate/area_select.js";?>'></script>

<div class="headbar">
	<div class="position"><span>会员</span><span>></span><span>会员管理</span><span>></span><span><?php if(isset($member['user_id'])){?>编辑会员<?php }else{?>添加会员<?php }?></span></div>
</div>
<div class="content_box">
	<div class="content form_content">
		<form action="<?php echo IUrl::creatUrl("/member/member_save/");?>" method="post" name="memberForm">
			<input name="user_id" value="" type="hidden" />
			<table class="form_table">
				<col width="150px" />
				<col />
				<tbody>
					<tr>
						<th>用户名：</th>
						<td><input class="normal" name="username" type="text" value="" pattern="required" alt="用户名不能为空" /><label>* 用户名称（必填）</label></td>
					</tr>
					<tr>
						<th>邮箱：</th>
						<td><input type="text" class="normal" name="email" pattern="email" alt="邮箱错误" /><label>* 邮箱（必填）</label></td>
					</tr>
					<tr>
						<th>密码：</th><td><input class="normal" name="password" type="password" /><label>登录密码</label></td>
					</tr>
					<tr>
						<th>确认密码：</th><td><input class="normal" name="repassword" type="password" /><label>确认密码</label></td>
					</tr>
					<tr>
						<th>会员组：</th>
						<td>
							<select class="normal" name="group_id">
								<option value=''>请选择</option>
								<?php $query = new IQuery("user_group");$items = $query->find(); foreach($items as $key => $item){?>
								<option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['group_name'])?$item['group_name']:"";?></option>
								<?php }?>
							</select>
						</td>
					</tr>
					<tr>
						<th>姓名：</th>
						<td><input class="normal" name="true_name" type="text" value="" /><label>真实姓名</label></td>
					</tr>
					<tr>
						<th>姓别：</th>
						<td>
							<label><input name="sex" type="radio" value="1" checked="checked" />男</label>
							<label><input name="sex" type="radio" value="2" />女</label>
						</td>
					</tr>
					<tr>
						<th>电话：</th><td><input class="normal" name="telephone" type="text" value="" empty pattern="phone" alt="格式不正确 格式：（地区号-）用户号（-分机号）如010-66668888-123" /><label>格式：（地区号-）用户号（-分机号）如010-66668888-123</label></td>
					</tr>
					<tr>
						<th>手机：</th><td><input class="normal" name="mobile" type="text" value="" empty pattern="mobi" alt="格式不正确" /><label>手机号码</label></td>
					</tr>
					<tr>
						<th>地区：</th>
						<td>
							<select name="province" child="city,area" onchange="areaChangeCallback(this);"></select>
							<select name="city" child="area" parent="province" onchange="areaChangeCallback(this);"></select>
							<select name="area" parent="city"></select>
						</td>
					</tr>
					<tr>
						<th>地址：</th><td><input class="normal" name="contact_addr" type="text" value="" /><label>联系地址</label></td>
					</tr>
					<tr>
						<th>邮编：</th><td><input class="normal" name="zip" type="text" value="" empty pattern="zip" alt="格式不正确（6位数字）" /><label>邮政编码</label></td>
					</tr>
					<tr>
						<th>QQ：</th><td><input class="normal" name="qq" type="text" value="" empty pattern="qq" alt="格式不正确" /><label>QQ号码</label></td>
					</tr>
					<tr>
						<th>MSN：</th><td><input class="normal" name="msn" type="text" value="" /></td>
					</tr>
					<tr>
						<th>经验值：</th><td><input class="normal" name="exp" type="text" value="" /></td>
					</tr>
					<tr>
						<th>积分：</th><td><input class="normal" name="point" type="text" value="" /></td>
					</tr>
					<tr>
						<td></td><td><button class="submit" type="submit"><span>确 定</span></button></td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</div>
<script language="javascript">
//DOM加载完毕
$(function(){
	//初始化地域联动
	template.compile("areaTemplate",areaTemplate);

	//修改模式
	<?php if(isset($this->userInfo)){?>
		var formObj = new Form('memberForm');
		formObj.init(<?php echo JSON::encode($this->userInfo);?>);

		//城市设置
		<?php if($this->userInfo['area']){?>
			<?php $area = explode(',',trim($this->userInfo['area'],','))?>
			createAreaSelect('province',0,"<?php echo isset($area[0])?$area[0]:"";?>");
			createAreaSelect('city',"<?php echo isset($area[0])?$area[0]:"";?>","<?php echo isset($area[1])?$area[1]:"";?>");
			createAreaSelect('area',"<?php echo isset($area[1])?$area[1]:"";?>","<?php echo isset($area[2])?$area[2]:"";?>");
		<?php }else{?>
			createAreaSelect('province',0,"");
		<?php }?>

		//锁定字段一旦注册无法修改
		var lockCols = ['email','username'];
		for(var index in lockCols)
		{
			$('input:text[name="'+lockCols[index]+'"]').addClass('readonly');
			$('input:text[name="'+lockCols[index]+'"]').attr('readonly',true);
		}
	<?php }else{?>
		createAreaSelect('province',0,'');
	<?php }?>
});

/**
 * 生成地域js联动下拉框
 * @param name
 * @param parent_id
 * @param select_id
 */
function createAreaSelect(name,parent_id,select_id)
{
	//生成地区
	$.getJSON("<?php echo IUrl::creatUrl("/block/area_child");?>",{"aid":parent_id,"random":Math.random()},function(json)
	{
		$('[name="'+name+'"]').html(template.render('areaTemplate',{"select_id":select_id,"data":json}));
	});
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
