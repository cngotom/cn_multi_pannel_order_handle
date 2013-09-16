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
			<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/my97date/wdatepicker.js"></script>
<div class="headbar">
	<div class="position"><span>会员</span><span>></span><span>邮件短信设置</span><span>></span><span>到货通知</span></div>
	<div class="operating">
		<a href="javascript:void(0)" onclick="sendMail()"><button class="operating_btn" type="button"><span class="remove">发送通知</span></button></a>
		<a href="javascript:void(0)" onclick="selectAll('check[]')"><button class="operating_btn" type="button"><span class="sel_all">全选</span></button></a>
		<a href="javascript:void(0)" onclick="delModel({form:'notify_list',msg:'确定要删除选中的记录吗？'})"><button class="operating_btn" type="button"><span class="delete">批量删除</span></button></a>
		<a href="javascript:void(0)" onclick="location.reload()"><button class="operating_btn" type="button"><span class="refresh">刷新</span></button></a>
		<a href="javascript:void(0)" onclick="filter()"><button class="operating_btn" type="button"><span class="filter">筛选</span></button></a>
		<a href="javascript:void(0)" onclick="exportCSV();return false;"><button class="operating_btn" type="button"><span class="download">导出为CSV</span></button></a>
	</div>
	<div class="field">
		<table class="list_table">
			<col width="40px" />
			<col />
			<col width="100px" />
			<col width="100px" />
			<col width="150px" />
			<col width="150px" />
			<col width="150px" />
			<col width="150px" />
			<thead>
				<tr role="head">
					<th class="t_c">选择</th>
					<th>缺货商品名称</th>
					<th datatype="num">库存</th>
					<th>用户名</th>
					<th>email</th>
					<th>登记时间</th>
					<th>通知时间</th>
					<th>通知状态</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
<form action="<?php echo IUrl::creatUrl("/message/notify_del");?>" method="post" name="notify_list" onsubmit="return checkboxCheck('check[]','尚未选中任何记录！')">
<div class="content" style="position:relative;">
	<input type="hidden" name="move_group" value="" />
	<table id="list_table" class="list_table">
		<col width="40px" />
		<col />
		<col width="100px" />
		<col width="100px" />
		<col width="150px" />
		<col width="150px" />
		<col width="150px" />
		<col width="150px" />
		<tbody>
			<?php $page= (isset($_GET['page'])&&(intval($_GET['page'])>0))?intval($_GET['page']):1;?>
			<?php $query = new IQuery("notify_registry as notify");$query->join = "left join goods as goods on notify.goods_id = goods.id left join user as u on notify.user_id = u.id";$query->fields = "notify.*,u.username,goods.name as goods_name,goods.store_nums";$query->page = "$page";$query->where = "$where";$items = $query->find(); foreach($items as $key => $item){?>
			<tr>
				<td class="t_c"><input class="check_ids" name="check[]" type="checkbox" value="<?php echo isset($item['id'])?$item['id']:"";?>" /></td>
				<td><a href="<?php echo IUrl::creatUrl("/goods/goods_edit/gid/$item[goods_id]");?>"><?php echo isset($item['goods_name'])?$item['goods_name']:"";?></a></td>
				<td><?php echo isset($item['store_nums'])?$item['store_nums']:"";?></td>
				<td><a href="<?php echo IUrl::creatUrl("/member/member_edit/uid/$item[user_id]");?>"><?php echo isset($item['username'])?$item['username']:"";?></a></td>
				<td><?php echo isset($item['email'])?$item['email']:"";?></td>
				<td><?php echo isset($item['register_time'])?$item['register_time']:"";?></td>
				<td><?php echo isset($item['notify_time'])?$item['notify_time']:"";?></td>
				<td><?php if($item['notify_status']==1){?>已通知<?php }else{?><font color="#FF0000">未通知</font><?php }?></td>
			</tr>
			<?php }?>
		</tbody>
	</table>
