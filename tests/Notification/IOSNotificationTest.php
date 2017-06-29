<?php

namespace Notification;

use \PHPUnit\Framework\TestCase;
use \UmengPush\Ios\IOSUnicast;

class IOSNotificationTest extends TestCase
{
    protected $appkey = null;
    protected $appMasterSecret = null;
    protected $timestamp = null;
    protected $validation_token = null;
    protected $deviceTokens = null;

    /**
     * 初始化各项参数
     *
     * 注意：如果测试提示error_code为2004，那么请将你代码所在位置的公网IP设置到友盟的白名单中。
     */
    protected function setUp()
    {
        $this->appkey = '';
        $this->appMasterSecret = '';
        $this->deviceTokens = '';
        $this->timestamp = strval(time());
    }

    public function testUnicast()
    {
        $unicast = new IOSUnicast();
        $unicast->setAppMasterSecret($this->appMasterSecret);
        $unicast->setPredefinedKeyValue("appkey", $this->appkey);
        $unicast->setPredefinedKeyValue("timestamp", $this->timestamp);
        // Set your device tokens here
        $unicast->setPredefinedKeyValue("device_tokens", $this->deviceTokens);
        $unicast->setPredefinedKeyValue("alert", "IOS 单播测试");
        $unicast->setPredefinedKeyValue("badge", 0);
        $unicast->setPredefinedKeyValue("sound", "chime");
        $unicast->setPredefinedKeyValue("expire_time", "2017-07-02 14:01:59");
        // Set 'production_mode' to 'true' if your app is under production mode
        $unicast->setPredefinedKeyValue("production_mode", "false");
        $unicast->setPredefinedKeyValue("description", "IOS 单播测试");

        // Set customized fields
        $unicast->setCustomizedField("test", "helloworld");
        $result = json_decode($unicast->send(), true);
        $this->assertEquals('SUCCESS', $result['ret']);
    }
}
