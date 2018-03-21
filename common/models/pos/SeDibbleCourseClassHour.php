<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_dibbleCourse_classHour".
 *
 * @property integer $hourID
 * @property string $sequence
 * @property string $squenceName
 * @property string $url
 * @property string $material
 * @property string $playTimes
 * @property string $updateTime
 * @property string $creatorID
 * @property string $createTime
 * @property string $isDelete
 * @property string $courseID
 */
class SeDibbleCourseClassHour extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_dibbleCourse_classHour';
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
            [['hourID'], 'required'],
            [['hourID'], 'integer'],
            [['sequence', 'material', 'playTimes', 'updateTime', 'creatorID', 'createTime', 'courseID'], 'string', 'max' => 20],
            [['squenceName', 'url'], 'string', 'max' => 50],
            [['isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'hourID' => '课时id',
            'sequence' => '序号',
            'squenceName' => '节次名称',
            'url' => '视频资源URL',
            'material' => '知识点/章节',
            'playTimes' => '点播次数',
            'updateTime' => '最后一次点播时间',
            'creatorID' => '信息创建人',
            'createTime' => '创建时间',
            'isDelete' => '是否已经删除',
            'courseID' => '课程id',
        ];
    }

    /**
     * @inheritdoc
     * @return SeDibbleCourseClassHourQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeDibbleCourseClassHourQuery(get_called_class());
    }
}
