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
		<?php $user_id = $this->user['user_id']?>
<?php $query = new IQuery("member");$query->where = "user_id = $user_id";$users = $query->find();?>
<?php $user = $users[0];?>
<div class="main f_r">
	<?php $msg_ids = strlen($user['message_ids'])>=2?substr($user['message_ids'],0,-1):0;?>
    <?php $query = new IQuery("message");$query->fields = "count(id) as num";$query->where = "id in($msg_ids)";$items = $query->find();?>
    <?php $num = isset($items[0]['num'])?$items[0]['num']:0?>
    <?php if($num>0){?>
    <div class="prompt m_10">
        <b>温馨提示：</b>您有<span class="red"><?php echo isset($num)?$num:"";?></span> 条站内未读短信息，<a class="blue" href="<?php echo IUrl::creatUrl("/ucenter/message");?>">现在去看看</a>
    </div>
    <?php }?>

	<div class="userinfo_bar"><span class="f_r">上一次登录时间：<?php echo ISafe::get('last_login');?></span><b class="f14">您好，<?php echo isset($this->user['username'])?$this->user['username']:"";?> 欢迎回来!</b></div>
	<div class="box clearfix">
		<h3>用户信息</h3>
		<dl class="userinfo_box">
			<dt>
			<?php $user_ico = $this->user['head_ico']?>
			<a class="ico"><img id="user_ico_img" src="<?php echo IUrl::creatUrl("")."$user_ico";?>" width="100" height="100" alt="" onerror="this.src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/user_ico.gif";?>'" /></a>
			<a class="blue" href="javascript:select_ico();">修改头像</a>
			</dt>
			<dd>
			<table width="100%" cellpadding="0" cellspacing="0">
				<col width="192px" />
				<col width="120px" />
				<col width="192px" />
				<col />
				<tr>
					<td>你的账户目前总积分：<b class="red2"><?php echo isset($user['point'])?$user['point']:"";?></b></td>
					<td><a class="blue" href="<?php echo IUrl::creatUrl("/ucenter/integral");?>">查看积分历史</a></td>
					<?php $query = new IQuery("order");$query->fields = "sum(order_amount) as amount,count(id) as num";$query->where = "user_id = $user_id and pay_status = 1";$items = $query->find();?>
					<?php $amount = isset($items[0]['amount'])?$items[0]['amount']:0.00;$num = isset($items[0]['num'])?$items[0]['num']:0?>
					<td>你的订单交易总数量：<b class="red2"><?php echo isset($num)?$num:"";?></b> 笔</td>
					<td><a class="blue" href="<?php echo IUrl::creatUrl("/ucenter/order");?>">进入订单列表</a></td>
				</tr>
				<tr>

					<td>总消费额：<b>￥</b><b class="red2"><?php echo isset($amount)?$amount:"";?></b></td>
					<td></td>
					<td>预存款余额：<b>￥</b><b class="red2"><?php echo isset($user['balance'])?$user['balance']:"";?></b></td>
				</tr>
				<tr>
					<?php $prop = strlen($user['prop'])>2?substr($user['prop'],1,-1):0;?>
					<?php $query = new IQuery("prop");$query->fields = "count(id) as num";$query->where = "id in ($prop) and type = 0";$items = $query->find();?>
					<?php $num=isset($items[0]['num'])?$items[0]['num']:0;?>
					<td>代金券：拥有可用代金券 <b class="red2"><?php echo isset($num)?$num:"";?></b> 张</td>
					<td></td>
				</tr>
			</table>
			<div class="stat">
				<?php $query = new IQuery("comment");$query->fields = "count(id) as num";$query->where = "user_id = $user_id and status = 0";$items = $query->find();?>
				<?php $num=isset($items[0]['num'])?$items[0]['num']:0;?>
				<span>待评价商品：<label>(<b class="red2"><?php echo isset($num)?$num:"";?></b>)</label></span>
				<?php $query = new IQuery("order");$query->fields = "count(id) as num";$query->where = "user_id = $user[user_id] and status = 1";$items = $query->find();?>
				<?php $num = isset($items[0]['num'])?$items[0]['num']:0?>
				<span>待付款订单：<label>(<b class="red2"><?php echo isset($num)?$num:"";?></b>)</label></span>
				<?php $query = new IQuery("order");$query->fields = "count(id) as num";$query->where = "user_id = $user[user_id] and status = 2 and distribution_status = 1";$items = $query->find();?>
				<?php $num = isset($items[0]['num'])?$items[0]['num']:0?>
				<span>待确认收货：<label>(<b class="red2"><a href="<?php echo IUrl::creatUrl("/ucenter/order");?>"><?php echo isset($num)?$num:"";?></b>)</a></label></span>
			</div>
			</dd>
		</dl>
	</div>
	<h3 class="bg">我的订单</h3>
	<div class="box m_10">
		<table class="list_table" width="100%" cellpadding="0" cellspacing="0">
			<col width="140px" />
			<tr>
				<th>订单编号</th><th>下单日期</th><th>收货人</th><th>支付方式</th><th>总金额</th><th>订单状态</th>
			</tr>

			<?php $query = new IQuery("order");$query->where = "user_id = $user[user_id] and if_del = 0";$query->order = "id desc";$query->limit = "6";$items = $query->find(); foreach($items as $key => $item){?>
			<tr>
				<td><a href="<?php echo IUrl::creatUrl("/ucenter/order_detail/id/$item[id]");?>"><?php echo isset($item['order_no'])?$item['order_no']:"";?></a></td><td><?php echo isset($item['create_time'])?$item['create_time']:"";?></td><td><?php echo isset($item['accept_name'])?$item['accept_name']:"";?></td><td><?php echo isset($this->payments[$item['pay_type']]['name'])?$this->payments[$item['pay_type']]['name']:"";?></td><td>￥<?php echo ($item['order_amount']);?></td><td>
					<?php if($item['status']==1){?>
					<?php if($item['pay_type']==0){?>
					<b class="orange">等待确认</b>
					<?php }else{?>
					<b class="orange">等待付款</b>
					<?php }?>
					<?php }elseif($item['status']==2){?>
					<?php if($item['distribution_status']==1){?>
					<b class="green">已发货</b>
					<?php }else{?>
					<b class="orange">等待发货</b>
					<?php }?>
					<?php }elseif($item['status']==3 || $item['status']==4){?>
					<b class="green">已取消</b>
					<?php }elseif($item['status']==5){?>
					<b class="green">已完成</b>
					<?php if($item['pay_status']==2){?>
					<b class="green">已退款</b>
					<?php }elseif($item['pay_status']==3){?>
					<b class="green">已申请退款</b>
					<?php }?>
					<?php if($item['distribution_status']==2){?>
					<b class="green">已退货</b>
					<?php }elseif($item['distribution_status']==3){?>
					<b class="green">已申请退货</b>
					<?php }?>
					<?php }?>
				</td>
			</tr>
			<?php }?>

			<tfoot><tr><td colspan="6" class="t_r"><a class="blue" href="<?php echo IUrl::creatUrl("/ucenter/order");?>">更多订单&gt;&gt;</a></td></tr></tfoot>
		</table>
	</div>
	<div class="box">
		<div class="title"><h2>也许你会对下列商品感兴趣</h2></div>
		<div class="cont clearfix">
			<ul class="prolist f_l">
				<?php $query = new IQuery("goods");$query->where = "id in( select goods_id from commend_goods where commend_id = 4 ) and is_del = 0";$query->limit = "12";$items = $query->find(); foreach($items as $key => $item){?>
				<li>
				<a href="<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>" target="_black"><img src="<?php echo IUrl::creatUrl("")."$item[list_img]";?>" alt="<?php echo isset($item['name'])?$item['name']:"";?>" height="100" width="100"></a>
				<p class="pro_title"><a href="<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>" target='_black'><?php echo isset($item['name'])?$item['name']:"";?></a></p>
				<p class="price_new"><b>￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></b></p>
				</li>
				<?php }?>
			</ul>
		</div>
	</div>
</div>
<script type='text/javascript'>
//选择头像
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
