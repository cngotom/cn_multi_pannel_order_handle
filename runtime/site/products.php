<?php 
	$user = $this->user;
	$myCartObj = new Cart();
	$myCartInfo = $myCartObj->getMyCart();
	$siteConfig = new Config("site_config");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $siteConfig->name;?></title>
	<link type="image/x-icon" href="favicon.ico" rel="icon">
        <link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/old.css";?>" />
	<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/common.css";?>" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/jquery/jquery-1.9.0.min.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/jquery/jquery-migrate-1.1.1.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/systemjs/artdialog/skins/default.css" />
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/common.js";?>"></script>
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("/javascript/adloader/");?>"></script>
	<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/site.js";?>'></script>
</head>
    
    
    <!-- top start -->
    <div class="top">
        
        <div class="head_bar">
            <div class="theme">
                <ul class="head_bar_logo">
                    <li style="padding-left: 3px;">
                        <img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/index/scstar_icon.gif";?>"></li>
                    <li style="border-left: none; padding-left: 5px; width: 85px;" class="shoucang"><a href="javascript:addBookmark('<?php echo $siteConfig->name;?>',window.location.href)">收藏<?php echo $siteConfig->name;?></a></li>
                </ul>
                <ul class="head_bar_link" style="float: right; padding-right: 20px;">
                     <?php if((isset($user['user_id']) && $user['user_id'])){?>
                    <li><span id="welcome">亲爱的<?php echo isset($user['username'])?$user['username']:"";?>，欢迎光临！&nbsp;&nbsp; <a href="<?php echo IUrl::creatUrl("/ucenter/index");?>">我的帐户</a>&nbsp;|&nbsp<a href="<?php echo IUrl::creatUrl("/simple/logout");?>" class="reg">安全退出</a>
                        &nbsp;|&nbsp;<a href="../Sale/SaleCart.aspx" class="a1">购物车</a> &nbsp;|&nbsp;<a href="../Service/h_%E6%94%AF%E4%BB%98%E6%96%B9%E5%BC%8F_aspx_help-S49.aspx">帮助中心</a>&nbsp;|&nbsp;<a href="../Web/ArticleCulture.aspx">送礼文化</a></li>
                        </span><?php }else{?>
                        [<a href="<?php echo IUrl::creatUrl("/simple/login");?>">登录</a>
			<?php $callback = IFilter::act(IReq::get('callback'),'text') ? urlencode(IReq::get('callback')) : ''?>
                            <?php if($callback){?>
                            <a class="reg" href="<?php echo IUrl::creatUrl("/simple/reg?callback=$callback");?>">免费注册</a>
                            <?php }else{?>
                            <a class="reg" href="<?php echo IUrl::creatUrl("/simple/reg");?>">免费注册</a>
                            <?php }?>
			]
		   <?php }?>
                </ul>
            </div>
       </div>
        
        
        <div class="theme" style="height: 85px;">
            <div class="head_shop">
                <div style="float: left;">
                    <a href="<?php echo IUrl::creatUrl("");?>">
                        <img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/index/weblogo.jpg";?>" height="58" width="161" alt=""></a></div>
                <div style="float: left; margin-left: 25px;">
                    <ul>
                        <form method='get'>
                            <input type='hidden' name='controller' value='site' />
                            <input type='hidden' name='action' value='search_list' />
                            <li class="head_shop_search">
                                <input id="txtSearchName" type="text" name='word' class="input_txt" value="输入关键字...">
                            </li>
                            <li class="head_shop_btn">
                                <input type="submit"  class="btn"  value="" style="border-width: 0px;" onclick="checkInput('word','输入关键字...');">
                            </li>
                        </form>
			<!--自动完成div 开始-->
			<ul class="auto_list" style='display:none'></ul>
			<!--自动完成div 开始-->
                        
                        <li class="head_shop_hotword">

        <span style=" font-weight:bold;">热门搜索词：</span>


        
                <?php  $hot_words = array('礼品册','中秋','生日礼物','年会礼物','送长辈'); ?>
			<?php foreach($hot_words as $key => $word){?>
			<?php $tmpWord = urlencode($word);?>
                         <span><a href="<?php echo IUrl::creatUrl("/site/search_list/word/$tmpWord");?>">
                             <?php echo isset($word)?$word:"";?>&nbsp;</a></span>
			<?php }?>
                        </li>
                    </ul>
                </div>
                <div style="float: right;">
                    <img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/index/toptel.jpg";?>"><br>

                </div>
            </div>
        </div>
        
        
        
        
        <!-- nav bar start -->
        <div class="nav_box">
            <ul class="nav">
                  
                <li class="c1_title"><a href="<?php echo IUrl::creatUrl("");?>" class="c1">
                            首页
                        </a>
                </li>
                <?php $i=0;?>
                <?php $query = new IQuery("guide");$items = $query->find(); foreach($items as $key => $item){?>
                <?php $i++;$item['link']=IUrl::creatUrl($item['link']);?>
                <li class="c1_title"><a href="<?php echo isset($item['link'])?$item['link']:"";?>" class="c1 c1_over"><?php echo isset($item['name'])?$item['name']:"";?> </a></li>

                <?php }?>
                
              
            <div id="ucPageHead_ucNavigation_rptC1_NavigationContent_1" class="c2_title" style="display: none;">
                <table cellpadding="0" cellspacing="0" class="cat_tbl">
                            <tbody>
                             <tr>
                                <td class="tit">
                                    <h2>
                                        <a href="">
                                           礼品册
                                        </a>
                                    </h2>
                                </td>
                                <td class="txt">
                                    
                                </td>
                            </tr>
                </tbody></table>
                
               
            </div>
        </li>
            </ul>
        </div>
        <!-- nav bar end -->
    </div>
    <!-- top end -->
    <div class="clear"></div>
    
    
    <!-- main start -->
    <div class="main">
        	<?php 
	$seo_data=array();
	$site_config=new Config('site_config');
	$seo_data['title']=$name."_".$site_config->name;
	$seo_data['keywords']=$keywords;
	$seo_data['description']=$description;
	seo::set($seo_data);
?>
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/cookie/jquery.cookie.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/jquery.jqzoom/css/jquery.jqzoom.css";?>" />
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/jquery.jqzoom/js/jquery.jqzoom-core-pack.js";?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/jquery.bxSlider/jquery.bxslider.css";?>" />
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/jquery.bxSlider/jquery.bxSlider.min.js";?>"></script>

