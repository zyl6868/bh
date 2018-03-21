<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_homeworkQuestion_platform".
 *
 * @property string $id
 * @property string $homeworkId
 * @property string $questionTypeId
 * @property string $questionId
 * @property double $score
 *  @property integer $orderNumber
 */
class SeHomeworkQuestionPlatform extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_homeworkQuestion_platform';
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
            [['homeworkId', 'questionTypeId', 'questionId'], 'integer'],
            [['score'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '题目id',
            'homeworkId' => '作业id',
            'questionTypeId' => '题型id',
            'questionId' => '题目id',
            'score' => '分数',
        ];
    }

    /**
     * @inheritdoc
     * @return SeHomeworkQuestionPlatformQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeHomeworkQuestionPlatformQuery(get_called_class());
    }


    /**
     * 根据作业id获取其中的题id
     * wgl
     * @param integer $homeworkID 作业id
     * @return array|SeHomeworkQuestionPlatform[]
     */
    public static function getHomeworkQuePlatformQuestionIdAll(int $homeworkID)
    {
        return self::find()->where(['homeworkId' => $homeworkID])->select('questionId')->orderBy('orderNumber')->asArray()->all();
    }
}
