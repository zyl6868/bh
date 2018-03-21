<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_homeworkQuestion".
 *
 * @property string $id
 * @property string $homeworkId
 * @property string $sectionId
 * @property string $questionTypeId
 * @property string $questionId
 * @property string $questionName
 * @property string $score
 * @property integer $orderNumber
 */
class SeHomeworkQuestion extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_homeworkQuestion';
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
//            [['id'], 'required'],
            [['id', 'homeworkId', 'sectionId', 'questionTypeId', 'questionId'], 'integer'],
            [['questionName'], 'string', 'max' => 200],
            [['score'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'homeworkId' => '作业id',
            'sectionId' => '分卷id',
            'questionTypeId' => '题型id',
            'questionId' => '题目id',
            'questionName' => '题目名称',
            'score' => '分数',
        ];
    }

    /**
     * @inheritdoc
     * @return SeHomeworkQuestionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeHomeworkQuestionQuery(get_called_class());
    }

    /**
     * 获取题id
     * @param integer $homeworkID 作业id
     * @return array|SeHomeworkQuestion[]
     */
    public static function getHomeworkQuestionId(int $homeworkID)
    {
       if($homeworkID > 0){
           return self::find()->where(['homeworkId' => $homeworkID])->select('questionId')->orderBy('orderNumber')->asArray()->all();
       }
        return null;
    }
}
