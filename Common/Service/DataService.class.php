<?php
/**
 * 数据解析服务
**/
namespace Common\Service;

use Think\Model;

class DataService{

	/**
     * author: lly
     * date  : 2018-03-14 
     * used : 从第三方网站获取数据之后进行解析
     *
	**/
	public function get_data_from_alcoin($html='')
	{
		if($html=''){
			return false;
		}
		//获取到网站保存下来的所有数据
		$data_info = $this->_get_aicoin_info($html);
		return $data_info;
	} 
	/**
     * author: lly
     * date : 2018-03-14
     * used : 唯一的从https:\/\/www.aicoin.net.cn/currencies获取数据
     * desc : 不同的网站解析的方式不一样
	**/
	private function _get_aicoin_info($html='')
	{
		if($html=''){
			return false;
		}
		$preg = "/<tr.*?>(.*?)<\/tr>/ism";
		preg_match_all($preg,$html,$matches);
		$allcoin_info = array();
		foreach($matches[0] as $key=>$v)
		{
			//首先拿到币的名称
			$a = "/<a.*?>(.*?)<\/a>/ism";
			preg_match_all($a,$v,$aarr);
			if(!empty($aarr[0]))
			{
				$bi_name = strip_tags($aarr[0][0]);
				$allcoin_info[$bi_name] = '';	
				//获取到所有币的名称 ： strip_tags($aarr[0][0]);
			}
			if($key < 1){continue;}
			//第二步拿到每一行的信息
			$span ="/<span.*?>(.*?)<\/span>/ism";
			preg_match_all($span,$v,$linearr);
			//给对应的列赋值
			$cloune = array(1=>'币值',2=>'价格',3=>'流通数量',4=>'24小时成交额',5=>'24小时涨跌幅',6=>'发行总量');
			$tmparr = array();
			foreach(array_filter($linearr[0]) as $tk=>$tv)
			{
				
				if(strpos($tv,'class="icon icon-site-')!==false){
					$b = strpos($tv,'icon-site');
					$e = strpos($tv,'" data-reactid');
					//echo strlen(substr($tv,$b,$e-$b+1));
					//echo strpos($tv,'icon icon-site');
					//echo '__'.strpos($tv,'" data-reactid');
					//echo '['.substr($tv,$b+10,$e-10-$b).']';
					$tmparr['来源'] = substr($tv,$b+10,$e-10-$b);
				}else{
					$tmpv = strip_tags($tv);
					$pattern = '/\s/';//去除空白
					$newstr = preg_replace($pattern, '@', $tmpv);
					if(isset($cloune[$tk]) && $cloune[$tk]!='')
					{
						$tmparr[$cloune[$tk]] = $newstr;
					}
				}				
			}
			$allcoin_info[$bi_name] = $tmparr;
		}
		return $allcoin_info;
	}
}