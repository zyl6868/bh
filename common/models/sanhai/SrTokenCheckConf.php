<?php

namespace common\models\sanhai;

use Yii;

/**
 * This is the model class for table "sr_tokenCheckConf".
 *
 * @property integer $id
 * @property string $project
 * @property string $webServiceNS
 * @property string $methodName
 * @property string $tokenStr
 * @property string $isChecked
 * @property string $confDateTime
 */
class SrTokenCheckConf extends SanhaiActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sr_tokenCheckConf';
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
            [['tokenStr'], 'string'],
            [['project', 'isChecked'], 'string', 'max' => 20],
            [['webServiceNS'], 'string', 'max' => 300],
            [['methodName'], 'string', 'max' => 200],
            [['confDateTime'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project' => '工程 1校外 2校内 3三库',
            'webServiceNS' => 'web服务命名空间',
            'methodName' => 'web服务方法名',
            'tokenStr' => 'token字符串',
            'isChecked' => '是否检查 0不检查 1检查',
            'confDateTime' => '设置时间',
        ];
    }

    /**
     * @inheritdoc
     * @return SrTokenCheckConfQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SrTokenCheckConfQuery(get_called_class());
    }
}
