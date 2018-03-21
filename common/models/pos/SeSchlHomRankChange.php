<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_schlHomRankChange".
 *
 * @property integer $id
 * @property string $msgId
 * @property string $examID
 * @property string $subjectId
 * @property string $subjectName
 * @property integer $rankChange
 */
class SeSchlHomRankChange extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_schlHomRankChange';
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
     * @return SeSchlHomRankChangeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeSchlHomRankChangeQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'rankChange'], 'integer'],
            [['msgId', 'examID', 'subjectId', 'subjectName'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'msgId' => '消息id',
            'examID' => '科目名称',
            'subjectId' => '科目id',
            'subjectName' => '科目名称',
            'rankChange' => '名次变化',
        ];
    }
}