<div class="position"><span>您当前的位置：</span><a href="<?php echo IUrl::creatUrl("");?>"> 首页</a> » <?php if(isset($category['id'])){?><a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/$category[id]");?>"><?php echo isset($category['name'])?$category['name']:"";?></a> » <?php }?><?php echo isset($name)?$name:"";?></div>
<div class="wrapper clearfix">
	<div class="summary">
		<h2><?php echo isset($name)?$name:"";?></h2>

		<!--货品ID，当为商品时值为空-->
		<input type='hidden' id='product_id' alt='货品ID' value='' />

		<!--基本信息区域-->
		<ul>
			<li>
				<span class="f_r light_gray">商品编号：<label id="data_goodsNo"><?php echo $goods_no?$goods_no:$id;?></label></span>
				<?php if(isset($brand)){?>品牌：<?php echo isset($brand)?$brand:"";?><?php }?>
			</li>

			<!--抢购-->
			<?php if($promo == 'time'){?>
				<?php if(isset($promotion)){?>
				<!--抢购正常-->
				<li class="current">
					<span class="bold red2">抢购价：</span><b class="price red2"><span class="f30">￥</span><?php echo isset($promotion['award_value'])?$promotion['award_value']:"";?></b>
					<?php $query = new IQuery("promotion");$query->fields = "award_value,end_time,user_group";$query->where = "type = 1 and `condition` = $id and NOW() between start_time and end_time";$items = $query->find(); foreach($items as $key => $item){?>
					<?php $free_time = ITime::getDiffSec($item['end_time']);?>
					<span class="time" id="promotiona">还剩 <i class="bold red2" id='cd_hour_promotiona'><?php echo floor($free_time/3600);?></i>小时<i class="bold red2" id='cd_minute_promotiona'><?php echo floor(($free_time%3600)/60);?></i>分<i class="bold red2" id='cd_second_promotiona'><?php echo $free_time%60;?></i>秒结束</span>
					<?php }?>
				</li>
				<li>
					销售价：<span class="price light_gray"><s class="f30">￥<label id="data_sellPrice"><?php echo isset($sell_price)?$sell_price:"";?></label></s></span>
					立省：￥<?php echo abs($sell_price-$promotion['award_value']);?>
				</li>
				<?php }else{?>
				<!--抢购过期-->
				<li><span class="f30"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/grab_expir.png";?>" style="float:right;" name="timeover" /></span></li>
				<li>销售价：<b class="price red2"><span class="f30"><?php if($minSellPrice != $maxSellPrice){?>￥<?php echo isset($minSellPrice)?$minSellPrice:"";?> - ￥<?php echo isset($maxSellPrice)?$maxSellPrice:"";?><?php }else{?>￥<?php echo isset($sell_price)?$sell_price:"";?><?php }?></span></b></li>
				<?php }?>
			<?php }?>

			<!--团购-->
			<?php if($promo == 'groupon'){?>
				<?php if(isset($regiment)){?>
				<!--团购正常-->
				<li class="current">
					<span class="bold red2">团购价：</span><b class="price red2"><span class="f30">￥</span><?php echo isset($regiment['regiment_price'])?$regiment['regiment_price']:"";?></b>
					<?php $query = new IQuery("regiment");$query->fields = "id as rid,regiment_price,end_time,start_time";$query->where = "goods_id = $id and  NOW() between start_time and end_time";$items = $query->find(); foreach($items as $key => $item){?>
					<?php $free_time = ITime::getDiffSec($item['end_time']);?>
					<span class="time" id="promotionb">还剩 <i class="bold red2" id='cd_hour_promotionb'><?php echo floor($free_time/3600);?></i>小时<i class="bold red2" id='cd_minute_promotionb'><?php echo floor(($free_time%3600)/60);?></i>分<i class="bold red2" id='cd_second_promotionb'><?php echo $free_time%60;?></i>秒结束</span>
					<?php $query = new IQuery("regiment_user_relation");$query->fields = "count(*) as totalNum";$query->where = "regiment_id = $item[rid]";$items = $query->find(); foreach($items as $key => $value){?>
					<span class="bold red2">已参加团购<?php echo isset($value['totalNum'])?$value['totalNum']:"";?>人</span>
					<?php }?>
					<?php }?>
				</li>
				<li>
					销售价：<span class="price light_gray"><s class="f30">￥<label id="data_sellPrice"><?php echo isset($sell_price)?$sell_price:"";?></label></s></span>
					立省：￥<?php echo abs($sell_price-$regiment['regiment_price']);?>
				</li>
				<?php }else{?>
				<!--团购过期-->
				<li><span class="f30"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/group_expir.png";?>" style="float:right;" name="timeover" /></span></li>
				<li>销售价：<b class="price red2"><span class="f30"><?php if($minSellPrice != $maxSellPrice){?>￥<?php echo isset($minSellPrice)?$minSellPrice:"";?> - ￥<?php echo isset($maxSellPrice)?$maxSellPrice:"";?><?php }else{?>￥<?php echo isset($sell_price)?$sell_price:"";?><?php }?></span></b></li>
				<?php }?>
			<?php }?>

			<!--普通正常-->
			<?php if($promo == ''){?>
			<!--商品价格-->
			<li id='priceLi'></li>
			<?php }?>

			<li>
				市场价：<s id="data_marketPrice"><?php if($minMarketPrice != $maxMarketPrice){?>￥<?php echo isset($minMarketPrice)?$minMarketPrice:"";?> - ￥<?php echo isset($maxMarketPrice)?$maxMarketPrice:"";?><?php }else{?>￥<?php echo isset($market_price)?$market_price:"";?><?php }?></s>
			</li>

			<li>
				库存：现货<span>(<label id="data_storeNums"><?php echo isset($store_nums)?$store_nums:"";?></label>)</span>
				<a class="favorite" onclick="favorite_add(this);" href="javascript:void(0)">收藏此商品</a>
			</li>

			<li>顾客评分：<span class="grade"><i style="width:<?php echo $comment_num?(14*$comment_point/$comment_num):0;?>px;"></i></span>(已有<?php echo isset($comment_num)?$comment_num:"";?>人评价)</li>

			<?php if($point > 0){?>
			<li>送积分：单件送<?php echo isset($point)?$point:"";?>分</li>
			<?php }?>

			<li class="relative" style="z-index:2">至
				<a class="sel_area blue" href="javascript:;">所在地区</a>：
				<span id="deliveInfo"></span>
				<div class="area_box" style="display:none;">
					<ul>
						<li><a data-code="1" href="#J_PostageTableCont"><strong>全部</strong></a></li>
						<?php $query = new IQuery("areas");$query->where = "parent_id = 0";$items = $query->find(); foreach($items as $key => $item){?>
						<li><a href="javascript:delivery('<?php echo isset($item['area_id'])?$item['area_id']:"";?>','<?php echo isset($item['area_name'])?$item['area_name']:"";?>')"><?php echo isset($item['area_name'])?$item['area_name']:"";?></a></li>
						<?php }?>
					</ul>
				</div>
			</li>
		</ul>

		<!--配送方式的模板-->
		<script type='text/html' id='deliveInfoTemplate'>
			<%if(if_delivery == 0){%>
			<%=name%>：<b class="orange"><%=price%></b>（<%=description%>）
			&nbsp;&nbsp;
			<%}else{%>
			<%=name%>：<b class="orange">该地区无法送达</b>
			&nbsp;&nbsp;
			<%}%>
		</script>

		<!--商品价格模板-->
		<script type='text/html' id='priceTemplate'>
		<%if(group_price){%>
		<li id='priceLi'>
			会员价：<b class="price red2"><span class="f30" id="real_price"><%=group_price%></span></b> &nbsp;&nbsp;&nbsp;
			销售价：<s><%if(minSellPrice != maxSellPrice){%>￥<%=minSellPrice%> - ￥<%=maxSellPrice%><%}else{%>￥<%=sell_price%><%}%></s>
		</li>
		<%}else{%>
		<li id='priceLi'>销售价：<b class="price red2"><span class="f30" id="real_price"><%if(minSellPrice != maxSellPrice){%>￥<%=minSellPrice%> - ￥<%=maxSellPrice%><%}else{%>￥<%=sell_price%><%}%></span></b></li>
		<%}%>
		</script>

		<!--购买区域-->
		<div class="current">
		<?php if($store_nums <= 0){?>
			该商品已售完，不能购买，您可以看看其它商品！(<a href="<?php echo IUrl::creatUrl("/simple/arrival/goods_id/$id");?>" class="orange">到货通知</a>)
		<?php }else{?>
			<?php if($spec_array){?>
			<?php $specArray = JSON::decode($spec_array);?>
			<?php foreach($specArray as $key => $item){?>
			<dl class="m_10 clearfix" name="specCols">
				<dt><?php echo isset($item['name'])?$item['name']:"";?>：</dt>
				<dd class="w_45" style="margin-left:67px;" id="specList<?php echo isset($item['id'])?$item['id']:"";?>">
					<?php $specVal=explode(',',trim($item['value'],','))?>
					<?php foreach($specVal as $key => $spec_value){?>
					<?php if($item['type'] == 1){?>
					<div class="item w_27"><a href="javascript:void(0);" onclick="sele_spec(this);" value='{"id":"<?php echo isset($item['id'])?$item['id']:"";?>","type":"<?php echo isset($item['type'])?$item['type']:"";?>","value":"<?php echo isset($spec_value)?$spec_value:"";?>","name":"<?php echo isset($item['name'])?$item['name']:"";?>"}' ><?php echo isset($spec_value)?$spec_value:"";?><span></span></a></div>
					<?php }else{?>
					<div class="item"><a href="javascript:void(0);" onclick="sele_spec(this);" value='{"id":"<?php echo isset($item['id'])?$item['id']:"";?>","type":"<?php echo isset($item['type'])?$item['type']:"";?>","value":"<?php echo isset($spec_value)?$spec_value:"";?>","name":"<?php echo isset($item['name'])?$item['name']:"";?>"}' ><img src="<?php echo IUrl::creatUrl("")."$spec_value";?>" width='30px' height='30px' /><span></span></a></div>
					<?php }?>
					<?php }?>
				</dd>
			</dl>
			<?php }?>
			<?php }?>

			<dl class="m_10 clearfix">
				<dt>购买数量：</dt>
				<dd>
					<input class="gray_t f_l" type="text" id="buyNums" onblur="checkBuyNums();" value="1" maxlength="5" />
					<div class="resize">
						<a class="add" href="javascript:modified(1);"></a>
						<a class="reduce" href="javascript:modified(-1);"></a>
					</div>
				</dd>
			</dl>

			<?php if(isset($spec_array) && $spec_array){?>
			<p class="m_10">已选择：<span class="orange bold" id="specSelected"></span></p>

			<!--货品规格模板-->
			<script type='text/html' id='selectedSpecTemplate'>
				<%if(type == 1){%>
					<span id="selectedSpan<%=id%>">“<%=value%>”</span>
				<%}else{%>
					<span id="selectedSpan<%=id%>"><img class="img_border" src="<?php echo IUrl::creatUrl("")."<%=value%>";?>" width="30px" height="30px" /></span>
				<%}%>
			</script>
			<?php }?>

                        <div style="width:169px;float: left;"><input class="submit_buy" type="button" id="buyNowButton" onclick="buy_now();" value="立即购买" /></div>
			<?php if($promo==''){?>
			<div class="shop_cart" style="z-index:1;">
				<input type="button" class="submit_join" id="joinCarButton" onclick="joinCart();" value="加入购物车">

				<div class="shopping" id="product_myCart" style='display:none'>
					<dl class="cart_stats">
						<dt class="gray f14 bold">
							<a class="close_2 f_r" href="javascript:closeCartDiv();" title="关闭">关闭</a>
							<img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/right_s.gif";?>" width="24" height="24" alt="" />成功加入购物车
						</dt>
						<dd class="gray">目前选购商品共<b class="orange" name='mycart_count'></b>件<span>合计：<b name='mycart_sum'></b></span></dd>
						<dd><a class="btn_blue bold" href="<?php echo IUrl::creatUrl("/simple/cart");?>">进入购物车</a><a class="btn_blue bold" href="javascript:void(0)" onclick="closeCartDiv();">继续购物>></a></dd>
					</dl>
				</div>
			</div>
			<?php }?>
		<?php }?>
		</div>

	</div>

	<!--图片放大镜-->
	<div class="preview">
		<div class="pic_show" style="width:435px;height:435px;position:relative;z-index:5">
			<a class="jqzoom" href="javascript:void(0)" rel='goodsPhoto' id="bigPicBox" alt="原图">
				<img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/nopic_435_435.gif";?>" style="border:none;width:435px;height:435px" id="smallPicBox" alt="缩略图" />
			</a>
		</div>

		<div class="m_10 bx_wrap">
			<div class="bx_container">
				<ul id="thumblist" class="pic_thumb m_10">
					<?php foreach($photo as $key => $item){?>
					<?php $bigImg=IUrl::creatUrl().$item['img'];$smallImg=Thumb::get($item['img'],435,435);?>
					<li>
						<a href='javascript:void(0);' rel="{gallery:'goodsPhoto',smallimage:'<?php echo isset($smallImg)?$smallImg:"";?>',largeimage:'<?php echo isset($bigImg)?$bigImg:"";?>'}">
							<img src='<?php echo isset($smallImg)?$smallImg:"";?>' width="60px" height="60px" />
						</a>
					</li>
					<?php }?>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="t_l">
	<?php if(isset($photo) && $photo){?>
	<a class="zoom blue" href="<?php echo IUrl::creatUrl("/site/pic_show/id/$id");?>">点击看大图</a>
	<?php }?>
