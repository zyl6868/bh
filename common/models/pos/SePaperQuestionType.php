<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_paperQuestionType".
 *
 * @property integer $id
 * @property string $paperId
 * @property string $sectionId
 * @property string $typeId
 * @property string $name
 * @property string $note
 * @property string $typeSeq
 * @property string $ischecked
 * @property string $showTypeId
 */
class SePaperQuestionType extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_paperQuestionType';
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
     * @return SePaperQuestionTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SePaperQuestionTypeQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['paperId', 'sectionId', 'typeId', 'typeSeq', 'ischecked', 'showTypeId'], 'string', 'max' => 20],
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
            'paperId' => '试卷id',
            'sectionId' => '分卷id',
            'typeId' => '题目类型id',
            'name' => '名称',
            'note' => '注释',
            'typeSeq' => '类型顺序',
            'ischecked' => 'Ischecked',
            'showTypeId' => '题目显示类型',
        ];
    }
}
