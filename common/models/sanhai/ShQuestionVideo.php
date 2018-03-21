<?php

namespace common\models\sanhai;

use Yii;

/**
 * This is the model class for table "sh_question_video".
 *
 * @property integer $id
 * @property string $resourceId
 * @property string $questionId
 * @property string $creatorID
 */
class ShQuestionVideo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sh_question_video';
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
            [['resourceId', 'questionId', 'creatorID'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'resourceId' => 'Resource ID',
            'questionId' => 'Question ID',
            'creatorID' => 'Creator ID',
        ];
    }

    /**
     * @inheritdoc
     * @return ShQuestionVideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShQuestionVideoQuery(get_called_class());
    }
}
