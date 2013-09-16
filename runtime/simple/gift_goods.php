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

<div class="position"><span>您当前的位置：</span><a href="<?php echo IUrl::creatUrl("");?>"> 首页</a> » <?php if(isset($category['id'])){?><a href="<?php echo IUrl::creatUrl("/simple/volumes/id/$volumes_info[id]");?>"><?php echo isset($volumes_info['title'])?$volumes_info['title']:"";?></a> » <?php }?><?php echo isset($name)?$name:"";?></div>
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


			<!--商品价格-->
			<li id='priceLi'>价格： <?php echo isset($volumes_info['price'])?$volumes_info['price']:"";?></li>

			<li>
				库存：现货<span>(<label id="data_storeNums"><?php echo isset($store_nums)?$store_nums:"";?></label>)</span>
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
			<div class="shop_cart" style="z-index:1;">

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

	<!--滑动面tab标签-->
	<div >

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

				
			</ul>
			<?php if(isset($content) && $content){?>
			<div class="salebox">
				<strong class="saletitle block">产品描述：</strong>
				<p class="saledesc"><?php echo isset($content)?$content:"";?></p>
			</div>
			<?php }?>
		</div>
		<!-- 商品详情 end -->

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


});

//立即购买按钮
function buy_now()
{
	
        var id = <?php echo isset($goods_id)?$goods_id:"";?>;
	//普通购买
	var url = '<?php echo IUrl::creatUrl("/simple/card_do_exchange/ex_goods_id/@id@");?>';
	url = url.replace('@id@',id);

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
