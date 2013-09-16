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
        	<?php $seo_data=array(); $site_config=new Config('site_config');$site_config=$site_config->getInfo();?>
<?php $seo_data['title']= $this->catRow['title']?$this->catRow['title']:$this->catRow['name']?>
<?php if(isset($site_config['name'])){?>
	<?php $seo_data['title'].="_".$site_config['name']?>
<?php }?>
<?php if($this->catRow['keywords']!=""){?>
	<?php $seo_data['keywords']=$this->catRow['keywords']?>
<?php }?>
<?php if($this->catRow['descript']!=""){?>
	<?php $seo_data['description']=$this->catRow['descript']?>
<?php }?>
<?php seo::set($seo_data);?>

<?php $allCatIdArray=array();$catIdArray=array();?>
<?php $goodsCatTree = block::getCatTree($this->goodsCategory,$this->catId)?>

<div class="position">
	<span>您当前的位置：</span>
	<a href="<?php echo IUrl::creatUrl("");?>"> 首页</a> »
	<?php if(isset($goodsCatTree['id'])){?>
		<a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/$goodsCatTree[id]");?>"><?php echo isset($goodsCatTree['name'])?$goodsCatTree['name']:"";?></a>
		<?php if($goodsCatTree['id']!=$this->catRow['id']){?>
			» <?php echo isset($this->catRow['name'])?$this->catRow['name']:"";?>
		<?php }?>
	<?php }?>
</div>