</div>

<div class="wrapper clearfix container_2">

	<!--左边栏-->
	<div class="sidebar f_l">
		<?php if(isset($buyer_id) && $buyer_id){?>
		<div class="box m_10">
			<div class="title">购买本商品的用户还购买过</div>
			<div class="content">
				<ul class="ranklist">
					<?php $query = new IQuery("order_goods as og");$query->join = "join order as o on og.order_id = o.id left join goods as lg on lg.id = og.goods_id AND lg.is_del = 0";$query->fields = "DISTINCT lg.id,lg.sell_price as price,lg.small_img,lg.name";$query->where = "o.user_id in ($buyer_id) AND lg.id is not null";$query->order = "o.completion_time desc";$query->limit = "5";$items = $query->find(); foreach($items as $key => $item){?>
					<li class="current">
						<a href="<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>"><img width="58px" height="58px" src="<?php echo IUrl::creatUrl("")."$item[small_img]";?>"></a>
						<a title="<?php echo isset($item['name'])?$item['name']:"";?>" class="p_name" href="<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>"><?php echo isset($item['name'])?$item['name']:"";?></a>
						<b>￥<?php echo isset($item['price'])?$item['price']:"";?></b>
					</li>
					<?php }?>
				</ul>
			</div>
		</div>
		<?php }?>

		<div class="box m_10">
			<div class="title">热卖商品</div>
			<div class="content">
				<ul class="ranklist">
				<?php $query = new IQuery("commend_goods as cg");$query->join = "left join goods as lg on lg.id = cg.goods_id";$query->fields = "lg.name,lg.sell_price,lg.small_img,lg.id";$query->where = "commend_id = 3 AND lg.is_del = 0 AND lg.id is not null";$query->order = "lg.sort asc,lg.id desc";$query->limit = "5";$items = $query->find(); foreach($items as $key => $item){?>
					<li class="current">
						<a href="<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>"><img width="58px" height="58px" alt="<?php echo isset($item['name'])?$item['name']:"";?>" src="<?php echo IUrl::creatUrl("")."$item[small_img]";?>" /></a>
						<a title="<?php echo isset($item['name'])?$item['name']:"";?>" class="p_name" href="<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>"><?php echo isset($item['name'])?$item['name']:"";?></a>
						<b>￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></b>
					</li>
				<?php }?>
				</ul>
			</div>
		</div>
	</div>

	<!--滑动面tab标签-->
	<div class="main f_r" style="overflow:hidden">

		<div class="uc_title">
			<label onclick="selectTab('tab_1','lab-1')" id="lab-1" name="lab-name" class="current"><span>商品详情</span></label>
			<label onclick="selectTab('tab_2','lab-2')" id="lab-2" name="lab-name"><span>顾客评价(<?php echo isset($comment_num)?$comment_num:"";?>)</span></label>
			<label onclick="selectTab('tab_3','lab-3')" id="lab-3" name="lab-name"><span>购买记录(<?php echo isset($buy_num)?$buy_num:"";?>)</span></label>
			<label onclick="selectTab('tab_4','lab-4')" id="lab-4" name="lab-name"><span>购买前咨询(<?php echo isset($refer)?$refer:"";?>)</span></label>
			<label onclick="selectTab('tab_5','lab-5')" id="lab-5" name="lab-name"><span>网友讨论圈(<?php echo isset($discussion)?$discussion:"";?>)</span></label>
			<label onclick="selectTab('tab_6','lab-6')" id="lab-6" name="lab-name"><span>售后服务</span></label>
			<label onclick="selectTab('tab_7','lab-7')" id="lab-7" name="lab-name"><span>支付方式</span></label>
		</div>

		<!-- 商品详情 start -->
		<div id="tab_1" name="div_name">
			<ul class="saleinfos m_10 clearfix">
				<li>商品名称：<?php echo isset($name)?$name:"";?></li>

				<?php if(isset($brand) && $brand){?>
				<li>品牌：<?php echo isset($brand)?$brand:"";?></li>
				<?php }?>

				<?php if(isset($weight) && $weight){?>
				<li>商品毛重：<label id="data_weight"><?php echo isset($weight)?$weight:"";?></label></li>
				<?php }?>

				<?php if(isset($unit) && $unit){?>
				<li>单位：<?php echo isset($unit)?$unit:"";?></li>
				<?php }?>

				<?php if(isset($up_time) && $up_time){?>
				<li>上架时间：<?php echo isset($up_time)?$up_time:"";?></li>
				<?php }?>

				<?php if(($attribute)){?>
				<?php foreach($attribute as $key => $item){?>
				<li><?php echo isset($item['name'])?$item['name']:"";?>：<?php echo isset($item['attribute_value'])?$item['attribute_value']:"";?></li>
				<?php }?>
				<?php }?>
			</ul>
			<?php if(isset($content) && $content){?>
			<div class="salebox">
				<strong class="saletitle block">产品描述：</strong>
				<p class="saledesc"><?php echo isset($content)?$content:"";?></p>
			</div>
			<?php }?>
		</div>
		<!-- 商品详情 end -->

		<!-- 顾客评论 start -->
		<div class="comment_list box" id="tab_2" name="div_name" style="display:none;">
			<div class="title3">
				<span class="f_r f12 light_gray normal">
					只有购买过该商品的用户才能进行评价
					<?php if(isset($this->user['user_id']) && $user_id = $this->user['user_id']){?>
					<?php $query = new IQuery("comment");$query->fields = "id";$query->where = "status = 0 and goods_id = $id and user_id = $user_id";$query->limit = "1";$items = $query->find(); foreach($items as $key => $item){?>
					<a class="comm_btn" href="<?php echo IUrl::creatUrl("/site/comments/id/$item[id]");?>">我要评论</a>
					<?php }?>
					<?php }?>
				</span>
				<img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/comm.gif";?>" width="16px" height="16px" />商品评论<span class="f12 normal">（已有<b class="red2"><?php echo isset($comment_num)?$comment_num:"";?></b>条）</span>
			</div>

			<div id='commentBox'></div>

			<!--评论JS模板-->
			<script type='text/html' id='commentRowTemplate'>
			<div class="item">
				<div class="user">
					<div class="ico">
						<a href="javascript:void(0)">
							<img src="<?php echo IUrl::creatUrl("")."<%=head_ico%>";?>" width="70px" height="70px" onerror="this.src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/user_ico.gif";?>'" />
						</a>
					</div>
					<span class="blue"><%=username%></span>
				</div>
				<dl class="desc">
					<%var widthPoint = 14 * point;%>
					<p class="clearfix">
						<b>评分：</b>
						<span class="grade"><i style="width:<%=widthPoint%>px"></i></span>
						<span class="light_gray"><%=time%></span><label></label>
					</p>
					<hr />
					<p><b>评价：</b><span class="gray"><%=contents%></span></p>
				</dl>
				<div class="corner b"></div>
			</div>
			<hr />
			</script>
		</div>
		<!-- 顾客评论 end -->

		<!-- 购买记录 start -->
		<div class="box" id="tab_3" name="div_name" style="display:none;">
			<div class="title3">
				<img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/cart.gif";?>" width="16" height="16" alt="" />
				购买记录<span class="f12 normal">（已有<b class="red2"><?php echo isset($buy_num)?$buy_num:"";?></b>购买）</span>
			</div>

			<table width="100%" class="list_table m_10 mt_10">
				<col width="150" />
				<col width="120" />
				<col width="120" />
				<col width="150" />
				<col />
				<thead class="thead">
					<tr>
						<th>购买人</th>
						<th>出价</th>
						<th>数量</th>
						<th>购买时间</th>
						<th>状态</th>
					</tr>
				</thead>
			</table>

			<table width="100%" class="list_table m_10">
				<col width="150" />
				<col width="120" />
				<col width="120" />
				<col width="150" />
				<col />
				<tbody class="dashed" id="historyBox"></tbody>

				<!--购买历史js模板-->
				<script type='text/html' id='historyRowTemplate'>
				<tr>
					<td><%=username%></td>
					<td><%=goods_price%></td>
					<td class="bold orange"><%=goods_nums%></td>
					<td class="light_gray"><%=completion_time%></td>
					<td class="bold blue">成交</td>
				</tr>
				</script>
			</table>
		</div>
		<!-- 购买记录 end -->

		<!-- 购买前咨询 start -->
		<div class="comment_list box" id="tab_4" name="div_name" style="display:none;">
			<div class="title3">
				<span class="f_r f12 normal"><a class="comm_btn" href="<?php echo IUrl::creatUrl("/site/consult/id/$id");?>">我要咨询</a></span>
				<img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/cart.gif";?>" width="16" height="16" />购买前咨询<span class="f12 normal">（共<b class="red2"><?php echo isset($refer)?$refer:"";?></b>记录）</span>
			</div>

			<div id='referBox'></div>

			<!--购买咨询JS模板-->
			<script type='text/html' id='referRowTemplate'>
			<div class="item">
				<div class="user">
					<div class="ico"><img src="<?php echo IUrl::creatUrl("")."<%=head_ico%>";?>" width="70px" height="70px" onerror="this.src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/user_ico.gif";?>'" /></div>
					<span class="blue"><%=username%></span>
					<p class="gray"><%=rtime%></p>
				</div>
				<dl class="desc gray">
					<p>
						<img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/ask.gif";?>" width="16px" height="17px" />
						<b>咨询内容：</b><span class="f_r"><%=time%></span>
					</p>
					<p class="indent"><%=question%></p>
					<hr />
					<%if(answer){%>
					<p class="bg_gray"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/answer.gif";?>" width="16px" height="17px" />
					<b class="orange"><?php echo $siteConfig->name;?>回复：</b><span class="f_r"><%=reply_time%></span></p>
					<p class="indent bg_gray"><%=answer%></p>
					<%}%>
				</dl>
				<div class="corner b"></div>
				<div class="corner tl"></div>
			</div>
			<hr />
			</script>
		</div>
		<!-- 购买前咨询 end -->

		<!-- 网友讨论圈 start -->
		<div class="box" id="tab_5" name="div_name" style="display:none;">
			<div class="title3">
				<span class="f_r f12 normal"><a class="comm_btn" href="javascript:sendDiscuss();">发表话题</a></span>
				<img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/discuss.gif";?>" width="18px" height="19px" />
				网友讨论圈<span class="f12 normal">（共<b class="red2"><?php echo isset($discussion)?$discussion:"";?></b>记录）</span>
			</div>
			<div class="wrap_box no_wrap">
				<!--讨论内容列表-->
				<table width="100%" class="list_table">
					<col />
					<col width="150">
					<tbody id='discussBox'></tbody>
				</table>

				<!--讨论JS模板-->
				<script type='text/html' id='discussRowTemplate'>
				<tr>
					<td class="t_l discussion_td" style="border:none;">
						<span class="blue"><%=username%></span>
					</td>
					<td style="border:none;" class="t_r gray discussion_td"><%=time%></td>
				</tr>
				<tr><td class="t_l" colspan="2" style="padding:0 7px 0 13px;"><%=contents%></td></tr>
				</script>

				<!--讨论内容输入框-->
				<table class="form_table" style="display:none;" id="discussTable">
					<col width="80px">
					<col />

					<tbody>
						<tr>
							<th>讨论内容：</th>
							<td valign="top"><textarea id="discussContent" pattern="required" alt="请填写内容"></textarea></td>
						</tr>
						<tr>
							<th>验证码：</th>
							<td><input type='text' class='gray_s' name='captcha' pattern='^\w{5}$' alt='填写下面图片所示的字符' /><label>填写下面图片所示的字符</label></td>
						</tr>
						<tr class="low">
							<th></th>
							<td><img src='<?php echo IUrl::creatUrl("/site/getCaptcha");?>' id='captchaImg' /><span class="light_gray">看不清？<a class="link" href="javascript:changeCaptcha('<?php echo IUrl::creatUrl("/site/getCaptcha");?>');">换一张</a></span></td>
						</tr>
						<tr>
							<td></td>
							<td><label class="btn"><input type="submit" value="发表" onclick="sendDiscussData();" /></label></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<!-- 网友讨论圈 end -->

		<!-- 售后服务 start -->
		<div class="box" id="tab_6" name="div_name" style="display:none;">
			<div class="title3"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/tel.gif";?>" width="20px" height="19px" />售后服务</div>
			<div class="cont_s gray">
				<?php $query = new IQuery("help");$query->fields = "content";$query->where = "id = 52";$items = $query->find(); foreach($items as $key => $item){?>
					<?php echo $item['content'];?>
				<?php }?>
			</div>
		</div>
		<!-- 售后服务 end -->

		<!-- 支付方式 start -->
		<div class="box" id="tab_7" name="div_name" style="display:none;">
			<div class="title3"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/card.gif";?>" width="23px" height="18px" />支付方式</div>
			<div class="cont_pay">
				<?php $query = new IQuery("help");$query->fields = "content";$query->where = "id = 53";$items = $query->find(); foreach($items as $key => $item){?>
					<?php echo $item['content'];?>
				<?php }?>
			</div>
		</div>
		<!-- 支付方式 end -->
	</div>
