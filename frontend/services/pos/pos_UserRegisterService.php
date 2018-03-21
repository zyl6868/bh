<?php

namespace frontend\services\pos;
use ArrayObject;
use frontend\services\BaseService;
use frontend\services\ShanHaiSoapClient;

/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-8-26
 * Time: 下午4:17
 */
class pos_UserRegisterService extends BaseService
{
    /**
     * @return ServiceJsonResult
     */
    function __construct()
    {
        $this->_soapClient = new ShanHaiSoapClient(app()->params['pos_webService'] . "schoolService/schUserRegister?wsdl");
    }


    /**
     * @param $phoneReg
     * @return bool
     * 判断手机号是否被注册
     */
    public function   phoneIsExist($phoneReg)
    {
        $soapResult = $this->_soapClient->phoneIsExist(array("phoneReg" => $phoneReg));
        $jsonStr = $this->_soapClient->mapSoapResult($soapResult, new ArrayObject());
        $json = json_decode($jsonStr);
        if ($this->mapperJsonResult($json)->resCode == "000000") {
            return false;
        }
        return true;
    }

    /**
     * 3.3.2.检查验证码
     * @param $email
     * @return string
     * @throws \Camcima\Exception\InvalidParameterException
     */
    public function  checkResetPasswdTolken($resetPasswdTolken)
    {
        $soapResult = $this->_soapClient->checkResetPasswdTolken(array("resetPasswdTolken" => $resetPasswdTolken));
        $result = $this->soapResultToJsonResult($soapResult);
        if ($result->resCode == self::successCode) {
            return $result->data->email;
        }
        return '';
    }

    /**
     * 3.3.3.重置登录密码
     * resetPasswdTolken    验证码
     * newPassWd    新密码
     * @throws \Camcima\Exception\InvalidParameterException
     */
    public function  resetPassWord($resetPasswdTolken, $newPassWd)
    {
        $soapResult = $this->_soapClient->resetPassWord(array("resetPasswdTolken" => $resetPasswdTolken, 'newPassWd' => $newPassWd));
        $result = $this->soapResultToJsonResult($soapResult);
        if ($result->resCode == self::successCode) {
            return true;
        }
        return false;
    }



}