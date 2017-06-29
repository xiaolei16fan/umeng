<?php

namespace Notification;

use \PHPUnit\Framework\TestCase;
use UmengPush\Android\AndroidUnicast;

class AndroidNotificationTest extends TestCase
{
    protected $appkey = null;
    protected $appMasterSecret = null;
    protected $timestamp = null;
    protected $validation_token = null;
    protected $deviceTokens = null;

    protected function setUp()
    {
        $this->appkey = '';
        $this->appMasterSecret = '';
        $this->deviceTokens = '';
        $this->timestamp = time();
    }

    /**
     * 安卓单播测试
     */
    public function testAndroidUnicast()
    {
        $unicast = new AndroidUnicast();
        $unicast->setAppMasterSecret($this->appMasterSecret);
        $unicast->setPredefinedKeyValue("appkey", $this->appkey);
        $unicast->setPredefinedKeyValue("timestamp", $this->timestamp);
        // Set your device tokens here
        $unicast->setPredefinedKeyValue("device_tokens", $this->deviceTokens);
        $unicast->setPredefinedKeyValue("description", "安卓单播测试");
        $unicast->setPredefinedKeyValue("ticker", "Android unicast ticker");
        $unicast->setPredefinedKeyValue("title", "Android unicast title");
        $unicast->setPredefinedKeyValue("text", "Android unicast text");
        $unicast->setPredefinedKeyValue("after_open", "go_app");
        $unicast->setPredefinedKeyValue("display_type", "notification");
        // Set 'production_mode' to 'false' if it's a test device.
        // For how to register a test device, please see the developer doc.
        $unicast->setPredefinedKeyValue("production_mode", "false");

        // Set extra fields
        $unicast->setExtraField("test", "helloworld");
        $result = json_decode($unicast->send(), true);
        $this->assertEquals('SUCCESS', $result['ret']);
    }
}