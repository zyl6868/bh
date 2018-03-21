<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_homeworkSection".
 *
 * @property integer $id
 * @property integer $homeworkId
 * @property string $sectionName
 * @property string $sectionNote
 * @property integer $secSeq
 * @property string $ischecked
 */
class SeHomeworkSection extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_homeworkSection';
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
     * @return SeHomeworkSectionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeHomeworkSectionQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'homeworkId', 'secSeq'], 'integer'],
            [['sectionName', 'sectionNote'], 'string', 'max' => 500],
            [['ischecked'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '分卷id',
            'homeworkId' => '试卷id',
            'sectionName' => '卷标',
            'sectionNote' => '注释',
            'secSeq' => '分卷顺序',
            'ischecked' => 'Ischecked',
        ];
    }
}
