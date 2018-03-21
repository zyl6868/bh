<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_homeworkImage".
 *
 * @property string $id
 * @property string $homeworkId
 * @property string $url
 */
class SeHomeworkImage extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_homeworkImage';
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
//            [['id'], 'required'],
            [['id', 'homeworkId'], 'integer'],
            [['url'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'homeworkId' => '作业id',
            'url' => '图片url',
        ];
    }

    /**
     * @inheritdoc
     * @return SeHomeworkImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeHomeworkImageQuery(get_called_class());
    }
}
