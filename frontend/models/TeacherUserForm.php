<?php
namespace frontend\models;

use common\models\pos\SeUserinfo;

/**
 * Created by 王
 * User: Administrator
 * Date: 14-9-10
 * Time: 上午11:46
 */
class  TeacherUserForm extends UserForm
{


    public function rules()
    {
        return [
            [['department', 'textbookVersion'], 'required'],
            [['provience', 'city', 'county', 'schoolId', 'schoolName', 'department', 'identity', 'identityDes', 'stuID', 'teacherClass', 'schoolIdentity', 'textbookVersion', 'trueName', 'phone', 'subjectID'], 'safe'],
        ];
    }


    public function attributeLabels()
    {
        return array(
            'provience' => '省',
            'city' => '市',
            'county' => '区',
            'schoolId' => 'schoolId',
            'schoolName' => '学校名称',
            'department' => '学段',
            'classId' => 'classId',
            'identity' => '职务',
            'className' => '班级',
            'identityDes' => 'identityDes',
            'stuID' => '学校',
            'teacherClass' => 'teacherClass',
            'trueName' => '真实姓名',
            'phone' => '手机号',
            'subjectID' => '科目'
        );
    }

    /**
     * @param $u   SeUserinfo
     */
    public function  parseUserInfo($u)
    {
        $this->city = $u->city;
        $this->county = $u->country;
        $this->provience = $u->provience;
        $this->department = $u->department;
        $this->schoolId = $u->schoolID;
        $this->userID = $u->userID;
        $this->schoolName = $u->schoolName;
        $this->trueName = $u->trueName;
        $this->phone = $u->phone;
        $this->stuID = $u->stuID;
        $this->textbookVersion = $u->textbookVersion;
        $this->subjectID = $u->subjectID;

    }


}