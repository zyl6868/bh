<?php

namespace common\models\sanhai;

use Yii;

/**
 * This is the model class for table "se_dateDictionary".
 *
 * @property integer $ID 自增ID
 * @property string $firstCode 一级代码
 * @property string $firstCodeValue 一级代码
 * @property string $secondCode 二级代码
 * @property string $secondCodeValue 二级代码
 * @property string $status 是否启用 1：启用（默认）0未启用
 * @property string $reserve1 预留字段1
 * @property string $reserve2 预留字段2
 * @property string $reserve3 预留字段3
 * @property string $scorea 科目小学分数
 * @property string $scoreb 科目初中分数
 * @property string $scorec 科目高中分数
 * @property integer $orderNo 排序字段
 */
class SeDateDictionary extends SanhaiActiveRecord
{
    public $reserveTwo;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_dateDictionary';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_sanku');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstCode', 'firstCodeValue', 'secondCode', 'secondCodeValue', 'status', 'scorea', 'scoreb', 'scorec'], 'string', 'max' => 20],
            [['reserve1', 'reserve2', 'reserve3'], 'string', 'max' => 500],
            [['orderNo'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'firstCode' => '一级代码',
            'firstCodeValue' => '一级代码',
            'secondCode' => '二级代码',
            'secondCodeValue' => '二级代码',
            'status' => '是否启用 1：启用（默认）0未启用',
            'reserve1' => '预留字段1',
            'reserve2' => '预留字段2',
            'reserve3' => '预留字段3',
            'scorea' => '科目小学分数',
            'scoreb' => '科目初中分数',
            'scorec' => '科目高中分数',
            'orderNo' => '排序字段',
        ];
    }

    /**
     * @inheritdoc
     * @return SeDateDictionaryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeDateDictionaryQuery(get_called_class());
    }


}
