<?php

namespace Notification;

use \PHPUnit\Framework\TestCase;
use UmengPush\Ios\IOSBroadcast;
use UmengPush\Ios\IOSGroupcast;
use \UmengPush\Ios\IOSUnicast;

class IOSNotificationTest extends TestCase
{
    protected $appkey = null;
    protected $appMasterSecret = null;
    protected $timestamp = null;
    protected $validation_token = null;
    /**
     * @var string 是否开启生产模式，false表示测试模式，true表示生产模式
     */
    protected $productionMode = "false";

    /**
     * 测试初始化
     *
     * 运行测试时需要填写的参数：
     * 1. appkey
     * 2. appMasterSecret
     */
    protected function setUp()
    {
        $this->appkey = '';
        $this->appMasterSecret = '';
        $this->timestamp = strval(time());
    }

    /**
     * 单播测试
     *
     * 运行测试时需要填写的参数：
     * 1. device_tokens
     */
    public function testUniCast()
    {
        $unicast = new IOSUnicast();
        $unicast->setAppMasterSecret($this->appMasterSecret);
        $unicast->setPredefinedKeyValue("appkey", $this->appkey);
        $unicast->setPredefinedKeyValue("timestamp", $this->timestamp);
        // Set your device tokens here
        $unicast->setPredefinedKeyValue("device_tokens", "your device token");
        $unicast->setPredefinedKeyValue("alert", "IOS 单播测试");
        $unicast->setPredefinedKeyValue("badge", 0);
        $unicast->setPredefinedKeyValue("sound", "chime");
        $unicast->setPredefinedKeyValue("expire_time", "2017-07-02 14:01:59");
        // Set 'production_mode' to 'true' if your app is under production mode
        $unicast->setPredefinedKeyValue("production_mode", $this->productionMode);
        $unicast->setPredefinedKeyValue("description", "IOS 单播测试");

        // Set customized fields
        $unicast->setCustomizedField("test", "helloworld");
        $result = json_decode($unicast->send(), true);
        $this->assertEquals('SUCCESS', $result['ret']);
    }

    /**
     * 组播测试
     *
     * 运行测试时需要填写的参数：
     * 1. app_version
     */
    public function testGroupCast()
    {
        $filter = array(
            "where" => array(
                "and" => array(
                    array(
                        "or" => array(
                            array("app_version" => ">2017032802"),
                        ),
                    ),
                ),
            ),
        );

        $groupcast = new IOSGroupcast();
        $groupcast->setAppMasterSecret($this->appMasterSecret);
        $groupcast->setPredefinedKeyValue("appkey", $this->appkey);
        $groupcast->setPredefinedKeyValue("timestamp", $this->timestamp);
        // Set the filter condition
        $groupcast->setPredefinedKeyValue("filter", $filter);
        $groupcast->setPredefinedKeyValue("alert", "hello world");
        $groupcast->setPredefinedKeyValue("badge", 0);
        $groupcast->setPredefinedKeyValue("sound", "default");
        // Set 'production_mode' to 'true' if your app is under production mode
        $groupcast->setPredefinedKeyValue("production_mode", $this->productionMode);
        $result = json_decode($groupcast->send(), true);
        $this->assertEquals('SUCCESS', $result['ret']);
    }

    public function testBroadcast()
    {
        $brocast = new IOSBroadcast();
        $brocast->setAppMasterSecret($this->appMasterSecret);
        $brocast->setPredefinedKeyValue("appkey", $this->appkey);
        $brocast->setPredefinedKeyValue("timestamp", $this->timestamp);

        $brocast->setPredefinedKeyValue("alert", "IOS 广播测试");
        $brocast->setPredefinedKeyValue("badge", 0);
        $brocast->setPredefinedKeyValue("sound", "default");
        // Set 'production_mode' to 'true' if your app is under production mode
        $brocast->setPredefinedKeyValue("production_mode", $this->productionMode);
        // Set customized fields
        $brocast->setCustomizedField("test", "helloworld");
        $result = json_decode($brocast->send(), true);
        $this->assertEquals('SUCCESS', $result['ret']);
    }
}
