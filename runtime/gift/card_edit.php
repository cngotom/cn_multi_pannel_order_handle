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
			<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/my97date/wdatepicker.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artTemplate/artTemplate-plugin.js"></script>

<div class="headbar clearfix">
	<div class="position"><span>商品</span><span>></span><span>礼册管理</span><span>></span><span><?php if(isset($id)){?>礼册修改<?php }else{?>礼册添加<?php }?></span></div>
</div>

<div class="content_box">
	<div class="content form_content">
		<form action="<?php echo IUrl::creatUrl("/gift/card_update");?>" name="volumesForm" method="post">
			<input type="hidden" name="id" value="<?php echo isset($card_id)?$card_id:"";?>" />
			<div id="table_box_1">
				<table class="form_table">
					<col width="150px" />
					<col />
					<tr>
						<th>礼卡账号：</th>
						<td>
							<input class="normal" name="no" type="text" value="" pattern="required" alt="账号不能为空" /><label>*</label>
						</td>
					</tr>
                                                                        <tr>
						<th>礼卡密码：</th>
						<td>
							<input class="normal" name="password" type="password"  value=""   <?php if(!isset($card_id)){?> pattern="required" <?php }?>  alt="密码不能为空" /><label>*</label>
						</td>
					</tr>
                                                                      
                                                                        <tr>
						<th>礼册名称：</th>
						<td>  	
                                                                                            <select class="auto" name="volume_id" pattern="required" alt="礼册名称不能为空">
								<?php $query = new IQuery("volumes");$items = $query->find(); foreach($items as $key => $item){?>
                                                                                                                        <option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['title'])?$item['title']:"";?></option>
								<?php }?>
                                                                                            </select>
						</td>
					</tr>
                                                                         <tr>
						<th>有效期：</th>
						<td>
							<input class="normal" name="expire" type="text" value="<?php if(!isset($card_id)){?>12<?php }?>" pattern="int" alt="有效期格式不正确" /><label>( 月 )</label>
						</td>
					</tr>
					
                                             
				</table>
                                                          <table class="form_table">
                                                                    <col width="150px" />
                                                                    <col />
                                                                    <tr>
                                                                            <td></td>
                                                                            <td><button class="submit" type="submit" onclick="return checkForm()"><span>确认</span></button></td>
                                                                    </tr>
                                                        </table>
			</div>
		</form>
	</div>
</div>

<script language="javascript">
//创建表单实例
var formObj = new Form('volumesForm');
$(function()
{
	//商品分类回填
	<?php if(isset($card_id)){?>
                    var card = <?php echo JSON::encode($card);?>;
                    formObj.setValue('no',card.no);
                    formObj.setValue('volume_id',card.volume_id);
                    formObj.setValue('expire',card.expire);     
	<?php }?>
});

//提交表单前的检查
function checkForm()
{

	return true;
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
