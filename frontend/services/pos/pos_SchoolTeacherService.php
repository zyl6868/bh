<?php
namespace frontend\services\pos;
use frontend\services\BaseService;
use frontend\services\ShanHaiSoapClient;

/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-9-12
 * Time: 下午6:12
 */
class pos_SchoolTeacherService extends BaseService
{
    function __construct()
    {
        $this->_soapClient = new ShanHaiSoapClient(app()->params['pos_webService'] . "schoolService/schoolteacher?wsdl");
    }



    /**
     * 查询教师班级
     * /schoolService/schoolteacher?wsdl下的
     * 方法名    searchTeacherClass
     * @param $teacherID integer   教师id
     * @param $token   string     安全保护措施
     *
     *  "data": {
     * "classListSize": 3,
     * "classList": [
     * {
     * "joinYear": "2010",入学年级
     * "classNumber": "1",班级号
     * "department": "20203",学部
     * "classID": "100400",班级id
     * "className": "aaa",班级名
     * "departmentName": "高中部"学部名
     * },
     * {
     * "joinYear": "2014",
     * "classNumber": "1班",
     * "department": "20203",
     * "classID": "100321",
     * "className": "大时代",
     * "departmentName": "高中部"
     * },
     * {
     * "joinYear": "2014",
     * "classNumber": "1",
     * "department": "20203",
     * "classID": "100311",
     * "className": "IT班",
     * "departmentName": "高中部"
     * }
     * ]
     * },
     * "resCode": "000000",
     * "resMsg": "成功"
     * }
     * @return ServiceJsonResult
     */
    /**
     * @param $teacherID
     * @return array
     */
    public function searchTeacherClass($teacherID)
    {
        $soapResult = $this->_soapClient->searchTeacherClass(array('teacherID' => $teacherID));
        $result = $this->soapResultToJsonResult($soapResult);
        if ($result->resCode == self::successCode) {
            return $result->data;
        }
        return array();
    }

}