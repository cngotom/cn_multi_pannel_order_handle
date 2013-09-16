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
<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/admin.js";?>"></script>
</head>
<body style="width:600px">
<div class="pop_win">
<form action="<?php echo IUrl::creatUrl("/order/order_collection_doc");?>" method="post" id="pay_form">
	<input type="hidden" name="id" value="<?php echo isset($order_id)?$order_id:"";?>"/>
	<input type="hidden" name="order_no" value="<?php echo isset($order_no)?$order_no:"";?>"/>
	<input type="hidden" name="user_id" value="<?php echo isset($user_id)?$user_id:"";?>"/>

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
				<th>订单总金额:</th><td align="left"><?php echo isset($order_amount)?$order_amount:"";?></td>
			</tr>
			<tr>
				<th>收款方式:</th>
				<td align="left">
					<select name="payment_id" pattern="required" alt="请选择支付方式" >
					<?php $query = new IQuery("payment");$query->where = "status = 0";$items = $query->find(); foreach($items as $key => $item){?>
					<option value="<?php echo isset($item['id'])?$item['id']:"";?>" <?php if($pay_type==$item['id']){?>selected<?php }?>><?php echo isset($item['name'])?$item['name']:"";?></option>
					<?php }?>
					</select>
				</td>
			</tr>
			<tr>
				<th>收款金额:</th>
				<td align="left" colspan="3"><input type="text" class="small" name="amount" id="amount" value="<?php echo isset($order_amount)?$order_amount:"";?>" pattern="float"/></td>
			</tr>
			<tr>
				<th>是否开票:</th><td align="left"><?php if($invoice==0){?>否<?php }else{?>是<?php }?></td>
				<th>税金:</th><td align="left">￥<?php echo isset($taxes)?$taxes:"";?></td>
			</tr>
			<tr>
				<th>发票抬头:</th><td align="left"><?php echo isset($invoice_title)?$invoice_title:"";?></td>
				<th>付款人:</th><td align="left"><?php echo isset($username)?$username:"";?></td>
			</tr>
			<tr>
				<th>收款备注:</th>
				<td colspan="3" align="left">
					<textarea name="note" id="note" rows="3" cols="65"></textarea>
				</td>
			</tr>
		</tbody>
	</table>
</form>
</div>
</body>
</html>