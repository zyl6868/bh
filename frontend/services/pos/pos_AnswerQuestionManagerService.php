<?php

namespace frontend\services\pos;
use ArrayObject;
use frontend\services\BaseService;
use frontend\services\ShanHaiSoapClient;

/**
 * Created by PhpStorm.
 * User: ysd
 * Date: 14-10-31
 * Time: 上午11:05
 */
class pos_AnswerQuestionManagerService extends BaseService{

    function __construct(){
        $this->_soapClient = new ShanHaiSoapClient(app()->params['pos_webService']."schoolService/answerQuestionManager?wsdl");
    }

    /**
     * 3.27.12.用户问题个数统计
     * 接口地址	http://主机地址:端口号/ schoolService / answerQuestionManager?wsdll
     * 方法名	stasticUserQues
     * @param integer $userID   用户ID（不为空）
     * {
    "data": {
    "askQuesCnt": 2,//提问个数
    "useCnt": 0,//采用个数
    "answerCnt": 12//回答个数
    },
    "resCode": "000000",
    "resMsg": "成功"
    }
     * @return null
     */
    public function stasticUserQues($userID){
        $soapResult = $this->_soapClient->stasticUserQues(array("userID" => $userID));
        $result = $this->soapResultToJsonResult($soapResult);
        if ($result->resCode == self::successCode) {

            return $result->data;
        }
        return null;
    }

}

