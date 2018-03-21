<?php
namespace frontend\models;

use common\models\pos\SeUserControl;
use common\models\pos\SeUserinfo;
use yii\base\Model;

class TeacherRegisterForm extends Model
{

    /**
     * @var  string 真实姓名
     */
    public $trueName;
    /**
     * @var  int 性别
     */
    public $sex = 0;
    /**
     * @var string 登录名
     */
    public $phoneReg;
    /**
     * @var string 密码
     */
    public $passwd;
    /**
     * @var string 确认密码
     */
    public $repasswd;
    /**
     * @var int 默认老师
     */
    public $type = 1;

    /**
     * @var string 手机号
     */
    public $mobile;
    /**
     * @var string 图片验证码
     */
    public $imgverifycode;
    /**
     * @var string 手机验证码
     */
    public $verifycode;
    /**
     * @var string 学部
     */
    public $department;
    /**
     * @var string 学科
     */
    public $subjectID;
    /**
     * @var string 教材版本
     */
    public $textbookVersion;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [

            [['trueName', 'passwd', 'repasswd', 'phoneReg','mobile','verifycode','type','department','subjectID','textbookVersion','sex'], 'required', 'message' => '此处不能为空'],

            [['passwd'], 'string', 'min' => 6, 'max' => 20, 'message' => '请输入6-20位字母和数字'],

            [['sex'], 'in','range'=>[0,1,2]],

            [['mobile'], 'checkPhoneNumber'],

            [['phoneReg'], 'checkPhoneReg'],

            [['verifycode'], 'checkVerifycode'],

            [['repasswd'], 'compare', 'compareAttribute' => 'passwd', 'message' => '两次密码输入不相同'],
            [['passwd','mobile', 'trueName', 'phoneReg'], "safe"],
        ];
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'trueName' => '姓名',
            'sex'=>'性别',
            'phoneReg' => '登录名',
            'passwd' => '密码',
            'repasswd' => '确认密码',
            'type' => '身份',
            'mobile' => '手机号',
            'imgverifycode' => '图片验证码',
            'verifycode' => '验证码',
            'department' => '学部',
            'subjectID' => '学科',
            'textbookVersion' => '版本'

        );
    }

    /**
     * 验证注册手机号是否已经被使用
     * @param $attribute
     * @param $params
     */
    public function checkPhoneNumber($attribute, $params)
    {
        $phone = $this->mobile;
        $info = SeUserinfo::find()->where(['phone'=>$phone])->one();
        if ($info) {
            $this->addError($attribute, '此手机号已被其他人使用!');
        }
    }


    /**
     * 验证验证码是否匹配
     * @param $attribute
     * @param $params
     */
    public function checkVerifycode($attribute, $params)
    {
        $phone = $this->mobile;
        $verifycode = $this->verifycode;
        $userControl = SeUserControl::find()->where(['phoneReg' => $phone])->orderBy('generateCodeTime desc')->one();

        if($userControl){
            $generateCodeTime = $userControl->generateCodeTime;
            if((time()-$generateCodeTime/1000) < 1800){
                $activateMailCode = $userControl->activateMailCode;
                if($verifycode != $activateMailCode){
                    $this->addError($attribute, '验证码不匹配!');
                }
            }else{
                $this->addError($attribute, '验证码超时!');
            }

        }else{
            $this->addError($attribute, '验证码不匹配!');
        }
    }

    /**
     * 检查登录名是否被其他人使用
     * @param $attribute
     * @param $params
     */
    public function checkPhoneReg($attribute, $params)
    {
        $phoneReg = $this->phoneReg;
        $phoneRegLen = mb_strlen($phoneReg,'utf-8');
        if($phoneRegLen < 5 || $phoneRegLen > 20){
            $this->addError($attribute,'用户名长度必须介于5-20个字符之间');
        }else{
            $info = SeUserinfo::find()->where(['phoneReg'=>$phoneReg])->one();
            if ($info) {
                $this->addError($attribute, '此登录名已被其他人使用!');
            }
        }

    }



}
