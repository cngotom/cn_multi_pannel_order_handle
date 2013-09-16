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
	<div class="position">订单<span>></span><span>单据管理</span><span>></span><span>发货单信息</span></div>
</div>
<div class="content">
	<table width="98%" class="border_table" style="margin:10px auto">
		<tbody>
			<tr>
				<th>订单号：</th><td><?php echo isset($order_no)?$order_no:"";?></td><th>配送方式:</th><td><?php echo isset($pname)?$pname:"";?></td><th>订单时间:</th><td><?php echo isset($create_time)?$create_time:"";?></td>
			</tr>
			<tr>
				<th>操作员：</th><td><?php echo isset($admin)?$admin:"";?></td><th>会员名:</th><td><?php echo isset($username)?$username:"";?></td><th>收货人：</th><td><?php echo isset($name)?$name:"";?></td>
			</tr>
			<tr>
				<th>收货地区：</th><td><?php echo isset($country)?$country:"";?></td><th>收货地址:</th><td><?php echo isset($address)?$address:"";?></td><th>邮编:</th><td><?php echo isset($postcode)?$postcode:"";?></td>
			</tr>
			<tr>
				<th>电话：</th><td><?php echo isset($telphone)?$telphone:"";?></td><th>手机:</th><td><?php echo isset($mobile)?$mobile:"";?></td><th>运费:</th><td><?php echo isset($freight)?$freight:"";?></td>
			</tr>
			<tr>
				<th>物流单号：</th><td><?php echo isset($delivery_code)?$delivery_code:"";?></td><th>生成时间:</th><td colspan="3"><?php echo isset($time)?$time:"";?></td>
			</tr>
			<tr>
				<th>备注：</th><td colspan="5"><?php echo isset($note)?$note:"";?></td>
			</tr>
		</tbody>
	</table>
	<table width="98%" class="border_table" style="margin:10px auto">
		<col />
		<col width="150px" />
		<thead>
			<tr>
				<th style="text-align:center">商品名称</th>
				<th style="text-align:center">商品数量</th>
			</tr>
		</thead>
		<tbody>
			<?php $query = new IQuery("order_goods as og");$query->join = "left join goods as gg on og.goods_id = gg.id left join products as p on p.id = og.product_id";$query->fields = "gg.name as gname,p.spec_array as spec,og.id as ogid,og.goods_array,og.product_id,og.goods_price,og.goods_nums,og.real_price*og.goods_nums as total,og.shipments,og.real_price";$query->where = "og.order_id = $order_id";$items = $query->find(); foreach($items as $key => $item){?>
			<tr id="a<?php echo isset($item['ogid'])?$item['ogid']:"";?>">
				<td style="text-align:center">
					<?php echo isset($item['gname'])?$item['gname']:"";?>
					<?php if($item['spec']){?>
					&nbsp;&nbsp;
					<?php $specData = JSON::decode($item['spec']);?>
					<?php foreach($specData as $key => $value){?>
						<?php echo $value['name'];?>:<?php if($value['type']==1){?><?php echo isset($value['value'])?$value['value']:"";?><?php }else{?><img src="<?php echo IUrl::creatUrl().$value['value'];?>" width="15px" height="15px" class="spec_photo" /><?php }?>&nbsp;&nbsp;
					<?php }?>
					<?php }?>
				</td>
				<td style="text-align:center"><?php echo isset($item['goods_nums'])?$item['goods_nums']:"";?></td>
			</tr>
			<?php }?>
		</tbody>
	</table>
</div>
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
