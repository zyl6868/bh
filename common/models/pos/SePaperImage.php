<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_paperImage".
 *
 * @property integer $id
 * @property string $paperId
 * @property string $url
 * @property string $isDelete
 */
class SePaperImage extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_paperImage';
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
     * @return SePaperImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SePaperImageQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['paperId'], 'string', 'max' => 20],
            [['url'], 'string', 'max' => 500],
            [['isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '图片id',
            'paperId' => '试卷id',
            'url' => '图片url',
            'isDelete' => 'Is Delete',
        ];
    }
}
