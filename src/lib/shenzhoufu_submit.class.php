<?php
require_once(dirname(dirname(__FILE__)) . '/shenzhoufu.config.php');
require_once(dirname(__FILE__) . '/shenzhoufu_tool.class.php');

class ShenzhoufuSubmit {
	
	//手机充值卡提交并返回结果
	public static function mobileSubmit($params)
	{
		$postParam = [];
		//TODO: 验证卡类信息
		
		//原始数据
		$fields = ['version', 'merId', 'payMoney', 'orderId', 'returnUrl', 'merUserName', 'merUserMail',
			'privateField', 'verifyType', 'cardTypeCombine'];
		
		foreach($fields as $field){
			if(isset($params[$field])){
				$postParam[$field] = $params[$field];
			}
		}
		
		//卡类信息加密
		$postParam['cardInfo'] = \ShenzhoufuTool::getMobileDesInfo($params['cardMoney'], $params['cardNum'], 
				$params['cardPwd'], \ShenzhoufuConfig::$desKey);
		
		//生成签名
		$postParam['md5String'] = \ShenzhoufuTool::getMobileMd5Sign($postParam, \ShenzhoufuConfig::$privateKey);
		
		//post提交
		return \ShenzhoufuTool::curlPost(\ShenzhoufuConfig::$mobilePostUrl, $postParam);
	}
	
	//游戏卡提交并返回结果
	public static function gamecardSubmit($params)
	{
		$postParam = [];
		//TODO: 验证卡类信息
		
		//原始数据
		$fields = ['version', 'merId', 'payMoney', 'orderId', 'returnUrl', 'merUserName', 'merUserMail',
			'privateField', 'verifyType'];
		
		foreach($fields as $field){
			if(isset($params[$field])){
				$postParam[$field] = $params[$field];
			}
		}
		
		//卡类信息加密
		$postParam['cardInfo'] = \ShenzhoufuTool::getGamecardDesInfo($params['cardType'], $params['cardMoney'], $params['cardNum'], 
				$params['cardPwd'], \ShenzhoufuConfig::$desKey);
		
		//生成签名
		$postParam['md5String'] = \ShenzhoufuTool::getGamecardMd5Sign($postParam, \ShenzhoufuConfig::$privateKey);
		
		//post提交
		return \ShenzhoufuTool::curlPost(\ShenzhoufuConfig::$gamecardPostUrl, $postParam);
	}
	
	//微信提交并返回结果
	public static function weixinSubmit($params)
	{
		$postParam = [];
		
		//原始数据
		$fields = ['version', 'merId', 'payMoney', 'orderId', 'returnUrl', 'merUserName', 'merUserMail',
			'privateField', 'verifyType'];
		
		foreach($fields as $field){
			if(isset($params[$field])){
				$postParam[$field] = $params[$field];
			}
		}
		
		//生成签名
		$postParam['md5String'] = \ShenzhoufuTool::getWeixinMd5Sign($postParam, \ShenzhoufuConfig::$privateKey);
		
		//post提交
		return \ShenzhoufuTool::curlPost(\ShenzhoufuConfig::$weixinPostUrl, $postParam);
	}
	
	//构造给手机端微信的提交参数
	static public function getMobileWeixinParam($params)
	{
		$returnParam = [];
		
		$fields = ['version', 'merId', 'payMoney', 'orderId', 'pageReturnUrl', 'serverReturnUrl', 'merUserName', 'productUrl',
			'privateField', 'gatewayId', 'verifyType', 'returnType', 'isDebug'];
		
		foreach($fields as $field){
			$returnParam[$field] = isset($params[$field]) ? $params[$field] : '';
		}
		
		//生成签名
		$returnParam['md5String'] = \ShenzhoufuTool::getMobileWeixinMd5Sign($returnParam, \ShenzhoufuConfig::$privateKey);
		
		return $returnParam;
	}
}
