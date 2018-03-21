<?php
namespace frontend\models;

use yii\base\Model;

/**
 * This is the model class for table "sh_school".
 *
 * The followings are the available columns in table 'sh_school':
 * @property integer $schoolID
public $userName
 * public $nickName
 * public $sex
 * public $birthday
 * public $passwd
 * public $salt
 * public $provience
 * public $city
 * public $county
 * public $email
 * public $phone
 * public $lastLoginTime
 * public $createTime
 * public $updateTime
 * @property integer $status
public $faceIcon
 * public $bankCardNo
 * public $initBankName
 * public $zhifubaoID
 * public $brief
 * public $schoolName
 * public $schoolAddress
 * public $schoolmasterName
 * public $identityNo
 * public $identityAttach
 * public $companyName
 * public $businessLicenseNo
 */
class SchoolForm extends Model
{
    public $schoolID;
    public $userName;
    public $nickName;
    public $sex;
    public $birthday;
    public $passwd;
    public $salt;
    public $provience;
    public $city;
    public $county;
    public $email;
    public $phone;
    public $lastLoginTime;
    public $createTime;
    public $updateTime;
    public $status;
    public $faceIcon;//头像
    public $bankCardNo;
    public $initBankName;
    public $zhifubaoID;
    public $brief;//简介
    public $schoolName;
    public $schoolAddress;
    public $schoolmasterName;
    public $identityNo;
    public $identityAttach;
    public $companyName;
    public $businessLicenseNo;
    public $trainCourse;
    public $trainGrade;
    public $businessLicenseAttach;
    public $department;//学部
    public $lengthOfSchooling;//学制
    public $beginTime; //新学制开始时间


    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            [['status'], 'numerical', 'integerOnly' => true],
            [['userName', 'nickName', 'passwd', 'salt', 'provience', 'city', 'county', 'bankCardNo', 'zhifubaoID', 'schoolName', 'companyName', 'businessLicenseNo'], 'length', 'max' => 50],
            [['sex'], 'length', 'max' => 10],
            [['phone'], 'match', 'pattern' => '/^[1][358]\d{9}$/', 'message' => '手机号格式有误'],
            [['email'], 'length', 'max' => 30],
            [[' schoolmasterName'], 'length', 'max' => 10, 'message' => '校长姓名不符合规范'],
            [['faceIcon', 'initBankName', 'identityAttach'], 'length', 'max' => 200],
            [['brief'], 'length', 'max' => 500],
            [['schoolAddress'], 'length', 'max' => 100],
            [['identityNo'], 'length', 'max' => 18],
            [['trainCourse', 'trainGrade', 'birthday', 'lastLoginTime', 'createTime', 'updateTime', 'businessLicenseAttach', 'lengthOfSchooling', 'beginTime', 'department'], 'safe'],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            [['schoolID', 'userName', 'nickName', 'sex', 'birthday', 'passwd', 'salt', 'provience', 'city', 'county', 'email', 'phone', 'lastLoginTime', 'createTime', 'updateTime', 'status', 'faceIcon', 'bankCardNo', 'initBankName', 'zhifubaoID', 'brief', 'schoolName', 'schoolAddress', 'schoolmasterName', 'identityNo', 'identityAttach', 'companyName', 'businessLicenseNo', 'businessLicenseAttach', 'department', 'lengthOfSchooling', 'beginTime'], 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'schoolID' => 'SchoolForm',
            'userName' => 'User Name',
            'nickName' => 'Nick Name',
            'sex' => 'Sex',
            'birthday' => 'Birthday',
            'passwd' => '密码',
            'repasswd' => '确认密码',
            'salt' => 'Salt',
            'provience' => 'Provience',
            'city' => 'City',
            'county' => 'County',
            'email' => '邮箱',
            'phone' => 'Phone',
            'lastLoginTime' => 'Last Login Time',
            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
            'faceIcon' => 'Face Icon',
            'bankCardNo' => 'Bank Card No',
            'initBankName' => 'Init Bank Name',
            'zhifubaoID' => 'Zhifubao',
            'brief' => 'Brief',
            'schoolName' => 'SchoolForm Name',
            'schoolAddress' => 'SchoolForm Address',
            'schoolmasterName' => 'Schoolmaster Name',
            'identityNo' => 'Identity No',
            'identityAttach' => 'Identity Attach',
            'companyName' => 'Company Name',
            'businessLicenseNo' => 'Business License No',
        );
    }
}
