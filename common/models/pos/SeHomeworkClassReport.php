<?php

namespace common\models\pos;

use common\helper\DateTimeHelper;
use Yii;

/**
 * This is the model class for table "se_homework_classReport".
 *
 * @property integer $sid
 * @property integer $classId
 * @property integer $subjectId
 * @property integer $finishNum
 * @property integer $totalNum
 * @property integer $excellentNum
 * @property integer $goodNum
 * @property integer $middleNum
 * @property integer $badNum
 * @property integer $createTime
 * @property string $generateTime
 */
class SeHomeworkClassReport extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_homework_classReport';
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
            [['classId', 'subjectId', 'finishNum', 'totalNum', 'excellentNum', 'goodNum', 'middleNum', 'badNum', 'createTime'], 'integer'],
            [['generateTime'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sid' => '统计主键id',
            'classId' => '班级id',
            'subjectId' => '科目id',
            'finishNum' => '作业完成人次',
            'totalNum' => '需要答题的总人次',
            'excellentNum' => '优（人次）',
            'goodNum' => '良（人次）',
            'middleNum' => '中（人次）',
            'badNum' => '差（人次）',
            'createTime' => '创建时间',
            'generateTime' => '生成时间（创建时间）',
        ];
    }

    /**
     * @inheritdoc
     * @return SeHomeworkClassReportQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeHomeworkClassReportQuery(get_called_class());
    }

    /**
     * 月报告统计数据
     * @param $item
     */
    public static function instertData($item){

        $classReportModel = new self();
        $classReportModel->badNum = $item['badNum'];
        $classReportModel->excellentNum = $item['excellentNum'];
        $classReportModel->middleNum = $item['middleNum'];
        $classReportModel->goodNum = $item['goodNum'];
        $classReportModel->subjectId = $item['subjectId'];
        $classReportModel->classId = $item['classId'];
        $classReportModel->totalNum = $item['totalNum'];
        $classReportModel->finishNum = $item['finishNum'];
        $classReportModel->createTime = DateTimeHelper::timestampX1000();
        $classReportModel->generateTime = $item['generateTime'];
        $classReportModel->save();

    }

}
