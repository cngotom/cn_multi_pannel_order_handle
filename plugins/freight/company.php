<?php
/**
 * @copyright (c) 2011 jooyea.cn
 * @file company.php
 * @brief 货运公司中文名称转换为拼音或英文
 * @author relay
 * @date 2011-07-15
 * @version 0.6
 */
class Company
{
	/**
	 * @param $freight string 货运公司的中文名称
	 * @return string 货运公司拼音或英文
	 * @brief 中文名称转换为拼音或英文模块
	 */
	//如提示：公司参数不正确 请修改这里,请将物流公司中的名称与$freight中的值保持一致。
	function getCompany($freight)
	{
		 if ($freight == '中国邮政'){
			$freight = 'ems';
		  }elseif($freight == '申通快递'){
			$freight = 'shentong';
		  }elseif($freight == '圆通速递'){
			$freight = 'yuantong';
		  }elseif($freight == '顺丰速运'){
			$freight = 'shunfeng';
		  }elseif($freight == '天天快递'){
			$freight = 'tiantian';
		  }elseif($freight == '韵达快递'){
			$freight = 'yunda';
		  }elseif($freight == '中通速递'){
			$freight = 'zhongtong';
		  }elseif($freight == '龙邦物流'){
			$freight = 'longbanwuliu';
		  }elseif($freight == '宅急送'){
			$freight = 'zhaijisong';
		  }elseif($freight == '全一快递'){
			$freight = 'quanyikuaidi';
		  }elseif($freight == '汇通速递'){
			$freight = 'huitongkuaidi';
		  }elseif($freight == '民航快递'){
			$freight = 'minghangkuaidi';
		  }elseif($freight == '亚风速递'){
			$freight = 'yafengsudi';
		  }elseif($freight == '快捷速递 '){
			$freight = 'kuaijiesudi';
		  }elseif($freight == 'DDS快递 '){
			$freight = 'dds';
		  }elseif($freight == '华宇物流 '){
			$freight = 'tiandihuayu';
		  }elseif($freight == '中铁快运'){
			$freight = 'ztky';
		  }elseif($freight == 'FedEx'){
			$freight = 'fedex';
		  }elseif($freight == 'UPS'){
			$freight = 'ups';
		  }elseif($freight == 'DHL'){
			$freight = 'dhl';
		  }else {
		  	$freight = '';
		  }
		  return $freight;
	}
}