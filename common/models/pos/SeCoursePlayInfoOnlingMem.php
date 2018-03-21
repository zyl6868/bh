<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_coursePlayInfoOnlingMem".
 *
 * @property integer $recordID
 * @property string $courseID
 * @property string $userID
 * @property string $status
 * @property string $inTime
 * @property string $outTime
 * @property string $limit
 * @property string $isDelete
 */
class SeCoursePlayInfoOnlingMem extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_coursePlayInfoOnlingMem';
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
            [['recordID'], 'required'],
            [['recordID'], 'integer'],
            [['courseID', 'userID', 'inTime', 'outTime'], 'string', 'max' => 20],
            [['status', 'limit', 'isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'recordID' => '记录id',
            'courseID' => '课程id',
            'userID' => '用户id',
            'status' => '状态，0在课堂，1离开课堂',
            'inTime' => '进入课堂时间',
            'outTime' => '离开课堂时间',
            'limit' => '权限',
            'isDelete' => '是否删除',
        ];
    }

    /**
     * @inheritdoc
     * @return SeCoursePlayInfoOnlingMemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeCoursePlayInfoOnlingMemQuery(get_called_class());
    }
}
