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
        	<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/artTemplate/area_select.js";?>'></script>
<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/orderFormClass.js";?>'></script>
<script type='text/javascript'>
//创建订单表单实例
orderFormInstance = new orderFormClass();

//DOM加载完毕
jQuery(function(){
	//使用红包按钮

	//初始化地域联动JS模板
	template.compile("areaTemplate",areaTemplate);

	//收货地址数据
	orderFormInstance.addressInit("<?php echo isset($this->defaultAddressId)?$this->defaultAddressId:"";?>","<?php echo isset($this->defaultPrpvinceId)?$this->defaultPrpvinceId:"";?>");

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

//[address]保存到常用的收货地址
function address_default_save()
{
	if(orderFormInstance.addressCheck())
	{
		$.getJSON('<?php echo IUrl::creatUrl("/ucenter/address_add");?>',$('form[name="order_form"]').serialize(),function(content){
			if(content.isError == false)
			{
				var addressLiHtml = template.render('addressLiTemplate',{"item":content.data});
				$('.addr_list').prepend(addressLiHtml);
				$('input:radio[name="radio_address"]:first').trigger('click');
			}
			else
			{
				alert(content.message);
			}
		});
	}
}

//[delivery]根据省份地区ajax获取配送方式
function get_delivery(province)
{
	
}


</script>

<div class="wrapper clearfix">
	<div class="position mt_10"><span>您当前的位置：</span> <a href="<?php echo IUrl::creatUrl("");?>"> 首页</a> » 填写核对订单信息</div>
	

	<form action='<?php echo IUrl::creatUrl("/simple/exchange3");?>' method='post' name='order_form' callback='orderFormInstance.isSubmit();'>

		<input type='hidden' name='timeKey' value='<?php echo time();?>' />
		<input type='hidden' name='direct_gid' value='<?php echo isset($this->gid)?$this->gid:"";?>' />
		<input type='hidden' name='direct_type' value='<?php echo isset($this->type)?$this->type:"";?>' />
		<input type='hidden' name='direct_num' value='<?php echo isset($this->num)?$this->num:"";?>' />
		<input type='hidden' name='direct_promo' value='<?php echo isset($this->promo)?$this->promo:"";?>' />
		<input type='hidden' name='direct_active_id' value='<?php echo isset($this->active_id)?$this->active_id:"";?>' />

		<div class="cart_box m_10">
			<div class="title">填写核对订单信息</div>
			<div class="cont">

				<!--地址管理 开始-->
				<div class="wrap_box">
					<h3>
						<span class="orange">收货人信息</span>
						<a class="normal f12" href="javascript:void(0)" id="addressToggleButton" onclick="orderFormInstance.addressModToggle();">[退出]</a>
					</h3>

					<!--地址展示 开始-->
					<table class="form_table" id="address_show_box" style='display:none'>
						<col width="120" />
						<col />

						<tbody id="addressShowBox"></tbody>

						<!--收货地址展示模板-->
						<script type='text/html' id='addressShowTemplate'>
						<tr><th>收货人姓名：</th><td><%=accept_name%></td></tr>
						<tr><th>省份：</th><td><%=province_val%> <%=city_val%> <%=area_val%></td></tr>
						<tr><th>地址：</th><td><%=address%></td></tr>
						<tr><th>手机号码：</th><td><%=mobile%></td></tr>
						<tr><th>固定电话：</th><td><%=telphone%></td></tr>
						<tr><th>邮政编码：</th><td><%=zip%></td></tr>
						</script>
					</table>
					<!--地址展示 结束-->

					<!--收货表单信息 开始-->
					<div class="prompt_4 m_10" id='address_often'>
						<strong>常用收货地址</strong>
						<ul class="addr_list">
							<?php foreach($this->addressList as $key => $item){?>
							<li>
								<label><input class="radio" name="radio_address" type="radio" value="<?php echo isset($item['id'])?$item['id']:"";?>" onclick='orderFormInstance.addressSelected(<?php echo JSON::encode($item);?>);' /><?php echo isset($item['accept_name'])?$item['accept_name']:"";?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo isset($item['province_val'])?$item['province_val']:"";?> <?php echo isset($item['city_val'])?$item['city_val']:"";?> <?php echo isset($item['area_val'])?$item['area_val']:"";?> <?php echo isset($item['address'])?$item['address']:"";?></label>
							</li>
							<?php }?>
							<li>
								<label><input type='radio' name='radio_address' onclick='orderFormInstance.addressEmpty();' value='' />其他收货地址</label>
							</li>
						</ul>

						<!--收货地址项模板-->
						<script type='text/html' id='addressLiTemplate'>
						<li>
							<label><input class="radio" name="radio_address" type="radio" value="<%=item['id']%>" onclick='orderFormInstance.addressSelected(<%=jsonToString(item)%>);' /><%=item['accept_name']%>&nbsp;&nbsp;&nbsp;&nbsp;<%=item['province_val']%> <%=item['city_val']%> <%=item['area_val']%> <%=item['address']%></label>
						</li>
						</script>
					</div>

					<div class="box" id='address_form'>
						<table class="form_table">
							<col width="90px" />
							<col />

							<tbody>
								<tr>
									<th>收货人姓名：</th><td><input class="normal" type="text" name="accept_name" pattern='required' alt='收件人姓名不能为空' /> <span>(*) 收货人的姓名</span> </td>
								</tr>
								<tr>
									<th>省份：</th>
									<td>
										<select name="province" child="city,area" onchange="areaChangeCallback(this);"></select>
										<select name="city" child="area" parent="province" onchange="areaChangeCallback(this);"></select>
										<select name="area" parent="city" pattern="required" alt="请选择收货地区"></select>
										<span>(*) 收货地区</span>
									</td>
								</tr>
								<tr>
									<th>地址：</th><td><input class="normal" name='address' type="text" alt='格式不正确' pattern='required' /> <span>(*) 收货地址</span></td>
								</tr>
								<tr>
									<th>手机号码：</th><td><input class="middle" name='mobile' type="text" pattern='mobi' alt='格式不正确' /> <span>(*) 收货人的手机号，用于接收发货通知短信及送货前确认</span></td>
								</tr>
								<tr>
									<th>固定电话：</th><td><input class="middle" type="text" pattern='phone' name='telphone' empty alt='格式不正确' /></td>
								</tr>
								<tr>
									<th>邮政编码：</th><td><input class="middle" name='zip' empty type="text" pattern='zip' alt='格式不正确' /></td>
								</tr>
								<?php if($this->user['user_id']){?>
								<tr>
									<th></th><td><a href="javascript:void(0)" onclick="address_default_save();" class="blue">[添加到常用收货地址]</a></td>
								</tr>
								<?php }?>
							</tbody>
						</table>
					</div>
					<!--收货表单信息 结束-->
                                        <div style="position: relative">
                                            <label class="btn_orange3" id='address_save_button'><input type="button" value="保存收货人地址" onclick="orderFormInstance.addressSave();" /></label> 
                                            <span name="errTips" class="errInfo" id="address_save_error" style="display: none;">请确认收货信息</span>
                                        </div>
                                       
				</div>
				<!--地址管理 结束-->

			

				<!--订单留言 开始-->
				<div class="wrap_box">
					<h3>
						<span class="orange">订单附言</span>
						<a class="normal f12" href="javascript:void(0)" id='messageToggleButton' onclick="orderFormInstance.messageModToggle();">[修改]</a>
					</h3>

					<table width="100%" class="border_table" id='message_show_box'>
						<col width="120px" />
						<col />
						<tbody>
							<tr>
								<th>订单附言：</th>
								<td id="messageShowBox"></td>
							</tr>
						</tbody>
					</table>

					<table width="100%" class="form_table" id='message_form' style='display:none'>
						<col width="120px" />
						<col />
						<tr>
							<th>订单附言：</th>
							<td><input class="normal" type="text" name='message' /></td>
						</tr>
					</table>
                                        <div style="position: relative">
                                            <label class="btn_orange3" id='message_save_button' style='display:none'><input type="button" onclick="orderFormInstance.messageSave();" value="保存订单附言" /></label>
                                            <span name="errTips" class="errInfo" id="message_save_error" style="display: none;">请确认订单附言</span>
                                        </div> 
				</div>
				<!--订单留言 结束-->

				<!--购买清单 开始-->
				<div class="wrap_box">

					<h3><span class="orange">购买的商品</span></h3>


					<table width="100%" class="cart_table t_c">
						<col width="115px" />
						<col width="85px" />
						<col width="80px" />

						<thead>
							<tr>
								<th>图片</th>
								<th>商品名称</th>
								<th>礼册名称</th>
							</tr>
						</thead>

						<tbody>

							

							<!-- 商品展示 开始-->
							<?php foreach($this->goodsList as $key => $item){?>
							<tr>
								<td><img src="<?php echo IUrl::creatUrl("")."$item[small_img]";?>" width="66" height="66" alt="<?php echo isset($item['name'])?$item['name']:"";?>" title="<?php echo isset($item['name'])?$item['name']:"";?>" /></td>
								<td >
									<a href="<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>" class="blue"><?php echo isset($item['name'])?$item['name']:"";?></a>
								</td>
								<td><?php echo isset($item['title'])?$item['title']:"";?></td>
							</tr>
							<?php }?>
							<!-- 商品展示 结束-->

						</tbody>
					</table>
				</div>
				<!--购买清单 结束-->

			</div>
		</div>

		<!--金额结算-->
		<div class="cart_box" id='amountBox'>
			<div class="cont_2">
				<strong>结算信息</strong>
				
				<hr class="dashed" />
				
				<p class="m_10 t_r"><input type="submit" class="submit_order" /></p>
			</div>
		</div>

	</form>

</div>
    </div>
    <!-- main end -->
    
    
    
    <!--footer start -->
   
      
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
