<?php
namespace frontend\services\pos;
use app\models\UserInfo;
use ArrayObject;
use frontend\services\BaseService;
use frontend\services\ShanHaiSoapClient;
use JsonMapper;

/**
 * Created by wangchunlei
 * User: Administrator
 * Date: 14-9-19
 * Time: 下午5:11
 */
class pos_PersonalInformationService extends BaseService
{

    function    __construct()
    {
        $this->_soapClient = new ShanHaiSoapClient(app()->params['pos_webService'] . "schoolService/personalInformation?wsdl");
    }

    /**
     * 3.4.10.    获取两个用户是否在同一个班级
     * @param $userOne
     * @param $userTwo
     * @return ServiceJsonResult
     */
    public function querySameClassByTwoUser($userOne, $userTwo)
    {
        $soapResult = $this->_soapClient->querySameClassByTwoUser(
            array(
                "userOne" => $userOne,
                "userTwo" => $userTwo
            ));

        $jsonStr = $this->_soapClient->mapSoapResult($soapResult, new ArrayObject());
        $json = json_decode($jsonStr, true);
        $result = $this->mapperJsonResult($json);
        return $result;
    }

}