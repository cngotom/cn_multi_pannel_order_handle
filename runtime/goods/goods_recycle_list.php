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
	<div class="position"><span>商品</span><span>></span><span>商品管理</span><span>></span><span>商品回收站</span></div>
	<div class="operating">
		<div class="search f_r">
			<form name="serachuser" action="<?php echo IUrl::creatUrl("/");?>" method="get">
			<input type='hidden' name='controller' value='goods' />
			<input type='hidden' name='action' value='goods_recycle_list' />
			<select class="auto" name="search">
				<option value="goods.name" <?php if($search=='goods.name'){?>selected<?php }?>>商品名</option>
				<option value="c.name" <?php if($search=='c.name'){?>selected<?php }?>>分类</option>
			</select>
			<input class="small" name="keywords" type="text" value="<?php echo isset($keywords)?$keywords:"";?>" /><button class="btn" type="submit"><span class="sch">搜 索</span></button>
			</form>
		</div>
		<a href="javascript:;"><button class="operating_btn" onclick="window.location='<?php echo IUrl::creatUrl("/goods/goods_list");?>'"><span class="return">返回列表</span></button></a>
		<a href="javascript:void(0)" onclick="selectAll('id[]')"><button class="operating_btn" type="button"><span class="sel_all">全选</span></button></a>
		<a href="javascript:void(0)" onclick="goods_recycle_del()"><button class="operating_btn" type="button"><span class="delete">彻底删除</span></button></a>
		<a href="javascript:void(0)" onclick="goods_recycle_restore()"><button class="operating_btn"><span class="recover">还原</span></button></a>
	</div>
	<div class="searchbar">
		<form action="<?php echo IUrl::creatUrl("/");?>" method="get" name="goods_list">
			<input type='hidden' name='controller' value='goods' />
			<input type='hidden' name='action' value='goods_recycle_list' />
			<select class="auto" name="category_id">
				<option value="">选择分类</option>
				<?php $query = new IQuery("category");$items = $query->find(); foreach($items as $key => $item){?>
				<option value="<?php echo isset($item['id'])?$item['id']:"";?>" <?php if($category_id==$item['id']){?>selected<?php }?>><?php echo isset($item['name'])?$item['name']:"";?></option>
				<?php }?>
			</select>
			<select class="auto" name="store_nums">
				<option value="">选择库存</option>
				<option value="1" <?php if($store_nums=='1'){?>selected<?php }?>>缺货</option>
				<option value="10" <?php if($store_nums=='10'){?>selected<?php }?>>低于10</option>
				<option value="100" <?php if($store_nums=='100'){?>selected<?php }?>>10-100</option>
				<option value="101" <?php if($store_nums=='101'){?>selected<?php }?>>100以上</option>
			</select>
			<select class="auto" name="commend">
				<option value="">选择商品标签</option>
				<option value="1" <?php if($commend=='1'){?>selected<?php }?>>最新商品</option>
				<option value="2" <?php if($commend=='2'){?>selected<?php }?>>特价商品</option>
				<option value="3" <?php if($commend=='3'){?>selected<?php }?>>热卖商品</option>
				<option value="4" <?php if($commend=='4'){?>selected<?php }?>>推荐商品</option>
			</select>
			<button class="btn" type="submit"><span class="sel">筛 选</span></button>
		</form>
	</div>
	<div class="field">
		<table class="list_table">
			<col width="30px" />
			<col />
			<col width="150px" />
			<col width="60px" />
			<col width="60px" />
			<col width="30px" />
			<col width="60px" />
			<col width="80px" />
			<col width="50px" />
			<col width="60px" />
			<col width="70px" />
			<thead>
				<tr role="head">
					<th class="t_c">选择</th>
					<th>商品名称</th>
					<th datatype="num">分类</th>
					<th datatype="num" class="t_c">销售价</th>
					<th datatype="num" class="t_c">库存</th>
					<th class="t_c">上架</th>
					<th datatype="num" class="t_c">市场价</th>
					<th>品牌</th>
					<th>重量</th>
					<th>排序</th>
					<th>操作</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
