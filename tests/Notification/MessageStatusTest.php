<?php

namespace Notification;

use PHPUnit\Framework\TestCase;
use UmengPush\MessageCancel;
use UmengPush\MessageStatus;

/**
 * Class MessageStatusTest 消息发送状态
 * @package Notification
 */
class MessageStatusTest extends TestCase
{
    protected $appkey = null;
    protected $appMasterSecret = null;
    protected $timestamp = null;
    protected $taskId = null;

    protected function setUp()
    {
        $this->appkey = '';
        $this->appMasterSecret = '';
        $this->taskId = '';
        $this->timestamp = strval(time());
    }

    public function testMessageStatus()
    {
        $messageStatus = new MessageStatus();
        $messageStatus->setAppMasterSecret($this->appMasterSecret);
        $messageStatus->setPredefinedKeyValue('appkey', $this->appkey);
        $messageStatus->setPredefinedKeyValue('timestamp', $this->timestamp);
        $messageStatus->setPredefinedKeyValue('task_id', $this->taskId);
        $result = json_decode($messageStatus->send(), true);
        print_r($result);
        $this->assertEquals('SUCCESS', $result['ret']);
    }

    public function testMessageCancel()
    {
        $timeStamp = time();
        $cancelMsg = new MessageCancel();
        $cancelMsg->setAppMasterSecret($this->appMasterSecret);
        $cancelMsg->setPredefinedKeyValue('appkey', $this->appkey);
        $cancelMsg->setPredefinedKeyValue('timestamp', $timeStamp);
        $cancelMsg->setPredefinedKeyValue('task_id', $this->taskId);

        $result = json_decode($cancelMsg->send(), true);
        print_r($result);
        $this->assertEquals('SUCCESS', $result['ret']);
    }
}