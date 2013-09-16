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
	$site_config=new Config('site_config');
	$seo_data=array();
	$seo_data['title']=$site_config->name;
	$seo_data['title'].=$site_config->index_seo_title;
	$seo_data['keywords']=$site_config->index_seo_keywords;
	$seo_data['description']=$site_config->index_seo_description;
	seo::set($seo_data);
?>



<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/index.css";?>" />
<div class="theme">
            <div class="index_container_left">
                <div class="login_container" id="divLogin">
                    <ul class="tit">
                        <li class="T1"  style="color: rgb(191, 4, 5);">会员登陆</li>
                        <!--<li class="T2 login_tab_bg" onmousemove="c2();" style="color: rgb(255, 255, 255);">礼品卡/册兑换</li>-->
                    </ul>
                    <ul class="tab">
                       <!--
                        <li class="tab_01" style="display: none;">
                            <ul class="list">
                                <li>卡&nbsp;&nbsp;号：<input name="" type="text" id="CardID_M"><span class="star">*</span></li>
                                <li>密&nbsp;&nbsp;码：<input name="" type="password" id="Password_M"><span class="star">*</span></li>
                                <li>验证码：<input name="" id="ValidCode_M" type="text" style="width:50px"><img alt="" height="20px" width="45px;" class="vam hand" style=" padding-left:6px; vertical-align:top;" src="Captcha.axd?CaptchaCode=ValidCode_M?0.313183355377987"><span id="Captcha_ValidCode_M" style="cursor: pointer;font-size:12px;">看不清换一张</span><label id="lblCaptcha_ValidCode_M" for=""></label></li>
                                <li style="margin-left: 50px;">
                                    <input name="btnSubmit_M" type="button" id="btnSubmit_M" class="btn_01" value="兑换"></li>
                            </ul>
                        </li>
                       -->
                        <li class="tab_02" style="display: list-item;">
                            
                            <?php if((isset($user['user_id']) && $user['user_id'])){?>
                                <!-- 如果程序判断出用户已经登录了，那就显示下面这个div的内容 -->
                                <div class="login_container_ed">
                                    <p>亲爱的 <span class="customerid"><?php echo isset($user['username'])?$user['username']:"";?></span>，您已经登录</p>
                                    <p class="loginout">
                                        <a href="<?php echo IUrl::creatUrl("/ucenter/index");?>">我的帐户</a>&nbsp;|&nbsp
                                        <a href="<?php echo IUrl::creatUrl("/simple/logout");?>" class="reg">安全退出</a>
                                    </p>
                                </div>  
                           <?php }else{?>
                            <ul class="list" id="notloginOn"  >
                                <li> <span id="login_error"> </span> </li>
                                <li>用户名：<input name="" type="text" id="CustomerID_L"></li>
                                <li>密&nbsp;&nbsp;&nbsp;码：<input name="" type="password" id="Password_L"></li>
                                <li>验证码：<input name="" type="text" id="ValidCode_L" style="width:50px"><img alt="" height="20px" width="45px;" id="captchaImg" class="vam hand" style=" padding-left:6px; vertical-align:top;" src="<?php echo IUrl::creatUrl("/simple/getCaptcha");?>"><span id="Captcha_ValidCode_L" style="font-size: 12px; text-decoration: none;">看不清？<a class="link" href="javascript:changeCaptcha('<?php echo IUrl::creatUrl("/simple/getCaptcha");?>');">换一张</a></span><label id="lblCaptcha_ValidCode_L" for=""></label></li>
                                <li style="margin-left: 50px;">
                                    <input name="" id="btnSubmit_L" type="button" class="btn_01" value="登录"></li>
                            </ul>        
                           <?php }?>
              
                        </li>
                    </ul>
                </div>
                         
                <div class="news_container">
                    
                    
<h1 class="tit">
    最新动态 <span class="more"><a href="<?php echo IUrl::creatUrl("/site/article/id/1");?>">更多+</a></span></h1>