</div>



<?php echo $query->getPageBar();?>
</form>
<SCRIPT LANGUAGE="JavaScript">
var content_filter = {};
var tpl_filter =	'<form name="form_filter" action="" method="post"></form>'+
					'<div name="filter" style="width:630px;">'+
					'	<div name="menu" style="clear:both;width:100%;float:left;border-bottom:1px solid #DDDDDD;height:24px;">'+
					'		<div style="width:120px;float:left;">添加筛选条件：</div>'+
					'		<div style="width:100px;float:left;"><select name="requirement" onchange="addoption()">'+
					'				<option value="c">请选择</option>'+
					'				<option value="goodsname">商品名称</option>'+
					'				<option value="username">用户名</option>'+
					'				<option value="store_nums">库存</option>'+
					'				<option value="email">Email</option>'+
					'				<option value="regtime">登记日期</option>'+
					'				<option value="status">通知状态</option>'+
					'			</select></div>'+
					'		<div><a href="javascript:void(0)" onclick="del_all_option()" >删除所有筛选条件</a></div>'+
					'	</div>'+
					'</div>';
var tpl_option = new Array();
tpl_option['goodsname'] =	'	<div name="goodsname" style="clear:both;width:100%;float:left;border-bottom:1px solid #DDDDDD;">'+
						'		<div style="width:120px;float:left;border-right:1px solid #DDDDDD;height:24px;">商品名称</div>'+
						'		<div style="width:100px;float:left;border-right:1px solid #DDDDDD;height:24px;padding-left:3px;"><select name="goodsname_key"><option value="eq">等于</option><option value="contain">包含</option></select></div>'+
						'		<div style="width:350px;float:left;border-right:1px solid #DDDDDD;height:24px;padding-left:3px;"><input type="text" name="goodsname_value" /></div>'+
						'		<div style="border-right:1px solid #DDDDDD;height:24px;width:26px;float:left;"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_del.gif";?>" alt="删除" onclick="del_option(this)" /></div>'+
						'	</div>';
tpl_option['username'] ='	<div name="username" style="clear:both;width:100%;float:left;border-bottom:1px solid #DDDDDD;">'+
						'		<div style="width:120px;float:left;border-right:1px solid #DDDDDD;height:24px;">用户名</div>'+
						'		<div style="width:100px;float:left;border-right:1px solid #DDDDDD;height:24px;padding-left:3px;"><select name="username_key"><option value="eq">等于</option><option value="contain">包含</option></select></div>'+
						'		<div style="width:350px;float:left;border-right:1px solid #DDDDDD;height:24px;padding-left:3px;"><input type="text" name="username_value" /></div>'+
						'		<div style="border-right:1px solid #DDDDDD;height:24px;width:26px;float:left;"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_del.gif";?>" alt="删除" onclick="del_option(this)" /></div>'+
						'	</div>';
tpl_option['store_nums'] ='	<div name="store_nums" style="clear:both;width:100%;float:left;border-bottom:1px solid #DDDDDD;">'+
						'		<div style="width:120px;float:left;border-right:1px solid #DDDDDD;height:24px;">库存</div>'+
						'		<div style="width:100px;float:left;border-right:1px solid #DDDDDD;height:24px;padding-left:3px;"><select name="store_nums_key"><option value="gt">大于</option><option value="eq">等于</option><option value="lt">小于</option></select></div>'+
						'		<div style="width:350px;float:left;border-right:1px solid #DDDDDD;height:24px;padding-left:3px;"><input type="text" name="store_nums_value" /></div>'+
						'		<div style="border-right:1px solid #DDDDDD;height:24px;width:26px;float:left;"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_del.gif";?>" alt="删除" onclick="del_option(this)" /></div>'+
						'	</div>';
