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
<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/admin.js";?>"></script>
</head>
<body style="width:450px;">
<div class="pop_win clearfix">
	<form name="groupPriceForm">
		<table class="border_table" width="90%">
			<thead>
				<tr>
					<th>会员组名称</th>
					<th>商品价格</th>
					<th>默认价格</th>
					<th>会员组折扣率</th>
				</tr>
			</thead>
			<tbody>
				<?php $query = new IQuery("user_group");$items = $query->find(); foreach($items as $key => $item){?>
				<tr class='td_c'>
					<td><?php echo isset($item['group_name'])?$item['group_name']:"";?></td>
					<td><input type="text" name="groupPrice<?php echo isset($item['id'])?$item['id']:"";?>" class="small" pattern="float" /></td>
					<td>￥<?php echo ($item['discount']/100)*$sell_price;?></td>
					<td><?php echo isset($item['discount'])?$item['discount']:"";?>%</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</form>
</div>
<script type='text/javascript'>
$(function(){
	var groupPrice = art.dialog.data('groupPrice');
	if(groupPrice)
	{
		var groupPriceObject = $.parseJSON(groupPrice);
		for(var groupId in groupPriceObject)
		{
			$('input[name="groupPrice'+groupId+'"]').val(groupPriceObject[groupId]);
		}
	}
});
</script>
</body>
</html>