<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/8/6
 * Time: 17:40
 */

namespace common\clients;


use backend\components\sbNav;
use common\components\MicroServiceRequest;
use Httpful\Mime;
use Httpful\Request;
use Yii;

/**
 * Class JfManageService
 * @package common\clients
 */
class JfManageService
{

    /**
     * @var null
     */
    private $uri = null;
    private $microServiceRequest = null;
    private $host = null;

    /**
     * JfMicroservice constructor.
     */
    public function __construct()
    {
        $this->uri = Yii::$app->params['microService'];
        $this->host = 'incentive-service';
        $this->microServiceRequest = new MicroServiceRequest($this->host);
    }

    /**
     * 积分全国排名
     * @param int $userType 角色
     * @return mixed
     */
    public function userCountrySorts(int $userType)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/user-country-sorts?' . http_build_query(['user-type' => $userType]))
            ->expectsType(Mime::JSON)
            ->send();
        return $result->body;
    }

    /**
     * 积分全校排名
     * @param int $userType 角色
     * @param int $schoolID 学校id
     * @return mixed
     */
    public function userSorts(int $schoolID, int $userType)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/user-sorts?' . http_build_query(['user-type' => $userType, 'school-id' => $schoolID]))
            ->expectsType(Mime::JSON)
            ->send();
        return $result->body;
    }

    /**
     * 积分全班排名
     * @param int $userType 角色
     * @param int $classID 班级id
     * @return mixed
     */
    public function userClassSorts(int $classID, int $userType)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/user-class-sorts?' . http_build_query(['user-type' => $userType, 'class-id' => $classID]))
            ->expectsType(Mime::JSON)
            ->send();
        return $result->body;
    }

    /**
     * 添加积分/学米
     * @param $ruleCode
     * @param $userID
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function addJfXuemi($ruleCode, $userID, $type=2)
    {
        //添加学米/积分
        $result = $this->microServiceRequest->post($this->uri . '/v1/incentive-update/user/'.$userID)
            ->body(http_build_query(['rule-code' => $ruleCode,'type'=>$type]))
            ->sendsType(Mime::FORM)
            ->send();
        return $result->body;
    }

    /**
     * 积分明细
     * @param $userID
     * @param int $page
     * @param int $pageSize
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function Points($userID, $page = 1, $pageSize = 50)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/jf-currents?' . http_build_query(['user-id' => $userID, 'page' => $page, 'per-page' => $pageSize]))
            ->expectsType(Mime::JSON)
            ->send();
        return $result;
    }

    /**
     * 签到
     * @param $userID
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function Sign($userID)
    {
        $result = $this->microServiceRequest->post($this->uri . '/v1/signs')
            ->body(http_build_query(['user-id' => $userID]))
            ->contentType('')
            ->sendsType(Mime::FORM)
            ->send();
        return $result->body;
    }

    /**
     * 查看签到
     * @param $userID
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function checkSign($userID)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/signs?' . http_build_query(['user-id' => $userID]))
            ->send();
        return $result->body;
    }

    /**
     * 积分等级
     * @param integer $userID 用户id
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function JfGrade(int $userID)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/jf-user-grades/' . $userID)
            ->contentType('')
            ->sendsType(Mime::FORM)
            ->send();
        return $result->body;
    }

    /**
     * 积分等级(多个用户)
     * @param string $userIds 用户id
     * @return array
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function JfUsersGrade(string $userIds):array
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/jf-user-grades?' . http_build_query(['user-ids' => $userIds]))
            ->contentType('')
            ->sendsType(Mime::FORM)
            ->send();
        return $result->body;
    }

    /**
     * 积分兑换
     * @param integer $userId 用户id
     * @param string $contact 联系人
     * @param string $contactPhone 联系方式
     * @param string $address 联系地址
     * @param integer $goodsId 商品id
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function JfExchange($userId, $contact, $contactPhone, $address, $goodsId)
    {
        $result = $this->microServiceRequest->post($this->uri . '/v1/jf-exchanges')
            ->body(http_build_query(['userID' => $userId, 'goodsId' => $goodsId, 'contact' => $contact, 'contactPhone' => $contactPhone, "address" => $address]))
            ->contentType('')
            ->sendsType(Mime::FORM)
            ->send();
        return $result->body;
    }

    /**
     * 用户总积分
     * @param integer $userID
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function UserScore(int $userID)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/user-accounts?' . http_build_query(['user-id' => $userID]))
            ->expectsType(Mime::JSON)
            ->send();
        return $result->body;
    }


    /**
     * 用户获取当日积分
     * @param integer $userID
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function UserDayScore(int $userID)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/user-currents?' . http_build_query(['user-id' => $userID]))
            ->expectsType(Mime::JSON)
            ->send();
        return $result->body;
    }

    /**
     * 商品列表
     * @param $type
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function Goods($type)
    {
        $result = Request::get($this->uri . '/v1/jf-goods?' . http_build_query(['type' => $type]))
            ->expectsType(Mime::JSON)
            ->send();
        return $result->body;
    }


} 