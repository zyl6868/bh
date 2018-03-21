<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_schoolUploadList".
 *
 * @property integer $id_schoolUploadList
 * @property string $uploadfile
 * @property integer $schoolID
 */
class SeSchoolUploadList extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_schoolUploadList';
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
     * @return SeSchoolUploadListQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeSchoolUploadListQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['schoolID'], 'integer'],
            [['uploadfile'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_schoolUploadList' => 'Id School Upload List',
            'uploadfile' => 'Uploadfile',
            'schoolID' => 'School ID',
        ];
    }
}