tpl_option['email']	=	'	<div name="email" style="clear:both;width:100%;float:left;border-bottom:1px solid #DDDDDD;">'+
						'		<div style="width:120px;float:left;border-right:1px solid #DDDDDD;height:24px;">Email</div>'+
						'		<div style="width:100px;float:left;border-right:1px solid #DDDDDD;height:24px;padding-left:3px;"><select name="email_key"><option value="eq">等于</option><option value="contain">包含</option></select></div>'+
						'		<div style="width:350px;float:left;border-right:1px solid #DDDDDD;height:24px;padding-left:3px;"><input type="text" name="email_value" /></div>'+
						'		<div style="border-right:1px solid #DDDDDD;height:24px;width:26px;float:left;"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_del.gif";?>" alt="删除" onclick="del_option(this)" /></div>'+
						'	</div>';
tpl_option['regtime'] =	'	<div name="regtime" style="clear:both;width:100%;float:left;border-bottom:1px solid #DDDDDD;">'+
						'		<div style="width:120px;float:left;border-right:1px solid #DDDDDD;height:24px;">登记时间</div>'+
						'		<div style="width:100px;float:left;border-right:1px solid #DDDDDD;height:24px;padding-left:3px;">开始 - 截止</div>'+
						'		<div style="width:350px;float:left;border-right:1px solid #DDDDDD;height:24px;padding-left:3px;"><input type="text" name="regtimeBegin" onfocus="WdatePicker()" style="width:80px;" /> - <input type="text" name="regtimeEnd" onfocus="WdatePicker()" style="width:80px;" /></div>'+
						'		<div style="border-right:1px solid #DDDDDD;height:24px;width:26px;float:left;"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_del.gif";?>" alt="删除" onclick="del_option(this)" /></div>'+
						'	</div>';
tpl_option['status'] ='	<div name="status" style="clear:both;width:100%;float:left;border-bottom:1px solid #DDDDDD;">'+
						'		<div style="width:120px;float:left;border-right:1px solid #DDDDDD;height:24px;">通知状态</div>'+
						'		<div style="width:100px;float:left;border-right:1px solid #DDDDDD;height:24px;padding-left:3px;"></div>'+
						'		<div style="width:350px;float:left;border-right:1px solid #DDDDDD;height:24px;padding-left:3px;"><select name="status"><option value="-1">请选择</option><option value="1">已通知</option><option value="0">未通知</option></select></div>'+
						'		<div style="border-right:1px solid #DDDDDD;height:24px;width:26px;float:left;"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_del.gif";?>" alt="删除" onclick="del_option(this)" /></div>'+
						'	</div>';