</div>

<script type="text/javascript">
$(function(){

//图片初始化
var goodsSmallPic = "<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/nopic_435_435.gif";?>";
var goodsBigPic   = "<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/nopic_435_435.gif";?>";

//存在图片数据时候
<?php if(isset($photo) && $photo){?>
goodsSmallPic = "<?php echo Thumb::get($photo[0]['img'],435,435);?>";
goodsBigPic   = "<?php echo IUrl::creatUrl("")."";?><?php echo isset($photo[0]['img'])?$photo[0]['img']:"";?>";
<?php }?>

//初始化商品轮换图
var bxObj = $('#thumblist').bxSlider({
	infiniteLoop: false,
	hideControlOnEnd: true,
	pager:false,
	minSlides: 5,
	maxSlides: 5,
	slideWidth: 72,
	slideMargin: 15,
	controls:true,
	onSliderLoad:function(currentIndex){
		//设置图片
		$('#smallPicBox').attr('src',goodsSmallPic);
		$('#bigPicBox').attr('href',goodsBigPic);

		//开启放大镜
		$('.jqzoom').jqzoom({
			title:false,
			lens:true,
			preloadText:'加载中...',
			zoomWidth:300,
			zoomHeight:300,
			xOffset:15,
		    zoomType: 'standard',
		    preloadImages: false
		});
	}
});

//如果抢购或团购过期则不许立即购买
<?php if($promo!='' && !isset($promotion) && !isset($regiment)){?>
	closeBuy();
<?php }?>

//如果当前是团购
<?php if(isset($regiment)){?>
	<?php $reg_id = IReq::get('active_id');?>

	//团购检查,1,人数已满 2,已经参加过
	<?php if(Regiment::isFull($reg_id) || (isset($this->user['user_id']) && Regiment::hasJoined($reg_id,$this->user['user_id'])) || (ICookie::get("regiment_".$reg_id) && Regiment::hasJoined($reg_id,ICookie::get("regiment_".$reg_id)))){?>
		closeBuy();
	<?php }?>
<?php }?>

//开启倒计时功能
var cd_timer = new countdown();

//限时抢购倒计时
<?php if(isset($promotion)){?>
cd_timer.add('promotiona');
<?php }?>

//团购倒计时
<?php if(isset($regiment)){?>
cd_timer.add('promotionb');
<?php }?>

//城市地域选择按钮事件
$('.sel_area').hover(
	function(){
		$('.area_box').show();
	},function(){
		$('.area_box').hide();
	}
);
$('.area_box').hover(
	function(){
		$('.area_box').show();
	},function(){
		$('.area_box').hide();
	}
);

//获取地址的ip地址
getAddress();

//生成商品价格
var priceHtml = template.render('priceTemplate',{"group_price":"<?php echo isset($group_price)?$group_price:"";?>","minSellPrice":"<?php echo isset($minSellPrice)?$minSellPrice:"";?>","maxSellPrice":"<?php echo isset($maxSellPrice)?$maxSellPrice:"";?>","sell_price":"<?php echo isset($sell_price)?$sell_price:"";?>"});
$('#priceLi').replaceWith(priceHtml);

});