<ul>
    
            <?php $query = new IQuery("article");$query->where = "visiblity = 1 and top = 1 and category_id = 1";$query->order = "sort ASC,id DESC";$query->fields = "title,id,style,color";$query->limit = "6";$items = $query->find(); foreach($items as $key => $item){?>
                <?php $tmpId=$item['id'];?>
                <li><a href="<?php echo IUrl::creatUrl("/site/article_detail/id/$tmpId");?>"><?php echo Article::showTitle($item['title'],$item['color'],$item['style']);?></a></li>
            <?php }?>
</ul>

                </div>
            </div>
    
    
    <!-- 幻灯片开始  -->
      <div class="foucs" name="__DT">
                <ul class="foucs-pic">
                            <?php $index=0;?>
                            <?php foreach($this->index_slide as $key => $item){?>
                                <li    class="" <?php if( $index == 0){?> style="display: block"<?php }else{?>style="display: none;" <?php }?>   ><a onfocus="this.blur()" href="<?php echo isset($item['url'])?$item['url']:"";?>" target="_blank">
                                            <img title="<?php echo isset($item['name'])?$item['name']:"";?>" alt="<?php echo isset($item['name'])?$item['name']:"";?>" src="<?php echo isset($item['img'])?$item['img']:"";?>"></a>
                                </li>
                                <?php $index+=1;?>
                            <?php }?>

                </ul>
                <ul class="foucs-li op">
                            <?php $index=0;?>
                            <?php foreach($this->index_slide as $key => $item){?>
                                <li   <?php if( $index == 0){?>  class="cur"<?php }else{?> class="" <?php }?>   ></li>
                                <?php $index+=1;?>
                            <?php }?>
                </ul>
                <ul class="foucs-li foucs-txt">
                            <?php $index=0;?>
                            <?php foreach($this->index_slide as $key => $item){?>
                                <li class="<?php if($index == 0){?>cur<?php }?>"><a onfocus="this.blur()" href=<?php echo isset($item['url'])?$item['url']:"";?>" target="_blank">
                    <?php echo isset($item['name'])?$item['name']:"";?></a> </li>
                                 <?php $index+=1;?>
                            <?php }?>
                </ul>

       </div>
       <!-- end 幻灯品 -->
            <script src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/index.js";?>" type="text/javascript"></script>
 </div>







<div class="theme">
            <ul class="four_column">
                <li>
                    <a href="<?php echo IUrl::creatUrl("/simple/festival");?>"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/index/Theme_01.jpg";?>" alt="礼品册" title="礼品册"></a>


                    </li>
                <li>
                    <a href="<?php echo IUrl::creatUrl("/site/help/id/54");?>"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/index/Theme_02.jpg";?>" alt="积分外包" title="积分外包"></a>


                    </li>
                <li>
                    <a href="<?php echo IUrl::creatUrl("/simple/CreditMall");?>"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/index/Theme_03.jpg";?>" alt="积分商城" title="积分商城"></a>


                    </li>
                <li>
                    <a href="<?php echo IUrl::creatUrl("/simple/vip");?>"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/index/Theme_04.jpg";?>" alt="大客户专区" title="大客户专区"></a>


                    </li>
            </ul>
        </div>






<!--信息三栏开始 -->
<div class="theme ">
            <!--第一个-->
            <div class="index_info">
                <div class="info_column" style="background-color: #fcfcfc;">
                    
                    

<h2>
    我们的影响力</h2>
<ul class="info_column_up">
    <li class="pic"><a href="../Web/MediaCenter.aspx">
        <img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/index/column_pic01.jpg";?>"></a></li>
    <li class="tit">尊品购喜获众多权威媒</li>
    <li class="des"><a href="../Web/MediaCenter.aspx">“路虽远，行则至；事虽难，做则成！”相信，在众多媒体跟踪报下，在知名风投争相追捧下，尊品购一定可以书写新的佳绩！</a></li>
</ul>
<ul class="info_column_down">
    
            <li><a href="http://gc.cctv.com/20110812/107712.shtml">
                央视网对尊品购的报道
            </a></li>
        
            <li><a href="http://rich.online.sh.cn/rich/gb/content/2011-08/12/content_4757847.htm">
                上海热线财经频道对尊品购的报道
            </a></li>
        
    <li><a href="../Web/MediaCenter.aspx">更多..</a></li>
