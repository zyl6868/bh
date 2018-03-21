<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2015/11/20
 * Time: 11:50
 */

namespace common\models\pos;

use Yii;


/**
 * This is the model class for table "se_homeworkAnswerImage".
 * @property integer $answerImageId
 * @property string $homeworkAnswerID
 * @property string $url
 * @property string $createTime
 */

class SeHomeworkAnswerImage extends PosActiveRecord
{
	/**
	 * @inheritdoc
	 * @return string
	 */
	public static function tableName()
	{
		return 'se_homeworkAnswerImage';
	}


	/**
	 * @return null|object
	 * @throws \yii\base\InvalidConfigException
	 * @return \yii\db\Connection the database connection used by this AR class.
	 */
	public static function getDb()
	{
		return Yii::$app->get('db_school');
	}

	/**
	 * @inheritdoc
	 * @return array
	 */
	public function rules()
	{
		return [
//		[['answerImageId'], 'required'],
			[['answerImageId'], 'integer'],
			[['url'],'string','max'=>300],
			[['homeworkAnswerID','createTime'], 'string', 'max'=>100]
		];
	}

	/**
	 * @inheritdoc
	 * @return array
	 */
	public function attributeLabels()
	{
		return [
			'answerImageId' => 'answer Image Id',
			'homeworkAnswerID' => 'Homework Answer ID',
			'url' => 'url',
			'createTime' => 'create Time'
		];
	}

	/**
	 * @inheritdoc
	 * @return SeHomeworkAnswerQuestionPicQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new SeHomeworkAnswerImageQuery(get_called_class());
	}

    public function getSeHomeworkAnswerInfo(){
        return $this->hasOne(SeHomeworkAnswerInfo::className(), ['homeworkAnswerID' => 'homeworkAnswerID']);
    }


}