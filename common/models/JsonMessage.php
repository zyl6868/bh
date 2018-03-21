<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 14-7-2
 * Time: 上午11:54
 */

namespace common\models;

/**
 * Class JsonMessage json信息
 */
class JsonMessage
{
    public $message = '';
    public $code = 0;
    public $success = false;
    public $data;

    public function __construct($code = 0, $message = '', $success = false)
    {
        $this->code = $code;
        $this->message = $message;
        $this->success = $success;
    }
}


