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
			<?php $data=$this->data_info?>
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artTemplate/artTemplate-plugin.js"></script>
<div class="headbar">
	<div class="position">
		<span>系统</span><span>></span>
		<span>配送管理</span><span>></span>
		<span><?php if(isset($data['id'])){?>编辑<?php }else{?>添加<?php }?>配送方式</span>
	</div>
</div>

<div class="content_box">
	<div class="content form_content">
		<form action='<?php echo IUrl::creatUrl("/system/delivery_update");?>' method='post' name='form'>
			<input type="hidden" name="id" value="" />

			<table class="form_table">
				<col width="150px" />
				<col />

				<tr>
					<th>配送方式名称:</th>
					<td>
						<input class="normal" name="name" value="" type="text" pattern="required" alt="配送方式名称不能为空" />
					</td>
				</tr>

				<tr>
					<th>货运公司:</th>
					<td>
						<select name="freight_id">
						<?php $query = new IQuery("freight_company");$query->where = "is_del = 0";$items = $query->find(); foreach($items as $key => $item){?>
						<option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['freight_name'])?$item['freight_name']:"";?></option>
						<?php }?>
						</select>
						<label>选择此配送方式所使用的物流公司</label>
					</td>
				</tr>

				<tr>
					<th>类型:</th>
					<td>
						<label class='attr'><input type="radio" value='0' name="type" checked='checked'>先收款后发货</label>
						<label class='attr'><input type="radio" value='1' name="type">货到付款</label>
						<label>货到付款选择货到付款后顾客无需再选择支付方式</label>
					</td>
				</tr>

				<tr>
					<th>重量设置:</th>
					<td>
						<label class='attr'>
							首重重量
							<select name="first_weight" pattern='int'>
								<option label="500克" value="500">500克</option>
								<option label="1公斤" value="1000" selected="selected">1公斤</option>
								<option label="1.2公斤" value="1200">1.2公斤</option>
								<option label="2公斤" value="2000">2公斤</option>
								<option label="5公斤" value="5000">5公斤</option>
								<option label="10公斤" value="10000">10公斤</option>
								<option label="20公斤" value="20000">20公斤</option>
								<option label="50公斤" value="50000">50公斤</option>
							</select>
						</label>

						<label class='attr'>首重费用<input class='tiny' name="first_price" value=""  pattern="float" alt="该项必填且只允许填写数字金额" type="text">元</label>

						<label class='attr'>
							续重重量
							<select name="second_weight" pattern='int'>
								<option label="500克" value="500">500克</option>
								<option label="1公斤" value="1000" selected="selected">1公斤</option>
								<option label="1.2公斤" value="1200">1.2公斤</option>
								<option label="2公斤" value="2000">2公斤</option>
								<option label="5公斤" value="5000">5公斤</option>
								<option label="10公斤" value="10000">10公斤</option>
								<option label="20公斤" value="20000">20公斤</option>
								<option label="50公斤" value="50000">50公斤</option>
							</select>
						</label>

						<label class='attr'>续重费用<input class='tiny' name="second_price" value="" pattern="float" alt="该项必填且只允许填写数字金额" type="text">元</label>

						<p><label>根据重量来计算运费，当物品不足《首重重量》时，按照《首重费用》计算，超过部分按照《续重重量》和《续重费用》乘积来计算</label></p>
					</td>
				</tr>

				<tr>
					<th>支持保价:</th>
					<td>
						<label class='attr'><input name="is_save_price" value="1" type="checkbox" onclick="$('#protectBox').toggle();">支持物流保价</label>

						<!--支持保价隐藏域-->
						<span id='protectBox' style='display:none'>
							<label class='attr'>费率<input name="save_rate" value="" class='tiny' pattern="float" alt="该项必填且只允许填写数字金额" type="text" />%</label>
							<label class='attr'>最低保价费<input name="low_price" value="" class='tiny' pattern="float" alt="该项必填且只允许填写数字金额" type="text" />元</label>
							<label>当用户需要保价后，一般是按照货物总金额的《费率》计算，但是保价金额最低不低于《最低保价费》</label>
						</span>
					</td>
				</tr>

				<tr>
					<th>设置地区运费:</th>
					<td>
						<label class='attr'><input name="price_type" value="0" type="radio" onclick="$('#areaBox').hide();" checked="checked">统一地区运费</label>
						<label class='attr'><input name="price_type" value="1" type="radio" onclick="$('#areaBox').show();">指定地区运费</label>
						<label>《统一地区运费》：全部的地区都使用默认的《重量设置》中的计费方式。《指定地区运费》：单独指定部分地区的运费</label>
					</td>
				</tr>
			</table>

			<!--按照地区设置-->
			<table class="form_table" id="areaBox" style='display:none'>
				<col width="150px" />
				<col />

				<tr>
					<th></th>
					<td>
						<label class='attr'><input name="open_default" value="1" type='checkbox' />地区默认运费</label>
						<label>注意：如果不开启此项，那么未设置的地区将无法送达！</label>
					</td>
				</tr>

				<tr>
					<th>支持的配送地区:</th>
					<td>
	                    <div id="deliveryAreaBox"></div>

	                    <!--地域设定模板-->
	                    <script type='text/html' id='areaTemplate'>
						<div class='content_box' style='padding:6px'>
							<input type='hidden' name='area_groupid[]' value='<%=area_groupid%>' />

							<label class='attr'>
								选择地区：
								<select>
									<?php foreach($this->areaList as $key => $item){?>
										<option value="<?php echo isset($item['area_id'])?$item['area_id']:"";?>"><?php echo isset($item['area_name'])?$item['area_name']:"";?></option>
									<?php }?>
								</select>
							</label>
							<button type="button" class="btn" onclick='addProvince(this);'><span class="add">添加</span></button>

							<label class='attr'>已选择地区：<input class="middle" name="areaName" value="<%=areaname%>" readonly="readonly" disabled='disabled' /></label>
							<label class='attr'>首重费用：<input class="tiny" name="firstprice[]" value="<%=firstprice%>" pattern="float" alt="该项必填且只允许填写数字金额" type="text" /></label>
							<label class='attr'>续重费用：<input class="tiny" name="secondprice[]" value="<%=secondprice%>" pattern="float" alt="该项必填且只允许填写数字金额" type="text" /></label>
							<a href="javascript:void(0)" onclick="$(this).parent().remove();" class="f_r"><img alt="删除" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_del.gif";?>" class="operator"/></a>
						</div>
	                    </script>
						<button type="button" class="btn" onclick='addArea()'><span class="add">添加地区</span></button>
					</td>
				</tr>
			</table>

			<table class="form_table">
				<col width="150px" />
				<col />
				<tr>
					<th>排序:</th><td><input class='tiny' type="text" name="sort" value="" size="5" pattern="int" alt="请输入排序项正整数" /></td>
				</tr>
				<tr>
					<th>状态:</th>
					<td>
						<label class='attr'><input name="status" type="radio" value="1" checked="checked" />启用</label>
						<label class='attr'><input name="status" type="radio" value="0" />关闭</label>
					</td>
				</tr>
				<tr>
					<th>详细介绍:</th><td><textarea name="description" rows="5" cols=""></textarea></td>
				</tr>
				<tr>
					<th></th><td><button type="submit" class="submit"><span>保 存</span></button></td>
				</tr>
			</table>
		</form>
	</div>
