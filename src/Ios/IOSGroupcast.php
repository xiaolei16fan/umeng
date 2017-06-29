<?php
namespace UmengPush\Ios;

use UmengPush\IOSNotification;

class IOSGroupcast extends IOSNotification
{
    public function __construct()
    {
        parent::__construct();
        $this->data["type"] = "groupcast";
        $this->data["filter"] = null;
    }
}
