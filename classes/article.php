<?php
/**
 * @copyright (c) 2011 jooyea.cn
 * @file article.php
 * @brief 关于文章管理
 * @author chendeshan
 * @date 2011-02-14
 * @version 0.6
 */

 /**
 * @class article
 * @brief 文章管理模块
 */
class Article
{
	//展示select框分类
	public static function showCat($selectName='category_id',$selectedValue=null,$defaultValue=array())
	{
		//取得文章分类信息
		$catObj = new IModel('article_category');
		$data   = $catObj->query('','id,name,path','path','asc');

		$str = '<select class="auto" name="'.$selectName.'" pattern="required" alt="请选择分类值">';

		//默认option值
		if(!empty($defaultValue))
			$str.='<option value="'.current($defaultValue).'">'.key($defaultValue).'</option>';

		//拼接分类信息
		foreach($data as $val)
		{
			$isSelect = ($val['id']==$selectedValue) ? 'selected=selected':null;
			$str.='<option value="'.$val['id'].'" '.$isSelect.'>'.str_repeat("&nbsp;&nbsp;",substr_count($val['path'],",")-2).'└'.$val['name'].'</option>';
		}
		$str.='</select>';
		return $str;
	}

	//显示标题
	static function showTitle($title,$color=null,$fontStyle=null)
	{
		$str='<span style="';
		if($color!=null) $str.='color:'.$color.';';
		if($fontStyle!=null)
		{
			switch($fontStyle)
			{
				case "1":
				$str.='font-weight:bold;';
				break;

				case "2":
				$str.='font-style:oblique;';
				break;
			}
		}
		$str.='">'.$title.'</span>';
		return $str;
	}
}