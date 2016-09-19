# shenzhoufu-php
神州付对接，php客户端版

需要安装php mcrypt扩展和php curl扩展。

doc目录为神州付官方文档，代码均以此为参照标准

src目录下的shenzhoufu.config.php为配置文件，请按照需要进行修改。

demo目录各文件夹下是相应的后台提交(submit.php)和接收异步回传通知(notify.php)示例
---gamecard_pc 游戏点卡，PC版
---mobile_pc 手机充值卡，PC版
---weixin_pc 微信扫码支付，PC版
---weixin_app 微信扫码支付，手机版

tests文件夹为测试用例，会逐步完善
