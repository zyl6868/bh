<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_paperSection".
 *
 * @property integer $id
 * @property string $paperId
 * @property string $sectionName
 * @property string $sectionNote
 * @property string $secSeq
 * @property string $ischecked
 */
class SePaperSection extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_paperSection';
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
     * @return SePaperSectionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SePaperSectionQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['paperId', 'secSeq', 'ischecked'], 'string', 'max' => 20],
            [['sectionName', 'sectionNote'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '分卷id',
            'paperId' => '试卷id',
            'sectionName' => '卷标',
            'sectionNote' => '注释',
            'secSeq' => '分卷顺序',
            'ischecked' => 'Ischecked',
        ];
    }
}
