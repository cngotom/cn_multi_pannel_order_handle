<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>后台管理</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/admin.css";?>" />
	<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/bootstrap.min.css";?>" />
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
	<div class="contain" >
		<div id="header" style="display:none">
			<div class="logo">
				<a href="<?php echo IUrl::creatUrl("/system/default");?>"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/logo.gif";?>" width="303" height="43" /></a>
			</div>
			<div id="menu">
				<ul name="menu">
				</ul>
			</div>
			<p><a href="<?php echo IUrl::creatUrl("/systemadmin/logout");?>">退出管理</a></p>
		</div>
		<div id="info_bar" style="display:none">
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
			<div class="container"> 
	<table class="table">



		<thead>
			<th> 产品名称 </th>
			<th> 图片</th>
			<th> 重量/KG</th>
			<th> 价格/元 </th>
		</thead>

		<tbody>

			<?php foreach($goods as $key => $item){?>
					<tr> 
						<td><?php echo isset($item['title'])?$item['title']:"";?>	</td>
						<td> <img src="<?php echo isset($item['pic_path'])?$item['pic_path']:"";?>"  width="60" height="60"  />	</td>
						<td> <span type="weight"  gid="<?php echo isset($item['id'])?$item['id']:"";?>" class="value" mode="show">  <?php echo isset($item['weight'])?$item['weight']:"";?> </span>  </td>
						<td> <span type="price" gid="<?php echo isset($item['id'])?$item['id']:"";?>"  class="value" mode="show">  <?php echo isset($item['pprice'])?$item['pprice']:"";?> </span>  </td>
					</tr>
			<?php }?>

		</tbody>









	</table>

</div>
<script>
$(function(){
	var select_span = null;

	function change_mode_show()
	{
		if(select_span != null)
		{
			if($(select_span).attr('mode') == "edit"){
				var span = select_span;
				var input = $(select_span).find("input");
				var value =  parseFloat(input.val());

				var type = $(select_span).attr('type');
				var gid =  $(select_span).attr('gid');
				
				$(span).html(value);

				$.post(
					'<?php echo IUrl::creatUrl("/goods/ajaxUpdate");?>',
					{"gid":gid,"value":value,"type":type}
				);




				$(span).attr('mode','show');
			}
		}
	}

	$('body').click(change_mode_show);
	$(".value").click(function(){
		if($(this).attr('mode') == "show")
		{	
			change_mode_show();

			var v = $(this).html();
			$(this).html(
				'<input type="input" value="' + v +'" />'
			)
			$(this).attr('mode','edit');
			 $(this).find("input").trigger('focus');

			 select_span = this;
			 return false;
		}
		
	})
	.mouseover(function(){

		$(this).addClass('hover');

	})
	.mouseout(function(event) {
		$(this).removeClass('hover');
	});




});

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
