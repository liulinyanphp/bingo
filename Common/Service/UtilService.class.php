<?php
/**
 * 数据curl请求接口
**/
namespace Common\Service;

class UtilService{
	
	public function curl_get_http($url)
    {
	    $curl = curl_init(); // 启动一个CURL会话
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_HEADER, 0);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true); // 跳过证书检查
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
	    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);// 模拟用户使用的浏览器
	    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
	    $tmpInfo = curl_exec($curl);     //返回api的json对象
	    //关闭URL请求
	    curl_close($curl);
	    return $tmpInfo;
	    //file_put_contents('aa.html',$tmpInfo);    
    }
}
?>