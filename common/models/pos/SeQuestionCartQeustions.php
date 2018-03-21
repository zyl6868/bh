<?php

namespace common\models\pos;

use common\models\sanhai\ShTestquestion;
use common\models\search\Es_testQuestion;
use Yii;

/**
 * This is the model class for table "se_questionCartQeustions".
 *
 * @property integer $cartQuestionId
 * @property integer $cartId
 * @property integer $questionId
 * @property integer $statusSign
 * @property integer $createTime
 * @property integer $updateTime
  * @property integer $orderNumber
 */
class SeQuestionCartQeustions extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_questionCartQeustions';
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
            [['cartId', 'questionId', 'createTime'], 'required'],
            [['cartId', 'questionId', 'statusSign', 'createTime', 'updateTime'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cartQuestionId' => '选题篮题目id',
            'cartId' => '选题篮id',
            'questionId' => '题目id',
            'statusSign' => '状态',
            'createTime' => '添加时间',
            'updateTime' => '修改时间',
        ];
    }

    /**
     * @inheritdoc
     * @return SeQuestionCartQeustionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeQuestionCartQeustionsQuery(get_called_class());
    }

    public function getEsTestQuestion()
    {
        return $this->hasMany(Es_testQuestion::className(),["id"=>"questionId"]);
    }

    public function getShTestQuestion()
    {
        return $this->hasMany(ShTestquestion::className(),["id"=>"questionId"]);
    }
}
