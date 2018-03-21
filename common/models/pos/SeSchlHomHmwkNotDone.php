<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_schlHomHmwkNotDone".
 *
 * @property integer $id
 * @property string $msgId
 * @property string $subjectId
 * @property string $subjectName
 * @property integer $cnt
 */
class SeSchlHomHmwkNotDone extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_schlHomHmwkNotDone';
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
     * @return SeSchlHomHmwkNotDoneQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeSchlHomHmwkNotDoneQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'cnt'], 'integer'],
            [['msgId', 'subjectId', 'subjectName'], 'string', 'max' => 20]
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
            'subjectId' => '科目id',
            'subjectName' => '科目名称',
            'cnt' => '次数',
        ];
    }
}
