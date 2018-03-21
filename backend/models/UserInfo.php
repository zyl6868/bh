<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "UserInfo".
 *
 * @property integer $userID
 * @property string $email
 * @property string $gradeID
 * @property string $nickName
 * @property string $phone
 * @property string $testCode
 * @property string $invitationCode
 * @property string $trueName
 * @property string $faceIcon
 * @property string $sex
 * @property string $Birthday
 * @property string $provience
 * @property string $city
 * @property string $county
 * @property string $bankCardNo
 * @property string $initBankName
 * @property string $zhifubaoID
 * @property string $stuSchoolName
 * @property string $weakAtCourse
 * @property string $parentsName
 * @property string $parentsTel
 * @property string $goodAtCourse
 * @property string $strongPoint
 * @property string $interest
 * @property string $brief
 * @property string $goodAtGrade
 * @property string $teachCourse
 * @property string $jobTitle
 * @property string $teachingPerformance
 * @property string $awards
 * @property string $schoolName
 * @property string $schoolAddress
 * @property string $trainCourse
 * @property string $trainGrade
 * @property string $schoolmasterName
 * @property string $identityNo
 * @property string $identityAttach
 * @property string $companyName
 * @property string $businessLicenseNo
 * @property string $businessLicenseAttach
 * @property string $lastLoginTime
 * @property string $createTime
 * @property string $updateTime
 * @property integer $type
 * @property integer $statu
 * @property integer $useStatu
 * @property integer $backPwdNum
 * @property string $backPwdTIME
 * @property string $sendTimeTest
 * @property string $resetPasswdToken
 * @property string $resetPasswdTm
 * @property string $userName
 * @property string $passwd
 */
class UserInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'UserInfo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'statu', 'useStatu', 'backPwdNum'], 'integer'],
            [['backPwdTIME'], 'safe'],
            [['email'], 'string', 'max' => 30],
            [['gradeID', 'phone', 'trueName', 'Birthday', 'parentsName', 'parentsTel', 'jobTitle', 'schoolmasterName', 'lastLoginTime', 'createTime', 'updateTime', 'resetPasswdTm'], 'string', 'max' => 20],
            [['nickName', 'testCode', 'invitationCode', 'provience', 'city', 'county', 'bankCardNo', 'zhifubaoID', 'stuSchoolName', 'goodAtCourse', 'goodAtGrade', 'teachCourse', 'schoolName', 'trainCourse', 'trainGrade', 'companyName', 'businessLicenseNo'], 'string', 'max' => 50],
            [['faceIcon', 'initBankName', 'teachingPerformance', 'awards', 'identityAttach', 'businessLicenseAttach'], 'string', 'max' => 200],
            [['sex'], 'string', 'max' => 10],
            [['weakAtCourse', 'strongPoint', 'interest', 'brief', 'resetPasswdToken'], 'string', 'max' => 500],
            [['schoolAddress', 'sendTimeTest'], 'string', 'max' => 100],
            [['identityNo'], 'string', 'max' => 18],
            [['userName', 'passwd'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userID' => 'User ID',
            'email' => 'Email',
            'gradeID' => 'Grade ID',
            'nickName' => 'Nick Name',
            'phone' => 'Phone',
            'testCode' => 'Test Code',
            'invitationCode' => 'Invitation Code',
            'trueName' => 'True Name',
            'faceIcon' => 'Face Icon',
            'sex' => 'Sex',
            'Birthday' => 'Birthday',
            'provience' => 'Provience',
            'city' => 'City',
            'county' => 'County',
            'bankCardNo' => 'Bank Card No',
            'initBankName' => 'Init Bank Name',
            'zhifubaoID' => 'Zhifubao ID',
            'stuSchoolName' => 'Stu School Name',
            'weakAtCourse' => 'Weak At Course',
            'parentsName' => 'Parents Name',
            'parentsTel' => 'Parents Tel',
            'goodAtCourse' => 'Good At Course',
            'strongPoint' => 'Strong Point',
            'interest' => 'Interest',
            'brief' => 'Brief',
            'goodAtGrade' => 'Good At Grade',
            'teachCourse' => 'Teach Course',
            'jobTitle' => 'Job Title',
            'teachingPerformance' => 'Teaching Performance',
            'awards' => 'Awards',
            'schoolName' => 'School Name',
            'schoolAddress' => 'School Address',
            'trainCourse' => 'Train Course',
            'trainGrade' => 'Train Grade',
            'schoolmasterName' => 'Schoolmaster Name',
            'identityNo' => 'Identity No',
            'identityAttach' => 'Identity Attach',
            'companyName' => 'Company Name',
            'businessLicenseNo' => 'Business License No',
            'businessLicenseAttach' => 'Business License Attach',
            'lastLoginTime' => 'Last Login Time',
            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',
            'type' => 'Type',
            'statu' => 'Statu',
            'useStatu' => 'Use Statu',
            'backPwdNum' => 'Back Pwd Num',
            'backPwdTIME' => 'Back Pwd Time',
            'sendTimeTest' => 'Send Time Test',
            'resetPasswdToken' => 'Reset Passwd Token',
            'resetPasswdTm' => 'Reset Passwd Tm',
            'userName' => 'User Name',
            'passwd' => 'Passwd',
        ];
    }
}
