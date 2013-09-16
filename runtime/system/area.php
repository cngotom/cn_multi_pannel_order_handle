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
	<div class="position"><span>系统</span><span>></span><span>配送管理</span><span>></span><span>地区管理</span></div>
	<div class="operating">
		<a href="javascript:void(0)"><button class="operating_btn" type="button" onclick='event_link("<?php echo IUrl::creatUrl("/system/area_edit");?>")'><span class="addition">添加地区</span></button></a>
	</div>
	<div class="field">
		<table class="list_table">
			<col width="100px" />
			<col width="50px" />
			<col width="300px" />
			<col />
			<thead>
				<tr>
					<th>排序</th>
					<th></th>
					<th>地区名称</th>
					<th>操作</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
<div class="content">
	<table class="list_table">
		<col width="100px" />
		<col width="50px" />
		<col width="300px" />
		<col />
		<tbody>
			<?php $query = new IQuery("areas");$query->where = "parent_id = 0";$query->order = "sort asc";$items = $query->find(); foreach($items as $key => $item){?>
			<tr parent=<?php echo isset($item['parent_id'])?$item['parent_id']:"";?>>
				<td><input class="tiny" id="sort<?php echo isset($item['area_id'])?$item['area_id']:"";?>" onblur="toSort(<?php echo isset($item['area_id'])?$item['area_id']:"";?>);" size="2" type="text" value="<?php echo isset($item['sort'])?$item['sort']:"";?>" /></td>
				<td></td>
				<td class="switch" parent=<?php echo isset($item['parent_id'])?$item['parent_id']:"";?>>
					<img id="<?php echo isset($item['area_id'])?$item['area_id']:"";?>" class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/open.gif";?>" alt="展开" />
					<?php echo isset($item['area_name'])?$item['area_name']:"";?>
				</td>
				<td><a href="<?php echo IUrl::creatUrl("/system/area_edit/aid/$item[area_id]/pid/$item[parent_id]");?>"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_edit.gif";?>" alt="修改" /></a><a href="javascript:void(0)" onclick="area_del(this,'<?php echo isset($item['area_id'])?$item['area_id']:"";?>')"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_del.gif";?>" alt="删除" /></a></td>
			</tr>
			<?php }?>
		</tbody>
	</table>
</div>

<script language="javascript">
function toggle(obj_jq,indent)
{
	$(obj_jq).each(function(i) {
		var obj_tr = $(this).parent().parent();
		$(this).toggle(function(){
			if (obj_tr.next("tr[grade='child']").length>0)
			{
				obj_tr.next("tr[grade='child']").toggle(true);
			}else{
				$.get("<?php echo IUrl::creatUrl("/block/area_child/");?>",{aid:$(this).attr('id')},function(areas){
					if (areas.length>0)
					{
						var html = '<tr grade="child"><td colspan="4" style="padding:0px;border:0px;height:auto;"><table width="100%"><col width="100px" /><col width="50px" /><col width="300px" /><col /><tbody>';

						for (var i=0;i<areas.length ;i++ )
						{
							var addButton  = '<?php echo IUrl::creatUrl("/system/area_edit/pid/@pid@");?>';
							var addButton  = addButton.replace('@pid@',areas[i].area_id);

							var editButton = '<?php echo IUrl::creatUrl("/system/area_edit/aid/@aid@/pid/@pid@");?>';
							var editButton = editButton.replace('@aid@',areas[i].area_id);
							var editButton = editButton.replace('@pid@',areas[i].parent_id);
							html += '<tr parent="'+areas[i].parent_id+'">'+
									'	<td><input class="tiny" id="sort'+areas[i].area_id+'" onblur="toSort(<?php echo isset($item['id'])?$item['id']:"";?>);" size="2" type="text" value="'+areas[i].sort+'" /></td><td></td>'+
									'	<td style="padding-left:'+indent+'px;" class="switch" parent="'+areas[i].parent_id+'"><img id="'+areas[i].area_id+'" class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/open.gif";?>" alt="展开" />'+
									'	'+areas[i].area_name+'</td>'+
									'	<td><a href="'+addButton+'"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_add.gif";?>" alt="添加" /></a>'+
									'		<a href="'+editButton+'"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_edit.gif";?>" alt="修改" /></a>'+
									'		<a href="javascript:void(0)" onclick="area_del(this,'+areas[i].area_id+')"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_del.gif";?>" alt="删除" /></a>'+
									'	</td>'+
									'</tr>';
						}
						html += '</tbody></table></td></tr>';
						obj_tr.after(html);
						toggle(obj_tr.next("tr[grade='child']").find("td.switch .operator").get(),indent+pl);
					}
				},'json');
			}
			$(this).attr("src", "<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/close.gif";?>");
		},function(){
			obj_tr.next("tr[grade='child']").toggle(false);
			$(this).attr("src", "<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/open.gif";?>");
		});
	});
}
//缩进像素
pl=20;
toggle($("td.switch .operator").get(),pl);
function area_del(obj,aid)
{
	art.dialog({
		title: '删除地区',
		width:200,
		height:80,
		icon:'confirm',
		content: '<br />是否删除此地区？',
		ok:function(){
			$.get("<?php echo IUrl::creatUrl("/system/area_del/");?>",{'aid':aid},function(i){
				if (i!='-1')
				{
					var tbody = $(obj).parent().parent().parent();
					var tr_child = tbody.parent().parent().parent();
					$(obj).parent().parent().remove();
					if (tbody.children().length<1)
					{
						tr_child.remove();
					}
				}
				else
				{
					alert('不能删除此分类，此分类下还存在子分类');
				}
			});
			return true;
		},
		cancel: true
	});
}
//排序
function toSort(id)
{
	if(id!='')
	{
		var va = $('#sort'+id).val();
		if(va!='' && va!=undefined)
		{
			$.get("<?php echo IUrl::creatUrl("/system/area_sort");?>",{'id':id,'sort':va}, function(data)
			{
				if(data=='0')
				{
					alert('修改商品品牌排序错误!');
				}
			});
		}
	}
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
