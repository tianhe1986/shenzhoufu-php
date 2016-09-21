<?php

class ShenzhoufuConfig
{
	public static $version = 3;
	//商户ID
	public static $merId = '151525';
	//手机充值卡支付数据提交URL
	public static $mobilePostUrl = 'http://pay3.shenzhoufu.com/interface/version3/serverconnszx/entry-noxml.aspx';
	//游戏点卡支付数据提交URL
	public static $gamecardPostUrl = 'http://pay3.shenzhoufu.com/interface/version3/serverconngc/entry.aspx';
	//微信支付数据提交URL
	public static $weixinPostUrl = 'http://pay3.shenzhoufu.com/version3/serverconnwxsm/entry.aspx';
	//私钥,用于md5签名
	public static $privateKey = '123456';
	//des key，用于加密卡类信息
	public static $desKey = 'fNCrhSynUm4=';
	//错误码
	public static $mobileCardErrorCodeText = [
		'101' => 'md5 验证失败',
		'102' => '订单号重复',
		'103' => '恶意用户',
		'104' => '序列号，密码简单验证失败或之前曾提交过的卡密已验证失败',
		'105' => '密码正在处理中',
		'106' => '系统繁忙，暂停提交',
		'107' => '多次充值时卡内余额不足',
		'109' => 'des 解密失败',
		'201' => '证书验证失败',
		'501' => '插入数据库失败',
		'502' => '插入数据库失败',
		'902' => '商户参数不全',
		'903' => '商户 ID 不存在',
		'904' => '商户没有激活',
		'905' => '商户没有使用该接口的权限',
		'906' => '商户没有设置  密钥（privateKey）',
		'907' => '商户没有设置  DES 密钥',
		'908' => '该笔订单已经处理完成（订单状态已经为确定的状态：成功  或者  失败）',
		'910' => '服务器返回地址，不符合规范',
		'911' => '订单号，不符合规范',
		'912' => '非法订单',
		'913' => '该地方卡暂时不支持',
		'914' => '金额非法',
		'915' => '卡面额非法',
		'916' => '商户不支持该充值卡',
		'917' => '参数格式不正确',
		'0' => '网络连接失败',
	];
	
	public static $gamecardErrorCodeText = [
		'101' => 'md5 验证失败',
		'105' => '重复提交点卡',
		'106' => '系统繁忙，请重新发起新订单',
		'902' => '商户参数不全',
		'903' => '商户 ID 不存在',
		'904' => '商户没有激活',
		'905' => '商户没有使用该接口的权限',
		'906' => '商户没有设置  密钥（privateKey）',
		'907' => '商户没有设置  DES 密钥',
		'908' => '该笔订单已经处理完成（订单状态已经为确定的状态：成功  或者  失败）',
		'910' => '服务器返回地址，不符合规范',
		'911' => '订单号，不符合规范',
		'912' => '非法订单',
		'915' => '点卡信息有误或卡号密码无效',
		'917' => '参数格式不正确',
	];
	
	public static $weixinErrorCodeText = [
		'101' => 'md5 验证失败',
		'106' => '系统繁忙，请重新发起新订单',
		'902' => '商户参数不全',
		'903' => '商户 ID 不存在',
		'904' => '商户没有激活',
		'905' => '商户没有使用该接口的权限',
		'906' => '商户没有设置  密钥（privateKey）',
		'907' => '商户没有设置  DES 密钥',
		'908' => '该笔订单已经处理完成（订单状态已经为确定的状态：成功  或者  失败）',
		'909' => '该订单不符合重复支付的条件',
		'910' => '服务器返回地址，不符合规范',
		'911' => '订单号，不符合规范',
		'912' => '非法订单',
		'917' => '参数格式不正确',
	];
	
	public static function getPublicKey()
	{
		$certPath = dirname(__FILE__) . '/key/ShenzhoufuPay.cer';
		$fp = fopen($certPath, "r");
		$cert = fread($fp, 8192);
		fclose($fp);
		$publicKey= openssl_get_publickey($cert);
		
		return $publicKey;
	}
}

