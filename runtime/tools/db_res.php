<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>后台管理</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/admin.css";?>" />
	<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/bootstrap.min.css";?>" />
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
	<div class="contain">
		<div id="header">
			<div class="logo">
				<a href="<?php echo IUrl::creatUrl("/system/default");?>"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/logo.gif";?>" width="303" height="43" /></a>
			</div>
			<div id="menu">
				<ul name="menu">
				</ul>
			</div>
			<p><a href="<?php echo IUrl::creatUrl("/systemadmin/logout");?>">退出管理</a></p>
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
	<div class="position"><span>工具</span><span>></span><span>数据库管理</span><span>></span><span>恢复数据库</span></div>
	<div class="operating">
		<a href="javascript:void(0)" onclick="selectAll('name[]');"><button class="operating_btn" type="button"><span class="sel_all">全选</span></button></a>
		<a href="javascript:void(0)" onclick="delModel()"><button class="operating_btn" type="button"><span class="delete">批量删除</span></button></a>
		<a href="javascript:void(0)" onclick="confirm('确定要还原么？','res_act()')"><button class="operating_btn" type="button"><span class="import">还原</span></button></a>
		<a href="javascript:void(0)" onclick="confirm('确定要打包下载么？','res_pack()')"><button class="operating_btn" type="button"><span class="download">打包下载</span></button></a>
		<a href="javascript:void(0)" onclick="localUpload();"><button class="operating_btn" type="button"><span class="import">本地导入</span></button></a>
	</div>
	<div class="field">
		<table class="list_table">
			<col width="40px" />
			<col width="300px" />
			<col width="120px" />
			<col width="150px" />
			<col />
			<thead>
				<tr>
					<th class="t_c">选择</th>
					<th>文件名</th>
					<th>使用空间</th>
					<th>备份时间</th>
					<th>操作</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
<div class="content">
	<form action='<?php echo IUrl::creatUrl("/tools/backup_del");?>' method='post' name='resForm'>
		<table class="list_table">
			<col width="40px" />
			<col width="300px" />
			<col width="120px" />
			<col width="150px" />
			<col />
			<tbody>
				<?php foreach($system as $key => $item){?>
				<tr>
					<td class="t_c"><input type="checkbox" name="name[]" value="<?php echo isset($item['name'])?$item['name']:"";?>" /></td>
					<td><?php echo isset($item['name'])?$item['name']:"";?></td>
					<td><?php echo isset($item['size'])?$item['size']:"";?>KB</td>
					<td><?php echo isset($item['time'])?$item['time']:"";?></td>
					<td>
						<a href="<?php echo IUrl::creatUrl("/tools/download/file/$item[name]");?>"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_down.gif";?>" alt="下载" title="下载" /></a>
						<a href='javascript:void(0)' onclick="delModel({link:'<?php echo IUrl::creatUrl("/tools/backup_del/name/$item[name]");?>'});"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_del.gif";?>" alt="删除" title="删除" /></a>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</form>
</div>
<script type='text/javascript'>
	//还原操作
	function res_act()
	{
		art.dialog({id:'message'}).content('<img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/loading.gif";?>" />正在还原请稍候......');
		var dataJson = getArray('name[]','checkbox');
		$.post('<?php echo IUrl::creatUrl("/tools/res_act");?>',{name:dataJson},function(c)
		{
			if(c.isError == true)
				alert(c.message);
			else
				window.location.href=c.redirect;

			art.dialog({id:'message'}).close();
		}
		,'json');
	}

	//打包下载操作
	function res_pack()
	{
		document.forms[0].action = '<?php echo IUrl::creatUrl("/tools/download_pack");?>';
		document.forms[0].submit();
	}

	//本地上传附件
	function localUpload()
	{
		var formStr =
			'<form action="<?php echo IUrl::creatUrl("/tools/localUpload");?>" method="post" enctype="multipart/form-data">'+
				'<table width="90%" class="border_table" style="margin:10px auto">'+
					'<tbody>'+
						'<tr>'+
							'<th>要导入的SQL文件：</th><td><input class="normal" name="attach" type="file" /></td>'+
						'</tr>'+
						'<tr>'+
							'<th></th><td><button class="submit" type="submit"><span>上传</span></button></td>'+
						'</tr>'+
					'</tbody>'+
				'</table>'+
			'</form>';

		art.dialog({id:'localUpload'}).content(formStr);
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
