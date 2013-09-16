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
			<div class="headbar clearfix">
	<div class="position"><span>商品</span><span>></span><span>模型管理</span><span>></span><span>模型<?php if(isset($id)){?>编辑<?php }else{?>添加<?php }?></span></div>
	<ul class="tab" name="menu1">
		<li id="li_1" class="selected"><a href="javascript:selectTab('1');" hidefocus="true">基本信息</a></li>
		<li id="li_2"><a href="javascript:selectTab('2');" hidefocus="true">规格</a></li>
	</ul>
</div>

<form name="ModelForm" action="<?php echo IUrl::creatUrl("/goods/model_update");?>" method="post">
<div class="content_box">
	<div class="content form_content">
		<!--属性表格-->
		<table id="tab-1" class="form_table" name="table">
			<col width="150px" />
			<col />
			<tr>
				<th>模型名称：</th>
				<td>
					<input class="normal" name="model_name" id="model_name" type="text" pattern="required" alt="模型名称不能为空！" value="<?php echo isset($name)?$name:"";?>"  /><label>* 模型名称（必填）</label>
					<input name="model_id" type="hidden" value="<?php echo isset($id)?$id:"";?>" />
				</td>
			</tr>
			<tr>
				<th>添加扩展属性：</th>
				<td><button class="btn" onclick="addAttr()" type="button"><span class="add">添加扩展属性</span></button></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<table width="90%" class='border_table'>
						<thead>
							<tr>
								<th>属性名</th>
								<th>操作样式</th>
								<th>选择项数据【每项数据之间用逗号','做分割】</th>
								<th>是否作为商品的筛选项</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody id="attr_list"></tbody>

						<!--属性列表-->
						<script type='text/html' id='attrListTemplate'>
						<%for(var item in templateData){%>
						<%include('attrTrTemplate',{'item':templateData[item]})%>
						<%}%>
						</script>

						<!--属性单行-->
						<script type='text/html' id='attrTrTemplate'>
						<tr class='td_c'>
							<td>
								<input name='attr[id][]' type='hidden' value="<%=item['id']%>" />
								<input name='attr[name][]' class='small' type='text' value="<%=item['name']%>" />
							</td>
							<td>
								<select class="middle" name='attr[show_type][]'>
									<option value='1' <%if(item['type']=='1'){%>selected<%}%>>单选框</option>
									<option value='2' <%if(item['type']=='2'){%>selected<%}%>>复选框</option>
									<option value='3' <%if(item['type']=='3'){%>selected<%}%>>下拉框</option>
								</select>
							</td>
							<td>
								<input class='normal' name='attr[value][]' type='text' value="<%=item['value']%>" />
							</td>
							<td>
								<input type='checkbox' <%if(item['search']== '1'){%>checked<%}%> onclick="selectCheck(this)" />
								<input type='hidden' name='attr[is_search][]' value="<%=item['search']?item['search']:0%>" />
							</td>
							<td>
								<img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_del.gif";?>" alt="删除" onclick="delAttr(this)" />
							</td>
						</tr>
						</script>
					</table>
				</td>
			</tr>
		</table>

		<!--规格表格-->
		<table id="tab-2" class="form_table" name="table" style="display: none">
			<col width="150px" />
			<col />
			<tr>
				<th>添加规格：</th>
				<td><button class="btn" onclick="addSpec()" type="button"><span class="add">添加规格</span></button></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<table width="90%" class="border_table">
						<thead>
							<tr>
								<th>规格</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody id="spec_list"></tbody>

						<!--规格列表模板-->
						<script type='text/html' id='specListTemplate'>
						<%for(var item in templateData){%>
						<%include('specTrTemplate',{'item':templateData[item]})%>
						<%}%>
						</script>

						<!--规格单行模板-->
						<script type='text/html' id='specTrTemplate'>
						<tr class='td_c'>
							<td>
								<input name='spec[id][]' type='hidden' value="<%=item['id']%>" />
								<%=item['name']%> <%if(item['note']){%>[<%=item['note']%>]<%}%>
							</td>
							<td>
								<img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_asc.gif";?>" onclick="positionUp($(this).parent().parent(),$('#spec_list'))" alt="向上" />
								<img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_desc.gif";?>" onclick="positionDown($(this).parent().parent(),$('#spec_list'))" alt="向下" />
								<img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_del.gif";?>" onclick="delAttr(this)" alt="删除" />
							</td>
						</tr>
						</script>
					</table>
				</td>
			</tr>
		</table>
		<table class="form_table">
			<col width="150px" />
			<col />
			<tr>
				<td></td>
				<td><button class="submit" type="button" onclick="checkForm()"><span>保 存</span></button></td>
			</tr>
		</table>
	</div>
