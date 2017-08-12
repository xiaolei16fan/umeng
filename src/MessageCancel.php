<?php

namespace UmengPush;

/**
 * Class MessageCancel
 * @package UmengPush
 */
class MessageCancel extends UmengNotification
{
    protected $data = array(
        'appkey'    => null,
        'timestamp' => null,
        'task_id'   => null,
    );
    protected $postPath = '/api/cancel';

    public function setPredefinedKeyValue($key, $value)
    {
        if ( ! is_string($key)) {
            throw new \Exception("key should be a string!");
        }
        if ( ! in_array($key, array('appkey', 'timestamp', 'task_id'))) {
            throw new \Exception("Unknown key: $key");
        }

        $this->data[$key] = $value;
    }

}