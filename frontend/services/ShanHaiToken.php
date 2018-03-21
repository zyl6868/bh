<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 14-6-27
 * Time: 上午10:59
 */
namespace frontend\services;

/**
 * Class SchoolService
 */
class ShanHaiToken
{


    public $ip;
    public $uid;
    public $tm = 0;
    public $dm;
    public $did;
    public $os;
    public $token;


    function getData()
    {
        $result = @parse_user_agent();
        $this->ip = ip();
        $this->uid = app()->user->getId();
        $this->dm = "";
        $this->did = "";
        $this->os = $result['platform'] . " " . $result['browser'] . " " . $result['version'];
        $this->token = '';
    }
}