<div class="wrapper clearfix container_2">

	<div class="sidebar f_l">

		<!--侧边栏分类-->
		<div class="box_2 m_10">

			<?php if(!empty($goodsCatTree)){?>
			<?php $allCatIdArray[]=$goodsCatTree['id']?>
			<div class="title"><?php echo isset($goodsCatTree['name'])?$goodsCatTree['name']:"";?></div>
			<div class="content">
				<?php if(isset($goodsCatTree['second'])){?>
				<?php foreach($goodsCatTree['second'] as $key => $second){?>
				<?php $allCatIdArray[]=$second['id']?>
				<dl class="clearfix">
					<dt><a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/$second[id]");?>"><?php echo isset($second['name'])?$second['name']:"";?></a></dt>
					<?php foreach($second['more'] as $key => $more){?>
					<?php $allCatIdArray[]=$more['id']?>
					<?php $catIdArray[]=$more['id'];?>
					<dd><a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/$more[id]");?>"><?php echo isset($more['name'])?$more['name']:"";?></a></dd>
					<?php }?>
				</dl>
				<?php }?>
				<?php }?>
			</div>
			<?php }?>
		</div>
		<!--侧边栏分类-->

		<!--销售排行-->
	  	<?php $query = new IQuery("category_extend as ca");$query->join = "left join goods as go on ca.goods_id = go.id left join order_goods as ord on ord.goods_id = go.id";$query->where = "ca.category_id in ($this->childId) and go.is_del = 0 and ord.goods_nums > 0";$query->fields = "go.id,go.name,go.list_img,go.sell_price,SUM(ord.goods_nums) as sum";$query->order = "sum desc";$query->group = "ord.goods_id";$query->limit = "10";$sellList = $query->find();?>
	  	<?php if(!empty($sellList)){?>
		<div class="box m_10">
			<div class="title">销售排行榜</div>
			<div class="content">
				<ul class="ranklist" id='ranklist'>
					<?php foreach($sellList as $key => $item){?>
				  	<li>
				  		<span><?php echo intval($key+1);?></span>
				  		<a href="<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>"><img src="<?php echo IUrl::creatUrl("")."$item[list_img]";?>" width="60" height="60" alt="<?php echo isset($item['name'])?$item['name']:"";?>" /></a>
				  		<a title="<?php echo isset($item['name'])?$item['name']:"";?>" class="p_name" href="<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>"><?php echo isset($item['name'])?$item['name']:"";?></a><b>￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></b>
				  	</li>
				  	<?php }?>
				</ul>
			</div>
		</div>
		<?php }?>
		<!--销售排行-->

	</div>

	<div class="main f_r">
		<!--推荐商品-->
	  	<?php $query = new IQuery("category_extend as ca");$query->join = "left join goods as go on ca.goods_id = go.id left join commend_goods as co on co.goods_id = go.id";$query->where = "ca.category_id in ($this->childId) and co.commend_id = 4 and go.is_del = 0";$query->limit = "6";$query->order = "go.sort asc,go.id desc";$query->fields = "DISTINCT go.list_img,go.sell_price,go.name,go.id,go.market_price,go.description";$pro_list = $query->find();?>

	  	<?php if(!empty($pro_list)){?>
		<div class="brown_box m_10 clearfix">
			<p class="caption"><span>推荐</span></p>

			<ul class="prolist">
				<?php foreach($pro_list as $key => $item){?>
				<li>
					<a class="pic" href="<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>"><img src="<?php echo IUrl::creatUrl("")."$item[list_img]";?>" alt="<?php echo isset($item['name'])?$item['name']:"";?>" height="85px" width="85px"></a>
					<p class="pro_title"><a class="blue" href="<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>"><?php echo isset($item['name'])?$item['name']:"";?></a><span class="gray"><?php echo isset($item['description'])?$item['description']:"";?></span></p>
					<p><b>￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></b> <s>￥<?php echo isset($item['market_price'])?$item['market_price']:"";?></s></p>
				</li>
				<?php }?>
			</ul>
		</div>
		<?php }?>
		<!--推荐商品-->

		<div class="box m_10">
			<div class="title"><?php echo isset($this->catRow['name'])?$this->catRow['name']:"";?></div>
			<div class="cont">

				<!--品牌展示-->
				<?php $query = new IQuery("category_extend as ca");$query->join = "left join goods as go on ca.goods_id = go.id left join brand as b on b.id = go.brand_id";$query->where = "ca.category_id in ( $this->childId ) and go.is_del = 0 and go.brand_id  !=  0";$query->fields = "DISTINCT b.id,b.name";$query->limit = "10";$brandList = $query->find();?>
				<?php if(!empty($brandList)){?>
				<dl class="sorting">
					<dt>品牌：</dt>
					<dd id='brand_dd'>
						<a class="nolimit current" href="<?php echo block::searchUrl('brand','');?>">不限</a>
						<?php foreach($brandList as $key => $item){?>
						<a href="<?php echo block::searchUrl('brand',$item['id']);?>" id='brand_<?php echo isset($item['id'])?$item['id']:"";?>'><?php echo isset($item['name'])?$item['name']:"";?></a>
						<?php }?>
					</dd>
				</dl>
				<?php }?>
				<!--品牌展示-->

				<?php if(stripos($this->childId,',') === false){?>

				<!--商品属性-->
				<?php $query = new IQuery("category as ca");$query->join = "left join attribute as attr on ca.model_id = attr.model_id";$query->where = "ca.id = $this->childId and attr.search = 1";$query->fields = "attr.name as name,attr.id ,attr.value as value";$items = $query->find(); foreach($items as $key => $item){?>
				<dl class="sorting">
					<dt><?php echo isset($item['name'])?$item['name']:"";?>：</dt>
					<dd id='attr_dd_<?php echo isset($item['id'])?$item['id']:"";?>'>
						<a class="nolimit current" href="<?php echo block::searchUrl('attr['.$item["id"].']','');?>">不限</a>
						<?php $attrVal = explode(',',$item['value']);?>
						<?php foreach($attrVal as $key => $attr){?>
						<a href="<?php echo block::searchUrl('attr['.$item["id"].']',$attr);?>" id="attr_<?php echo isset($item['id'])?$item['id']:"";?>_<?php echo urlencode($attr);?>"><?php echo isset($attr)?$attr:"";?></a>
						<?php }?>
					</dd>
				</dl>
				<?php }?>
				<!--商品属性-->

				<!--商品规格-->
				<?php if(!empty($this->spec)){?>
				<?php foreach($this->spec as $key => $item){?>
				<dl class="sorting">
					<dt><?php echo isset($item['name'])?$item['name']:"";?>：</dt>
					<dd id='spec_dd_<?php echo isset($item['id'])?$item['id']:"";?>'>
						<a class="nolimit current" href="<?php echo block::searchUrl('spec['.$item["id"].']','');?>">不限</a>
						<?php if($item['type'] == 1){?>
						<?php foreach(JSON::decode($item['value']) as $key => $spec){?>
						<a href="<?php echo block::searchUrl('spec['.$item["id"].']',$spec);?>" id='spec_<?php echo isset($item['id'])?$item['id']:"";?>_<?php echo urlencode($spec);?>'><?php echo isset($spec)?$spec:"";?></a>
						<?php }?>

						<?php }else{?>

						<?php foreach(JSON::decode($item['value']) as $key => $spec){?>
						<a href="<?php echo block::searchUrl('spec['.$item["id"].']',$spec);?>" id='spec_<?php echo isset($item['id'])?$item['id']:"";?>_<?php echo urlencode($spec);?>'><img src='<?php echo IUrl::creatUrl("$spec");?>' style='width:20px;height:20px' /></a>
						<?php }?>
						<?php }?>
					</dd>

				</dl>
				<?php }?>
				<?php }?>
				<!--商品规格-->

				<?php }?>

				<!--商品价格-->
				<dl class="sorting">
					<dt>价格：</dt>
					<dd id='price_dd'>
						<p class="f_r"><input type="text" class="mini" name="min_price" value="<?php echo IReq::get('min_price');?>" onchange="checkPrice(this);"> 至 <input type="text" class="mini" name="max_price" onchange="checkPrice(this);" value="<?php echo IReq::get('max_price');?>"> 元
						<label class="btn_gray_s"><input type="button" onclick="priceLink();" value="确定"></label></p>
						<a class="nolimit current" href="<?php echo block::searchUrl(array('min_price','max_price'),'');?>">不限</a>
						<?php $goodsPrice = goods_class::getGoodsPrice($this->childId)?>
						<?php foreach($goodsPrice as $key => $item){?>
							<?php $priceZone = explode('-',$item)?>
							<a href="<?php echo block::searchUrl(array('min_price','max_price'),array($priceZone[0],$priceZone[1]));?>" id="<?php echo isset($priceZone[0])?$priceZone[0]:"";?>-<?php echo isset($priceZone[1])?$priceZone[1]:"";?>"><?php echo isset($item)?$item:"";?></a>
						<?php }?>
					</dd>
				</dl>
				<!--商品价格-->
			</div>
		</div>

		<!--商品列表展示-->
		<div class="display_title">
			<span class="l"></span>
			<span class="r"></span>
			<span class="f_l">排序：</span>
			<ul>
				<?php foreach($this->orderArray as $key => $item){?>
					<?php if($this->order == $key){?>
						<?php $next = $key.'_toggle';$tip  = 'desc';?>
					<?php }else{?>
						<?php $next = $key;$tip  = '';?>
					<?php }?>
					<li class="<?php echo (stripos($this->order,$key)!==false) ? 'current':'';?>">
						<span class="l"></span><span class="r"></span>
						<a href="<?php echo block::searchUrl('order',$next);?>">
							<?php echo isset($item)?$item:"";?><span class='<?php echo isset($tip)?$tip:"";?>'>&nbsp;</span>
						</a>
					</li>
				<?php }?>
			</ul>
			<span class="f_l">显示方式：</span>
			<a class="show_b" href="<?php echo block::searchUrl('show_type','win');?>" title='橱窗展示' alt='橱窗展示'><span class='<?php echo $this->show_type == 'win' ? 'current':'';?>'></span></a>
			<a class="show_s" href="<?php echo block::searchUrl('show_type','list');?>" title='列表展示' alt='列表展示'><span class='<?php echo $this->show_type == 'list' ? 'current':'';?>'></span></a>
		</div>

		<?php if(!empty($this->resultData)){?>
		<ul class="display_list clearfix m_10">
			<?php foreach($this->resultData as $key => $item){?>
			<li class="clearfix <?php echo isset($this->show_type)?$this->show_type:"";?>">
				<div class="pic">
					<a title="<?php echo isset($item['name'])?$item['name']:"";?>" href="<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>"><img src="<?php echo Thumb::get($item['img'],$this->listImageWidth,$this->listImageHeight);?>" width="<?php echo isset($this->listImageWidth)?$this->listImageWidth:"";?>" height="<?php echo isset($this->listImageHeight)?$this->listImageHeight:"";?>" alt="<?php echo isset($item['name'])?$item['name']:"";?>" title="<?php echo isset($item['name'])?$item['name']:"";?>" /></a>
				</div>
				<h3 class="title"><a title="<?php echo isset($item['name'])?$item['name']:"";?>" class="p_name" href="<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>"><?php echo isset($item['name'])?$item['name']:"";?></a><span>总销量：<?php echo intval($item['sell_num']);?><a class="blue" href="<?php echo IUrl::creatUrl("/site/comments_list/id/$item[id]");?>">( <?php echo intval($item['comments_num']);?>人评论 )</a></span><span class='grade'><i style='width:<?php echo 14*$item['average_point'];?>px'></i></span></h3>
				<div class="handle">
					<label class="btn_gray_m"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/ucenter/shopping.gif";?>" width="15" height="15" /><input type="button" value="加入购物车" onclick="joinCart_list(<?php echo isset($item['id'])?$item['id']:"";?>);"></label>
					<label class="btn_gray_m"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/ucenter/favorites.gif";?>" width="15" height="14" /><input type="button" value="收藏" onclick="favorite_add_ajax('<?php echo IUrl::creatUrl("/simple/favorite_add");?>','<?php echo isset($item['id'])?$item['id']:"";?>',this);"></label>
					<div class="msgbox" style="width:350px;display:none">
						<div class="msg_t"><a class="close f_r" onclick="$(this).parents('.msgbox').hide();">关闭</a>请选择规格</div>
						<div class="msg_c" id='product_box_<?php echo isset($item['id'])?$item['id']:"";?>'></div>
					</div>
				</div>
				<div class="price">￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?><s>￥<?php echo isset($item['market_price'])?$item['market_price']:"";?></s></div>
			</li>
			<?php }?>
		</ul>

		<div class="pages_bar">
			<?php echo $this->goodsObj->getPageBar();?>
		</div>

		<?php }else{?>
		<p class="display_list mt_10" style='margin-top:50px;margin-bottom:50px'>
			<strong class="gray f14">对不起，没有找到相关商品</strong>
		</p>
		<?php }?>
		<!--商品列表展示-->

	</div>
