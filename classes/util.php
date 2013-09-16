<?php
/**
 * @copyright Copyright(c) 2011 jooyea.cn
 * @file util.php
 * @brief 公共函数类
 * @author kane
 * @date 2011-01-13
 * @version 0.6
 * @note
 */

 /**
 * @class Util
 * @brief 公共函数类
 */
class Util
{
	/**
	 * @brief 移除分隔符
	 * @param string $str 		待处理字符串 	格式,如 '1,2,3,4,'
	 * @param string $separator 分隔符 			格式,如 ',','|'
	 * @param int 	 $position  位置 			0：移除开始位置分隔符；1：移除最后位置分隔符
	 * @return string 返回处理过的字符串
	 */
	public static function  removeSeparator($str,$separator,$position = -1)
	{
		if($position == -1)
		{
			if(substr($str,-1) == $separator)
			{
				$str= substr($str,0,strlen($str)-1);
			}
		}
		else
		{
			if(substr($str,0,1) == $separator)
			{
				$str = substr($str,1);
			}
		}
		return $str;
	}

	/**
	 * @brief 显示错误信息（dialog框）
	 * @param string $message	错误提示字符串
	 */
	public static function showMessage($message)
	{
		echo '<script type="text/javascript">art.dialog.tips("'.$message.'")</script>';
		exit;
	}

	/**
	 * 处理二维数组
	 *
	 * 根据第二维某个索引的值来设置相应的第一维数组的key
	 * 如原来是
	 * array(array('id'=>'a','data'=>'') ,array('id'=>1000,'data'=>'')  )
	 * 按照id索引处理后：
	 * array('a'=>array('id'=>'a','data'=>'') ,1000=>array('id'=>1000,'data'=>'')  )
	 *
	 * @author walu
	 * @param array $arr	待处理的二维数组
	 * @param array $key	获取第二维值的索引
	 * @return array
	 */
	public static function array_rekey($arr,$key='id')
	{
		$fun_re=array();
		foreach($arr as $value)
		{
			$fun_re[$value[$key]]=$value;
		}
		return $fun_re;
	}


	/**
	 * 将参数[可以为数组]的值进行intval
	 *
	 * 如果是不是数组，直接intval，如果是array，则将这个array所有的值转为整形
	 *
	 * @param mixed $arr
	 * @return mixed
	 * @author walu
	 */
	public static function intval_value($arr)
	{
		if(is_array($arr))
		{
			foreach($arr as $key=>$value)
			{
				$arr[$key] = self::intval_value($value);
			}
			return $arr;
		}
		else
		{
			return intval($arr);
		}
	}

	/**
	 * 检测是否为合法的用户名
	 *
	 * 合法的用户名：英文字母、数组、下划线、短横线、中文
	 * @param string $username
	 * @return bool
	 * @author walu
	 */
	 public static function is_username($username)
	 {
	 	return preg_match("!^[_a-zA-Z0-9\\x{4e00}-\\x{9fa5}]{2,20}$!u",$username);
	 }

	/**
	 * 把一、二维数组转成CSV格式的字符串
	 *
	 * @param array $array
	 * @param string $delimiter
	 * @param string $enclosure
	 * @return string
	 * @author walu
	 */
	public static function array2csv($array,$delimiter=",",$enclosure='"')
	{
		$string = array();
		foreach($array as $row)
		{
			$row_string=array();
			//判断是否为二维数组
			if(is_array($row))
			{
				foreach($row as $value)
				{
					$row_string[] = self::string2csv($value,$delimiter=",",$enclosure='"');
				}
				$string[] = implode($delimiter,$row_string);
			}
			else
			{
				$string[] = self::string2csv($row,$delimiter=",",$enclosure='"');
			}
		}
		$string = implode("\n",$string);
		return $string;
	}
	/**
	 * 单个字段内容转成csv格式
	 *
	 * @param array $string
	 * @param string $delimiter
	 * @param string $enclosure
	 * @return string
	 * @author relay
	 */
	public static function string2csv($string,$delimiter=",",$enclosure='"')
	{
		if($string)
		{
			$string = str_replace($enclosure,$enclosure.$enclosure,$string);
			$string = $enclosure.$string.$enclosure;
		}
		return $string;
	}
	//字符串拼接
	public static function joinStr($id)
	{
		if(is_array($id) && isset($id[0]) && $id[0]!='')
		{
			$id_str = join(',',$id);
			$where = ' id in ('.$id_str.')';
		}
		else
			$where = 'id = '.$id;

		return $where;
	}

	/**
	 * 商品价格格式化
	 * @param $price float 商品价
	 * @return float 格式化后的价格
	 */
	public static function priceFormat($price)
	{
		return round($price,2);
	}
}