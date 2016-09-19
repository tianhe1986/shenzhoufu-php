<?php
//工具类
class ShenzhoufuTool {
	//用desKey加密
	private static function getDesInfo($str, $desKey)
	{
		$size = mcrypt_get_block_size('des', 'ecb');
		
		//pkcs5_pad
		$pad = $size - (strlen($str) % $size);
		$input = $str . str_repeat(chr($pad), $pad);
     	
		$td = mcrypt_module_open(MCRYPT_DES,'','ecb',''); //使用MCRYPT_DES算法,ecb模式   
		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);   
		$key=base64_decode($desKey);
		mcrypt_generic_init($td, $key, $iv); //初始处理   
		//加密   
		$encrypted_data = mcrypt_generic($td, $input);   

		//结束处理   
		mcrypt_generic_deinit($td);   
		mcrypt_module_close($td); 
		//base64       
		$encode = base64_encode($encrypted_data); 
		return $encode; 
	}
	
	//手机充值卡des加密
	public static function getMobileDesInfo($cardMoney, $cardNum, $cardPwd, $desKey)
	{
		$str = $cardMoney."@".$cardNum."@".$cardPwd;	
     	return self::getDesInfo($str, $desKey);
	}
	
	//游戏卡des加密
	public static function getGamecardDesInfo($cardType, $cardMoney, $cardNum, $cardPwd, $desKey)
	{
		$str = $cardType."@".$cardMoney."@".$cardNum."@".$cardPwd;	
     	return self::getDesInfo($str, $desKey);
	}
	
	//签名
	private static function getMd5Sign($str, $privateKey)
	{
		return md5($str.$privateKey);
	}
	
	//手机充值签名
	public static function getMobileMd5Sign($params, $privateKey)
	{
		$str = '';
		$fields = ['version', 'merId', 'payMoney', 'orderId', 'returnUrl', 'cardInfo', 'privateField', 'verifyType'];
		foreach($fields as $field){
			$tempStr = isset($params[$field]) && strlen($params[$field]) > 0 ? $params[$field] : '';
			$str .= $tempStr;
		}
		return self::getMd5Sign($str, $privateKey);
	}
	
	//游戏卡充值签名
	public static function getGamecardMd5Sign($params, $privateKey)
	{
		$str = '';
		$fields = ['version', 'merId', 'payMoney', 'orderId', 'returnUrl', 'cardInfo', 'privateField', 'verifyType'];
		foreach($fields as $field){
			$tempStr = isset($params[$field]) && strlen($params[$field]) > 0 ? $params[$field] : '';
			$str .= $tempStr;
		}
		return self::getMd5Sign($str, $privateKey);
	}
	
	public static function getMobileNotifyMd5Sign($params, $privateKey)
	{
		$str = '';
		$fields = ['version', 'merId', 'payMoney', 'orderId', 'payResult', 'privateField', 'payDetails'];
		foreach($fields as $field){
			$tempStr = isset($params[$field]) && strlen($params[$field]) > 0 ? $params[$field] : '';
			$str .= $tempStr;
		}
		return self::getMd5Sign($str, $privateKey);
	}
	
	public static function getWeixinMd5Sign($params, $privateKey)
	{
		$str = '';
		$fields = ['version', 'merId', 'payMoney', 'orderId', 'returnUrl', 'privateField', 'verifyType'];
		foreach($fields as $field){
			$tempStr = isset($params[$field]) && strlen($params[$field]) > 0 ? $params[$field] : '';
			$str .= $tempStr;
		}
		return self::getMd5Sign($str, $privateKey);
	}
	
	public static function getMobileWeixinMd5Sign($params, $privateKey)
	{
		$params['privateKey'] = $privateKey;
		$str = '';
		$fields = ['version', 'merId', 'payMoney', 'orderId', 'pageReturnUrl', 'serverReturnUrl',
			'privateField', 'privateKey', 'verifyType', 'returnType', 'isDebug'];
		$isFirst = true;
		foreach($fields as $field){
			$tempStr = '';
			if(false == $isFirst){
				$tempStr .= '|';
			} else {
				$isFirst = false;
			}
			$tempStr .= isset($params[$field]) && strlen($params[$field]) > 0 ? $params[$field] : '';
			$str .= $tempStr;
		}
		return md5($str);
	}
	
	public static function getWeixinNotifyMd5Sign($params, $privateKey)
	{
		return self::getMobileNotifyMd5Sign($params, $privateKey);
	}
	
	public static function getGamecardNotifyMd5Sign($params, $privateKey)
	{
		return self::getMobileNotifyMd5Sign($params, $privateKey);
	}
	
	public static function getWeixinRetMd5Sign($params, $privateKey)
	{
		$str = '';
		$fields = ['resCode', 'orderId', 'qrCodeUrl'];
		foreach($fields as $field){
			$tempStr = isset($params[$field]) && strlen($params[$field]) > 0 ? $params[$field] : '';
			$str .= $tempStr;
		}
		return self::getMd5Sign($str, $privateKey);
	}
	
	//证书验证
	public static function certVerify($data, $signature, $publicKey)
	{
		$result = openssl_verify($data, base64_decode($signature), $publicKey, OPENSSL_ALGO_MD5);
		if (1 === $result){
			return true;
		}
		return false;
	}
	
	//curl post提交
	public static function curlPost($url, $postData)
	{
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		$response = curl_exec($ch);
		return $response;
	}
}

