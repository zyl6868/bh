<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_customerSuggestion".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $time
 * @property integer $userID
 * @property string $userName
 */
class SeCustomerSuggestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_customerSuggestion';
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
            [['time'], 'safe'],
            [['userID'], 'integer'],
            [['title'], 'string', 'max' => 200],
            [['content'], 'string', 'max' => 2000],
            [['userName'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'content' => '内容',
            'time' => '创建时间',
            'userID' => 'User ID',
            'userName' => 'User Name',
        ];
    }

    /**
     * @inheritdoc
     * @return SeCustomerSuggestionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeCustomerSuggestionQuery(get_called_class());
    }
}
