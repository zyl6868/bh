<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/8/6
 * Time: 17:40
 */

namespace common\clients;


use common\components\BanhaiRequest;
use common\components\MicroServiceRequest;
use Httpful\Mime;
use Httpful\Request;
use Yii;

/**
 *短信服务
 * Class SmsManageService
 * @package common\clients
 */
class SmsManageService
{

    private $uri = null;
    private $host=null;
    private $microServiceRequest=null;

  public   function __construct()
    {
        $this->uri = Yii::$app->params['microService'];
        $this->host = 'sms-service';
        $this->microServiceRequest = new MicroServiceRequest($this->host);
    }


    /**
     *调用后台短信服务
     * @param $type integer  1验证 2 说明
     * @param $phone string  手机号
     * @param $sourceType  integer 1 web  2 手机
     * @param $content
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    private function smsManage($type, $phone, $sourceType, $content)
    {
        $result = $this->microServiceRequest->post($this->uri . '/api/v1/sms/send-sms')
            ->body(http_build_query(['type' => $type, 'phone' => $phone, 'sourceType' => $sourceType, 'content' => $content]))
            ->sendsType(Mime::FORM)
            ->send();
        return $result;
    }


    /**
     * 短信服务
     * @param $type
     * @param $phone
     * @param $sourceType
     * @param $content
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public static function getCode($type, $phone, $sourceType, $content)
    {
        $sms = new SmsManageService();
        return $sms->smsManage($type, $phone, $sourceType, $content);

    }

}