<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/admin.css";?>" />
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/jquery/jquery-1.9.0.min.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/jquery/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/systemjs/artdialog/skins/default.css" />
</head>
<body style='min-width:500px'>
	<?php $tmpType=IReq::get('type');?>
	<form action='<?php echo IUrl::creatUrl("/block/goods_list/type/$tmpType");?>' method='post'>
		<table class='form_table'>
			<col width="150px" />
			<col />

			<tbody>
				<tr>
					<th>商品名称：</th>
					<td><input type='text' class='normal' name='keywords' /></td>
				</tr>
				<tr>
					<th>商品货号：</th>
					<td><input type='text' class='normal' name='goods_no' /></td>
				</tr>
				<tr>
					<th>商品分类：</th>
					<td>
						<select name="category_id" pattern="required" alt="请选择分类值" class="normal">
							<option value="">请选择</option>
							<?php $query = new IQuery("category");$query->order = "sort asc";$items = $query->find(); foreach($items as $key => $item){?>
							<option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></option>
							<?php }?>
						</select>
					</td>
				</tr>
				<tr>
					<th>商品价格：</th>
					<td>
						<input type='text' class='small' name='min_price' pattern='float' empty /> ～
						<input type='text' class='small' name='max_price' pattern='float' empty />
					</td>
				</tr>
				<tr>
					<th>规格选择：</th>
					<td>
						<label class='attr'><input type='radio' name='is_products' value='0' checked='checked' />无规格商品</label>
						<label class='attr'><input type='radio' name='is_products' value='1' />有规格货品</label>
					</td>
				</tr>
				<tr>
					<th>显示数量：</th>
					<td>
						<select class='small' name='show_num'>
							<option value='10' selected='selected'>10</option>
							<option value='20'>20</option>
						</select>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</body>
</html>
