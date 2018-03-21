<?php
/**
 * Created by PhpStorm.
 * User: wangchunlei
 * Date: 2016/7/18
 * Time: 11:15
 */
namespace schoolmanage\models;

use yii\base\Model;

/**
 * This is the model class for table "{{Teacher}}".
 *
 * The followings are the available columns in table '{{Teacher}}':
 * @property integer $userID
 * @property integer $gradeID
 * @property string $userName
 * @property string $nickName
 * @property string $sex
 * @property string $department
 * @property string $subjectID
 * @property string $textbookVersion
 * @property string $birthday
 * @property string $passwd
 * @property string $salt
 * @property string $provience
 * @property string $city
 * @property string $county
 * @property string $email
 * @property string $lastLoginTime
 * @property string $createTime
 * @property string $updateTime
 * @property integer $status
 * @property string $faceIcon
 * @property string $bankCardNo
 * @property string $initBankName
 * @property string $zhifubaoID
 * @property string $brief
 * @property string $parentsName
 * @property string $parentsTel
 * @property string $strongPoint
 * @property string $interest
 * @property string $invitationCode
 * @property string $trueName
 * @property string $goodAtCourse
 * @property string $hobby
 * @property string $bindphone
 * @property string $phoneReg
 */
class TeacherForm extends Model
{

    public $userID;
    public $sex;
    public $department;
    public $subjectID;
    public $texbookVersion;
    public $passwd;
    public $provience;
    public $city;
    public $county;
    public $email;
    public $createTime;
    public $updateTime;
    public $brief;
    public $trueName;
    public $bindphone;
    public $phoneReg;
    public $schoolId;
    public $type;



    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            [['bindphone'], 'match', 'pattern' => '/^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/', 'message' => '手机号格式有误'],
            [[ 'createTime', 'updateTime'], 'safe'],
            [['userID', 'userName', 'sex', 'department', 'subjectID', 'texbookVersion',  'passwd', 'provience', 'city', 'county', 'email', 'createTime', 'updateTime', 'status', 'trueName','bindphone','schoolId','type','phoneReg'], 'safe', 'on' => 'search'],
        ];
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'userID' => 'User',
            'sex' => 'Sex',
            'department' => 'department',
            'subjectID' => 'subjectID',
            'texbookVersion' => 'texbookVersion',
            'passwd' => '密码',
            'provience' => 'Provience',
            'city' => 'City',
            'county' => 'County',
            'email' => '邮箱',
            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',
            'trueName' => 'True Name',
            'bindphone'=>'bindphone',
            'phoneReg'=>'phoneReg',
            'schoolId'=>'schoolId',
            'type'=>'type'
        );
    }


}
