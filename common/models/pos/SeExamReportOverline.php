<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_exam_reportOverline".
 * 上线分数报表,班级id为0，表示全校统计。科目id为0，表示总分统计。
 * @property integer $overLineReportId 上线分数报表记录id
 * @property integer $schoolExamId 考试id（学校）
 * @property integer $classExamId 考试id（班级）
 * @property integer $borderline 分数线号
 * @property integer $classId 班级id
 * @property integer $subjectId 科目id
 * @property integer $bothOverLineNum 双上线,单科总分都上线
 * @property integer $singleOverLineNum 单科上线，总分未上线
 * @property integer $singleNotOverLineNum 总分上线，单科未上线
 * @property integer $bothNotOverLineNum 双未上线
 * @property integer $createTime 创建时间
 * @property integer $updateTime 更新时间
 */
class SeExamReportOverline extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_exam_reportOverline';
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
            [['schoolExamId', 'borderline', 'createTime'], 'required'],
            [['schoolExamId', 'classExamId', 'borderline', 'classId', 'subjectId', 'bothOverLineNum', 'singleOverLineNum', 'singleNotOverLineNum', 'bothNotOverLineNum', 'createTime', 'updateTime'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'overLineReportId' => '上线分数报表记录id',
            'schoolExamId' => '考试id（学校）',
            'classExamId' => '考试id（班级）',
            'borderline' => '分数线号',
            'classId' => '班级id',
            'subjectId' => '科目id',
            'bothOverLineNum' => '双上线',
            'singleOverLineNum' => '单科上线人数',
            'singleNotOverLineNum' => '单科未上线人数',
            'bothNotOverLineNum' => '双未上线',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
        ];
    }

    /**
     * @inheritdoc
     * @return SeExamReportOverlineQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeExamReportOverlineQuery(get_called_class());
    }
}
