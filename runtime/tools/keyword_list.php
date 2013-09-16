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
	<div class="position"><span>工具</span><span>></span><span>关键词管理</span><span>></span><span>关键词列表</span></div>
	<div class="operating">
		<a href="javascript:void(0)" onclick="event_link('<?php echo IUrl::creatUrl("/tools/keyword_edit");?>');"><button class="operating_btn" type="button"><span class="addition">添加关键词</span></button></a>
		<a href="javascript:void(0)" onclick="selectAll('id[]');"><button class="operating_btn" type="button"><span class="sel_all">全选</span></button></a>
		<a href="javascript:void(0)" onclick="delModel();"><button class="operating_btn" type="button"><span class="delete">批量删除</span></button></a>
		<a href="javascript:void(0)" onclick="window.document.forms[0].action='<?php echo IUrl::creatUrl("/tools/keyword_account");?>';delModel({msg:'是否批量同步？'});"><button class="operating_btn" type="button"><span class="refresh">批量同步</span></button></a>
	</div>
	<div class="field">
		<table class="list_table">
			<col width="40px" />
			<col width="200px" />
			<col width="100px" />
			<col width="80px" />
			<col width="100px" />
			<col />
			<thead>
				<tr>
					<th class="t_c">选择</th>
					<th>关键词</th>
					<th>关联商品数量</th>
					<th>是否热门</th>
					<th>排序</th>
					<th>操作</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
<div class="content">
	<form action="<?php echo IUrl::creatUrl("/tools/keyword_del");?>" method="post">
		<table class="list_table">
			<col width="40px" />
			<col width="200px" />
			<col width="100px" />
			<col width="80px" />
			<col width="100px" />
			<col />
			<tbody>
				<?php $page= (isset($_GET['page'])&&(intval($_GET['page'])>0))?intval($_GET['page']):1;?>
				<?php $query = new IQuery("keyword");$query->page = "$page";$query->order = "`order` asc";$items = $query->find(); foreach($items as $key => $item){?>
				<tr>
					<td class="t_c"><input type="checkbox" name="id[]" value="<?php echo isset($item['word'])?$item['word']:"";?>" /></td>
					<td><?php echo isset($item['word'])?$item['word']:"";?></td>
					<td><?php echo isset($item['goods_nums'])?$item['goods_nums']:"";?></td>
					<td>
						<?php if($item['hot']==1){?>
						<a class='red2' href='javascript:void(0);' onclick='set_hot("<?php echo isset($item['word'])?$item['word']:"";?>",this);'>是</a>
						<?php }else{?>
						<a class='blue' href='javascript:void(0);' onclick='set_hot("<?php echo isset($item['word'])?$item['word']:"";?>",this);'>否</a>
						<?php }?>
					</td>
					<td>
						<input type='text' maxlength='6' onblur='set_order("<?php echo isset($item['word'])?$item['word']:"";?>",this,"<?php echo isset($item['order'])?$item['order']:"";?>");' class='tiny' value='<?php echo isset($item['order'])?$item['order']:"";?>' />
					</td>
					<td>
						<a href='<?php echo IUrl::creatUrl("/tools/keyword_account/id/$item[word]");?>'><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_refresh.gif";?>" alt="同步商品" title="同步商品" /></a>
						<a href='javascript:void(0)' onclick="delModel({link:'<?php echo IUrl::creatUrl("/tools/keyword_del/id/$item[word]");?>'});"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_del.gif";?>" alt="删除" title="删除" /></a>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</form>
</div>
<?php echo $query->getPageBar();?>

<script type='text/javascript'>
	//设置热门关键词
	function set_hot(word,obj)
	{
		var rd = Math.random();
		$.getJSON('<?php echo IUrl::creatUrl("/tools/keyword_hot/hot/1");?>',{id:word,rd:rd},function(content){
			if(content.isError ==  false)
			{
				if(content.hot == 1)
				{
					obj.innerHTML = '是';
					$(obj).removeClass('blue');
					$(obj).addClass('red2');
				}
				else
				{
					obj.innerHTML = '否';
					$(obj).removeClass('red2');
					$(obj).addClass('blue');
				}
			}
			else
			{
				alert(content.message);
			}
		});
	}

	//设置排序
	function set_order(word,obj,default_val)
	{
		var order = $(obj).val();
		if(isNaN(order))
		{
			alert('排序必须是一个数字');
			$(obj).val(default_val);
		}
		else
		{
			$.getJSON('<?php echo IUrl::creatUrl("/tools/keyword_order");?>',{id:word,order:order},function(content){
				if(content.isError == true)
				{
					alert(content.message);
				}
			});
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
