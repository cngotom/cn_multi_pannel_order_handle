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
			<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/editor/kindeditor-min.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/editor/lang/zh_CN.js"></script>
<div class="headbar">
	<div class="position"><span>工具</span><span>></span><span>文章管理</span><span>></span><span><?php if(isset($this->articleRow['id'])){?>编辑<?php }else{?>添加<?php }?>文章</span></div>
</div>
<div class="content_box">
	<div class="content form_content">
		<form action='<?php echo IUrl::creatUrl("/tools/article_edit_act");?>' method='post' name='article'>
			<table class="form_table">
				<col width="150px" />
				<col />
				<input type='hidden' name='id' value="" />
				<input type='hidden' name='relation_goods' value='' />
				<tr>
					<th>分类：</th>
					<td>
						<?php echo Article::showCat('category_id',$this->articleRow['category_id'],array('请选择分类'=>null));?>
						<label>*选择文章所属分类（必填）</label>
					</td>
				</tr>
				<tr>
					<th>标题：</th>
					<td><input type='text' name='title' class='normal' value='' pattern='required' alt='标题不能为空' /></td>
				</tr>
				<tr>
					<th>是否发布：</th>
					<td>
						<label class='attr'><input type='radio' name='visiblity' value='1' checked=checked />是</label>
						<label class='attr'><input type='radio' name='visiblity' value='0' />否</label>
					</td>
				</tr>
				<tr>
					<th>首页推荐：</th>
					<td>
						<label class='attr'><input type='radio' name='top' value='1' checked=checked />是</label>
						<label class='attr'><input type='radio' name='top' value='0' />否</label>
					</td>
				</tr>
				<tr>
					<th>标题字体：</th>
					<td>
						<label class='attr'><input type='radio' name='style' value='0' checked=checked />正常</label>
						<label class='attr'><input type='radio' name='style' value='1' /><b>粗体</b></label>
						<label class='attr'><input type='radio' name='style' value='2' /><span style="font-style:oblique;">斜体</span></label>
					</td>
				</tr>
				<tr>
					<th>标题颜色：</th>
					<td>
						<div class="color_sel">
							<?php $color = ($this->articleRow['color']===null) ? '#000000' : $this->articleRow['color']?>
							<input type='hidden' name='color' value='' />
							<a class="color_current" style='color:<?php echo isset($color)?$color:"";?>;background-color:<?php echo isset($color)?$color:"";?>;' href='javascript:void(0)' onclick='showColorBox();' id='titleColor'><?php echo isset($color)?$color:"";?></a>
							<div id='colorBox' class="color_box" style='display:none'></div>
						</div>
					</td>
				</tr>
				<tr>
					<th>排序：</th><td><input type='text' class='small' name='sort' value='' /></td>
				</tr>
				<tr>
					<th>关联相关商品：</th>
					<td>
						<div id='goods_box' class='photo_list'>
							<?php if(!empty($this->goodsList)){?>
								<?php foreach($this->goodsList as $key => $item){?>
								<img src='<?php echo IUrl::creatUrl("")."";?><?php echo isset($item['list_img'])?$item['list_img']:"";?>' alt='<?php echo isset($item['name'])?$item['name']:"";?>' width='120px' />
								<?php }?>
							<?php }?>
						</div>
						<button class='btn' type='button' onclick="searchGoods('<?php echo IUrl::creatUrl("/block/search_goods/type/radio");?>',searchGoodsCallback);"><span>选择商品</span></button>
						<label>文章所要关联的商品（可选）</label>
					</td>
				</tr>

				<tr>
					<th valign="top">内容：</th><td><textarea id="content" name='content' style='width:700px;height:300px' pattern='required' alt='内容不能为空'><?php echo htmlspecialchars($this->articleRow['content']);?></textarea></td>
				</tr>
				<tr>
					<th>KEYWORDS(SEO)：</th><td><input type='text' class='normal' name='keywords' value='' /></td>
				</tr>
				<tr>
					<th>DESCRIPTION(SEO)：</th><td><input type='text' class='normal' name='description' value='' /></td>
				</tr>
				<tr>
					<th></th><td><button class='submit' type='submit'><span>确 定</span></button></td>
				</tr>
			</table>
		</form>
	</div>