<form action="" method="post" name="orderForm">
<div class="content">
	<table id="list_table" class="list_table">
		<col width="30px" />
		<col />
		<col width="150px" />
		<col width="60px" />
		<col width="60px" />
		<col width="30px" />
		<col width="60px" />
		<col width="80px" />
		<col width="50px" />
		<col width="60px" />
		<col width="70px" />
		<tbody>
			<?php $page= (isset($_GET['page'])&&(intval($_GET['page'])>0))?intval($_GET['page']):1;?>
			<?php $goods_list = new IQuery("goods as goods");$goods_list->join = "left join brand as brand on goods.brand_id = brand.id $left_join";$goods_list->fields = "goods.id,goods.name,goods.sell_price,goods.store_nums,goods.market_price,goods.weight,brand.name as brand_name,goods.sort,goods.is_del";$goods_list->where = "$where and is_del = 1";$goods_list->order = "goods.sort asc,goods.id desc";$goods_list->page = "$page";$items = $goods_list->find(); foreach($items as $key => $item){?>
			<tr>
				<td class="t_c"><input name="id[]" type="checkbox" value="<?php echo isset($item['id'])?$item['id']:"";?>" /></td>
				<td><a href="<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>"><?php echo isset($item['name'])?$item['name']:"";?></a></td>
				<td><?php $cate= '';?>
				<?php $query = new IQuery("category_extend as ce");$query->join = "left join category as cd on cd.id = ce.category_id";$query->fields = "cd.name";$query->where = "goods_id = $item[id]";$items = $query->find(); foreach($items as $key => $va){?>
					<?php $cate .= $va['name'].'|'?>
				<?php }?>
				<?php if($cate){?><?php echo  substr($cate,0,-1);?><?php }?></td>
				<td class="t_c"><?php echo isset($item['sell_price'])?$item['sell_price']:"";?></td>
				<td class="t_c"><?php echo isset($item['store_nums'])?$item['store_nums']:"";?></td>
				<td class="t_c"><?php echo $item['is_del']==0?'是':'否';?></td>
				<td class="t_c"><?php echo isset($item['market_price'])?$item['market_price']:"";?></td>
				<td><?php echo isset($item['brand_name'])?$item['brand_name']:"";?></td>
				<td><?php echo isset($item['weight'])?$item['weight']:"";?></td>
				<td><input type="text" id="s<?php echo isset($item['id'])?$item['id']:"";?>" value="<?php echo isset($item['sort'])?$item['sort']:"";?>" onblur="toSort(<?php echo isset($item['id'])?$item['id']:"";?>);" class='tiny' /></td>
				<td><a href="<?php echo IUrl::creatUrl("/goods/goods_edit/gid/$item[id]");?>"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_edit.gif";?>" alt="编辑" /></a>
				<a href="javascript:void(0)" onclick="delModel({link:'<?php echo IUrl::creatUrl("/goods/goods_recycle_del/id/$item[id]");?>'})"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_del.gif";?>" alt="删除" /></a></td>
			</tr>
			<?php }?>
		</tbody>
	</table>
</div>
</form>
<?php echo $goods_list->getPageBar();?>
<script type="text/javascript">
function toSort(id)
{
	if(id!='')
	{
		var va = $('#s'+id).val();
		if(va!='' && va!=undefined)
		{
			$.get("<?php echo IUrl::creatUrl("/goods/goods_sort");?>",{'id':id,'sort':va}, function(data)
			{
				if(data=='0')
				{
					alert('修改商品排序错误!');
				}
			});
		}

	}
}
function goods_recycle_del()
{
	$("form[name='orderForm']").attr('action','<?php echo IUrl::creatUrl("/goods/goods_recycle_del");?>');
	confirm('确定要彻底删除所选中的信息吗？','formSubmit(\'orderForm\')');
}
function goods_recycle_restore()
{
	var flag = 0;
	$('input:checkbox[name="id[]"]:checked').each(
		function(i)
		{
			flag = 1;
		}
	);
	if(flag == 0 )
	{
		alert('请选择要还原的数据');
		return false;
	}
	$("form[name='orderForm']").attr('action','<?php echo IUrl::creatUrl("/goods/goods_recycle_restore");?>');
	confirm('确定要还原删除所选中的信息吗？','formSubmit(\'orderForm\')');
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
