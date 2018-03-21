<?php
namespace frontend\models;

use yii\base\Model;

/**
 * Created by wangchunlei
 * User: Administrator
 * Date: 14-9-29
 * Time: 上午9:58
 */
class EditEmailForm extends Model
{
    public $passwd;
    public $afterEmail;
    public $email;

    public function rules()
    {
        return [
            [["passwd", "afterEmail"], 'required',],
            [["passwd"], 'length', 'min' => 6, 'max' => 20,],
            [["passwd"], "setEmail",],
            [["passwd", "afterEmail"], "email", "safe",]
        ];
    }

    public function attributeLabels()
    {
        return array(
            "passwd" => "密码",
            "afterEmail" => "新邮箱",
            "email" => "旧邮箱"
        );
    }

    /**
     * @param $attribute
     * 修改邮箱
     */
    public function  setEmail($attribute)
    {

        $email = $this->email;
        $passwd = $this->passwd;
        $afterEmail = $this->afterEmail;
        $student = new pos_UserRegisterService();
        $result = $student->updateEmail($email, $afterEmail, $passwd);
        if ($result->resCode != pos_UserRegisterService::successCode) {
            user()->getModel(false);
            $this->addError($attribute, "邮箱密码不匹配无法修改邮箱");
        }

    }
}
