<?php

namespace frontend\services\pos;
use ArrayObject;
use frontend\services\BaseService;
use frontend\services\ShanHaiSoapClient;

/**
 * Created by PhpStorm.
 * User: unizk
 * Date: 14-9-9
 * Time: 下午12:58
 */

/**
 * Class ClassMembersService
 */
class pos_ClassMembersService extends BaseService
{
    function __construct()
    {
        $this->_soapClient = new ShanHaiSoapClient(app()->params['pos_webService'] . "schoolService/classMembers?wsdl");
    }


    /**
     * 加载班级中已经注册的成员信息
     * queryType    查询类型，0查询教师，1查询学生
     * {
     * "data": {
     * "classMembersSize": 1,
     * "classMembers": [
     * {
     * "identity": "20401",//班级内部身份 20401：班主任 ；20403：学生 ； 20402：任课老师
     * "userID": "10127",//用户ID
     * "subjectNumber": "10010",//科目编码
     * "subjectName": "语文",//科目名称
     * "classID": "1017",//班级id
     * "classMemID": "9101142",//班级成员id（修改时使用该ID）
     * "job": null,//班内职务
     * "stuID": "",//学号
     * "memName": "王二狗"//在班级内的名称
     * },
     * {
     * "identity": "1",
     * "userID": "1014",
     * "subjectNumber": null,
     * "subjectName": null,
     * "classID": "1017",
     * "classMemID": "10150",
     * "job": null,
     * "stuID": "1016004",
     * "memName": "马辉煌"
     * }
     * ]
     * },
     * "resCode": "000000",
     * "resMsg": "成功"
     * }
     * @param string $classID
     * @return array
     */
    public function loadRegisteredMembers($classID = null, $queryType = null, $userID = null)
    {
        $soapResult = $this->_soapClient->loadRegisteredMembers(array("classID" => $classID, "queryType" => $queryType, "userID" => $userID));
        $result = $this->soapResultToJsonResult($soapResult);
        if ($result->resCode == self::successCode) {
            return $result->data->classMembers;
        }
        return array();

    }

}