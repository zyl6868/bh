<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_exam_school".
 *
 * @property integer $schoolExamId 学校考试id
 * @property integer $examId 考试id
 * @property integer $schoolId 学校id
 * @property string $examName 考试名称
 * @property integer $examType 考试类型，21901,期末 21902,期中 21903,月考 21904,模拟考试 21910,随堂测验 21911,一周测验 21912,单元测验 21906,会考
 * @property integer $departmentId 学段
 * @property integer $gradeId 年级
 * @property string $schoolYear 学年
 * @property integer $semester 学期
 * @property integer $examMonth 月份
 * @property integer $subjectType 文/理
 * @property integer $createrId 创建人
 * @property integer $createTime 创建时间
 * @property integer $updateTime 更新时间
 * @property integer $inputStatus 成绩录入状态，0未录入，1录入中，2录入完成
 * @property integer $reportStatus 报表生成状态，0初始状态，1处理中，2报表生成完成
 * @property integer $joinYear 入学年份
 */
class SeExamSchool extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_exam_school';
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
            [['examId', 'schoolId', 'examType', 'departmentId', 'gradeId', 'semester', 'examMonth', 'subjectType', 'createrId', 'createTime', 'updateTime', 'inputStatus','joinYear'], 'integer'],
            [['examName'], 'string', 'max' => 50],
            [['schoolYear'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'schoolExamId' => '学校考试id',
            'examId' => '考试id',
            'schoolId' => '学校id',
            'examName' => '考试名称',
            'examType' => '考试类型，21901,期末 21902,期中 21903,月考 21904,一模 21905,二模 21910,随堂测验 21911,一周测验 21912,单元测验 21906,会考',
            'departmentId' => '学段',
            'gradeId' => '年级',
            'schoolYear' => '学年',
            'semester' => '学期',
            'examMonth' => '月份',
            'subjectType' => '文/理',
            'createrId' => '创建人',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
            'inputStatus' => '成绩录入状态，0未录入，1录入中，2录入完成',
            'reportStatus' => '报表生成状态，0初始状态，1处理中，2报表生成完成',
            'joinYear'=>'入学年份'
        ];
    }

    public function getQuestionResult()
    {
        return $this->hasMany(SeQuestionResult::className(), ['rel_aqID' => 'aqID']);
    }


    public function getSeExamClass()
    {
        return $this->hasMany(SeExamClass::className(), ['schoolExamId' => 'schoolExamId']);
    }
    /**
     * 获取考试下的班级
     */
    public function getClasses()
    {

      $classesArray= $this->getSeExamClass()->select('classId')->column();
        //班级和科目
        $classes = SeClass::find()->where(['schoolID' => $this->schoolId, 'classID'=>$classesArray])->all();
        return $classes;
    }

    /**
     * 查询考试的科目
     * @return \yii\db\ActiveQuery
     */
    public function getExamSubject()
    {
        return $this->hasMany(SeExamSubject::className(), ['schoolExamId' => 'schoolExamId']);
    }

    /**
     * 获取科目总分数
     * @param integer $subjectId
     * @return int|mixed
     */
    public function getSubjectScoreById(int $subjectId)
    {
        $model = $this->getExamSubject()->where(['subjectId' => $subjectId])->limit(1)->one();
        if ($model) {
            return isset($model->fullScore) ? $model->fullScore : 0;
        }
        return 0;

    }

    /**
     * 获取所有学科总分
     * @return integer
     */
    public function getTotalScore()
    {

        $fullScore= $this->getExamSubject()->sum('fullScore');

        return  isset($fullScore)?$fullScore:0;

    }


    /**
     * @inheritdoc
     * @return SeExamSchoolQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeExamSchoolQuery(get_called_class());
    }

    /**
     * 获取学校升级信息
     * @return \yii\db\ActiveQuery
     */
    public function getSchoolUpGrade()
    {
        return $this->hasMany(SeSchoolUpGrade::className(),["department"=>"departmentId"]);
    }

    /**
     * 根据学校id 和 考试名称 查询该学校考试是否存在
     * @param integer $schoolID 学校id
     * @param string $examName 考试名称
     * @return bool
     */
    public static function existsExamSchool(int $schoolID, string $examName)
    {
        return self::find()->where(['schoolId' => $schoolID, 'examName' => $examName])->exists();
    }


    /**
     * 根据学校考试id 和 学校id 查询考试详情
     * @param integer $schoolExamId 学校考试id
     * @param integer $schoolId     学校id
     * @return array|SeExamSchool|null
     */
    public static function accordingToSchoolExamIdAndSchoolIdGetSchoolExamDetails(int $schoolExamId, int $schoolId)
    {
        return self::find()->where(['schoolExamId'=>$schoolExamId,'schoolId'=>$schoolId])->limit(1)->one();
    }
}
