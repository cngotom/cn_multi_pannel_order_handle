<?php 
	$myCartObj = new Cart();
	$myCartInfo = $myCartObj->getMyCart();
	$siteConfig = new Config("site_config");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $siteConfig->name;?></title>
	<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/index.css";?>" />
	<link rel="shortcut icon" href="favicon.ico" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/jquery/jquery-1.9.0.min.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/jquery/jquery-migrate-1.1.1.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/systemjs/artdialog/skins/default.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/systemjs/autovalidate/style.css" />
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/common.js";?>"></script>
	<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/site.js";?>'></script>
	<script type='text/javascript'>
		//用户中心导航条
		function menu_current()
		{
		    var current = "<?php echo $this->getAction()->getId();?>";
		    if(current == 'consult_old') current='consult';
		    else if(current == 'isevaluation') current ='evaluation';
		    else if(current == 'withdraw') current = 'account_log';
		    var tmpUrl = "<?php echo IUrl::creatUrl("/ucenter/current");?>";
		    tmpUrl = tmpUrl.replace("current",current);
		    $('div.cont ul.list li a[href^="'+tmpUrl+'"]').parent().addClass("current");
		}
	</script>
</head>
<body class="index">
<div class="ucenter container">
	<div class="header">
		<h1 class="logo"><a title="<?php echo $siteConfig->name;?>" style="background:url(<?php echo IUrl::creatUrl("")."image/logo.gif";?>);" href="<?php echo IUrl::creatUrl("");?>"><?php echo $siteConfig->name;?></a></h1>
		<ul class="shortcut">
			<li class="first"><a href="<?php echo IUrl::creatUrl("/ucenter/index");?>">我的账户</a></li><li><a href="<?php echo IUrl::creatUrl("/ucenter/order");?>">我的订单</a></li><li class='last'><a href="<?php echo IUrl::creatUrl("/site/help_list");?>">使用帮助</a></li>
		</ul>
		<?php $user = $this->user;?>
		<p class="loginfo"><?php echo isset($user['username'])?$user['username']:"";?>您好，欢迎您来到<?php echo $siteConfig->name;?>购物！[<a class='reg' href="<?php echo IUrl::creatUrl("/simple/logout");?>">安全退出</a>]</p>
	</div>
	<div class="navbar">
		<ul>
			<li><a href="<?php echo IUrl::creatUrl("");?>">首页</a></li>
			<?php $query = new IQuery("guide");$items = $query->find(); foreach($items as $key => $item){?>
			<li><a href="<?php echo isset($item['link'])?$item['link']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?><span> </span></a></li>
			<?php }?>
		</ul>
		<div class="mycart">
			<dl>
				<dt><a href="<?php echo IUrl::creatUrl("/simple/cart");?>">购物车<b name="mycart_count"><?php echo isset($myCartInfo['count'])?$myCartInfo['count']:"";?></b>件</a></dt>
				<dd><a href="<?php echo IUrl::creatUrl("/simple/cart");?>">去结算</a></dd>
			</dl>

			<!--购物车浮动div 开始-->
			<div class="shopping" id='div_mycart' style='display:none;'>
			</div>
			<!--购物车浮动div 结束-->

		</div>
	</div>

	<div class="searchbar">
		<div class="allsort">
			<a href="javascript:void();">全部商品分类</a>

			<!--总的商品分类-开始-->
			<ul class="sortlist" id='div_allsort' style='display:none'>
				<?php $catResult = block::goods_category();?>
				<?php foreach($catResult as $key => $first){?>
					<li>
						<h2><a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/$first[id]");?>"><?php echo isset($first['name'])?$first['name']:"";?></a></h2>

						<!--商品分类 浮动div 开始-->
						<div class="sublist" style='display:none'>

							<div class="items">
								<strong>选择分类</strong>
								<?php if(isset($first['second'])){?>
								<?php foreach($first['second'] as $key => $second){?>
								<dl class="category selected">
									<dt>
										<a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/$second[id]");?>"><?php echo isset($second['name'])?$second['name']:"";?></a>
									</dt>

									<dd>
										<?php if(isset($second['more'])){?>
										<?php foreach($second['more'] as $key => $third){?>
										<a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/$third[id]");?>"><?php echo isset($third['name'])?$third['name']:"";?></a>|
										<?php }?>
										<?php }?>
									</dd>
								</dl>
								<?php }?>
								<?php }?>

							</div>

						</div>
						<!--商品分类 浮动div 结束-->

					</li>
				<?php }?>

			</ul>
			<!--总的商品分类-结束-->

		</div>

		<div class="searchbox">

			<form method='get'>
				<input type='hidden' name='controller' value='site' />
				<input type='hidden' name='action' value='search_list' />
				<input class="text" type="text" name='word' autocomplete="off" value="输入关键字..." />
				<input class="btn" type="submit" value="商品搜索" onclick="checkInput('word','输入关键字...');" />
			</form>

			<!--自动完成div 开始-->
			<ul class="auto_list" style='display:none'></ul>
			<!--自动完成div 开始-->

		</div>
		<div class="hotwords">热门搜索：
			<?php $query = new IQuery("keyword");$query->where = "hot = 1";$query->limit = "5";$query->order = "`order` asc";$items = $query->find(); foreach($items as $key => $item){?>
			<?php $tmpWord = urlencode($item['word']);?>
			<a href="<?php echo IUrl::creatUrl("/site/search_list/word/$tmpWord");?>"><?php echo isset($item['word'])?$item['word']:"";?></a>
			<?php }?>
		</div>
	</div>

	<div class="position">
		您当前的位置： <a href="<?php echo IUrl::creatUrl("");?>">首页</a>&nbsp;&gt;&nbsp;我的账户
	</div>
	<div class="wrapper clearfix">
		<div class="sidebar f_l">
			<img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/ucenter/ucenter.gif";?>" width="180" height="40" />
			<div class="box">
				<div class="title"><h2>交易记录</h2></div>
				<div class="cont">
					<ul class="list">
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/order");?>">我的订单</a></li>
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/integral");?>">我的积分</a></li>
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/redpacket");?>">我的代金券</a></li>
					</ul>
				</div>
			</div>
			<div class="box">
				<div class="title"><h2 class='bg2'>服务中心</h2></div>
				<div class="cont">
					<ul class="list">
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/refunds");?>">退款申请</a></li>
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/complain");?>">站点建议</a></li>
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/consult");?>">商品咨询</a></li>
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/evaluation");?>">商品评价</a></li>
					</ul>
				</div>
			</div>
			<div class="box">
				<div class="title"><h2 class='bg3'>应用</h2></div>
				<div class="cont">
					<ul class="list">
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/message");?>">短信息</a></li>
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/favorite");?>">收藏夹</a></li>
					</ul>
				</div>
			</div>
			<div class="box">
				<div class="title"><h2 class='bg4'>账户资金</h2></div>
				<div class="cont">
					<ul class="list">
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/account_log");?>">帐户余额</a></li>
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/online_recharge");?>">在线充值</a></li>
					</ul>
				</div>
			</div>
			<div class="box">
				<div class="title"><h2 class='bg5'>个人设置</h2></div>
				<div class="cont">
					<ul class="list">
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/address");?>">地址管理</a></li>
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/info");?>">个人资料</a></li>
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/password");?>">修改密码</a></li>
					</ul>
				</div>
			</div>
		</div>
		<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/artTemplate/area_select.js";?>'></script>

