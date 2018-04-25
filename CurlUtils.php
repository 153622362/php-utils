<?php
namespace common\utils;

class CurlUtils{
	
	public static function _request($curl,$https=true,$method='GET',$data=null){
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, $curl);
		curl_setopt($ch, CURLOPT_HEADER, false);
		//超时时间
		curl_setopt($ch,CURLOPT_TIMEOUT,5);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if($https){
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
		}
		if($method=='POST'){
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}
		$content=curl_exec($ch);
		curl_close($ch);
		return $content;
	}
	/**
	 * http Post 的请求方式
	 * @param string $curl		请求的url
	 * @param array $data		请求的数据
	 * @param number $second	连接超时时间，默认3秒, 如果传入0，表示不设置超时时间
	 */
	public static function httpPost($curl,$data=null,$second=3){
		return self::getAndPost($curl, false, 'POST',$data, $second);
	}
	/**
	 * https Post 的请求方式
	 * @param string $curl		请求的url
	 * @param array $data		请求的数据
	 * @param number $second	连接超时时间，默认3秒, 如果传入0，表示不设置超时时间
	 */
	public static function httpsPost($curl,$data=null,$second=3){
		return self::getAndPost($curl, true, 'POST',$data, $second);
	}
	/**
	 * http GET 的请求方式
	 * @param string $curl		请求的url
	 * @param number $second	连接超时时间，默认3秒, 如果传入0，表示不设置超时时间
	 */
	public static function httpGet($curl,$second=3){
		return self::getAndPost($curl, false, 'GET',null, $second);
	}
	/**
	 * https GET 的请求方式
	 * @param string $curl		请求的url
	 * @param number $second	连接超时时间，默认3秒, 如果传入0，表示不设置超时时间
	 */
	public static function httpsGet($curl,$second=3){
		return self::getAndPost($curl, true, 'GET',null, $second);
	}
	
	private static function getAndPost($curl,$https,$method,$data,$second){
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, $curl);
		curl_setopt($ch, CURLOPT_HEADER, false);
		//超时时间
		if($second>0){
			curl_setopt($ch,CURLOPT_TIMEOUT,$second);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if($https){
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
		}
		//curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate, br');
		if($method=='POST'){
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
			//curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}
		$content=curl_exec($ch);
		curl_close($ch);
		return $content;
	}
	
	public static function _requestSetHeader($curl,$headers,$https=true,$method='GET',$data=null){
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, $curl);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		//超时时间
		//curl_setopt($ch,CURLOPT_TIMEOUT,$second);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if($https){
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
		}
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
		if($method=='POST'){
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}
		$content=curl_exec($ch);
		curl_close($ch);

		return $content;
	}
	
	/**
	 * get请求
	 * @param string $url	请求的url
	 */
	public static function _get($url){
		$timeout = array(
				'http'=> array(
						'timeout'=>5,//设置一个超时时间，单位为秒
						'method'=>'GET'
				)
		);
		$ctx = stream_context_create($timeout);
		$result = '';
		try{
			$result=file_get_contents($url,0,$ctx);
		}catch(\Exception $e){}
		return $result;
	}
}