<?php
declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 17-7-2
 * Time: 11:00
 */
namespace common\clients;

use common\components\MicroServiceRequest;
use Httpful\Mime;
use Yii;

class SearchSchoolMicroService
{
    /**
     * @var null
     */
    private $uri = null;
    private $microServiceRequest = null;
    private $host = null;

    /**
     * XuemiMicroService constructor.
     */
    public function __construct()
    {
        $this->uri = Yii::$app->params['microService'];
        $this->host = 'user-base-service';
        $this->microServiceRequest = new MicroServiceRequest($this->host);
    }

    /**
     * 根据地区查询学校（老师）
     * @param string $county
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getSchoolByCounty(string $county)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/school/country?'. http_build_query(['country' => $county]))
            ->sendsType(Mime::JSON)
            ->send();
        return $result->body;
    }

    /**
     * 根据名称查询学校（老师）
     * @param string $schoolName
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getSchoolByName(string $schoolName)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/school/school-name/'.$schoolName)
            ->sendsType(Mime::JSON)
            ->send();
        return $result->body;
    }


    /**
     * 根据名称查询学校（老师）
     * @param integer $departmentId
     * @param integer $schoolId
     * @return mixed
     */
    public function getClassListBySchool(int $departmentId,int $schoolId)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/class/school/'.$schoolId.'?'.http_build_query(['department'=>$departmentId]))
            ->sendsType(Mime::JSON)
            ->send();
        return $result->body;
    }

    /**
     * 判断是否存在班级
     * @param integer $schoolId
     * @param integer $gradeId
     * @param string $classId
     * @param string $joinYear
     * @return mixed
     */
    public function findClassOne(int $schoolId,int $gradeId,string $classId,string $joinYear)
    {

        $result = $this->microServiceRequest->get($this->uri . '/v1/class/conditions?'.http_build_query(['school-id' => $schoolId,'grade-id'=>$gradeId,'class-number'=>$classId,'join-year'=>$joinYear]))
            ->sendsType(Mime::JSON)
            ->send();
        return $result->body;
    }

    /**
     * 创建班级
     * @param int $userId
     * @param int $schoolId
     * @param string $departmentId
     * @param int $gradeId
     * @param string $classId
     * @param string $joinYear
     * @return mixed
     */
    public function createClass(int $userId,int $schoolId,string $departmentId,int $gradeId,string $classId,string $joinYear)
    {

        $result = $this->microServiceRequest->post($this->uri . '/v1/class')
            ->body(http_build_query(['creator-id' => $userId, 'school-id' => $schoolId,'department'=>$departmentId,'grade-id'=>$gradeId,'class-number'=>$classId,'join-year'=>$joinYear]))
            ->sendsType(Mime::FORM)
            ->send();
        return $result->body;
    }

    /**
     * 申请学校
     * @param integer $userId
     * @param string $applySchoolName
     * @param string $provinceId
     * @param string $cityId
     * @param string $countryId
     * @return \Httpful\associative|string
     */
    public function applySchool(int $userId,string $applySchoolName,string $provinceId,string $cityId,string $countryId)
    {

        $result = $this->microServiceRequest->post($this->uri . '/v1/school/create/apply')
            ->body(http_build_query(['user-id' => $userId, 'school-name' => $applySchoolName,'provience'=>$provinceId,'city'=>$cityId,'country'=>$countryId]))
            ->sendsType(Mime::FORM)
            ->send();
        return $result;
    }


}