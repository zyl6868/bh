<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_courseInTime".
 *
 * @property integer $id
 * @property string $type
 * @property string $canInTime
 */
class SeCourseInTime extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_courseInTime';
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
     * @return SeCourseInTimeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeCourseInTimeQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['type', 'canInTime'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '类型，0学生，1教师',
            'canInTime' => '时间，精确到秒',
        ];
    }
}