</div>

<script type='text/javascript'>
	//价格跳转
	function priceLink()
	{
		var minVal = $('[name="min_price"]').val();
		var maxVal = $('[name="max_price"]').val();
		if(isNaN(minVal) || isNaN(maxVal))
		{
			alert('价格填写不正确');
			return '';
		}
		var urlVal = "<?php echo preg_replace('|&min_price=\w*&max_price=\w*|','','?'.$_SERVER['QUERY_STRING']);?>";
		window.location.href=urlVal+'&min_price='+minVal+'&max_price='+maxVal;
	}

	//价格检查
	function checkPrice(obj)
	{
		if(isNaN(obj.value))
		{
			obj.value = '';
		}
	}

	//筛选条件按钮高亮
	$(document).ready(function(){
		<?php $attr_spec = Array('attr','spec');$brand = IReq::get('brand');?>

		<?php if(!empty($brand)){?>
		$('#brand_dd>a').removeClass('current');
		$('#brand_<?php echo isset($brand)?$brand:"";?>').addClass('current');
		<?php }?>

		<?php foreach($attr_spec as $key => $item){?>
			<?php $tempArray = IReq::get($item)?>
			<?php if(!empty($tempArray)){?>
				<?php $json = JSON::encode(array_map('urlencode',$tempArray))?>
				var attrArray = <?php echo isset($json)?$json:"";?>;
				for(val in attrArray)
				{
					if(attrArray[val])
					{
						$('#<?php echo isset($item)?$item:"";?>_dd_'+val+'>a').removeClass('current');
						document.getElementById('<?php echo isset($item)?$item:"";?>_'+val+'_'+attrArray[val]).className = 'current';
					}
				}
			<?php }?>
		<?php }?>

		<?php if(IReq::get('min_price') != ''){?>
		$('#price_dd>a').removeClass('current');
		$('#<?php echo IReq::get('min_price');?>-<?php echo IReq::get('max_price');?>').addClass('current');
		<?php }?>
	});
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