</div>
</form>
<script type='text/javascript'>
	$(function(){
		//初始化属性
		<?php if(isset($model_attr)){?>
		<?php foreach($model_attr as $key => $item){?><?php }?>
		var attrListHtml = template.render('attrListTemplate',{'templateData':<?php echo JSON::encode($model_attr);?>});
		$('#attr_list').html(attrListHtml);
		<?php }?>

		//初始化规格
		<?php if(isset($model_spec)){?>
		<?php foreach($model_spec as $key => $item){?><?php }?>
		var specListHtml = template.render('specListTemplate',{'templateData':<?php echo JSON::encode($model_spec);?>});
		$('#spec_list').html(specListHtml);
		<?php }?>
	});

	//添加模型规格
	function addSpec()
	{
		art.dialog.open('<?php echo IUrl::creatUrl("/goods/select_spec");?>', {
		    title: '选择规格',
		    okVal:'保存',
		    ok:function(iframeWin, topWin){
				var specChecked = $(iframeWin.document).find('[name="spec"]:checked');
				if(specChecked.length == 1)
				{
					var specJson = $.parseJSON(specChecked.val());
					var specTrHtml = template.render('specTrTemplate',{'item':specJson});
					$('#spec_list').append(specTrHtml);
				}
		    }
		});
	}

	//添加一个模型属性
	function addAttr()
	{
		var attrTrHtml = template.render('attrTrTemplate',{'item':[]});
		$('#attr_list').append(attrTrHtml);
	}

	//删除模型属性
	function delAttr(curr_attr)
	{
		$(curr_attr).parent().parent().remove();
	}

	//选择当前Tab
	function selectTab(curr_tab)
	{
		$("table[name='table']").hide();
		$("#tab-"+curr_tab).show();
		$("ul[name=menu1] > li").removeClass('selected');
		$('#li_'+curr_tab).addClass('selected');
	}

	//设置选择复选框的值
	function selectCheck(_self)
	{
		var checkValue = $(_self).siblings('[name="attr[is_search][]"]')[0];

		if($(_self).attr("checked"))
		{
			checkValue.value = 1;
		}
		else
		{
			checkValue.value = 0;
		}
	}

	//模型属性表单验证
	function checkForm()
	{
		var model_name = $('#model_name').val();
		if(model_name=='')
		{
			selectTab(1);
		}
		var isPass = true;
		//验证模型属性名字
		$("input[name='attr[name][]']").each(function(i,obj){
			$(this).removeClass(" invalid-text");
			if($(this).val()=='')
			{
				alert("属性名字不能为空！");
				$(this).addClass(" invalid-text");
				isPass = false;
				return false;
			}
		});
		//验证模型属性值
		$("input[name='attr[value][]']").each(function(i,obj){
			$(this).removeClass(" invalid-text");
			if($(this).val() == '')
			{
				alert("属性值不能为空！");
				$(this).addClass(" invalid-text");
				isPass = false;
				return false;
			}
		});
		//onsubmit事件在submit之前，所以先判断onsubmit事件是否成功。
		if(document.ModelForm.onsubmit()!=false && isPass)
		{
			document.ModelForm.submit();
		}
	}

	//项上升
	function positionUp(_self,container)
	{
		var childrenIndex = container.children().index(_self);
		if(childrenIndex == 0)
		{
			return;
		}
		_self.insertBefore(container.children().get(childrenIndex-1));
	}

	//项下降
	function positionDown(_self,container)
	{
		var childrenIndex = container.children().index(_self);
		if(childrenIndex == container.children().length - 1)
		{
			return;
		}
		_self.insertAfter(container.children().get(childrenIndex+1));
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
