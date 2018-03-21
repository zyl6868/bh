<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_coursePlayInfo".
 *
 * @property integer $courseID
 * @property string $courseName
 * @property string $connectID
 * @property string $beginTime
 * @property string $finishTime
 * @property string $url
 * @property string $courseBrief
 * @property string $gradeID
 * @property string $subjectID
 * @property string $teacherID
 * @property string $creatorID
 * @property string $createTime
 * @property string $isDelete
 * @property string $isHandout
 * @property string $classId
 * @property string $handoutID
 * @property string $filesID
 * @property string $courseStatus
 * @property string $copyDataUrl
 * @property string $isLimit
 * @property string $versionID
 * @property string $disabled
 * @property string $isSendMessage
 */
class SeCoursePlayInfo extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_coursePlayInfo';
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
     * @return SeCoursePlayInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeCoursePlayInfoQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['courseID'], 'required'],
            [['courseID'], 'integer'],
            [['courseBrief'], 'string'],
            [['courseName'], 'string', 'max' => 200],
            [['connectID', 'classId', 'handoutID'], 'string', 'max' => 50],
            [['beginTime', 'finishTime', 'gradeID', 'subjectID', 'teacherID', 'creatorID', 'createTime'], 'string', 'max' => 20],
            [['url', 'versionID'], 'string', 'max' => 100],
            [['isDelete', 'isHandout', 'courseStatus', 'isLimit', 'disabled', 'isSendMessage'], 'string', 'max' => 2],
            [['filesID'], 'string', 'max' => 500],
            [['copyDataUrl'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'courseID' => '课程id',
            'courseName' => '课程名称',
            'connectID' => '课程相关类型Id 0:知识点 1:章节',
            'beginTime' => '上课开始时间',
            'finishTime' => '上课结束时间',
            'url' => '广告图片url',
            'courseBrief' => '课程介绍',
            'gradeID' => '年级id',
            'subjectID' => '科目id',
            'teacherID' => '上课老师id',
            'creatorID' => '信息创建人',
            'createTime' => '信息创建时间',
            'isDelete' => '是否删除',
            'isHandout' => '是否有讲义 0:没有讲义1:有讲义',
            'classId' => '班级id',
            'handoutID' => '讲义id',
            'filesID' => '知识点或者章节的ID ID的字符串，多个用逗号隔开',
            'courseStatus' => '0未开始，1正在进行，2以完结',
            'copyDataUrl' => '已上课程，录制视频下载地址',
            'isLimit' => '是否有听课人员限制,0没有限制，1有限制',
            'versionID' => 'Version ID',
            'disabled' => '是否已经禁用 0：未禁用/激活/解禁/审核通过  1：已经禁用',
            'isSendMessage' => 'Is Send Message',
        ];
    }
}