</div>

<script type='text/javascript'>
jQuery(function(){
	//调色板颜色
	var colorBox = new Array('#000','#930','#330','#030','#036','#930','#000080','#339','#333','#800000','#f60','#808000','#808080','#008080','#00f','#669','#f00','#f90','#9c0','#396','#3cc','#36f','#800080','#999','#f0f','#fc0','#ff0','#0f0','#0ff','#0cf','#936','#c0c0c0','#f9c','#fc9','#ff9','#cfc','#cff','#9cf','#c9f','#fff');
	for(color in colorBox)
	{
		var aHTML = '<a href="javascript:void(0)" onclick="changeColor(this);" style="background-color:'+colorBox[color]+';color:'+colorBox[color]+'">'+colorBox[color]+'</a> ';
		$('#colorBox').html($('#colorBox').html() + aHTML);
	}

	var FromObj = new Form('article');
	FromObj.init(
	{
		'id':'<?php echo isset($this->articleRow["id"])?$this->articleRow["id"]:"";?>',
		'relation_goods':'<?php echo isset($this->relationStr)?$this->relationStr:"";?>',
		'category_id':'<?php echo isset($this->articleRow["category_id"])?$this->articleRow["category_id"]:"";?>',
		'title':'<?php echo isset($this->articleRow["title"])?$this->articleRow["title"]:"";?>',
		'visiblity':'<?php echo isset($this->articleRow["visiblity"])?$this->articleRow["visiblity"]:"";?>',
		'top':'<?php echo isset($this->articleRow["top"])?$this->articleRow["top"]:"";?>',
		'style':'<?php echo isset($this->articleRow["style"])?$this->articleRow["style"]:"";?>',
		'color':'<?php echo isset($color)?$color:"";?>',
		'sort':'<?php echo $this->articleRow["sort"]?$this->articleRow["sort"]:99;?>',
		'keywords':'<?php echo isset($this->articleRow["keywords"])?$this->articleRow["keywords"]:"";?>',
		'description':'<?php echo isset($this->articleRow["description"])?$this->articleRow["description"]:"";?>'
	});

	KindEditor.ready(function(K){
		K.create('#content',{uploadJson:'<?php echo IUrl::creatUrl("/block/upload_img_from_editor");?>'});
	});
});

//弹出调色板
function showColorBox()
{
	var layer = document.createElement('div');
	layer.className = "poplayer";
	$(document.body).append(layer);
	var poplay = $('#colorBox');
	$('.poplayer').bind("click",function(){if(poplay.css('display')=='block') poplay.fadeOut();$("div").remove('.poplayer');})
	poplay.fadeIn();
}

//选择颜色
function changeColor(obj)
{
	var color = $(obj).html();
	$('#titleColor').css({color:color,'background-color':color});
	$('input[type=hidden][name="color"]').val(color);
	$('#colorBox').fadeOut();
	$("div").remove('.poplayer');
}
//输入筛选商品的条件
function searchGoodsCallback(goodsList)
{
	goodsList.each(function()
	{
		var temp = $.parseJSON($(this).attr('data'));
		var content = {"data":[
			{"list_img":temp.list_img,"name":temp.name,"id":temp.goods_id}
		]};
		relationCallBack(content);
	});
}

//关联商品回调处理函数
function relationCallBack(content)
{
	var goodsIdArray = [];
	var dataHTML     = '';
	$(content['data']).each(
		function(i)
		{
			goodsIdArray.push(content['data'][i]['id']);
			dataHTML+=' <img width="120px" src="<?php echo IUrl::creatUrl("")."";?>'+content['data'][i]['list_img']+'" alt="'+content['data'][i]['name']+'" /> ';
		}
	);
	//动态插入图片
	$('#goods_box').html(dataHTML);

	//把关联的商品id存放在隐藏域
	$('input[name="relation_goods"]').val(goodsIdArray.join(','));
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