//禁止购买
function closeBuy()
{
	if($('#buyNowButton').length > 0)
	{
		$('#buyNowButton').attr('disabled','disabled');
		$('#buyNowButton').addClass('disabled');
	}

	if($('#joinCarButton').length > 0)
	{
		$('#joinCarButton').attr('disabled','disabled');
		$('#joinCarButton').addClass('disabled');
	}
}

//开放购买
function openBuy()
{
	if($('#buyNowButton').length > 0)
	{
		$('#buyNowButton').removeAttr('disabled');
		$('#buyNowButton').removeClass('disabled');
	}

	if($('#joinCarButton').length > 0)
	{
		$('#joinCarButton').removeAttr('disabled');
		$('#joinCarButton').removeClass('disabled');
	}
}

//加载根据地域获取城市
function getAddress()
{
	//根据IP查询所在地
	var ipAddress = $.cookie('ipAddress');
	if(ipAddress)
	{
		searchDelivery(ipAddress);
	}
	else
	{
		$.getScript('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js',function(){
			ipAddress = remote_ip_info['province'];
			$.cookie('ipAddress',ipAddress);
			searchDelivery(ipAddress);
		});
	}
}

//发表讨论
function sendDiscuss()
{
	var userId = "<?php echo isset($this->user['user_id'])?$this->user['user_id']:"";?>";
	if(userId)
	{
		$('#discussTable').show('normal');
		$('#discussContent').focus();
	}
	else
	{
		alert('请登陆后再发表讨论!');
	}
}

