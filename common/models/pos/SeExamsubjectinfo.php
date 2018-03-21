<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_examsubjectinfo".
 *
 * @property integer $examSubID
 * @property string $subjectID
 * @property string $subjectName
 * @property string $examID
 * @property string $classID
 * @property string $describe
 * @property string $paperName
 * @property string $teacherID
 * @property string $creatTime
 * @property string $uploadTime
 * @property string $isDelete
 * @property string $isChecked
 * @property string $ExcelURL
 * @property string $subjectScore
 * @property string $summary
 * @property string $startTime
 * @property string $endTime
 * @property string $knowledgePoint
 * @property string $grade
 * @property string $isHavePaper
 * @property string $isHaveScore
 * @property string $paperId
 * @property string $getType
 * @property string $isHaveCrossCheck
 * @property string $subScore
 * @property string $isWarnPar
 */
class SeExamsubjectinfo extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_examsubjectinfo';
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
     * @return SeExamsubjectinfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeExamsubjectinfoQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['examSubID'], 'required'],
            [['examSubID'], 'integer'],
            [['subjectID', 'subjectName', 'examID', 'classID', 'describe', 'teacherID'], 'string', 'max' => 30],
            [['paperName', 'grade'], 'string', 'max' => 100],
            [['creatTime', 'uploadTime', 'startTime', 'endTime', 'paperId', 'subScore'], 'string', 'max' => 20],
            [['isDelete', 'isChecked', 'isHavePaper', 'isHaveScore', 'getType', 'isHaveCrossCheck', 'isWarnPar'], 'string', 'max' => 2],
            [['ExcelURL', 'summary'], 'string', 'max' => 500],
            [['subjectScore'], 'string', 'max' => 50],
            [['knowledgePoint'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'examSubID' => '主键id',
            'subjectID' => '科目ID',
            'subjectName' => '科目名称',
            'examID' => '考试ID',
            'classID' => '班级ID',
            'describe' => '试卷描述',
            'paperName' => '试卷名称',
            'teacherID' => '教师ID',
            'creatTime' => '创建时间',
            'uploadTime' => '教师上传Excel表时间',
            'isDelete' => '是否删除0：否1：是默认0',
            'isChecked' => '是否批阅0：否1：是默认0',
            'ExcelURL' => 'Excel表URL',
            'subjectScore' => '科目成绩',
            'summary' => '学习规划',
            'startTime' => '考试开始时间',
            'endTime' => '考试结束时间',
            'knowledgePoint' => '知识点',
            'grade' => '年级',
            'isHavePaper' => '是否有试卷，0没有，1有',
            'isHaveScore' => '是否有成绩, 0没有，1有',
            'paperId' => 'Paper ID',
            'getType' => '0上传，1组织',
            'isHaveCrossCheck' => 'Is Have Cross Check',
            'subScore' => '科目满分',
            'isWarnPar' => '是否发送单科警告给家长',
        ];
    }
}
