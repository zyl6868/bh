<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_sameQuestion".
 *
 * @property integer $sameQid
 * @property string $aqID
 * @property string $sameQueUserId
 */
class SeSameQuestion extends PosActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'se_sameQuestion';
	}

	/**
	 * @return \yii\db\Connection the database connection used by this AR class.
	 */
	public static function getDb()
	{
		return Yii::$app->get('db_school');
	}

	/**
	 * @inheritdoc
	 * @return SeSameQuestionQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new SeSameQuestionQuery(get_called_class());
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['sameQid'], 'integer'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'sameQid' => '同问主键',
			'aqID' => '问题ID',
			'sameQueUserId' => '同问人Id',
		];
	}

	/**
	 * 查询该用户是否同问过该答疑
	 * @param integer $aqid
	 * @param integer $userId
	 * @return bool
	 */
	public function checkSame(int $aqid,int $userId)
	{
		return self::find()->where(['aqID' => $aqid, 'sameQueUserId' => $userId])->exists();
	}

	/**
	 * 添加同问
	 * @param integer $aqid
	 * @param integer $userId
	 * @return bool
	 */
	public function addSame(int $aqid,int $userId)
	{
		$this->aqID = $aqid;
		$this->sameQueUserId = $userId;
		if (self::save(false)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 查询所有同问
	 * @param integer $apId 问题id
	 * @return array|SeAnswerQuestion[]
	 */
	public static function selectSameQuestionAll(int $aqId)
	{
		$sameAll = self::find()->where(['aqID' => $aqId])->all();
		return $sameAll;
	}

	/**
	 * 查询同问数
	 * @param integer $apId 问题id
	 * @return int
	 */
	public static function AlsoAsk(int $apId)
	{
		$dataNumber = SeSameQuestion::find()->where(['aqID' => $apId])->count();
		return $dataNumber;
	}
}
