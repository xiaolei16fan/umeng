<?php

namespace Notification;

use PHPUnit\Framework\TestCase;
use UmengPush\Android\AndroidBroadcast;
use UmengPush\Android\AndroidGroupcast;
use UmengPush\Android\AndroidUnicast;
use UmengPush\MessageCancel;

class AndroidNotificationTest extends TestCase
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
        $this->timestamp = time();
    }

    /**
     * 单播测试
     *
     * 运行测试时需要填写的参数：
     * 1. device_tokens
     */
    public function testUniCast()
    {
        $unicast = new AndroidUnicast();
        $unicast->setAppMasterSecret($this->appMasterSecret);
        $unicast->setPredefinedKeyValue("appkey", $this->appkey);
        $unicast->setPredefinedKeyValue("timestamp", $this->timestamp);
        // Set your device tokens here
        $unicast->setPredefinedKeyValue("device_tokens", "your device token");
        $unicast->setPredefinedKeyValue("description", "安卓单播测试");
        $unicast->setPredefinedKeyValue("ticker", "Android unicast ticker");
        $unicast->setPredefinedKeyValue("title", "Android unicast title");
        $unicast->setPredefinedKeyValue("text", "Android unicast text");
        $unicast->setPredefinedKeyValue("after_open", "go_app");
        $unicast->setPredefinedKeyValue("display_type", "notification");
        // Set 'production_mode' to 'false' if it's a test device.
        // For how to register a test device, please see the developer doc.
        $unicast->setPredefinedKeyValue("production_mode", $this->productionMode);

        // Set extra fields
        $unicast->setExtraField("test", "helloworld");
        $result = json_decode($unicast->send(), true);
        $this->assertEquals('SUCCESS', $result['ret']);
    }

    /**
     * 组播测试
     *
     * 运行测试时需要填写的参数
     * 1. app_version
     */
    public function testGroupCast()
    {
        $filter = array(
            "where" => array(
                "and" => array(
                    array(
                        "or" => array(
                            array("app_version" => "7.1.4"),
                        ),
                    ),
                ),
            ),
        );

        $groupcast = new AndroidGroupcast();
        $groupcast->setAppMasterSecret($this->appMasterSecret);
        $groupcast->setPredefinedKeyValue("appkey", $this->appkey);
        $groupcast->setPredefinedKeyValue("timestamp", $this->timestamp);
        // Set the filter condition
        $groupcast->setPredefinedKeyValue("filter", $filter);
        $groupcast->setPredefinedKeyValue("ticker", "Android groupcast ticker");
        $groupcast->setPredefinedKeyValue("title", "Android groupcast title");
        $groupcast->setPredefinedKeyValue("text", "Android groupcast text");
        $groupcast->setPredefinedKeyValue("after_open", "go_app");
        // Set 'production_mode' to 'false' if it's a test device.
        // For how to register a test device, please see the developer doc.
        $groupcast->setPredefinedKeyValue("production_mode", $this->productionMode);
        $result = json_decode($groupcast->send(), true);
        $this->assertEquals('SUCCESS', $result['ret']);
    }

    public function testBroadCast()
    {
        $broadcast = new AndroidBroadcast();
        $broadcast->setAppMasterSecret($this->appMasterSecret);
        $broadcast->setPredefinedKeyValue("appkey", $this->appkey);
        $broadcast->setPredefinedKeyValue("timestamp", $this->timestamp);
        $broadcast->setPredefinedKeyValue("ticker", "Android broadcast ticker");
        $broadcast->setPredefinedKeyValue("title", "中文的title");
        $broadcast->setPredefinedKeyValue("text", "Android broadcast text");
        $broadcast->setPredefinedKeyValue("after_open", "go_app");
        $broadcast->setPredefinedKeyValue("start_time", '2017-09-14 09:55:21');
        $broadcast->setPredefinedKeyValue("expire_time", '2017-09-15 09:31:21');
        $broadcast->setPredefinedKeyValue("description", '安卓测试');

        // Set 'production_mode' to 'false' if it's a test device.
        // For how to register a test device, please see the developer doc.
        $broadcast->setPredefinedKeyValue("production_mode", $this->productionMode);
        // [optional]Set extra fields
        $broadcast->setExtraField("test", "helloworld");
        $result = json_decode($broadcast->send(), true);
        $this->assertEquals('SUCCESS', $result['ret']);
    }

    public function testCancel()
    {
        $taskId = '';
        $timeStamp = time();
        $cancelMsg = new MessageCancel();
        $cancelMsg->setAppMasterSecret($this->appMasterSecret);
        $cancelMsg->setPredefinedKeyValue('appkey', $this->appkey);
        $cancelMsg->setPredefinedKeyValue('timestamp', $timeStamp);
        $cancelMsg->setPredefinedKeyValue('task_id', $taskId);

        return $cancelMsg->send();
    }
}