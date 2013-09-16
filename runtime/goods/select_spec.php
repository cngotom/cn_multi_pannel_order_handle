<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理后台</title>
<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/admin.css";?>" />
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/jquery/jquery-1.9.0.min.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/jquery/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/systemjs/artdialog/skins/default.css" />
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/form/form.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/systemjs/autovalidate/style.css" />
<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/admin.js";?>"></script>
</head>
<body style="width:600px;height:400px;">
<div class="pop_win">
	<table class="spec" width="90%" cellspacing="0" cellpadding="0" border="0">
		<col width="35%" />
		<col width="65%" />
		<tr>
			<td>
				<h3>请选择规格</h3>
				<div class="cont" style='height:285px;'>
					<ul id="specs"></ul>

					<script type='text/html' id='specList'>
						<%for(var item in templateData){%>
							<%include('specLi',{'item':templateData[item]})%>
						<%}%>
					</script>

					<script type='text/html' id='specLi'>
					<li>
						<label><input type="radio" autocomplete="off" name="spec" onclick="selSpect(this,<%=item['id']%>)" value='{"id":"<%=item['id']%>","name":"<%=item['name']%>","type":"<%=item['type']%>","value":"<%=encodeJSON(item['value'])%>"}' /><%=item['name']%><%if(item['note']){%>[<%=item['note']%>]<%}%></label>
					</li>
					</script>
				</div>
				<p>没有找到需要的规格？</p>
				<p><button type="button" class="btn" onclick="addNewSpec()"><span class="add">添加新规格</span></button></p>
			</td>
			<td>
				<h4>规格预览区</h4>
				<div class="cont" style="width:360px;">
					<p>请在左侧列表选择规格！</p>
					<ul class="goods_spec_box"></ul>

					<!--商品规格列表-->
					<script type='text/html' id='showSpecTemplate'>
					<%var valueList = parseJSON(templateData['value']);%>
					<%for(var result in valueList){%>
					<li>
						<%if(templateData['type'] == 1){%>
						<span><%=valueList[result]%></span>
						<%}else{%>
						<span class="pic"><img src='<?php echo IUrl::creatUrl("")."<%=valueList[result]%>";?>' width='30px' height='30px' /></span>
						<%}%>
					</li>
					<%}%>
					</script>

				</div>
			</td>
		</tr>
	</table>
</div>

<script type='text/javascript'>
$(function(){
	<?php $query = new IQuery("spec");$query->where = "is_del = 0";$items = $query->find(); foreach($items as $key => $item){?><?php }?>
	var specListHtml = template.render('specList',{'templateData':<?php echo JSON::encode($items);?>});
	$('#specs').html(specListHtml);
});

//选择规格属性
function selSpect(_self,id)
{
	_self.focus();

	//设置当前选中规格的样式
	$('ul>li').removeClass('current');
	$(_self).parent().parent().addClass('current');

	//Ajax获取规格的详细信息
	$.getJSON("<?php echo IUrl::creatUrl("/block/spec_value_list");?>",{'id':id},function(data)
	{
		if(data)
		{
			var showSpecHtml = template.render('showSpecTemplate',{'templateData':data});
			$('.goods_spec_box').html(showSpecHtml);
		}
	});
}

//添加新规格
function addNewSpec()
{
	art.dialog.open('<?php echo IUrl::creatUrl("/goods/spec_edit");?>', {
		id:'addSpecWin',
	    title:'添加新规格',
	    okVal:'添加',
	    ok:function(iframeWin, topWin){
	    	var formObject = iframeWin.document.forms['specForm'];
			$.post(formObject.action,$(formObject).serialize(),function(json){
				if(json.flag == 'success')
				{
		    		var specLiHtml = template.render('specLi',{'item':json.data});
		    		$('#specs').append(specLiHtml);

		    		//最后一项出发激活事件
		    		$('[name="spec"]:last').trigger('click');
		    		return true;
				}
				else
				{
					alert(json.message);
					return false;
				}
			},'json');
	    }
	});
}
</script>
</body>
</html>