<?php
require_once(dirname(dirname(dirname(__FILE__)))."/src/lib/shenzhoufu_notify.class.php");

//读参数
$fields = ['version', 'merId', 'payMoney', 'cardMoney', 'orderId', 'payResult', 'privateField', 'payDetails',
			'md5String', 'errcode', 'signString'
];
$val = [];
foreach($fields as $field){
	$val[$field] = $_POST($field);
}

//验证数据有效性
$verifyResult = \ShenzhoufuNotify::verifyMobileNotify($val);

if(true == $verifyResult) {//验证成功
	//支付结果
	$resultPay = $val['payResult'];
	//订单号
	$orderId = $val['orderId'];
	if($resultPay == 1) { //支付成功
		//根据业务自行处理
	} else {
		//支付失败
	}
	//注意，不论支付成功或失败，都需要返回输出订单号，表示已经接收到回传。
	die($orderId);
} else {
	//验证失败;
	die("验证失败");
}

