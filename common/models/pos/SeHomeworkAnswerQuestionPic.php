<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_homeworkAnswerQuestionPic".
 *
 * @property integer $picID
 * @property string $answerUrl
 * @property string $checkJson
 * @property string $answerID
 * @property string $homeworkId
 * @property string $studentID
 * @property string $homeworkAnswerID
 */
class SeHomeworkAnswerQuestionPic extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_homeworkAnswerQuestionPic';
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
            [['answerID', 'homeworkId', 'studentID', 'homeworkAnswerID'], 'string', 'max' => 100]
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
            'homeworkId' => 'Homework ID',
            'studentID' => 'Student ID',
            'homeworkAnswerID' => 'Homework Answer ID',
        ];
    }

    /**
     * @inheritdoc
     * @return SeHomeworkAnswerQuestionPicQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeHomeworkAnswerQuestionPicQuery(get_called_class());
    }
}
