<?php if($mod == 'mycart'){?>
<dl class="cartlist">
	<?php foreach($data as $key => $item){?>
	<dd id="site_cart_dd_<?php echo isset($key)?$key:"";?>">
		<div class="pic f_l"><img width="55" height="55" src="<?php echo IUrl::creatUrl("")."$item[list_img]";?>"></div>
		<h3 class="title f_l"><a href="<?php echo IUrl::creatUrl("/site/products/id/$item[goods_id]");?>"><?php echo isset($item['name'])?$item['name']:"";?></a></h3>
		<div class="price f_r t_r">
			<b class="block">￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?> x <?php echo isset($item['count'])?$item['count']:"";?></b>
			<input class="del" type="button" value="删除" onclick="removeCart('<?php echo IUrl::creatUrl("/simple/removeCart");?>','<?php echo isset($item['id'])?$item['id']:"";?>','<?php echo isset($item['type'])?$item['type']:"";?>');$('#site_cart_dd_<?php echo isset($key)?$key:"";?>').hide('slow');" />
		</div>
	</dd>
	<?php }?>

	<dd class="static"><span>共<b name="mycart_count"><?php echo isset($count)?$count:"";?></b>件商品</span>金额总计：<b name="mycart_sum">￥<?php echo isset($sum)?$sum:"";?></b></dd>

	<?php if(isset($data) && !empty($data)){?>
		<dd class="static">
			<?php if(ISafe::get('user_id')){?>
			<a class="f_l" href="javascript:void(0)" onclick="deposit_ajax('<?php echo IUrl::creatUrl("/simple/deposit_cart_set");?>');">寄存购物车>></a>
			<?php }?>
			<label class="btn_orange"><input type="button" value="去购物车结算" onclick="window.location.href='<?php echo IUrl::creatUrl("/simple/cart");?>';" /></label>
		</dd>
	<?php }?>
</dl>
<?php }?>

<?php if($mod == 'selectProduct'){?>
	<table width="100%">
		<col />
		<col width="80px" />
		<col width="60px" />
		<?php foreach($productList as $key => $item){?>
		<tr>
			<td align="left">
				<?php $spec_array=Block::show_spec($item['spec_array']);?>
				<?php foreach($spec_array as $specName => $specValue){?>
					<?php echo isset($specName)?$specName:"";?>：<?php echo isset($specValue)?$specValue:"";?> &nbsp&nbsp
				<?php }?>
			</td>
			<td align="center"><span class="bold red2">￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></span></td>
			<td align="right"><label class="btn_gray_s"><input type="button" onclick="joinCart_ajax('<?php echo isset($item['id'])?$item['id']:"";?>','product');" value="购买"></label></td>
		</tr>
		<?php }?>
		<tr>
			<td colspan='3' align="left"><a href='<?php echo IUrl::creatUrl("/site/products/id/$item[goods_id]");?>'>查看更多</a></td>
		</tr>
	</table>
<?php }?>
