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
 * This is the model class for table "{{Student}}".
 *
 * The followings are the available columns in table '{{Student}}':
 * @property integer $userID
 * @property integer $gradeID
 * @property string $userName
 * @property string $nickName
 * @property string $sex
 * @property string $birthday
 * @property string $passwd
 * @property string $salt
 * @property string $provience
 * @property string $city
 * @property string $county
 * @property string $email
 * @property string $phone
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
 */
class StudentForm extends Model
{

    public $userID;
    public $sex;
    public $passwd;
    public $provience;
    public $city;
    public $county;
    public $email;
    public $phone;
    public $createTime;
    public $updateTime;
    public $brief;
    public $parentsName;
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
            [['phone'], 'match', 'pattern' => '/^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/', 'message' => '家长手机号格式有误'],
            [['bindphone'], 'match', 'pattern' => '/^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/', 'message' => '手机号格式有误'],
//            [[ 'passwd', 'provience', 'city', 'county'], 'length', 'max' => 50],
//            [['sex'], 'length', 'max' => 10],
//            [['email'], 'length', 'max' => 30],
//            [['phone', 'parentsName','trueName'], 'length', 'max' => 20],
            [[ 'createTime', 'updateTime'], 'safe'],
            // The following rule is used by search().

            [['userID', 'userName', 'sex',  'passwd', 'provience', 'city', 'county', 'email', 'phone',  'createTime', 'updateTime', 'status',  'parentsName',  'trueName','bindphone','schoolId','type','phoneReg'], 'safe', 'on' => 'search'],
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

            'passwd' => '密码',

            'provience' => 'Provience',
            'city' => 'City',
            'county' => 'County',
            'email' => '邮箱',
            'phone' => 'Phone',

            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',


            'parentsName' => 'Parents Name',


            'trueName' => 'True Name',
           'bindphone'=>'bindphone',
            'phoneReg'=>'phoneReg',
            'schoolId'=>'schoolId',
            'type'=>'type'

        );
    }


}
