<?php
namespace frontend\models;

use common\models\pos\SeUserinfo;
use yii\base\Model;

/**
 * Created by wangchunlei
 * User: Administrator
 * Date: 14-9-29
 * Time: 上午9:42
 */
class EditPasswordForm extends Model
{
	public $oldpasswd;
	public $passwd;
	public $repasswd;
	public $userId;

	public function rules()
	{
		return [
			[["oldpasswd", "passwd", "repasswd"], 'required',],
			[["oldpasswd"], "updatePassWord",],
			[["oldpasswd"], 'string', 'min' => 6, 'max' => 20,],
			[["passwd"], 'string', 'min' => 6, 'max' => 20,],
			[["repasswd"], 'string', 'min' => 6, 'max' => 20,],
			[["repasswd"], 'compare', 'compareAttribute' => 'passwd', 'message' => '两次密码输入不相同'],
			[["passwd", "oldpasswd", "repasswd"], "safe"]
		];
	}

	public function attributeLabels()
	{
		return array(
			"userId" => "用户Id",
			"oldpasswd" => "当前密码",
			"passwd" => "新密码",
			"repasswd" => "确认密码",
		);
	}

	/**
	 * @param $attribute
	 * @param $params
	 * 修改密码
	 */
	public function  updatePassWord($attribute, $params)
	{
		$userId = $this->userId;
		$oldpasswd = $this->oldpasswd;
		$passwd = $this->passwd;

		$userInfo = SeUserinfo::find()->where(['userID' => $userId, 'passWd' => strtoupper(md5($oldpasswd))])->one();
		//查询当前用户是否正确！
		if (empty($userInfo)) {
			$this->addError($attribute, "旧密码错误！");
			return false;
		}
		$userInfo->passWd = strtoupper(md5($passwd));
		if ($userInfo->save(false)) {
			return true;
		}

		return false;
	}
}