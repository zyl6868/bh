<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_coursePlayRaiseHandRecord".
 *
 * @property integer $rHandID
 * @property string $courseID
 * @property string $problemID
 * @property string $userID
 * @property string $createTime
 * @property string $isDelete
 * @property string $remark
 */
class SeCoursePlayRaiseHandRecord extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_coursePlayRaiseHandRecord';
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
            [['rHandID'], 'required'],
            [['rHandID'], 'integer'],
            [['courseID', 'problemID', 'userID', 'createTime'], 'string', 'max' => 20],
            [['isDelete'], 'string', 'max' => 2],
            [['remark'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rHandID' => '举手记录id',
            'courseID' => '课程id',
            'problemID' => '问题id',
            'userID' => '用户id',
            'createTime' => 'Create Time',
            'isDelete' => 'Is Delete',
            'remark' => '举手备注',
        ];
    }

    /**
     * @inheritdoc
     * @return SeCoursePlayRaiseHandRecordQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeCoursePlayRaiseHandRecordQuery(get_called_class());
    }
}
