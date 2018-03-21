<?php
/**
 * Created by PhpStorm.
 * User: WangShiKui
 * Date: 18-2-27
 * Time: 上午10:19
 */

namespace common\clients;


use common\components\MicroServiceRequest;
use common\models\pos\SeClassMembers;
use Httpful\Mime;
use Yii;

class OrganizationService
{
    /**
     * @var null
     */
    private $uri = null;
    private $microServiceRequest = null;
    private $host = null;

    /**
     * TestMicroService constructor.
     */
    public function __construct()
    {
        $this->uri = Yii::$app->params['microService'];
        $this->host = 'organization-service';
        $this->microServiceRequest = new MicroServiceRequest($this->host);
    }


    /**
     * 创建班级
     * @param int $userID
     * @param int $classNumber
     * @param int $departmentId
     * @param int $gradeId
     * @param int $joinYear
     * @param int $schoolID
     * @return \Httpful\Response
     */
    public function CreateClass(int $userID, int $classNumber, int $departmentId, int $gradeId, int $joinYear, int $schoolID)
    {
        $result = $this->microServiceRequest->post($this->uri . '/api/v2/organization/create-class')
            ->body(http_build_query(['school-id' => $schoolID, 'department-id' => $departmentId, 'grade-id' => $gradeId,
                'class-number' => $classNumber, 'join-year' => $joinYear, 'creator-id' => $userID]))
            ->sendsType(Mime::FORM)
            ->send();

        return $result->body;
    }

    /**
     * 添加老师到班级（没有班级则创建）
     * @param int $userID
     * @param int $classNumber
     * @param int $departmentId
     * @param int $gradeId
     * @param int $joinYear
     * @param int $schoolID
     * @return array|object|string
     */
    public function ClassAddTeacher(int $userID, int $classNumber, int $departmentId, int $gradeId, int $joinYear, int $schoolID)
    {
        $result = $this->microServiceRequest->post($this->uri . '/api/v2/organization/class-add-teacher')
            ->body(http_build_query(['school-id' => $schoolID, 'department-id' => $departmentId, 'grade-id' => $gradeId,
                'class-number' => $classNumber, 'join-year' => $joinYear, 'creator-id' => $userID]))
            ->sendsType(Mime::FORM)
            ->send();

        return $result->body;
    }

    /**
     * 封班
     * @param string $classIds
     * @param int $schoolID
     * @return array|object|string
     */
    public function CloseClass(string $classIds, int $schoolID)
    {
        $result = $this->microServiceRequest->post($this->uri . '/api/v2/organization/close-class')
            ->body(http_build_query(['school-id' => $schoolID, 'class-ids' => $classIds]))
            ->sendsType(Mime::FORM)
            ->send();

        return $result->body;
    }


    /**
     * 踢出班级
     * @param int $userID
     * @param int $classId
     * @param bool $ifCleanToken
     * @return array|object|string
     */
    public function OutClass(int $userID, int $classId, bool $ifCleanToken = true)
    {
        $result = $this->microServiceRequest->post($this->uri . '/api/v2/organization/out-class')
            ->body(http_build_query(['class-id' => $classId, 'user-id' => $userID, 'if-clean-token' => $ifCleanToken]))
            ->sendsType(Mime::FORM)
            ->send();

        return $result->body;
    }

    /**
     * 踢出学校
     * @param int $userID
     * @return array|object|string
     */
    public function OutSchool(int $userID)
    {
        $result = $this->microServiceRequest->post($this->uri . '/api/v2/organization/out-school')
            ->body(http_build_query(['user-id' => $userID]))
            ->sendsType(Mime::FORM)
            ->send();

        return $result->body;
    }

    /**
     * 跨学校更新班级
     * @param string $userIds
     * @param int $classId
     * @param int $departmentId
     * @param int $identity
     * @param int $schoolID
     * @param bool $ifCleanToken
     * @return array|object|string
     */
    public function SpanSchoolUpdateClass(string $userIds, int $classId, int $departmentId, int $schoolID,
                                          int $identity = SeClassMembers::STUDENT,  bool $ifCleanToken = true)
    {
        $result = $this->microServiceRequest->post($this->uri . '/api/v2/organization/span-school-update-class')
            ->body(http_build_query(['school-id' => $schoolID, 'department-id' => $departmentId, 'class-id' => $classId,
                'identity' => $identity, 'user-ids' => $userIds, 'if-clean-token' => $ifCleanToken]))
            ->sendsType(Mime::FORM)
            ->send();

        return $result->body;
    }

    /**
     * 老师更新班级信息
     * @param int $userID
     * @param string $classIds
     * @param bool $ifOnlyAdd
     * @param bool $ifCleanToken
     * @return array|object|string
     */
    public function ChangeTeacherClass(int $userID, string $classIds, bool $ifOnlyAdd = false,  bool $ifCleanToken = true)
    {
        $result = $this->microServiceRequest->post($this->uri . '/api/v2/organization/change-teacher-class')
            ->body(http_build_query(['user-id' => $userID, 'class-ids' => $classIds, 'if-only-add' => $ifOnlyAdd, 'if-clean-token' => $ifCleanToken]))
            ->sendsType(Mime::FORM)
            ->send();

        return $result->body;
    }

    /**
     * 学校升级
     * @param int $departmentId
     * @param int $schoolID
     * @return array|object|string
     */
    public function SchoolUpgrade(int $departmentId, int $schoolID)
    {
        $result = $this->microServiceRequest->post($this->uri . '/api/v2/organization/school-upgrade')
            ->body(http_build_query(['school-id' => $schoolID, 'department-id' => $departmentId]))
            ->sendsType(Mime::FORM)
            ->send();

        return $result->body;
    }

    /**
     * 通过邀请码加入班级
     * @param int $userID
     * @param string $inviteCode
     * @return array|object|string
     */
    public function AddClass(int $userID, string $inviteCode)
    {
        $result = $this->microServiceRequest->post($this->uri . '/api/v2/organization/add-class')
            ->body(http_build_query(['invite-code' => $inviteCode, 'user-id' => $userID]))
            ->sendsType(Mime::FORM)
            ->send();
        return $result->body;
    }

}