<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_wrongQuestionBookAttribute".
 *
 * @property integer $attrId
 * @property integer $wrongQuestionId
 * @property integer $sourceType
 * @property integer $sourceId
 * @property integer $createTime
 * @property integer $wrongTime
 */
class SeWrongQuestionBookAttribute extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_wrongQuestionBookAttribute';
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
            [['wrongQuestionId', 'sourceType', 'sourceId', 'createTime', 'wrongTime'], 'required'],
            [['wrongQuestionId', 'sourceType', 'sourceId', 'createTime', 'wrongTime'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'attrId' => '答疑属性记录id',
            'wrongQuestionId' => '错题记录id',
            'sourceType' => '来源类型',
            'sourceId' => '来源对象id',
            'createTime' => '创建时间',
            'wrongTime' => '做错时间',
        ];
    }

    /**
     * @inheritdoc
     * @return SeWrongQuestionBookAttributeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeWrongQuestionBookAttributeQuery(get_called_class());
    }
}
