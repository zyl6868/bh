<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_homeworkQuestionType".
 *
 * @property integer $id
 * @property integer $homeworkId
 * @property integer $sectionId
 * @property string $typeId
 * @property string $name
 * @property string $note
 * @property integer $typeSeq
 * @property string $ischecked
 * @property string $showTypeId
 */
class SeHomeworkQuestionType extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_homeworkQuestionType';
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
            [['id'], 'required'],
            [['id', 'homeworkId', 'sectionId', 'typeSeq'], 'integer'],
            [['typeId', 'ischecked', 'showTypeId'], 'string', 'max' => 20],
            [['name', 'note'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '题型id',
            'homeworkId' => '作业id',
            'sectionId' => '分卷id',
            'typeId' => '题目类型id',
            'name' => '题型名称',
            'note' => '题型注释',
            'typeSeq' => '类型顺序',
            'ischecked' => 'Ischecked',
            'showTypeId' => 'Show Type ID',
        ];
    }

    /**
     * @inheritdoc
     * @return SeHomeworkQuestionTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeHomeworkQuestionTypeQuery(get_called_class());
    }
}
