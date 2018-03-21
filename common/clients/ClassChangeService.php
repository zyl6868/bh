<?php
namespace common\clients;

use Httpful\Mime;
use Httpful\Request;
use Yii;

/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2016/7/22
 * Time: 17:09
 */
class ClassChangeService
{
	private $uri = null;

	public function __construct()
	{
		$this->uri = Yii::$app->params['banhai_webService'];
	}


	/**
	 * 封班
	 * @param  integer $schoolId 学校ID
	 * @param  string $classIds 班级ID(以逗号链接的字符串)
	 * @return mixed
	 * @throws \Httpful\Exception\ConnectionErrorException
	 */
	public function CloseClass($schoolId, $classIds)
	{
		$result = Request::post($this->uri . '/schoolManage/class-closes')
			->body(http_build_query(['schoolID' => $schoolId, 'classID' => $classIds]))
			->sendsType(Mime::FORM)
			->send();
		return $result->body;
	}


	/**
	 * 升级
	 * @param integer $schoolId 学校ID
	 * @param integer $departmentId 学段ID
	 * @return mixed
	 * @throws \Httpful\Exception\ConnectionErrorException
	 */
	public function SchoolUpgrade($schoolId, $departmentId)
	{
		$result = Request::post($this->uri . '/schoolManage/school-upgrades')
			->body(http_build_query(['schoolID' => $schoolId, 'department' => $departmentId]))
			->sendsType(Mime::FORM)
			->send();
		return $result->body;
	}


	/**
	 * 修改身份
	 * @param integer $userID 用户ID
	 * @param integer $classID 班级ID
	 * @param integer $identityID 身份ID
	 * @return mixed
	 * @throws \Httpful\Exception\ConnectionErrorException
	 */
	public function ChangeIdentity(int $userID, int $classID, int $identityID)
	{
		$result = Request::post($this->uri . '/schoolManage/identity-changes')
			->body(http_build_query(['userID' => $userID, 'classID' => $classID, 'identity' => $identityID]))
			->sendsType(Mime::FORM)
			->send();
		return $result->body;
	}


	/**
	 * 创建班级
	 * @param integer $schoolID 学校ID
	 * @param integer $gradeID 年级ID
	 * @param integer $department 学段ID
	 * @param integer $classNumber 第几班
	 * @param integer $joinYear 年份
	 * @param string $className 班级名称
	 * @param integer $creatorID 创建人ID
	 * @return mixed
	 * @throws \Httpful\Exception\ConnectionErrorException
	 */
	public function CreateClass($schoolID, $gradeID, $department, $classNumber, $joinYear, $className, $creatorID)
	{
		$result = Request::post($this->uri . '/schoolManage/create-classes')
			->body(http_build_query(['schoolID' => $schoolID, 'gradeID' => $gradeID, 'department' => $department, 'classNumber' => $classNumber,
				'joinYear' => $joinYear, 'className' => $className, 'creatorID' => $creatorID]))
			->sendsType(Mime::FORM)
			->send();
		return $result->body;
	}


	/**
	 * 老师调班
	 * @param integer $userID 用户ID
	 * @param string $classID 班级ID
	 * @return mixed
	 * @throws \Httpful\Exception\ConnectionErrorException
	 */
	public function TeacherChangeClass(int $userID, string $classID)
	{
		$result = Request::post($this->uri . '/schoolManage/teacher-class-changes')
			->body(http_build_query(['userID' => $userID, 'classID' => $classID]))
			->sendsType(Mime::FORM)
			->send();
		return $result->body;
	}


	/**
	 * 添加老师
	 * @param integer $userId 用户ID
	 * @param integer $classId 班级ID
	 * @return mixed
	 * @throws \Httpful\Exception\ConnectionErrorException
	 */
	public function AddTeacher(int $userId, int $classId)
	{
		$result = Request::post($this->uri . '/schoolManage/add-teachers')
			->body(http_build_query(['userID' => $userId, 'classID' => $classId]))
			->sendsType(Mime::FORM)
			->send();
		return $result->body;
	}

    /**
     * 新添加老师
     * @param integer $schoolID 用户ID
     * @param string $trueName 班级ID
     * @param integer $bindphone 手机号
     * @param integer $sex 性别
     * @param integer $department 学部
     * @param integer $subjectID 学科
     * @param integer $textbookVersion 版本
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function NewAddTeacher(int $schoolID,string $trueName,int $bindphone,int $sex,int $department, int $subjectID, int $textbookVersion)
    {
        $result = Request::post($this->uri . '/schoolManage/new-add-teachers')
            ->body(http_build_query(['schoolID' => $schoolID, 'trueName' => $trueName, 'bindphone' => $bindphone, 'sex' => $sex, 'department' => $department, 'subjectID' => $subjectID, 'textbookVersion' => $textbookVersion]))
            ->sendsType(Mime::FORM)
            ->send();
        return $result->body;
    }

	/**
	 * 添加学生
	 * @param integer $schoolID 学校ID
	 * @param integer $classID 班级ID
	 * @param string $stuID 学号
	 * @param string $trueName 真实名称
	 * @param string $phone 手机号
	 * @param integer $sex 性别
	 * @param string $phoneReg 账号
	 * @param string $parentsName 家长姓名
	 * @param string $bindphone 家长手机号
	 * @param integer $department 学段
	 * @return mixed
	 * @throws \Httpful\Exception\ConnectionErrorException
	 */
	public function AddStudent(int $schoolID, int $classID, string $stuID, string $trueName, string $phone, int $sex, string $phoneReg, string $parentsName, string $bindphone, int $depratment)
	{
		$result = Request::post($this->uri . "/schoolManage/add-students")
			->body(http_build_query(["schoolID" => $schoolID, "classID" => $classID, 'stuID' => $stuID, 'trueName' => $trueName,
				'phone' => $phone, 'sex' => $sex, 'phoneReg' => $phoneReg, 'parentsName' => $parentsName, 'bindphone' => $bindphone, 'department' => $depratment]))
			->sendsType(Mime::FORM)
			->send();
		return $result->body;
	}

