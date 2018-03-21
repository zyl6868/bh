<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_testAnswerQuestionMain".
 *
 * @property integer $tID
 * @property string $testAnswerID
 * @property string $questionID
 * @property string $isDelete
 * @property string $isRight
 * @property string $getScore
 * @property string $studentID
 * @property string $examSubID
 * @property string $testID
 */
class SeTestAnswerQuestionMain extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_testAnswerQuestionMain';
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
            [['testAnswerID', 'questionID', 'getScore', 'studentID'], 'string', 'max' => 20],
            [['isDelete', 'isRight'], 'string', 'max' => 2],
            [['examSubID', 'testID'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tID' => '主键',
            'testAnswerID' => '作业答案ID',
            'questionID' => '问题ID',
            'isDelete' => '是否删除',
            'isRight' => '是否正确，0错误，1正确，2未判定',
            'getScore' => '得分',
            'studentID' => 'Student ID',
            'examSubID' => 'Exam Sub ID',
            'testID' => 'Test ID',
        ];
    }

    /**
     * @inheritdoc
     * @return SeTestAnswerQuestionMainQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeTestAnswerQuestionMainQuery(get_called_class());
    }
}