<div class="main f_r">

	<div class="uc_title m_10">
		<label class="current"><span>个人资料</span></label>
	</div>

	<div class="form_content m_10">
		<div class="uc_title2 m_10"><strong>会员信息</strong></div>
		<dl class="userinfo_box clearfix">
			<dt>
				<?php $user_ico = $this->userRow['head_ico']?>
				<a class="ico" href="javascript:void(0);"><img src="<?php echo IUrl::creatUrl("")."$user_ico";?>" id="user_ico_img" onerror="this.src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/user_ico.gif";?>'" width="96" height="96" alt="个人头像" /></a>
				<a class="blue" href="javascript:select_ico();">修改头像</a>
			</dt>
			<dd>
				<table class="form_table" width="100%" cellpadding="0" cellspacing="0">
					<col width="120px" />
					<col />
					<tr>
						<th>登录名：</th><td><?php echo isset($this->userRow['username'])?$this->userRow['username']:"";?></td>
					</tr>
					<tr>
						<th>邮箱：</th>
						<td>
							<?php echo isset($this->userRow['email'])?$this->userRow['email']:"";?>
						</td>
					</tr>
					<tr>
						<th>会员等级：</th><td><?php echo isset($this->userGroupRow['group_name'])?$this->userGroupRow['group_name']:"";?></td>
					</tr>
				</table>
			</dd>
		</dl>
	</div>

	<div class="form_content m_10">
		<div class="uc_title2 m_10"><strong>个人信息</strong></div>
		<form action='<?php echo IUrl::creatUrl("/ucenter/info_edit_act");?>' method='post' name='user_info'>
			<table class="form_table" width="100%" cellpadding="0" cellspacing="0">
				<col width="120px" />
				<col />
				<tr>
					<th><span class="red">*</span> 姓名：</th><td><input class="normal" type="text" name="true_name" pattern='required' alt='请填写真实姓名' /></td>
				</tr>
				<tr>
					<th><span class="red">*</span> 性别：</th>
					<td>
						<label class='attr'><input type='radio' name='sex' value='1' />男</label>
						<label class='attr'><input type='radio' name='sex' value='2' checked=checked />女</label>
					</td>
				</tr>
				<tr>
					<th><span class="red">*</span>出生日期：</th>
					<td>
						<select name='year' pattern='required'></select>
						<select name='month' pattern='required'></select>
						<select name='day' pattern='required'></select>
					</td>
				</tr>
				<tr>
					<th><span class="red">*</span> 所在地区：</th>
					<td>
						<select name="province" child="city,area" onchange="areaChangeCallback(this);"></select>
						<select name="city" child="area" parent="province" onchange="areaChangeCallback(this);"></select>
						<select name="area" parent="city" pattern="required"></select>
					</td>
				</tr>
				<tr>
					<th><span class="red">*</span> 联系地址：</th>
					<td><input type='text' class='normal' name='contact_addr' pattern='required' alt='请填写联系地址' /></td>
				</tr>
				<tr>
					<th><span class="red">*</span> 手机号码：</th>
					<td><input class="normal" type="text" name='mobile' pattern='mobi' alt='请填写正确的手机号码' /></td>
				</tr>
				<tr>
					<th>邮编：</th>
					<td><input type='text' class='normal' name='zip' pattern='zip' empty alt='请填写正确的邮政编码' /></td>
				</tr>
				<tr>
					<th>固定电话：</th>
					<td><input class="normal" type="text" name='telephone' pattern='phone' empty alt='请填写正确的固定电话' /></td>
				</tr>
				<tr>
					<th>QQ：</th>
					<td><input class="normal" type="text" name='qq' pattern='qq' empty alt='请填写正确的QQ号' /></td>
				</tr>
				<tr>
					<th>MSN：</th>
					<td><input class="normal" type="text" name='msn' pattern='email' empty alt='请填写正确的MSN号' /></td>
				</tr>
				<tr><th></th><td><label class="btn"><input type="submit" value="保存基本信息" /></label></td></tr>
			</table>
		</form>
	</div>
