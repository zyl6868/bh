<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_knowledgepoint".
 *
 * @property integer $kid
 * @property string $pid
 * @property string $kpointname
 * @property string $subject
 * @property string $grade
 * @property string $isDelete
 * @property string $remark
 */
class SeKnowledgepoint extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_knowledgepoint';
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
     * @return SeKnowledgepointQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeKnowledgepointQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kid'], 'required'],
            [['kid'], 'integer'],
            [['pid', 'subject', 'grade'], 'string', 'max' => 20],
            [['kpointname'], 'string', 'max' => 100],
            [['isDelete'], 'string', 'max' => 2],
            [['remark'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kid' => 'Kid',
            'pid' => 'Pid',
            'kpointname' => 'Kpointname',
            'subject' => 'Subject',
            'grade' => 'Grade',
            'isDelete' => 'Is Delete',
            'remark' => 'Remark',
        ];
    }
}
