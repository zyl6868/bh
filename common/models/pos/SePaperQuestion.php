<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_paperQuestion".
 *
 * @property integer $id
 * @property string $paperId
 * @property string $sectionId
 * @property string $questionTypeId
 * @property string $questionId
 * @property string $questionName
 * @property string $score
 */
class SePaperQuestion extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_paperQuestion';
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
     * @return SePaperQuestionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SePaperQuestionQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['paperId', 'sectionId', 'questionTypeId', 'questionId', 'score'], 'string', 'max' => 20],
            [['questionName'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'paperId' => '试卷id',
            'sectionId' => '分卷id',
            'questionTypeId' => '题型id',
            'questionId' => '题目id',
            'questionName' => '题目名称',
            'score' => '分数',
        ];
    }
}
