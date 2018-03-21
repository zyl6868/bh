<?php

namespace frontend\services\pos;
use frontend\services\BaseService;
use frontend\services\ShanHaiSoapClient;

/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-9-3
 * Time: 下午4:04
 */
class pos_UserInfoLoginService extends BaseService{
    function __construct(){
        $this->_soapClient = new ShanHaiSoapClient(app()->params['pos_webService']."schoolService/userInfoLogin?wsdl");
    }
    /**
     * 3.4.1.登录验证(修改0408)
     * @param $userName
     * @param $password
     * @return array
     */
    public function userPhoneLogin($userName, $password)
    {
        $soapResult = $this->_soapClient->userPhoneLogin(array("phoneReg" =>$userName, 'passwd' =>$password));
        $jsonStr = $this->_soapClient->mapSoapResult($soapResult, new ArrayObject());
        $json = json_decode($jsonStr,true);
        $result = $this->mapperJsonResult($json);
        if (isset($result->data) && !empty($result->data)) {
            $mapper = new JsonMapper();
            $object = $mapper->map($result->data, new UserInfo());
        } else {
            $object = null;
        }

        return array($result->resCode, $object);
    }
}
