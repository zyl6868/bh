<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_testAnswerInfo".
 *
 * @property integer $testAnswerID
 * @property string $getType
 * @property string $studentID
 * @property string $testScore
 * @property string $uploadTime
 * @property string $isCheck
 * @property string $teacherID
 * @property string $checkTime
 * @property string $summary
 * @property string $isUploadAnswer
 * @property string $isDelete
 * @property string $otherTestAnswerID
 * @property string $examSubID
 * @property string $testID
 * @property string $subRank
 */
class SeTestAnswerInfo extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_testAnswerInfo';
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
     * @return SeTestAnswerInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeTestAnswerInfoQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['testAnswerID'], 'required'],
            [['testAnswerID'], 'integer'],
            [['getType', 'isCheck', 'isUploadAnswer', 'isDelete'], 'string', 'max' => 2],
            [['studentID', 'testScore', 'uploadTime', 'teacherID', 'checkTime', 'otherTestAnswerID', 'examSubID', 'subRank'], 'string', 'max' => 20],
            [['summary'], 'string', 'max' => 500],
            [['testID'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'testAnswerID' => '学生测验答案ID',
            'getType' => '测验试卷类型，0上传，1组卷',
            'studentID' => '学生ID',
            'testScore' => '测验分数',
            'uploadTime' => '答案上传时间',
            'isCheck' => '是否批阅 0未批阅，1已批阅',
            'teacherID' => '批阅教师ID',
            'checkTime' => '批阅时间',
            'summary' => '评价',
            'isUploadAnswer' => '是否上传答案，默认0，未上传',
            'isDelete' => '是否删除 0未删除，1已删除',
            'otherTestAnswerID' => 'Other Test Answer ID',
            'examSubID' => '考试id',
            'testID' => 'Test ID',
            'subRank' => '单科目排名',
        ];
    }
}
