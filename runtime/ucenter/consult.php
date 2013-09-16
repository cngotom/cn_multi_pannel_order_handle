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
		<div class="main f_r">
	<div class="uc_title m_10 tabs_menu">
		<label class="current node"><span>近一个月的咨询</span></label><label><span><a  href="<?php echo IUrl::creatUrl("/ucenter/consult_old");?>">一个月以前的咨询</a></span></label>
	</div>
	<div class='tabs_content'>
		<?php $month =date('Y-m-d',strtotime('-1 month'));?>
		<div class="node">
			<table class="list_table m_10" width="100%" cellpadding="0" cellspacing="0">
				<col width="160px" />
				<col />
				<col width="80px" />
				<col width="60px"/>
				<thead><tr><th>商品名称</th><th>内容</th><th>咨询时间</th><th>回复</th></tr></thead>
				<tbody>
					<?php $page= (isset($_GET['page'])&&(intval($_GET['page'])>0))?intval($_GET['page']):1;?>
					<?php $query = new IQuery("refer as r");$query->fields = "time,name,question,status,answer,admin_id,go.id as gid";$query->join = "join goods as go on r.goods_id = go.id";$query->where = "r.user_id = $user[user_id] and time >= '$month'";$query->page = "$page";$items = $query->find(); foreach($items as $key => $item){?>
					<tr>
						<td><a href="<?php echo IUrl::creatUrl("/site/products/id/$item[gid]");?>" target="_black"><?php echo isset($item['name'])?$item['name']:"";?></a></td><td><?php echo isset($item['question'])?$item['question']:"";?></td><td><?php echo substr($item['time'],0,10);?></td><td><?php if($item['status']==1){?><a class="blue bold" href="javascript:void(0);" onclick="show_msg(this,'<?php echo isset($item['reply_time'])?$item['reply_time']:"";?>','<?php echo isset($item['answer'])?$item['answer']:"";?>')">查看</a><?php }else{?>未回复<?php }?></td>
					</tr>
					<?php }?>
					<?php if(isset($item['time'])){?>
					<tr id='show_msg' class="show" style="display:none">
						<td colspan="4"><i class="close f_r" onclick='$(this).parent().parent().css("display","none")'></i> 管理员在 [<span><?php echo $item['time'];?></span>] 给您做了如下解答:<p class="gray indent mt_10" id='re_content'></p></td>
					</tr>
					<?php }?>
				</tbody>
				<tfoot><tr><td colspan="4" class="t_l"><?php echo $query->getPageBar();?></td></tr></tfoot>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
function show_msg(obj,re_time,re_content)
{
    $('#show_msg').css('display','').insertAfter($(obj).parent().parent())
    $('#show_msg #re_time').text(re_time);
    $('#show_msg #re_content').text(re_content);

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
