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
$orderId = 'test003';
// 同步回调通知地址，回调处理见同级目录的 return.php 文件, 其验证处理过程跟异步回调处理完全相同
$pageReturnUrl = 'http://test.mine.cn/return.php';
// 异步回调通知地址，回调处理见同级目录的 notify.php 文件
$serverReturnUrl = 'http://test.mine.cn/notify.php';
// 用户ID，使用唯一ID或昵称均可
$merUserName = 123;
// 产品url，随意填，但不能为空
$productUrl = 'http://test.mine.cn/hao';
// 自定义数据段
$privateField = '';
// 充值方式ID，固定14
$gatewayId = 14;
// 数据库校验方式，默认传1
$verifyType = 1;
// 返回结果方式，固定3
$returnType = 3;
// 是否调试，固定0
$isDebug = 0;
//构造参数
$params = array (
	"version" => $version,
	"merId" => $merId,
	"payMoney" => $payMoney,
	"orderId" => $orderId,
	'pageReturnUrl' => $pageReturnUrl,
	'serverReturnUrl' => $serverReturnUrl,
	'merUserName' => $merUserName,
	'productUrl' => $productUrl,
	'privateField' => $privateField,
	'gatewayId' => $gatewayId,
	'verifyType' => $verifyType,
	'returnType' => $returnType,
	'isDebug' => $isDebug,
);

//获取参数
$postParam = \ShenzhoufuSubmit::getMobileWeixinParam($params);

// 一定要用手机浏览器访问，由手机端将上述参数提交到
// http://pay3.shenzhoufu.com/interface/version3/entry.aspx
// 在这里只是返回页面内容

$result = \ShenzhoufuSubmit::weixinMobileSubmit($postParam);
echo $result;

