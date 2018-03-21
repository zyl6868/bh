<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_testAnswerDetailImage".
 *
 * @property integer $tID
 * @property string $testAnswerID
 * @property string $imageUrl
 * @property string $checkInfoJson
 * @property string $isDelete
 */
class SeTestAnswerDetailImage extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_testAnswerDetailImage';
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
            [['tID'], 'required'],
            [['tID'], 'integer'],
            [['checkInfoJson'], 'string'],
            [['testAnswerID'], 'string', 'max' => 20],
            [['imageUrl'], 'string', 'max' => 300],
            [['isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tID' => '主键ID',
            'testAnswerID' => '测试答案ID',
            'imageUrl' => '答案图片url',
            'checkInfoJson' => '批阅json',
            'isDelete' => '是否删除',
        ];
    }

    /**
     * @inheritdoc
     * @return SeTestAnswerDetailImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeTestAnswerDetailImageQuery(get_called_class());
    }
}
