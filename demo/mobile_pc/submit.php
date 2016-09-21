<?php
require_once(dirname(dirname(dirname(__FILE__)))."/src/lib/shenzhoufu_submit.class.php");

// 版本号，使用配置参数
$version = \ShenzhoufuConfig::$version;
//商户ID
$merId = \ShenzhoufuConfig::$merId;
//支付金额，单位为分
$payMoney = 100;
//订单号，使用自己系统内部的唯一订单号
$orderId = 'test001';
// 异步回调通知地址，回调处理见同级目录的 notify.php 文件
$returnUrl = 'http://test.mine.cn/notify.php';
// 充值卡类别，移动/联通/电信 具体见doc目录下 官方文档
$cardTypeCombine = 1;
// 充值卡面额
$cardMoney = 30;
// 充值卡号
$cardNum = '123456789';
// 充值卡密码
$cardPwd = '123456789012';
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
	'cardTypeCombine' => $cardTypeCombine,
	'cardMoney' => $cardMoney,
	'cardNum' => $cardNum,
	'cardPwd' => $cardPwd,
	'privateField' => $privateField,
	'verifyType' => $verifyType,
);

//发送请求
$requestResult = \ShenzhoufuSubmit::mobileSubmit($params);

if(200 == $requestResult){ //请求成功
	echo "请求成功\n";
	// 继续走下面的逻辑
} else { //失败
	//展示失败码及失败原因，实际应根据需要自行处理
	echo "错误码是 ".$requestResult."\n";
	echo "错误原因是 ".\ShenzhoufuConfig::$mobileCardErrorCodeText[$requestResult]."\n";
}


//请求失败，展示失败码及文字

