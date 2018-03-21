<?php
namespace frontend\services\apollo;
use frontend\services\BaseService;
use frontend\services\ShanHaiSoapClient;

/**
 * Created by PhpStorm.
 * User: unizk
 * Date: 14-9-9
 * Time: 下午12:58
 */
class Apollo_BaseInfoService extends BaseService
{
    function __construct()
    {
        $this->_soapClient = new ShanHaiSoapClient(app()->params['apollo_webService'] . "apollo/resource/BaseInfo?wsdl");
    }


    /**
     * 年级信息查询
     * @param string $department 学部
     *  20201    小学部
     * 20202    初中部
     * 20203    高中部
     * @param string $lengthOfSchooling 学制
     *  20501    六三学制
     * 20502    五四学制
     * 02503    五三学制
     * @return array
     */
    public function loadGrade(string $department = '', string $lengthOfSchooling = '')
    {
        if (!isset($department)) {
            $department = '';
        }

        if (!isset($lengthOfSchooling)) {
            $lengthOfSchooling = '';
        }
        $soapResult = $this->_soapClient->loadGrade(array("department" => $department, "lengthOfSchooling" => $lengthOfSchooling));

        $result = $this->soapResultToJsonResult($soapResult);
        if ($result->resCode == self::successCode) {
            return $result->data->gradeList;
        }
        return array();

    }


    /*
    * 根据年级获取科目
    * gradeId	年级id
    * $notHasComp不包含文综理综 0或空：包含文综理综  1：不包含文综理综

    */
    public function loadSubjectByGrade($gradeId,$notHasComp){
        $soapResult = $this->_soapClient->loadSubjectByGrade(
            array(
                'gradeId' => $gradeId,
                'notHasComp'=>$notHasComp
            ));
         return  $this->soapResultToJsonResult($soapResult);
    }

}