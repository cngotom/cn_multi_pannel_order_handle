<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
</head>
<body style="width:450px;height:150px;">
<div class="pop_win">
	<form name="balanceForm" callback="submitCallback();" action="#">
		<table class="form_table" style="width:90%">
			<col width="120px" />
			<col />
			<tr>
				<td class="t_r">请选择：</td>
				<td>
					<select name="type" class="middle" onchange="selectChange(this);" pattern='required'>
						<option value="1">充值</option>
						<option value="2">退款</option>
						<option value="3">提现</option>
					</select>
				</td>
			</tr>
			<tr id="orderNo" style="display:none;">
				<td class="t_r">订单号：</td>
				<td><input type="text" name="order_no" maxlength="20" class="middle" pattern='required' alt='必须要填写订单号' /></td>
			</tr>
			<tr>
				<td class="t_r">请输入金额：</td>
				<td><input name="balance" class="small" type="text" maxlength="8" pattern='float' alt='必须要填写退款金额' /></td>
			</tr>
		</table>
	</form>
</div>

<script type='text/javascript'>
//提交回调函数
function submitCallback()
{
	return false;
}
//选择预付款操作项
function selectChange(obj)
{
	if(obj.value == 2)
	{
		$('#orderNo').show();
	}
	else
	{
		$('#orderNo').hide();
	}
}
</script>
</body>
</html>