	/**
	 * 添加学生
	 * @param integer $schoolID 学校ID
	 * @param integer $classID 班级ID
	 * @param string $stuID 学号
	 * @param string $trueName 真实名称
	 * @param string $phone 手机号
	 * @param integer $sex 性别
	 * @param string $phoneReg 账号
	 * @param string $parentsName 家长姓名
	 * @param string $bindphone 家长手机号
	 * @param integer $department 学段
	 * @return mixed
	 * @throws \Httpful\Exception\ConnectionErrorException
	 */
	public function ModifyStudent(int $schoolID, int $classID, string $stuID, string $trueName, string $phone, int $sex, string $phoneReg, string $parentsName, string $bindphone, int $department)
	{

		$result = Request::post($this->uri . "/schoolManage/modify-students")
			->body(http_build_query(["schoolID" => $schoolID, "classID" => $classID, 'stuID' => $stuID, 'trueName' => $trueName,
				'phone' => $phone, 'sex' => $sex, 'phoneReg' => $phoneReg, 'parentsName' => $parentsName, 'bindphone' => $bindphone, 'department' => $department]))
			->sendsType(Mime::FORM)
			->send();
		return $result->body;
	}


	/**
	 * 学生调班
	 * @param integer $schoolId 学校ID
	 * @param integer $departmentId 学段ID
	 * @param integer $classId 班级ID
	 * @param integer $userId 用户ID
	 * @return mixed
	 * @throws \Httpful\Exception\ConnectionErrorException
	 */
	public function ChangeStudentClass(int $schoolId, int $departmentId, int $classId, int $userId)
	{
		$result = Request::post($this->uri . "/schoolManage/student-class-changes")
			->body(http_build_query(["schoolID" => $schoolId, "department" => $departmentId, 'classID' => $classId, 'userID' => $userId]))
			->sendsType(Mime::FORM)
			->send();
		return $result->body;
	}


	/**
	 * 移出班级
	 * @param integer $userID 用户ID
	 * @param integer $classID 班级ID
	 * @return mixed
	 * @throws \Httpful\Exception\ConnectionErrorException
	 */
	public function DelUserClass(int $userID, int $classID)
	{
		$result = Request::post($this->uri . '/schoolManage/out-classes')
			->body(http_build_query(['userID' => $userID, 'classID' => $classID]))
			->sendsType(Mime::FORM)
			->send();
		return $result->body;
	}


	/**
	 * 移出学校
	 * @param integer $userID 用户ID
	 * @param integer $schoolID 学校ID
	 * @return mixed
	 * @throws \Httpful\Exception\ConnectionErrorException
	 */
	public function DelUserSchool(int $userID, int $schoolID)
	{
		$result = Request::post($this->uri . '/schoolManage/out-schools')
			->body(http_build_query(['userID' => $userID, 'schoolID' => $schoolID]))
			->sendsType(Mime::FORM)
			->send();
		return $result->body;
	}

	/**
	 * 个人中心 邀请码查询班级
	 * @param integer $userID 用户ID
	 * @param string $inviteCode 邀请码
	 * @return mixed
	 * @throws \Httpful\Exception\ConnectionErrorException
	 */
	public function classInviteCode(int $userID,string $inviteCode)
	{
		$result = Request::post($this->uri . "/schoolManage/class-invite-codes")
				->body(http_build_query(["userID" => $userID, 'inviteCode' => $inviteCode]))
				->sendsType(Mime::FORM)
				->send();
		return $result->body;
	}

	/**
	 * 个人中心 邀请码加入班级
	 * @param integer $userID 用户ID
	 * @param string $inviteCode 邀请码
	 * @return mixed
	 * @throws \Httpful\Exception\ConnectionErrorException
	 */
	public function centerInviteCode($userID, $inviteCode)
	{
		$result = Request::post($this->uri . "/schoolManage/center-invite-codes")
			->body(http_build_query(["userID" => $userID, 'inviteCode' => $inviteCode]))
			->sendsType(Mime::FORM)
			->send();
		return $result->body;
	}

	/**
	 * 注册完后 邀请码加入班级
	 * @param integer $userID 用户ID
	 * @param string $inviteCode 邀请码
	 * @return mixed
	 * @throws \Httpful\Exception\ConnectionErrorException
	 */
	public function loginInviteCodes($userID, $inviteCode)
	{
		$result = Request::post($this->uri . "/schoolManage/login-invite-codes")
				->body(http_build_query(["userID" => $userID, 'inviteCode' => $inviteCode]))
				->sendsType(Mime::FORM)
				->send();
		return $result->body;
	}


    /**
     * 创建加入班级
     * @param integer $schoolID 学校ID
     * @param integer $gradeID 年级ID
     * @param string $department 学段ID
     * @param integer $classNumber 第几班
     * @param integer $joinYear 年份
     * @param integer $userId 创建人ID
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function CreateJoinClass(int $schoolID,int $gradeID,string $department,int $classNumber,int $joinYear,int $userId)
    {
        $result = Request::post($this->uri . '/schoolManage/class-add-teachers')
            ->body(http_build_query(['school-id' => $schoolID, 'grade-id' => $gradeID, 'department' => $department, 'class-number' => $classNumber, 'join-year' => $joinYear, 'user-id' => $userId]))
            ->sendsType(Mime::FORM)
            ->send();
        return $result;
    }

}