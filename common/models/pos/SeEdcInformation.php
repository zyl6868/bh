<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_edcInformation".
 *
 * @property integer $informationID
 * @property string $informationTitle
 * @property string $informationType
 * @property string $informationContent
 * @property string $informationKeyWord
 * @property string $publishTime
 * @property integer $userID
 * @property string $isDelete
 */
class SeEdcInformation extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_edcInformation';
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
     * @return SeEdcInformationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeEdcInformationQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['informationID'], 'required'],
            [['informationID', 'userID'], 'integer'],
            [['informationContent'], 'string'],
            [['informationTitle'], 'string', 'max' => 300],
            [['informationType', 'publishTime'], 'string', 'max' => 20],
            [['informationKeyWord'], 'string', 'max' => 100],
            [['isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'informationID' => 'Information ID',
            'informationTitle' => '资讯标题',
            'informationType' => '资讯类型',
            'informationContent' => '资讯内容',
            'informationKeyWord' => '资讯关键字',
            'publishTime' => '发布时间',
            'userID' => '创建者id',
            'isDelete' => '是否已删除',
        ];
    }
}