/**
 * 根据省份获取运费信息
 * @param province 省份名称
 */
function searchDelivery(province)
{
	var url = '<?php echo IUrl::creatUrl("/block/searchPrivice/random/@random@");?>';
	url = url.replace("@random@",Math.random);

	$.getJSON(url,{'province':province},function(json)
	{
		if(json.flag == 'success')
		{
			delivery(json.area_id,province);
		}
	});
}

//选择当前Tab
function selectTab(curr_div,curr_lab)
{
	//如果有ajax获取数据的tab标签
	switch(curr_div)
	{
		case "tab_2":
		{
			comment_ajax();
		}
		break;

		case "tab_3":
		{
			history_ajax();
		}
		break;

		case "tab_4":
		{
			refer_ajax();
		}
		break;

		case "tab_5":
		{
			discuss_ajax();
		}
		break;
	}

	$("div[name='div_name']").hide();
	$("#"+curr_div).show();

	$("label[name='lab-name']").removeClass();
	$("#"+curr_lab).addClass('current');
}

/**
 * 计算运费
 * @param provinceId
 * @param provinceName
 */
function delivery(provinceId,provinceName)
{
	$('.sel_area').text(provinceName);

	var weight  = '<?php echo isset($weight)?$weight:"";?>';
	var buyNums = $('#buyNums').val();

	//通过省份id查询出配送方式，并且传送总重量计算出运费,然后显示配送方式
	var totalWeight = parseInt(weight) * parseInt(buyNums);
	var url = '<?php echo IUrl::creatUrl("/block/order_delivery");?>';

	$.getJSON(url,{'province':provinceId,'total_weight':totalWeight,'random':Math.random},function(json)
	{
		//清空配送信息
		$('#deliveInfo').empty();

		for(var item in json)
		{
			var deliveRowHtml = template.render('deliveInfoTemplate',json[item]);
			$('#deliveInfo').append(deliveRowHtml);
		}
	});
}

/**
 * 获取评论数据
 * @page 分页数
 */
function comment_ajax(page)
{
	if(!page && $.trim($('#commentBox').text()))
	{
		return;
	}
	page = page ? page : 1;
	var url = '<?php echo IUrl::creatUrl("/site/comment_ajax/page/@page@/goods_id/$id");?>';
	url = url.replace("@page@",page);
	$.getJSON(url,function(json)
	{
		//清空评论数据
		$('#commentBox').empty();

		for(var item in json.data)
		{
			var commentHtml = template.render('commentRowTemplate',json.data[item]);
			$('#commentBox').append(commentHtml);
		}
		$('#commentBox').append(json.pageHtml);
	});
}

/**
 * 获取购买记录数据
 * @page 分页数
 */
function history_ajax(page)
{
	if(!page && $.trim($('#historyBox').text()))
	{
		return;
	}
	page = page ? page : 1;
	var url = '<?php echo IUrl::creatUrl("/site/history_ajax/page/@page@/goods_id/$id");?>';
	url = url.replace("@page@",page);
	$.getJSON(url,function(json)
	{
		//清空购买历史记录
		$('#historyBox').empty();
		$('#historyBox').parent().parent().find('.pages_bar').remove();

		for(var item in json.data)
		{
			var historyHtml = template.render('historyRowTemplate',json.data[item]);
			$('#historyBox').append(historyHtml);
		}
		$('#historyBox').parent().after(json.pageHtml);
	});
}

/**
 * 获取购买记录数据
 * @page 分页数
 */
function refer_ajax(page)
{
	if(!page && $.trim($('#referBox').text()))
	{
		return;
	}
	page = page ? page : 1;
	var url = '<?php echo IUrl::creatUrl("/site/refer_ajax/page/@page@/goods_id/$id");?>';
	url = url.replace("@page@",page);
	$.getJSON(url,function(json)
	{
		//清空评论数据
		$('#referBox').empty();

		for(var item in json.data)
		{
			var commentHtml = template.render('referRowTemplate',json.data[item]);
			$('#referBox').append(commentHtml);
		}
		$('#referBox').append(json.pageHtml);
	});
}

