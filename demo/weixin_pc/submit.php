<?php
require_once(dirname(dirname(dirname(__FILE__)))."/src/lib/shenzhoufu_submit.class.php");
require_once(dirname(dirname(dirname(__FILE__)))."/src/lib/shenzhoufu_notify.class.php");
// 版本号，使用配置参数
$version = \ShenzhoufuConfig::$version;
//商户ID
$merId = \ShenzhoufuConfig::$merId;
//支付金额，单位为分
$payMoney = 100;
//订单号，使用自己系统内部的唯一订单号
$orderId = 'test002';
// 异步回调通知地址，回调处理见同级目录的 notify.php 文件
$returnUrl = 'http://test.mine.cn/notify.php';
// 自定义数据段
$privateField = '';
// 数据库校验方式，默认传1
$verifyType = 1;

//构造参数
$params = array (
	"version" => $version,
	"merId" => $merId,
	"payMoney" => $payMoney,
	"orderId" => $orderId,
	'returnUrl' => $returnUrl,
	'privateField' => $privateField,
	'verifyType' => $verifyType,
);

//发送请求
$requestResult = \ShenzhoufuSubmit::weixinSubmit($params);
$result = json_decode($requestResult, true);
if(200 == $result['resCode']){ // 请求成功
	//验证签名
	$verifyResult = \ShenzhoufuNotify::verifyWeixinRet($result);

	if(true == $verifyResult) {//验证成功
		//得到二维码
		$qrCodeUrl = $result['qrCodeUrl'];
		echo "二维码数据为\n".$qrCodeUrl."\n";
		//接下来需要自行从二维码生成图片以便微信扫码支付，推荐使用jquery-qrcode
		//  https://github.com/jeromeetienne/jquery-qrcode
	} else {
		echo "验证失败\n";
	}				
} else {
	echo "错误码是 ".$result['resCode']."\n";
	echo "错误原因是 ".\ShenzhoufuConfig::$weixinErrorCodeText[$result['resCode']]."\n";
}

