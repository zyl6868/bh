<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_coursePlayProblemRecord".
 *
 * @property integer $problemID
 * @property string $courseID
 * @property string $userID
 * @property string $message
 * @property string $createTime
 * @property string $isDelete
 */
class SeCoursePlayProblemRecord extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_coursePlayProblemRecord';
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
            [['problemID'], 'required'],
            [['problemID'], 'integer'],
            [['courseID', 'userID', 'createTime'], 'string', 'max' => 20],
            [['message'], 'string', 'max' => 500],
            [['isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'problemID' => '问题记录id',
            'courseID' => '课程id',
            'userID' => '用户id',
            'message' => '问题内容',
            'createTime' => 'Create Time',
            'isDelete' => 'Is Delete',
        ];
    }

    /**
     * @inheritdoc
     * @return SeCoursePlayProblemRecordQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeCoursePlayProblemRecordQuery(get_called_class());
    }
}