/**
 * 获取购买记录数据
 * @page 分页数
 */
function discuss_ajax(page)
{
	if(!page && $.trim($('#discussBox').text()))
	{
		return;
	}
	page = page ? page : 1;
	var url = '<?php echo IUrl::creatUrl("/site/discuss_ajax/page/@page@/goods_id/$id");?>';
	url = url.replace("@page@",page);
	$.getJSON(url,function(json)
	{
		//清空购买历史记录
		$('#discussBox').empty();
		$('#discussBox').parent().parent().find('.pages_bar').remove();

		for(var item in json.data)
		{
			var historyHtml = template.render('discussRowTemplate',json.data[item]);
			$('#discussBox').append(historyHtml);
		}
		$('#discussBox').parent().after(json.pageHtml);
	});
}

//发布讨论数据
function sendDiscussData()
{
	var content = $('#discussContent').val();
	var captcha = $('[name="captcha"]').val();

	if($.trim(content)=='')
	{
		alert('请输入讨论内容!');
		$('#discussContent').focus();
		return false;
	}
	if($.trim(captcha)=='')
	{
		alert('请输入验证码!');
		$('[name="captcha"]').focus();
		return false;
	}

	var url = '<?php echo IUrl::creatUrl("/site/discussUpdate/id/$id/captcha/@captcha@/random/@Math@");?>';
	url = url.replace("@captcha@",captcha).replace("@Math@",Math.random);

	$.getJSON(url,{'content':content},function(json)
	{
		if(json.isError == false)
		{
			var discussHtml = template.render('discussRowTemplate',json);
			$('#discussBox').prepend(discussHtml);

			//清除数据
			$('#discussContent').val('');
			$('[name="captcha"]').val('');
			$('#discussTable').hide('normal');
			changeCaptcha('<?php echo IUrl::creatUrl("/site/getCaptcha");?>');
		}
		else
		{
			alert(json.message);
		}
	});
}

/**
 * 规格的选择
 * @param _self 规格本身
 */
function sele_spec(_self)
{
	var specObj = $.parseJSON($(_self).attr('value'));

	//清除同规格下已选数据
	$('#selectedSpan'+specObj.id).remove();

	//已经为选中状态时
	if($(_self).attr('class') == 'current')
	{
		$(_self).removeClass('current');
		$('#selectedSpan'+specObj.id).remove();
	}
	else
	{
		//清除同行中其余规格选中状态
		$('#specList'+specObj.id).find('a.current').removeClass('current');

		$(_self).addClass('current');
		var newSpecHtml = template.render('selectedSpecTemplate',specObj);
		$('#specSelected').append(newSpecHtml);
	}

	//检查规格是否选择符合标准
	if(checkSpecSelected())
	{
		//整理规格值
		var specArray = [];
		$('[name="specCols"]').each(function(){
			specArray.push($(this).find('a.current').attr('value'));
		});
		var specJSON = '['+specArray.join(",")+']';

		//获取货品数据并进行渲染
		$.getJSON('<?php echo IUrl::creatUrl("/site/getProduct");?>',{"goods_id":"<?php echo isset($id)?$id:"";?>","specJSON":specJSON,"random":Math.random},function(json){
			if(json.flag == 'success')
			{
				//普通商品购买方式(非团购，抢购等),商品价格渲染
				if($('#priceLi').length > 0)
				{
					var priceHtml = template.render('priceTemplate',json.data);
					$('#priceLi').replaceWith(priceHtml);
				}
				//非普通商品购买方式，商品价格渲染
				else if($('#data_sellPrice').length > 0)
				{
					$('#data_sellPrice').text(json.data.sell_price);
				}

				//普通货品数据渲染
				$('#data_goodsNo').text(json.data.products_no);
				$('#data_storeNums').text(json.data.store_nums);
				$('#data_marketPrice').text("￥"+json.data.market_price);
				$('#data_weight').text(json.data.weight);
				$('#product_id').val(json.data.id);

				//库存监测
				checkStoreNums();
			}
			else
			{
				alert(json.message);
				closeBuy();
			}
		});
	}
}

/**
 * 监测库存操作
 */
function checkStoreNums()
{
	var storeNums = parseInt($.trim($('#data_storeNums').text()));
	if(storeNums > 0)
	{
		openBuy();
	}
	else
	{
		closeBuy();
	}
}

/**
 * 检查规格选择是否符合标准
 * @return boolen
 */
function checkSpecSelected()
{
	if($('[name="specCols"]').length === $('[name="specCols"] .current').length)
	{
		return true;
	}
	return false;
}

//检查购买数量是否合法
function checkBuyNums()
{
	//购买数量小于0
	var buyNums = parseInt($.trim($('#buyNums').val()));
	if(buyNums <= 0)
	{
		$('#buyNums').val(1);
		return;
	}

	//购买数量大于库存
	var storeNums = parseInt($.trim($('#data_storeNums').text()));
	if(buyNums >= storeNums)
	{
		$('#buyNums').val(storeNums);
		return;
	}
}

/**
 * 购物车数量的加减
 * @param code 增加或者减少购买的商品数量
 */
function modified(code)
{
	var buyNums = parseInt($.trim($('#buyNums').val()));
	switch(code)
	{
		case 1:
		{
			buyNums++;
		}
		break;

		case -1:
		{
			buyNums--;
		}
		break;
	}

	$('#buyNums').val(buyNums);
	checkBuyNums();
}

//商品加入购物车
function joinCart()
{
	if(!checkSpecSelected())
	{
		tips('请先选择商品的规格');
		return;
	}

	var buyNums   = parseInt($.trim($('#buyNums').val()));
	var price     = parseFloat($.trim($('#real_price').text()));
	var productId = $('#product_id').val();
	var type      = productId ? 'product' : 'goods';
	var goods_id  = (type == 'product') ? productId : <?php echo isset($id)?$id:"";?>;

	$.getJSON('<?php echo IUrl::creatUrl("/simple/joinCart");?>',{"goods_id":goods_id,"type":type,"goods_num":buyNums,"random":Math.random},function(content){
		if(content.isError == false)
		{
			//获取购物车信息
			$.getJSON('<?php echo IUrl::creatUrl("/simple/showCart");?>',{"mode":"json"},function(json)
			{
				$('[name="mycart_count"]').text(json.count);
				$('[name="mycart_sum"]').text(json.sum);

				//展示购物车清单
				$('#product_myCart').show();

				//暂闭加入购物车按钮
				$('#joinCarButton').attr('disabled','disabled');
			});
		}
		else
		{
			alert(content.message);
		}
	});
}

//添加收藏夹
function favorite_add(obj)
{
	<?php if(isset($this->user['user_id'])){?>
		$.getJSON('<?php echo IUrl::creatUrl("/simple/favorite_add");?>',{'goods_id':<?php echo isset($id)?$id:"";?>,'random':Math.random},function(content)
		{
			if(content.isError == false)
			{
				$(obj).text(content.message);
			}
			else
			{
				alert(content.message);
			}
		});
	<?php }else{?>
		window.location.href="<?php echo IUrl::creatUrl("/simple/login/?callback=/site/products/id/$id");?>";
	<?php }?>
}

