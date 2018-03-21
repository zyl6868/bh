<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 17-4-20
 * Time: 11:00
 */

namespace common\clients;

use common\components\MicroServiceRequest;
use Httpful\Mime;
use Yii;

class XuemiMicroService
{
    /**
     * @var null
     */
    private $uri = null;
    private $microServiceRequest = null;
    private $host = null;

    /**
     * XuemiMicroService constructor.
     */
    public function __construct()
    {
        $this->uri = Yii::$app->params['microService'];
        $this->host = 'incentive-service';
        $this->microServiceRequest = new MicroServiceRequest($this->host);
    }

    /**
     * 获取月余额（老师）
     * @param integer $userId
     * @param string $month
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getMonthAccount(int $userId, string $month)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/user/' . $userId . '/xuemi/month-account/' . $month)
            ->sendsType(Mime::JSON)
            ->send();
        return $result->body;
    }

    /**
     * 获取我的可用学米（学生）
     * @param integer $userId
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getMyUsableAccount(int $userId)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/user/' . $userId . '/general-account')
            ->sendsType(Mime::JSON)
            ->send();
        return $result->body;
    }

    /**
     * 获取今天得到的学米
     * @param integer $userId
     * @param string $beginTime
     * @param string $endTime
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getTodayAccount(int $userId, string $beginTime, string $endTime)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/user/' . $userId . '/' . $beginTime . '/' . $endTime . '/xuemi-total')
            ->sendsType(Mime::JSON)
            ->send();
        return $result->body;
    }

    /**
     * 获取学米明细
     * @param integer $userId
     * @param integer $page
     * @param integer $perPage
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getXuemiDetails(int $userId, int $page, int $perPage)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/user/' . $userId . '/xuemi/total-accounts?' . http_build_query(['page' => $page, 'per-page' => $perPage]))
            ->sendsType(Mime::JSON)
            ->send();
        return $result;
    }

    /**
     * 学生学米排行
     * @param integer $userId
     * @param integer $rankType
     * @param integer $page
     * @param integer $perPage
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getXuemiRanking(int $userId, int $rankType, int $page, int $perPage)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/user/' . $userId . '/xuemi-ranks?' . http_build_query(['rank-type' => $rankType, 'page' => $page, 'per-page' => $perPage]))
            ->sendsType(Mime::JSON)
            ->send();
        return $result->body;
    }

    /**
     * 老师月度学米列表
     * @param integer $userId
     * @param integer $page
     * @param integer $perPage
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getMonthXuemiList(int $userId, int $page, int $perPage)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/user/' . $userId . '/xuemi/month-accounts?' . http_build_query(['page' => $page, 'per-page' => $perPage]))
            ->sendsType(Mime::JSON)
            ->send();
        return $result;
    }

    /**
     * 学生可用学米
     * @param integer $userId
     * @return int
     */
    public function getStudentUsableXuemi(int $userId)
    {
        $myAccount = 0;
        $myUsableAccount = $this->getMyUsableAccount($userId);
        if (!empty($myUsableAccount)) {
            $myAccount = $myUsableAccount->xueMi;
        }
        return $myAccount;

    }

    /**
     * 获取老师当月学米
     * @param integer $userId
     * @param string $month
     * @return int
     */
    public function getTeacherMonthXuemi(int $userId, string $month)
    {
        $myAccount = 0;
        $monthAccountModel = $this->getMonthAccount($userId, $month);
        if (!empty($monthAccountModel)) {
            $myAccount = isset($monthAccountModel->incomeTotal) ? $monthAccountModel->incomeTotal - $monthAccountModel->costTotal : 0;
        }
        return $myAccount;
    }

    /**
     * 获取今日学米
     * @param integer $userId
     * @return mixed
     */
    public function getTodayXuemi(int $userId)
    {

        $beginTime = urlencode(date('Y-m-d 00:00:00', time()));
        $endTime = urlencode(date('Y-m-d 23:59:59', time()));
        return $this->getTodayAccount($userId, (string)$beginTime, (string)$endTime);
    }


