<?php
namespace UmengPush\Android;

use UmengPush\AndroidNotification;

class AndroidBroadcast extends AndroidNotification
{
    public function __construct()
    {
        parent::__construct();
        $this->data["type"] = "broadcast";
    }
}
