<?php

namespace frontend\services\pos;
use ArrayObject;
use frontend\services\BaseService;
use frontend\services\ShanHaiSoapClient;

/**
 * Created by wangchunlei
 * User: Administrator
 * Date: 14-11-5
 * Time: 上午10:05
 */
class pos_HomeWorkManageService extends BaseService
{
    function __construct()
    {
        $this->_soapClient = new ShanHaiSoapClient(app()->params['pos_webService'] . "schoolService/homeworkManage?wsdl");
    }

    /**
     * 自动判断客观题
     * @param $homeworkAnswerID
     * @return \frontend\services\ServiceJsonResult
     */
    public function autoHomeworkCorrectResult($homeworkAnswerID){
        $array =['homeworkAnswerID'=>$homeworkAnswerID];
        $soapResult = $this->_soapClient->autoHomeworkCorrectResult($array);
        $result = $this->soapResultToJsonResult($soapResult);
        return $result;
    }

}