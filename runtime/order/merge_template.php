<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>单据打印</title>
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/jquery/jquery-1.9.0.min.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/jquery/jquery-migrate-1.1.1.min.js"></script>
<link rel="shortcut icon" href="favicon.ico" />
<style media="print" type="text/css">.noprint{display:none}</style>
<style media="screen,print" type="text/css">
body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td,button{padding:0;margin:0;font-size:100%;}
body{font:12px/1.5 "宋体", Arial, Helvetica, sans-serif;color:#404040;background-color:#fff;text-align:center}
table{border-collapse:collapse;}
.container{width:90%;margin:20px auto}
.v_m{vertical-align: middle}
.ml_20{margin-left:20px;}
.m_10{ margin-bottom:10px;}
.f14{font-size:14px;}
.f18{font-size:18px;}
.f30{font-size:30px;}
.bold{font-weight:bold}
.gray{color:#979797}
.orange{color:#f76f10;}
table.table{border-top:2px solid #b0b0b0;}
table.table tr{_background-image:none}
table.table thead th{height:35px;padding:0 15px;}
table.table tbody th{height:35px;background:#f8f8f8;border-top:1px solid #d0d0d0;border-bottom:1px solid #d0d0d0;}
table.table tbody td{padding:12px 10px}
table.table tbody td img.pic{float:left;padding:1px;border:1px solid #d2d2d2; vertical-align:middle;margin-right:10px;}
table.table tfoot{border-top:2px solid #b0b0b0;}
.btn_print{width:112px;height:31px;margin:20px auto;border:0;background: url(<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/submit_bg.gif";?>) -93px -402px no-repeat;}
</style>
<script type='text/javascript'>
	//更新打印状态
	function update_print_status(order_id,print_type)
	{
		var order_id   = order_id;
		var print_type = print_type;
		$.get('<?php echo IUrl::creatUrl("/order/update_print_status");?>',{order_id:order_id,print_type:print_type});
	}
</script>
</head>

<body>
<div class="container">
	<table class="m_10" width="100%" cellspacing="0" cellpadding="0" border="0">
		<col width="70%" />
		<col />
		<tr>
			<td align="left"><img src="<?php echo IUrl::creatUrl("")."image/logo.gif";?>" width="250" height="53" /></td>
			<td valign="bottom" align="left"><input id="pic_print" name="pic_print" class="v_m" type="checkbox" /> <label for="pic_print">打印图片</label><p>客户：<?php echo isset($accept_name)?$accept_name:"";?><span class="ml_20">电话：<?php echo isset($mobile)?$mobile:"";?></span></p></td>
		</tr>
	</table>
	<table class="table" width="100%" cellspacing="0" cellpadding="0" border="0">
		<col width="300px" />
		<col width="100px" />
		<col width="100px" />
		<col />
		<thead>
			<tr class="f14"><th align="left" colspan="3"><b>订单号：<?php echo isset($order_no)?$order_no:"";?></b></th><th align="right"><b>订购日期：<?php echo date('Y-m-d',strtotime($create_time));?></b></th></tr>
		</thead>
		<tbody>
			<tr class="f14"><th>商品名称</th><th>单价</th><th>数量</th><th>小计</th></tr>
			<?php $amount = 0;?>
			<?php $query = new IQuery("order_goods as og");$query->where = "order_id = $id";$items = $query->find(); foreach($items as $key => $item){?>
				<?php $price = 0;?>
			<tr>
			<?php $query = new IQuery("goods");$query->where = "id = $item[goods_id]";$items = $query->find(); foreach($items as $key => $va){?>
			<td align="left"><img src="<?php echo IUrl::creatUrl("")."$va[small_img]";?>" class="pic" width="70" height="70" /><label><?php echo isset($va['name'])?$va['name']:"";?><br />
			<?php if($item['product_id']!=0){?>
			<?php $query = new IQuery("products");$query->where = "id = $item[product_id]";$items = $query->find(); foreach($items as $key => $asd){?>
				<?php $spec_array=Block::show_spec($asd['spec_array']);?>
				<?php foreach($spec_array as $specName => $specValue){?>
					<span class="gray"><?php echo isset($specName)?$specName:"";?>：<?php echo isset($specValue)?$specValue:"";?><br /></span>
				<?php }?>
			<?php }?>
			<?php }?>
			</label></td>
			<td>￥<?php echo isset($va['sell_price'])?$va['sell_price']:"";?>元</td>
			<?php $price = $va['sell_price'];?>
			<?php }?>
			<td><?php echo isset($item['goods_nums'])?$item['goods_nums']:"";?></td>
			<td>￥<?php echo $price*$item['goods_nums'];?>元</td>
			</tr>
			<?php $amount = $amount+$price*$item['goods_nums'];?>
			<?php }?>
		</tbody>
	</table>
	<table class="table" width="100%" cellspacing="0" cellpadding="0" border="0">
		<col /><col width="250px" />
		<tr>
			<td align="left"></td><td align="left">商品总价：￥<?php echo isset($amount)?$amount:"";?>元</td>
		</tr>
		<tr>
			<td align="left">订单附言：<?php echo isset($postscript)?$postscript:"";?></td><td align="left">配送费用：￥<?php echo isset($real_freight)?$real_freight:"";?></td>
		</tr>
		<tr>
			<td></td><td align="left">保价费用：￥<?php echo isset($insured)?$insured:"";?></td>
		</tr>
		<tr>
			<td></td><td align="left">支付手续费：￥<?php echo isset($pay_fee)?$pay_fee:"";?></td>
		</tr>
		<tr>
			<td></td><td align="left">订单优惠：￥<?php echo isset($promotions)?$promotions:"";?></td>
		</tr>
		<tr>
			<td></td><td align="left"><b class="f14">应付总金额：￥<?php echo isset($order_amount)?$order_amount:"";?>元</b></td>
		</tr>
	</table>
	<table class="table" width="100%" cellspacing="0" cellpadding="0" border="0">
		<col /><col width="250px" />
		<tr>
			<td align="left">服务商：<?php if(isset($set['name'])){?><?php echo isset($set['name'])?$set['name']:"";?><?php }?></td><td align="left">电话：<?php if(isset($set['mobile'])){?><?php echo isset($set['mobile'])?$set['mobile']:"";?><?php }?></td>
		</tr>
		<tr>
			<td align="left">邮箱：<?php if(isset($set['email'])){?><?php echo isset($set['email'])?$set['email']:"";?><?php }?></td><td align="left">网站：<?php if(isset($set['url'])){?><?php echo isset($set['url'])?$set['url']:"";?><?php }?></td>
		</tr>
	</table>
	<table class="table" width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td align="left">您目前的总积分是<b><?php $query = new IQuery("member");$query->where = "user_id = $user_id";$items = $query->find(); foreach($items as $key => $item){?><?php echo isset($item['point'])?$item['point']:"";?><?php }?></b>分，
			累计购物
			<?php $query = new IQuery("order");$query->fields = "count(id) as num,sum(order_amount) as total";$query->where = "user_id = $user_id and status = 5";$items = $query->find(); foreach($items as $key => $item){?><b class="orange"><?php echo isset($item['num'])?$item['num']:"";?></b>次，累计购物金额<b class="orange">￥<?php if($item['total']){?><?php echo isset($item['total'])?$item['total']:"";?><?php }else{?>0<?php }?>元</b></td><?php }?>
		</tr>
		<tfoot><tr><td><input class="btn_print noprint" type="submit" onclick="javascript:window.print();" value="打印" /></td></tr></tfoot>
	</table>
</div>

<div class="container">
	<table class="m_10" width="100%" cellspacing="0" cellpadding="0" border="0">
		<col width="30%" />
		<col width="40%" />
		<col />
		<tr>
			<td align="left"><p>订单号：<?php echo isset($order_no)?$order_no:"";?><br />日期：<?php echo date('Y-m-d',strtotime($create_time));?></p></td>
			<td class="f30"><b><?php echo isset($order_no)?$order_no:"";?></b></td>
			<td valign="bottom" align="left"><input id="pic_print" name="pic_print" class="v_m" type="checkbox" /> <label for="pic_print">打印图片</label><p>客户：<?php echo isset($accept_name)?$accept_name:"";?><span class="ml_20">电话：<?php echo isset($mobile)?$mobile:"";?></span></p></td>
		</tr>
	</table>
	<table class="table" width="100%" cellspacing="0" cellpadding="0" border="0">
		<col width="300px" />
		<col width="100px" />
		<col width="100px" />
		<col />
		<tbody>
			<tr class="f14"><th>商品名称</th><th>单价</th><th>数量</th><th>小计</th></tr>
			<?php $amount = 0;?>
			<?php $query = new IQuery("order_goods as og");$query->where = "order_id = $id";$items = $query->find(); foreach($items as $key => $item){?>
				<?php $price = 0;?>
			<tr>
			<?php $query = new IQuery("goods");$query->where = "id = $item[goods_id]";$items = $query->find(); foreach($items as $key => $va){?>
			<td align="left"><img src="<?php echo IUrl::creatUrl("")."$va[small_img]";?>" class="pic" width="70" height="70" /><label><?php echo isset($va['name'])?$va['name']:"";?><br />
			<?php if($item['product_id']!=0){?>
			<?php $query = new IQuery("products");$query->where = "id = $item[product_id]";$items = $query->find(); foreach($items as $key => $asd){?>
				<?php $spec_array=Block::show_spec($asd['spec_array']);?>
				<?php foreach($spec_array as $specName => $specValue){?>
					<span class="gray"><?php echo isset($specName)?$specName:"";?>：<?php echo isset($specValue)?$specValue:"";?><br /></span>
				<?php }?>
			<?php }?>
			<?php }?>
			</label></td>
			<td>￥<?php echo isset($va['sell_price'])?$va['sell_price']:"";?>元</td>
			<?php $price = $va['sell_price'];?>
			<?php }?>
			<td><?php echo isset($item['goods_nums'])?$item['goods_nums']:"";?></td>
			<td>￥<?php echo $price*$item['goods_nums'];?>元</td></tr>
			<?php $amount = $amount+$price*$item['goods_nums'];?>
			<?php }?>
		</tbody>
	</table>
	<table class="table" width="100%" cellspacing="0" cellpadding="0" border="0">
		<col /><col width="250px" />
		<tr>
			<td></td><td align="left">订单优惠：￥<?php echo isset($promotions)?$promotions:"";?>元</td>
		</tr>
		<tr>
			<td></td><td align="left">总金额：￥<?php echo isset($order_amount)?$order_amount:"";?>元</td>
		</tr>
		<tr>
			<td align="left"></td><td align="left">配送：<?php if(isset($deliver['delivery_type'])){?><?php $query = new IQuery("delivery");$query->where = "id = $deliver[delivery_type]";$items = $query->find(); foreach($items as $key => $item){?><?php echo isset($item['name'])?$item['name']:"";?><?php }?><?php }?></td>
		</tr>
		<tr>
			<td align="left">订单附言：<?php echo isset($postscript)?$postscript:"";?></td><td align="left">收货人：<?php if(isset($deliver['name'])){?><?php echo isset($deliver['name'])?$deliver['name']:"";?><?php }?></td>
		</tr>
		<tr>
			<td></td><td align="left">电话：<?php if(isset($deliver['telphone'])){?><?php echo isset($deliver['telphone'])?$deliver['telphone']:"";?><?php }?></td>
		</tr>
		<tr>
			<td></td><td align="left">手机：<?php if(isset($deliver['mobile'])){?><?php echo isset($deliver['mobile'])?$deliver['mobile']:"";?><?php }?></td>
		</tr>
		<tr>
			<td></td><td align="left">地址：<?php if(isset($deliver['address'])){?><?php echo isset($deliver['address'])?$deliver['address']:"";?><?php }?></td>
		</tr>
		<tr>
			<td></td><td align="left">邮编：<?php if(isset($deliver['postcode'])){?><?php echo isset($deliver['postcode'])?$deliver['postcode']:"";?><?php }?></td>
		</tr>
	</table>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr><td class="f18" align="left"><b>签字：</b></td></tr>
	</table>
	<input class="btn_print noprint" type="submit" onclick="update_print_status('<?php echo isset($id)?$id:"";?>','merge');window.print();" value="打印" />
</div>
</body>
</html>