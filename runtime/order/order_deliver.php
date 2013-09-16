<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="overflow-y:auto">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理后台</title>
<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/admin.css";?>" />
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/jquery/jquery-1.9.0.min.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/jquery/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/systemjs/artdialog/skins/default.css" />
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/form/form.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/systemjs/autovalidate/style.css" />
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/admin.js";?>"></script>
<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/artTemplate/area_select.js";?>'></script>
</head>

<body style="width:750px">
<div class="pop_win">
	<form action="<?php echo IUrl::creatUrl("/order/order_delivery_doc");?>" method="post" id="deliver_form">
		<input type="hidden" name="order_no" value="<?php echo isset($order_no)?$order_no:"";?>"/>
		<input type="hidden" name="id" value="<?php echo isset($order_id)?$order_id:"";?>"/>
		<input type="hidden" name="weight_total" id="weight_total" value="<?php echo isset($goods_weight)?$goods_weight:"";?>"/>
		<input type="hidden" name="user_id" value="<?php echo isset($user_id)?$user_id:"";?>"/>
		<input type="hidden" name="ogid" id="ogid" value="<?php echo isset($ogid)?$ogid:"";?>" />
		<input type="hidden" name="freight" value="<?php echo isset($real_freight)?$real_freight:"";?>" />

		<table width="90%" class="border_table" style="margin:10px auto">
			<col width="100px" />
			<col />
			<col width="100px" />
			<col />
			<tbody>
				<tr>
					<th>订单号:</th><td align="left"><?php echo isset($order_no)?$order_no:"";?></td>
					<th>下单时间:</th><td align="left"><?php echo isset($create_time)?$create_time:"";?></td>
				</tr>
				<tr>
					<th>配送方式:</th>
					<td align="left">
						<select name="delivery_type" pattern="required" alt="请选择配送方式">
						<?php $query = new IQuery("delivery");$query->where = "is_delete = 0";$items = $query->find(); foreach($items as $key => $item){?>
						<option value="<?php echo isset($item['id'])?$item['id']:"";?>" <?php if($distribution==$item['id']){?>selected<?php }?>><?php echo isset($item['name'])?$item['name']:"";?></option>
						<?php }?>
						</select>
					</td>
					<th>配送费用:</th><td align="left"><?php echo isset($real_freight)?$real_freight:"";?></td>
				</tr>
				<tr>
					<th>配送单号:</th><td align="left" colspan="3"><input type="text" class="small" name="delivery_code" pattern="required"/></td>
				</tr>
				<tr>
					<th>是否保价:</th><td align="left"><?php if($if_insured==0){?>否<?php }else{?>是<?php }?></td><th>保价费用:</th><td align="left">￥<?php echo isset($insured)?$insured:"";?></td>
				</tr>
				<tr>
					<th>收货人姓名:</th><td align="left"><input type="text" class="small" name="name" value="<?php echo isset($accept_name)?$accept_name:"";?>" pattern="required"/></td>
					<th>电话:</th><td align="left"><input type="text" class="small" name="telphone" value="<?php echo isset($telphone)?$telphone:"";?>" pattern="phone" empty /></td>
				</tr>
				<tr>
					<th>手机:</th><td align="left"><input type="text" class="small" name="mobile" value="<?php echo isset($mobile)?$mobile:"";?>" pattern="mobi"/></td>
					<th>邮政编码:</th><td align="left"><input type="text" name="postcode" class="small" value="<?php echo isset($postcode)?$postcode:"";?>" pattern="zip" empty /></td>
				</tr>
				<tr>
					<th>地区:</th>
					<td align="left" colspan="3">
						<select name="province" child="city,area" onchange="areaChangeCallback(this);"></select>
						<select name="city" child="area" parent="province" onchange="areaChangeCallback(this);"></select>
						<select name="area" parent="city" pattern="required"></select>
					</td>
				</tr>
				<tr>
					<th>地址:</th><td align="left" colspan="3"><input type="text" class="normal" name="address" value="<?php echo isset($address)?$address:"";?>" size="50" pattern="required"/></td>
				</tr>
				<tr>
					<th>发货单备注:</th><td align="left" colspan="3"><textarea name="note" rows="3" cols="85"></textarea></td>
				</tr>
			</tbody>
		</table>
		<table width="100%" class="border_table" style="margin:10px auto">
			<col />
			<col width="80px" />
			<col width="80px" />
			<col width="80px" />
			<col width="80px" />
			<col width="130px" />
			<thead>
				<tr><th>商品名称</th><th>商品价格</th><th>当前库存</th><th>购买数量</th><th>已发货</th><th>商品数量</th></tr>
			</thead>
			<tbody>
				<?php $ogid=''?>
				<?php $query = new IQuery("order_goods as og");$query->join = "left join goods as gg on og.goods_id = gg.id left join products as p on p.id = og.product_id";$query->fields = "gg.name as gname,p.spec_array as spec,og.id as ogid,og.product_id,og.goods_array,og.goods_price,og.goods_nums,og.real_price*og.goods_nums as total,og.real_price,og.shipments,gg.store_nums";$query->where = "og.order_id = $order_id";$items = $query->find(); foreach($items as $key => $item){?>
					<?php $ogid .=$item['ogid'].',';?>
					<tr>
						<td style="white-space:normal">
							<?php echo isset($item['gname'])?$item['gname']:"";?>
							<?php if($item['spec']){?>
							&nbsp;&nbsp;
							<?php $specData = JSON::decode($item['spec']);?>
							<?php foreach($specData as $key => $value){?>
								<?php echo $value['name'];?>:<?php if($value['type']==1){?><?php echo isset($value['value'])?$value['value']:"";?><?php }else{?><img src="<?php echo IUrl::creatUrl().$value['value'];?>" width="15px" height="15px" class="spec_photo" /><?php }?>&nbsp;&nbsp;
							<?php }?>
							<?php }?>
						</td>
						<td><?php echo isset($item['real_price'])?$item['real_price']:"";?></td>
						<td><?php echo isset($item['store_nums'])?$item['store_nums']:"";?></td>
						<td><?php echo isset($item['goods_nums'])?$item['goods_nums']:"";?></td>
						<td><?php echo isset($item['shipments'])?$item['shipments']:"";?></td>
						<td><?php echo isset($item['goods_nums'])?$item['goods_nums']:"";?></td>
					</tr>
				<?php }?>
			</tbody>
		</table>
	</form>
</div>

<script type="text/javascript">
//DOM加载完毕
$(function(){
	//初始化地域联动
	template.compile("areaTemplate",areaTemplate);

	createAreaSelect('province',0,<?php echo isset($province)?$province:"";?>);
	createAreaSelect('city',<?php echo isset($province)?$province:"";?>,<?php echo isset($city)?$city:"";?>);
	createAreaSelect('area',<?php echo isset($city)?$city:"";?>,<?php echo isset($area)?$area:"";?>);
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
</body>
</html>