function sendMail()
{
	var ids = getArray('check[]','checkbox')
	if(ids.length>0)
	{
		art.dialog({id:'message'}).content('<p class="t_c"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/loading.gif";?>" /><br />正在发送邮件，请稍候......</p>');
		$.getJSON('<?php echo IUrl::creatUrl("/message/notify_send");?>',{notifyid:ids},function(c){
			art.dialog({id:'message'}).close();
			if(c.isError == false)
			{
				art.dialog({
					content: '总共发送邮件：'+c.count+'条<br />成功发送：'+c.succeed+'条<br />发送失败：'+c.failed+'条',
					icon: 'alert',
					lock: true,
					ok: function(){
						location.reload();
						return true;
					}
				});
			}
			else
			{
				alert(c.message);
			}
		});
	}
	else
	{
		alert("您尚未选中任何记录！");
	}
}
function filter()
{
	art.dialog({
		id: 'filter',
		title: '筛选',
		height: '320px',
		width: '480px',
		border: false,
		content: content_filter,
		tmpl: tpl_filter,
		ok:function(){
			var obj = $("select[name='requirement'] option");
			var queryurl = '';
			for (var i=1;i<obj.length ;i++)
			{
				if ($(obj[i]).attr('disabled')==true)
				{
					switch ($(obj[i]).val())
					{
						case 'goodsname':
							queryurl += 'goodsname_k='+$("select[name='goodsname_key']").val()+'&goodsname_v='+$(":input[name='goodsname_value']").val()+'&';
							break;
						case 'username':
							queryurl += 'username_k='+$("select[name='username_key']").val()+'&username_v='+$(":input[name='username_value']").val()+'&';
							break;
						case 'store_nums':
							queryurl += 'store_nums_k='+$("select[name='store_nums_key']").val()+'&store_nums_v='+$(":input[name='store_nums_value']").val()+'&';
							break;
						case 'email':
							queryurl += 'email_k='+$("select[name='email_key']").val()+'&email_v='+$(":input[name='email_value']").val()+'&';
							break;
						case 'regtime':
							queryurl += 'regtimeBegin='+$(":input[name='regtimeBegin']").val()+'&regtimeEnd='+$(":input[name='regtimeEnd']").val()+'&';
							break;
						case 'status':
							queryurl += 'status='+$("select[name='status']").val()+'&';
							break;
					}
				}
			}
			var tempUrl = '<?php echo IUrl::creatUrl("/message/notify_filter/@queryurl@");?>';
			tempUrl     = tempUrl.replace('@queryurl@',queryurl);
			$("form[name='form_filter']").attr('action',tempUrl);
			$("form[name='form_filter']").submit();
			return true;
		},
		cancel:true
	});
}
function del_all_option()
{
	$("div[name='filter']").children().not("div[name='menu']").each(function(i){
		$(this).remove();
	});
	$("select[name='requirement'] option").each(function(i){
		$(this).removeAttr('disabled');
	});
}
function del_option(obj)
{
	var name = $(obj).parent().parent().attr('name');
	$("select[name='requirement'] option[value='"+name+"']").removeAttr('disabled');
	$(obj).parent().parent().remove();
}
function addoption()
{
	var obj = $("select[name='requirement'] option:selected");
	if ($("div[name='"+obj.val()+"']").length<1)
	{
		$("div[name='filter']").append(tpl_option[obj.val()]);
	}
	obj.attr('disabled',true);
	$("select[name='requirement'] option:selected").removeAttr('selected');
}
function exportCSV()
{
	var ids=$(".check_ids:checked");

	if(ids.length==0)
	{
		alert("请选择要导出的行");
		return;
	}

	var content='<form action="<?php echo IUrl::creatUrl("/message/notify_export/");?>" method="post"><p style="margin-top:10px;">'+
		'	<span class="rcspan"><input name="csv_field[]" type="checkbox" value="goods_name" /><span>缺货商品名称</span></span>'+
		'	<span class="rcspan"><input name="csv_field[]" type="checkbox" value="store_nums" /><span>当前库存</span></span>'+
		'	<span class="rcspan"><input name="csv_field[]" type="checkbox" value="username" /><span>用户名</span></span>'+
		'	<span class="rcspan"><input name="csv_field[]" type="checkbox" value="email" /><span>email</span></span>'+
		'	<span class="rcspan"><input name="csv_field[]" type="checkbox" value="register_time" /><span>登记时间</span></span>'+
		'	<span class="rcspan"><input name="csv_field[]" type="checkbox" value="content" /><span>通知内容</span></span>'+
		'</p>'+
		'<br /><p>文件编码：<span class="rcspan"><input name="csv_encode" value="utf" type="radio" />utf8格式</span><span class="rcspan"><input name="csv_encode" value="gbk" type="radio" checked />GBK格式</span></p>'+
		'<p style="margin-top:10px;"><input type="submit" value="选择好了，现在导出" /><input type="hidden" id="export_ids" name="ids" /></p></form>';

	art.dialog({
		content:content,
		title:'请选择要导出的列与文件编码',
		lock:true
	});

	var data=[];
	for(var i=0;i<ids.length;i++)
	{
		data.push(ids[i].value);
	}
	$("#export_ids").val(data.join(','));
	return;
}
</SCRIPT>



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
