<?php
require_once(dirname(dirname(__FILE__)) . '/shenzhoufu.config.php');
require_once(dirname(__FILE__) . '/hash.php');
require_once(dirname(__FILE__) . '/shenzhoufu_tool.class.php');

class ShenzhoufuNotify
{
	//验证手机充值卡通知数据
	public static function verifyMobileNotify($params)
	{
		//先验签名，再验md5
		$signString = isset($params['signString']) ? $params['signString'] : '';
		$md5String = isset($params['md5String']) ? $params['md5String'] : '';

		if (strlen($md5String) == 0) {
			return false;
		}
		if (false == \ShenzhoufuTool::certVerify($md5String, $signString, \ShenzhoufuConfig::getPublicKey())) {
			return false;
		}

		$calculateMd5 = \ShenzhoufuTool::getMobileNotifyMd5Sign($params, \ShenzhoufuConfig::$privateKey);
		if (false == hash_equals($calculateMd5, $md5String)) {
			return false;
		}
		
		return true;
	}
	
	//验证微信同步返回数据
	public static function verifyWeixinRet($params)
	{
		$md5String = isset($params['md5String']) ? $params['md5String'] : '';

		if (strlen($md5String) == 0) {
			return false;
		}
		$calculateMd5 = \ShenzhoufuTool::getWeixinRetMd5Sign($params, \ShenzhoufuConfig::$privateKey);
		if (false == hash_equals($calculateMd5, $md5String)) {
			return false;
		}
		
		return true;
	}
	
	//验证微信通知数据
	public static function verifyWeixinNotify($params)
	{
		$md5String = isset($params['md5String']) ? $params['md5String'] : '';

		if (strlen($md5String) == 0) {
			return false;
		}
		$calculateMd5 = \ShenzhoufuTool::getWeixinNotifyMd5Sign($params, \ShenzhoufuConfig::$privateKey);
		if (false == hash_equals($calculateMd5, $md5String)) {
			return false;
		}
		
		return true;
	}
	
	//验证游戏点卡通知数据
	public static function verifyGamecardNotify($params)
	{
		$md5String = isset($params['md5String']) ? $params['md5String'] : '';

		$calculateMd5 = \ShenzhoufuTool::getGamecardNotifyMd5Sign($params, \ShenzhoufuConfig::$privateKey);
		if (false == hash_equals($calculateMd5, $md5String)) {
			return false;
		}
		
		return true;
	}
}