</div>

<script type='text/javascript'>
//DOM加载完毕
$(function()
{
	//初始化表单
	var formInstance = new Form('form');
	formInstance.init(<?php echo JSON::encode($data);?>);

	//设置隐藏域等部分
	<?php if(isset($data['is_save_price']) && $data['is_save_price'] == 1){?>
	$('#protectBox').show();
	<?php }?>

	//设置统一费用
	<?php if(isset($data['price_type']) && $data['price_type'] == 1){?>
	$('#areaBox').show();
	<?php }?>

	//具有特殊省份设置
	<?php if(isset($data['area_groupid']) && $data['area_groupid']!=''){?>
	var area_groupid = <?php echo JSON::encode(unserialize($data['area_groupid']));?>;
	var firstprice   = <?php echo JSON::encode(unserialize($data['firstprice']));?>;
	var secondprice  = <?php echo JSON::encode(unserialize($data['secondprice']));?>;

    for(var index in area_groupid)
    {
    	var areaname = [];
    	var idArray  = area_groupid[index].split(';');
    	for(var i in idArray)
    	{
    		if(idArray[i])
    		{
    			areaname.push(getAreaName(idArray[i]));
    		}
    	}
		var areaHtml = template.render('areaTemplate',{"area_groupid":area_groupid[index],"areaname":areaname.join(','),"firstprice":firstprice[index],"secondprice":secondprice[index]});
		$('#deliveryAreaBox').append(areaHtml);
    }
	<?php }?>
});

//添加地域项
function addArea()
{
	var areaHtml = template.render('areaTemplate',{});
	$('#deliveryAreaBox').append(areaHtml);
}

//获取省份名称
function getAreaName(provinceId)
{
	var areaNameList = <?php echo JSON::encode($this->area);?>;
	return areaNameList[provinceId];
}

//添加省份
function addProvince(_self)
{
	var parentObject = $(_self).parent();
	var selectObj    = parentObject.find('select');

	//当前选中的地区ID
	var areaGroupId = parentObject.find('input[name="area_groupid[]"]').val();

	//当前选中的地区NAME
	var areaGroupName = parentObject.find('input[name="areaName"]').val();

	//填写areaId
	if(areaGroupId == '')
	{
		parentObject.find('input[name="area_groupid[]"]').val(";" + selectObj.val() + ";");
	}
	else if(areaGroupId.indexOf(";" + selectObj.val() + ";") == -1)
	{
		parentObject.find('input[name="area_groupid[]"]').val(areaGroupId + selectObj.val() + ";");
	}
	else
	{
		alert('省份已经添加，不要重复添加');
		return;
	}

	//添加areaName
	areaGroupName = areaGroupName == '' ? selectObj.find('option:selected').text() : areaGroupName + "," + selectObj.find('option:selected').text();
	parentObject.find('input[name="areaName"]').val(areaGroupName);
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
