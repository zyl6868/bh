<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_homeworkAnswerQuestionMain".
 *
 * @property integer $tID
 * @property string $homeworkAnswerID
 * @property string $questionID
 * @property string $isDelete
 * @property string $isRight
 * @property string $getScore
 * @property string $homeworkId
 * @property string $studentID
 * @property string $createTime
 * @property string $relId
 */
class SeHomeworkAnswerQuestionMain extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_homeworkAnswerQuestionMain';
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
//            [['tID'], 'required'],
            [['tID'], 'integer'],
            [['homeworkAnswerID', 'questionID', 'getScore', 'homeworkId','relId','correctResult'], 'string', 'max' => 20],
            [['isDelete', 'isRight'], 'string', 'max' => 2],
            [['studentID'], 'string', 'max' => 100]
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
            'isDelete' => '是否删除',
            'isRight' => '是否正确，0错误，1正确，2未判定',
            'getScore' => '得分',
            'homeworkId' => 'Homework ID',
            'studentID' => 'Student ID',
            'relId'=>'rel ID',
            'correctResult'=>'correctResult'
        ];
    }

    /**
     * @inheritdoc
     * @return SeHomeworkAnswerQuestionMainQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeHomeworkAnswerQuestionMainQuery(get_called_class());
    }
}