</ul>

                </div>
                <div class="info_column" style="background-color: #f8f8f8;">
                    <h2>
                        我们的空间</h2>
                    <ul class="info_column_up">
                        <li class="pic"><a href="#">
                            <img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/index/column_pic02.jpg";?>"></a></li>
                        <li class="tit">尊品购空间</li>
                        <li class="des"><a href="#">上海喜购贸易有限公司，作为华东地区最大的礼品册和企业积分外包服务商，自2006年3月成立以来，至今已有六年......</a></li>
                    </ul>
                    <strong>微博互动,还可以赢礼物哦！</strong>
                    <div class="weibologo">
                        <div>
                            <strong>微博互动,还可以赢礼物哦！</strong></div>
                        <div class="xllogo">
                            <a href="http://weibo.com/u/2029361931" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/index/xllogo.jpg";?>"></a></div>
                        <div class="txlogo">
                            <a href="http://t.qq.com/at?ptlang=2052" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/index/txlogo.jpg";?>"></a></div>
                    </div>
                </div>
                <div class="info_column" style="background-color: #fcfcfc;">
                    
                    

<h2>
    送礼文化</h2>
<ul class="info_column_up">
    <li class="pic"><a href="../Web/ArticleCulture.aspx">
        <img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/index/column_pic03.jpg";?>"></a></li>
    <li class="tit">尊品购送礼文化</li>
    <li class="des"><a href="../Web/ArticleCulture.aspx">
        作为有着五千年历史的泱泱大国，礼品文化及其所蕴含的文化礼仪的精神一直占据着重要的地位。礼文化最初起源于原始社会的物质交换，自然的人伦秩序是礼产生的最原始的动力。《礼记·曲礼上》说“礼尚往来，往而不平，非礼也，来而不往，亦非礼也。”正是礼文化的初始意义。作为一个礼仪之邦，礼强烈地影响着中国人的思想言论和行动。重礼仪、守礼法、行礼教、讲礼信、遵礼义已经成为一种民众的自觉意识而穿于其心理、行为活动之中，成为中华民族的文化特征。
　  礼文化是一种期望以虔诚感化和影响自然神灵的一种方式一种手段，同时也是人与人之间一种发自内心的尊重、敬意而为之的一种态度一种行动，因此人与人之间相互馈赠礼物，是人类社会生活中不可缺少的交往内容。</a></li>
</ul>
<ul class="info_column_down">   
    
            <li><a href="../Web/a_bohinet_aspx_articleculturedetail-S101.aspx">
                【每周好礼推荐】团圆聚福银月饼
            </a></li>
        
            <li><a href="../Web/a_bohinet_aspx_articleculturedetail-S100.aspx">
                【每周好礼】古婺窑火之玉青瓷茶器乾坤
            </a></li>
        
    <li><a href="../Web/ArticleCulture.aspx">更多..</a></li>
</ul>

                </div>
            </div>
        </div>


<!-- 信息三栏结束 -->



<script language="javascript" type="text/javascript">
        $(document).ready(function() {
         
            $('#btnSubmit_L').click(function(){
               var username = $('#CustomerID_L').val();
               var password = $('#Password_L').val();
               var validcode = $('#ValidCode_L').val();
                //检查类型
               var tips = '';
               if(username == '')
                   tips = '用户名不能为空';
               else if( password == '')
                   tips = '密码不能为空';
               else if(validcode == '')
                   tips = '请输入验证码';
               if(tips != '')
                {
                    $('#login_error').html(tips);
                    return;
                }
              $('#login_error').html('');
                $.post( '<?php echo IUrl::creatUrl("/simple/ajax_login_act");?>', 
                        {
                            'login_info': username,
                            'password':password,
                            'captcha' : validcode
                        },
                        function(msg){
                            if(msg.code)
                            {
                                $('#login_error').html(msg.message);
                            }
                            else{
                               window.location.reload(); 
                            }

                        },'json');

                    });
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
