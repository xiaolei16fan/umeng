<?php
namespace UmengPush\Ios;

use UmengPush\IOSNotification;

class IOSBroadcast extends IOSNotification
{
    public function __construct()
    {
        parent::__construct();
        $this->data["type"] = "broadcast";
    }
}
