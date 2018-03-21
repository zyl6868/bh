<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_coursePlayInfoInOutTime".
 *
 * @property integer $id
 * @property string $recordID
 * @property string $action
 * @property string $inOrOutTime
 * @property string $isDelete
 */
class SeCoursePlayInfoInOutTime extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_coursePlayInfoInOutTime';
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
            [['id'], 'required'],
            [['id'], 'integer'],
            [['recordID', 'inOrOutTime'], 'string', 'max' => 20],
            [['action', 'isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'recordID' => 'Record ID',
            'action' => 'Action',
            'inOrOutTime' => 'In Or Out Time',
            'isDelete' => 'Is Delete',
        ];
    }

    /**
     * @inheritdoc
     * @return SeCoursePlayInfoInOutTimeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeCoursePlayInfoInOutTimeQuery(get_called_class());
    }
}
