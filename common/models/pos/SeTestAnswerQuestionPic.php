<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_testAnswerQuestionPic".
 *
 * @property integer $picID
 * @property string $answerUrl
 * @property string $checkJson
 * @property string $answerID
 * @property string $testAnswerID
 * @property string $examSubID
 * @property string $testID
 */
class SeTestAnswerQuestionPic extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_testAnswerQuestionPic';
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
     */
    public function rules()
    {
        return [
            [['picID'], 'required'],
            [['picID'], 'integer'],
            [['checkJson'], 'string'],
            [['answerUrl'], 'string', 'max' => 300],
            [['answerID', 'examSubID', 'testID'], 'string', 'max' => 100],
            [['testAnswerID'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'picID' => 'Pic ID',
            'answerUrl' => 'Answer Url',
            'checkJson' => 'Check Json',
            'answerID' => 'Answer ID',
            'testAnswerID' => '作业答案id',
            'examSubID' => 'Exam Sub ID',
            'testID' => 'Test ID',
        ];
    }

    /**
     * @inheritdoc
     * @return SeTestAnswerQuestionPicQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeTestAnswerQuestionPicQuery(get_called_class());
    }
}
