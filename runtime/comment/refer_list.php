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
	<div class="position"><span>会员</span><span>></span><span>咨询管理</span><span>></span><span>咨询信息列表</span></div>
	<div class="operating">
		<a href="javascript:void(0)" onclick="selectAll('check[]')"><button class="operating_btn" type="button"><span class="sel_all">全选</span></button></a>
		<a href="javascript:void(0)" onclick="delModel({form:'refer_list',msg:'确定要删除选中的记录吗？'})"><button class="operating_btn" type="button"><span class="delete">批量删除</span></button></a>
	</div>

	<form name="filter_form" method="get" action="<?php echo IUrl::creatUrl("/");?>">
		<input type='hidden' name='controller' value='comment' />
		<input type='hidden' name='action' value='refer_list' />
		<div class="searchbar">
			咨询人：<input class="small" type="text" name="username" value="<?php echo isset($username)?$username:"";?>" />
			咨询商品：<input class="small" type="text" name="goodsname" value="<?php echo isset($goodsname)?$goodsname:"";?>" />
			开始时间：<input class="small" type="text" name="beginTime" onfocus="WdatePicker()" value="<?php echo isset($beginTime)?$beginTime:"";?>" />
			截止时间：<input class="small" type="text" name="endTime" onfocus="WdatePicker()" value="<?php echo isset($endTime)?$endTime:"";?>" />
			<button class="btn" type="submit"><span class="sel">筛 选</span></button>
		</div>
	</form>

	<div class="field">
		<table class="list_table">
			<col width="40px" />
			<col />
			<col width="100px" />
			<col width="130px" />
			<col width="130px" />
			<col width="130px" />
			<col width="110px" />
			<thead>
				<tr role="head">
					<th class="t_c">选择</th>
					<th>咨询商品</th>
					<th>咨询人</th>
					<th>咨询时间</th>
					<th>最后回复人</th>
					<th>回复时间</th>
					<th>操作</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<form action="<?php echo IUrl::creatUrl("/comment/refer_del");?>" method="post" name="refer_list" onsubmit="return checkboxCheck('check[]','尚未选中任何记录！')">
	<div class="content">
		<input type="hidden" name="move_group" value="" />
		<table class="list_table">
			<col width="40px" />
			<col />
			<col width="100px" />
			<col width="130px" />
			<col width="130px" />
			<col width="130px" />
			<col width="110px" />
			<tbody>
				<?php $page= (isset($_GET['page'])&&(intval($_GET['page'])>0))?intval($_GET['page']):1;?>
				<?php $query = new IQuery("refer as r");$query->join = "left join goods as goods on r.goods_id = goods.id left join user as u on r.user_id = u.id left join order as o on o.id = r.order_id left join admin as admin on r.admin_id = admin.id";$query->fields = "r.*,u.username,goods.name as goods_name,goods.id as goods_id,admin.admin_name";$query->page = "$page";$query->where = "$where";$query->order = "r.id desc";$items = $query->find(); foreach($items as $key => $item){?>
				<tr>
					<td class="t_c"><input name="check[]" type="checkbox" value="<?php echo isset($item['id'])?$item['id']:"";?>" /></td>
					<td><a title="<?php echo isset($item['goods_name'])?$item['goods_name']:"";?>" href="<?php echo IUrl::creatUrl("/site/products/id/$item[goods_id]");?>" target='_blank'><?php echo isset($item['goods_name'])?$item['goods_name']:"";?></a></td>
					<td><?php if(isset($item['username'])){?><?php echo isset($item['username'])?$item['username']:"";?><?php }else{?>非会员<?php }?></td>
					<td><a href="javascript:void(0)"><?php echo date("Y-m-d H:i",strtotime($item['time']));?></a></td>
					<td><a href="javascript:void(0)"><?php echo isset($item['admin_name'])?$item['admin_name']:"";?></a></td>
					<td><a href="javascript:void(0)"><?php echo isset($item['reply_time'])?$item['reply_time']:"";?></a></td>
					<td><a href="<?php echo IUrl::creatUrl("/comment/refer_edit/rid/$item[id]");?>"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_edit.gif";?>" alt="修改" /></a>
						<a href="javascript:void(0)" onclick="delModel({link:'<?php echo IUrl::creatUrl("/comment/refer_del/check/$item[id]");?>'})"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_del.gif";?>" alt="删除" /></a>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</div>
	<?php echo $query->getPageBar();?>
</form>

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