    /**
     * 添加学米
     * @param integer $userId
     * @param string $ruleCode
     * @param string $occurrenceTime
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function addXuemi(int $userId, string $ruleCode, string $occurrenceTime)
    {

        $result = $this->microServiceRequest->post($this->uri . '/v1/user/' . $userId . '/xuemi')
            ->body(http_build_query(['rule-code' => $ruleCode, 'occurrence-time' => $occurrenceTime]))
            ->sendsType(Mime::FORM)
            ->send();
        return $result->body;
    }

    /**
     * 结转过的学米数
     * @param integer $userId
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function convertXuemiCount(int $userId)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/user/' . $userId . '/xuemi/month-account/convert')
            ->sendsType(Mime::JSON)
            ->send();
        return $result->body;
    }

    /**
     * 结转学米
     * @param integer $userId
     * @param integer $monthAccountId
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function convertXuemi(int $userId, int $monthAccountId)
    {
        $result = $this->microServiceRequest->post($this->uri . '/v1/user/' . $userId . '/transfer/' . $monthAccountId)
            ->sendsType(Mime::FORM)
            ->send();
        return $result->body;
    }


    /**
     * 学米商品列表
     * @param int $type 用户身份  0 学生  1 老师
     * @param int $accountType 账户类型  0  月账户  1 结转账户
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function Goods(int $type, int $accountType = 0)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/goods-exchange/xmgoods?' . http_build_query(['type' => $type, 'account-type' => $accountType]))
            ->expectsType(Mime::JSON)
            ->send();
        return $result->body;
    }

    /**
     * 学米兑换
     * @param integer $userId 用户id
     * @param integer $goodsId 商品id
     * @param integer $monthAccountId 月账户id
     * @param string $contact 联系人
     * @param string $contactPhone 联系方式
     * @param string $address 联系地址
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function XuemiExchange(int $userId, int $goodsId, int $monthAccountId, string $contact, string $contactPhone, string $address)
    {
        $result = $this->microServiceRequest->post($this->uri . '/v1/goods-exchange/xmgoods/exchange/' . $userId . '/good/' . $goodsId)
            ->body(http_build_query(['month-account-id' => $monthAccountId, 'contact' => $contact, 'contact-phone' => $contactPhone, "address" => $address]))
            ->contentType('')
            ->sendsType(Mime::FORM)
            ->send();
        return $result->body;
    }

    /**
     * 下载课件扣除学米
     * @param string $code
     * @param integer $price
     * @param integer $userId
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function deductXuemi(string $code, int $price, int $userId)
    {

        $result = $this->microServiceRequest->post($this->uri . '/v1/incentive-update/deduct-xuemi/user/' . $userId)
            ->body(http_build_query(['rule-code' => $code, 'xue-mi' => $price, 'user-id' => $userId]))
            ->sendsType(Mime::FORM)
            ->send();
        return $result->body;
    }


    /**
     * 根据规则查询某个用户一段时间获取的学米总数
     * @param int $userId
     * @param string $ruleCodes
     * @param string $beginTime
     * @param string $endTime
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getUserXuemiTotalByCodes(int $userId, string $ruleCodes, string $beginTime, string $endTime)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/user/' . $userId . '/xuemi-type/xuemi-total-max?' . http_build_query(['rule-codes' => $ruleCodes, 'begin-time' => $beginTime, 'end-time' => $endTime]))
            ->sendsType(Mime::JSON)
            ->expectsType(Mime::JSON)
            ->send();
        return $result;
    }


    /**
     * 根据规则查询某个用户一段时间获取的学米流水
     * @param int $userId
     * @param string $ruleCodes
     * @param string $beginTime
     * @param string $endTime
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getUserCurrentAccountsByCodes(int $userId, string $ruleCodes, string $beginTime, string $endTime)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/user/' . $userId . '/rule-code/current-accounts?' . http_build_query(['rule-codes' => $ruleCodes, 'begin-time' => $beginTime, 'end-time' => $endTime]))
            ->sendsType(Mime::JSON)
            ->expectsType(Mime::JSON)
            ->send();
        return $result;
    }
}