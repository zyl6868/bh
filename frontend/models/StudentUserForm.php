<?php
namespace frontend\models;

use common\models\pos\SeUserinfo;
use yii\base\Model;

/**
 * Created by 王
 * User: Administrator
 * Date: 14-9-10
 * Time: 上午11:46
 */
class StudentUserForm extends Model
{
    /** 用户ID */
    public $userID;

    /**
     * 学校ID
     */
    public $schoolId;
    /*
     * 学校名称
     */
    public $schoolName;

    /** 教材版本
     * @var
     */
    public $textbookVersion;

    /**
     *  学段
     */
    public $department;
    /**
     * @var 班级ID
     */
    public $classId;

    /**
     * @var 班级名称
     */
    public $className;
    /**
     * @var 班内职务（学生用户）
     */
    public $identity;
    /**
     * @var  班内职务名称（学生用户）
     */
    public $identityDes;
    /**
     * @var  学号
     */
    public $stuID;


    /**
     * @var
     * 真实姓名
     */
    public $trueName;

    /**
     * @var
     * 手机号
     */
    public $phone;

    /**
     * 班级职务
     * @var
     */
    public $job;


    /**
     * 班级成员id
     * @var
     */
    public $classMemID;


    public function rules()
    {
        return [
            [['schoolName', 'department', 'className'], 'required'],
            [['job', 'schoolId', 'schoolName', 'department', 'classId', 'className', 'identity', 'identityDes', 'stuID', 'textbookVersion', 'trueName', 'phone', 'classMemID'], 'safe'],
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
            'job' => 'job',
            'subjectID' => '科目',
            'classMemID' => 'classMemID'
        );
    }

    /**
     * @param $u SeUserinfo
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
        $this->classMemID = $u->classMemID;
        $items = $u->getUserClassGroup();
        if (count($items) > 0) {
            $this->classId = $items[0]->classID;
            $this->className = WebDataCache::getClassesName($items[0]->classID);
            $this->identity = $items[0]->identity;
            $this->job = $items[0]->job;
            $this->stuID = $items[0]->stuID;

        }
    }


}