</div>
<script type='text/javascript'>
//DOM加载完毕
$(function(){
	//初始化地域联动
	template.compile("areaTemplate",areaTemplate);

	<?php if(isset($this->memberRow['area']) && $this->memberRow['area']){?>
	<?php $area = explode(',',trim($this->memberRow['area'],','))?>
	createAreaSelect('province',0,<?php echo isset($area[0])?$area[0]:"";?>);
	createAreaSelect('city',<?php echo isset($area[0])?$area[0]:"";?>,<?php echo isset($area[1])?$area[1]:"";?>);
	createAreaSelect('area',<?php echo isset($area[1])?$area[1]:"";?>,<?php echo isset($area[2])?$area[2]:"";?>);
	<?php }else{?>
	createAreaSelect('province',0,"");
	<?php }?>
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

//修改头像
function select_ico()
{
	<?php $callback = urlencode(IUrl::creatUrl('/ucenter/user_ico_upload'))?>
	art.dialog.open('<?php echo IUrl::creatUrl("/block/photo_upload/callback/$callback");?>',{id:'user_ico',title:'设置头像'});
}

//头像上传回调函数
function callback_user_ico(content)
{
	var content = eval(content);
	if(content.isError == true)
	{
		alert(content.message);
	}
	else
	{
		$('#user_ico_img').attr('src',content.data);
	}
	art.dialog({id:'user_ico'}).close();
}

//出生日期
function dateSelectInit()
{
	var yearHtml = '<option value="">请选择</option>';
	for(var year=2010;year>=1940;year--)
	{
		yearHtml+= '<option value="'+year+'">'+year+'</option>';
	}

	var monthHtml = '<option value="">--</option>';
	for(var month=12;month>=1;month--)
	{
		if(month < 10) month = '0' + month;
		monthHtml+= '<option value="'+month+'">'+month+'</option>';
	}

	var dayHtml = '<option value="">--</option>';
	for(var day=31;day>=1;day--)
	{
		if(day < 10) day = '0' + day;
		dayHtml+= '<option value="'+day+'">'+day+'</option>';
	}

	$('[name="year"]').html(yearHtml);
	$('[name="month"]').html(monthHtml);
	$('[name="day"]').html(dayHtml);
}

//初始化日期
dateSelectInit();

//表单回填
<?php $birthday = explode('-',$this->memberRow['birthday'])?>
var formObj = new Form('user_info');
formObj.init({
	'id':'<?php echo isset($this->memberRow['id'])?$this->memberRow['id']:"";?>',
	'true_name':'<?php echo isset($this->memberRow['true_name'])?$this->memberRow['true_name']:"";?>',
	'telephone':'<?php echo isset($this->memberRow['telephone'])?$this->memberRow['telephone']:"";?>',
	'mobile':'<?php echo isset($this->memberRow['mobile'])?$this->memberRow['mobile']:"";?>',
	'contact_addr':'<?php echo isset($this->memberRow['contact_addr'])?$this->memberRow['contact_addr']:"";?>',
	'qq':'<?php echo isset($this->memberRow['qq'])?$this->memberRow['qq']:"";?>',
	'msn':'<?php echo isset($this->memberRow['msn'])?$this->memberRow['msn']:"";?>',
	'sex':'<?php echo isset($this->memberRow['sex'])?$this->memberRow['sex']:"";?>',
	'zip':'<?php echo isset($this->memberRow['zip'])?$this->memberRow['zip']:"";?>',
	'year':'<?php echo isset($birthday[0])?$birthday[0]:"";?>',
	'month':'<?php echo isset($birthday[1])?$birthday[1]:"";?>',
	'day':'<?php echo isset($birthday[2])?$birthday[2]:"";?>',
});
</script>
	</div>

	<div class="help m_10">
		<div class="cont clearfix">
			<?php $cat_list=array();?>
			<?php $query = new IQuery("help_category AS cat");$query->where = "position_foot = 1";$query->order = "sort asc,id desc";$query->limit = "5";$items = $query->find(); foreach($items as $key => $item){?>
			<?php $cat_list[$item['id']]=$item;?>
			<?php }?>
			<?php if(count($cat_list)){?>
				<?php $width=floor(100/count($cat_list))-1;?>
			<?php }?>

			<?php foreach($cat_list as $cat_id => $cat){?>
			<dl style="width:<?php echo isset($width)?$width:"";?>%">
     			<dt><a href="<?php echo IUrl::creatUrl("/site/help_list/id/$cat[id]");?>"><?php echo isset($cat['name'])?$cat['name']:"";?></a></dt>
     			<?php $query = new IQuery("help");$query->where = "cat_id = $cat_id";$query->order = "sort asc,id desc";$items = $query->find(); foreach($items as $key => $item){?>
					<dd><a href="<?php echo IUrl::creatUrl("/site/help/id/$item[id]");?>"><?php echo isset($item['name'])?$item['name']:"";?></a></dd>
				<?php }?>
      		</dl>
      		<?php }?>
		</div>
	</div>
	<?php echo IFilter::stripSlash($siteConfig->site_footer_code);?>

</div>
<script type='text/javascript'>
//DOM加载完毕后运行
$(function()
{
	$(".tabs").each(function(i){
	    var parrent = $(this);
		$('.tabs_menu .node',this).each(function(j){
			var current=".node:eq("+j+")";
			$(this).bind('click',function(event){
				$('.tabs_menu .node',parrent).removeClass('current');
				$(this).addClass('current');
				$('.tabs_content>.node',parrent).css('display','none');
				$('.tabs_content>.node:eq('+j+')',parrent).css('display','block');
			});
		});
	});

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

	menu_current();

	$('input:text[name="word"]').bind({
		keyup:function(){autoComplete('<?php echo IUrl::creatUrl("/site/autoComplete");?>','<?php echo IUrl::creatUrl("/site/search_list/word/@word@");?>','<?php echo isset($siteConfig->auto_finish)?$siteConfig->auto_finish:"";?>');}
	});

	<?php $word = IReq::get('word') ? IFilter::act(IReq::get('word'),'text') : '输入关键字...'?>
	$('input:text[name="word"]').val("<?php echo isset($word)?$word:"";?>");

	//购物车div层
	$('.mycart').hover(
		function(){
			showCart('<?php echo IUrl::creatUrl("/simple/showCart");?>');
		},
		function(){
			$('#div_mycart').hide('slow');
		}
	);
});
</script>
</body>
</html>
