<?php

namespace frontend\services\pos;
use frontend\services\BaseService;
use frontend\services\ShanHaiSoapClient;

/**
 * Created by PhpStorm.
 * User: liquan
 * Date: 2015/3/23
 * Time: 14:51
 */
class pos_UserSloganService extends BaseService{
    function __construct()
    {
        $this->_soapClient = new ShanHaiSoapClient(app()->params['pos_webService']."schoolService/userSlogan?wsdl");
    }
    /*
     * 查询个人口号
     * userID	用户id
     */
    public function searchUserSlogan($userID){
        $soapResult = $this->_soapClient->searchUserSlogan(
            array("userID" => $userID));
        $result = $this->soapResultToJsonResult($soapResult);
        if ($result->resCode == self::successCode) {
            return $result->data;
        }
        return array();
    }
}