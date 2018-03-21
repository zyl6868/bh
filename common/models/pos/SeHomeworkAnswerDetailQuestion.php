<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_homeworkAnswerDetailQuestion".
 *
 * @property integer $tID
 * @property string $homeworkAnswerID
 * @property string $questionID
 * @property string $answerDetail
 * @property string $checkInfoJson
 * @property string $isDelete
 * @property string $isRight
 * @property string $getScore
 */
class SeHomeworkAnswerDetailQuestion extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_homeworkAnswerDetailQuestion';
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
            [['tID'], 'required'],
            [['tID'], 'integer'],
            [['checkInfoJson'], 'string'],
            [['homeworkAnswerID', 'questionID', 'getScore'], 'string', 'max' => 20],
            [['answerDetail'], 'string', 'max' => 300],
            [['isDelete', 'isRight'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tID' => '主键',
            'homeworkAnswerID' => '作业答案ID',
            'questionID' => '问题ID',
            'answerDetail' => '提交的答案',
            'checkInfoJson' => '批阅结果（删除）',
            'isDelete' => '是否删除',
            'isRight' => '是否正确，0错误，1正确，2未判定',
            'getScore' => '得分',
        ];
    }

    /**
     * @inheritdoc
     * @return SeHomeworkAnswerDetailQuestionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeHomeworkAnswerDetailQuestionQuery(get_called_class());
    }
}