//立即购买按钮
function buy_now()
{
	//对规格的检查
	if(!checkSpecSelected())
	{
		tips('请选择商品的规格');
		return;
	}

	//设置必要参数
	var buyNums  = parseInt($.trim($('#buyNums').val()));
	var id = <?php echo isset($id)?$id:"";?>;
	var type = 'goods';

	if($('#product_id').val())
	{
		id = $('#product_id').val();
		type = 'product';
	}

	<?php if($promo){?>
	//有促销活动（团购，抢购）
	var url = '<?php echo IUrl::creatUrl("/simple/cart2/id/@id@/num/@buyNums@/type/@type@/promo/$promo/active_id/$active_id");?>';
	url = url.replace('@id@',id).replace('@buyNums@',buyNums).replace('@type@',type);
	<?php }else{?>
	//普通购买
	var url = '<?php echo IUrl::creatUrl("/simple/cart2/id/@id@/num/@buyNums@/type/@type@");?>';
	url = url.replace('@id@',id).replace('@buyNums@',buyNums).replace('@type@',type);
	<?php }?>

	//页面跳转
	window.location.href = url;
}
</script>

    </div>
    <!-- main end -->
    
    
    
    <!--footer start -->
    <div class="footer">

        <div class="theme">
            <div class="help_container">
                <div class="help_column_01">
                    <img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/index/help_serve_pic.jpg";?>">
                    <p>
                        您的建议或投诉，我们用心聆听</p>
                </div>
                <div class="help_column_02">


                    <?php $cat_list=array();?>
                    <?php $query = new IQuery("help_category AS cat");$query->where = "position_foot = 1";$query->order = "sort ASC,id desc";$query->limit = "5";$items = $query->find(); foreach($items as $key => $item){?>
                    <?php $cat_list[$item['id']]=$item;?>
                    <?php }?>
                    <?php if(count($cat_list)){?>
                            <?php $width=floor(100/count($cat_list))-1;?>
                    <?php }?>
                    <?php foreach($cat_list as $cat_id => $cat){?>
                            <ul style="float:left">
                            <li class="tit"><?php echo isset($cat['name'])?$cat['name']:"";?></li>
                            <?php $query = new IQuery("help");$query->where = "cat_id = $cat_id";$query->order = "sort ASC,id desc";$items = $query->find(); foreach($items as $key => $item){?>
                                    <li><a href="<?php echo IUrl::creatUrl("/site/help/id/$item[id]");?>" title="<?php echo isset($item['name'])?$item['name']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></a></li>
                            <?php }?>
                            </ul>
                            <p style="float: left; padding: 0 2px;"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/index/help_line.jpg";?>"></p>      
                    <?php }?>

                
                </div>
                <div class="help_column_03">
                    <p style="font-size: 14px; font-weight: bold;">
                        目录订阅</p>
                    <p>

                        <img id="ucPageFooter_imgLogo" src="http://images.dfld.cn/banner/email_pic_02.jpg">
                    </p>
                    <p>
                        E-mail订阅最新促销信息</p>
                    <p style="float: left">
                        <a name="submit1"></a>
                        <input name="orderinfo" type="text" value="请输入E-mail地址" id="ucPageFooter_txtEmail" class="TopText" onblur="if(this.value=='请输入E-mail地址'){this.value='';}this.select();" style="color:Gray;font-style:normal;width:100px;">
                    </p>
                     <p style="padding-left: 8px; float: left;">

                        <input type="image" name="ucPageFooter$ibtnSubmit" id="ucPageFooter_ibtnSubmit" onclick="orderinfo();" tabindex="3" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/index/dy_btn.jpg";?>">
                    </p>
		</div>
                    
                   
                </div>
            </div>
        </div>
        <!--底部服务保障图标-->
        <div class="theme" style="margin-top: 0;">
            <div class="webserver_icon">
                <ul>
                    <li>
                        <img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/index/baozhang_pic_01.gif";?>"></li>
                    <li>
                        <img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/index/baozhang_pic_02.gif";?>"></li>
                    <li>
                        <img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/index/baozhang_pic_03.gif";?>"></li>
                    <li>
                        <img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/index/baozhang_pic_04.gif";?>"></li>
                    <li>
                        <img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/index/baozhang_pic_05.gif";?>"></li>
                </ul>
            </div>
        </div>
        <!--底部导航-->
        <div class="theme">
            <div class="footer_nav">
                <p>




            | <a href="../Service/h_关于我们_aspx_help-S64.aspx" target="_blank" title="关于我们">关于我们</a>

            | <a href="../Service/h_联系我们_aspx_help-S65.aspx" target="_blank" title="联系我们">联系我们</a>

            | <a href="../Service/h_招聘信息_aspx_help-S66.aspx" target="_blank" title="招聘信息">招聘信息</a>

            | <a href="../Service/h_媒体报道_aspx_help-S67.aspx" target="_blank" title="媒体报道">媒体报道</a>

            | <a href="../Service/h_站点地图_aspx_help-S68.aspx" target="_blank" title="站点地图">站点地图</a>

            | <a href="http://www.dfld.cn/Web/m_bohinet_aspx_manual-S11.aspx" target="_blank" title="经销商">经销商</a>










                    </p>
            </div>
        </div>
        <!--底部copyright-->
        <div class="theme">
            <div class="footer_copyright">
             <?php echo IFilter::stripSlash($siteConfig->site_footer_code);?>
            </div>
        </div>

            </div>
    <!-- footer end -->
    
    
    
    
    
    
    
    
    
    
    

<script type='text/javascript'>
$(function()
{
	<?php $word = IReq::get('word') ? IFilter::act(IReq::get('word'),'text') : '输入关键字...'?>
	$('input:text[name="word"]').val("<?php echo isset($word)?$word:"";?>");

	$('input:text[name="word"]').bind({
		keyup:function(){autoComplete('<?php echo IUrl::creatUrl("/site/autoComplete");?>','<?php echo IUrl::creatUrl("/site/search_list/word/@word@");?>','<?php echo isset($siteConfig->auto_finish)?$siteConfig->auto_finish:"";?>');}
	});

        
        //email订阅 事件绑定
	var tmpObj = $('input:text[name="orderinfo"]');
	var defaultText = tmpObj.val();
	tmpObj.bind({
		focus:function(){checkInput($(this),defaultText);},
		blur :function(){checkInput($(this),defaultText);}
	});

});


//电子邮件订阅
function orderinfo()
{
	var email = $('[name="orderinfo"]').val();
	if(email == '')
	{
		alert('请填写正确的email地址');
	}
	else
	{
		$.getJSON('<?php echo IUrl::creatUrl("/site/email_registry");?>',{email:email},function(content){
			if(content.isError == false)
			{
				alert('订阅成功');
				$('[name="orderinfo"]').val('');
			}
			else
				alert(content.message);
		});
	}
}
</script>

</body>
</html>
