<?php

namespace common\models\pos;

use common\helper\DateTimeHelper;
use common\models\sanhai\SrMaterial;
use frontend\components\helper\DepartAndSubHelper;
use common\components\WebDataCache;
use common\components\WebDataKey;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "se_class".
 *
 * @property integer $classID 班级id
 * @property string $className 班级别名
 * @property integer $schoolID 学校id
 * @property integer $createTime 创建时间
 * @property integer $updateTime 最后一次修改时间
 * @property integer $isDelete 是否已删除，0表示未删除，1表示已删除，默认0
 * @property string $ownStuList 是否存在学生名单，0表示不存在，1表示存在，默认0
 * @property string $joinYear 入学年份
 * @property string $classNumber 第几班
 * @property integer $gradeID 年级id
 * @property string $stuID 学生学号
 * @property integer $creatorID 创建人id
 * @property integer $department 学部，学段(小学，初中，高中)
 * @property integer $disabled 是否已经禁用 0：未禁用/激活/解禁/审核通过  1：已经禁用
 * @property string $logoUrl 班级logourl
 * @property integer $status 默认：0活动的班,1封班,2毕业
 * @property string $inviteCode 邀请码
 * @property integer $upgradeTime 升级时间
 * @property integer $closeTime 封班时间
 */
class SeClass extends PosActiveRecord
{
    /**
     * 活动的班
     */
    const    IS_LIVE = 0;
    /**
     * 封班
     */
    const   IS_CLOSED = 1;
    /**
     * 毕业
     */
    const   IS_OVER = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_class';
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
     * @return SeClassQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeClassQuery(get_called_class());
    }


    /**
     *查询本班的所有科目
     */
    public function getClassSubjects()
    {

        $subjectNumber = [];
        $subjects = DepartAndSubHelper::getTopicSubArray();
        foreach ($subjects as $k => $v) {
            if ($this->department == $k) {
                $subjectNumber[] = $v;
            }
        }
        return $subjectNumber;

    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['classID'], 'required'],
            [['classID', 'status'], 'integer'],
            [['className', 'schoolID', 'createTime', 'updateTime', 'classNumber', 'gradeID', 'stuID', 'creatorID', 'department'], 'string', 'max' => 20],
            [['isDelete', 'ownStuList', 'disabled'], 'string', 'max' => 2],
            [['joinYear'], 'string', 'max' => 30],
            [['logoUrl'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'classID' => '班级id',
            'className' => '班级别名',
            'schoolID' => '学校id',
            'createTime' => '创建时间',
            'updateTime' => '最后一次修改时间',
            'isDelete' => '是否已删除，0表示未删除，1表示已删除，默认0',
            'ownStuList' => '是否存在学生名单，0表示不存在，1表示存在，默认0',
            'joinYear' => '入学年份',
            'classNumber' => '第几班',
            'gradeID' => '年级id',
            'stuID' => '学生学号',
            'creatorID' => '创建人id',
            'department' => '学部，学段',
            'disabled' => '是否已经禁用 0：未禁用/激活/解禁/审核通过  1：已经禁用',
            'logoUrl' => '班级logourl',
            'status' => '班级状态',
        ];
    }

    /**
     * 查询所有作业数
     * @return int|string
     */
    public function getCountHomeworkMember()
    {
        $cache = Yii::$app->cache;
        $key = WebDataKey::CLASS_HOMEWORK_MEMBER_CACHE_KEY . $this->classID;
        $homeworkMember = $cache->get($key);
        if ($homeworkMember == false) {
            $homeworkMember = SeHomeworkRel::find()->where(['classID' => $this->classID])->active()->count();
            $cache->set($key, $homeworkMember, 300);
        }
        return $homeworkMember;
    }

    /**
     * 已截止的作业数
     * @return int|string
     */

    public function getCountDeadlineTimeHomeworkMember()
    {
        $cache = Yii::$app->cache;
        $key = WebDataKey::CLASS_DEADLINE_TIME_HOMEWORK_MEMBER_CACHE_KEY . $this->classID;
        $deadlineTimeHomework = $cache->get($key);
        if ($deadlineTimeHomework == false) {
            $deadlineTimeHomework = 0;
            $SeHomeworkRel = SeHomeworkRel::find()->where(['classID' => $this->classID])->active()->all();
            foreach ($SeHomeworkRel as $val) {
                $deadlineTime = strtotime(date('Y-m-d 23:59:59', DateTimeHelper::timestampDiv1000($val->deadlineTime)));
                if ($deadlineTime < time()) {
                    $deadlineTimeHomework++;
                }
            }
            $cache->set($key, $deadlineTimeHomework, 300);
        }
        return $deadlineTimeHomework;
    }

    /**
     * 查询作业列表~
     * @return array|SeHomeworkRel[]
     */
    public function getHomeworkRelList()
    {
        $homeworkRel = SeHomeworkRel::find()->where(['classID' => $this->classID])->active()->all();
        return $homeworkRel;
    }

    /**
     *  查询所有考试总计数
     * @return int|string
     */
    public function getExamInfoCount()
    {
        $examInfoMem = SeExaminfo::find()->where(['classID' => $this->classID])->active()->count();
        return $examInfoMem;
    }

    /**
     * 查询所有已完成的考试
     * @return int|string
     */
    public function getFinishExamMem()
    {
        $finishExamMem = SeExaminfo::find()->where(['classID' => $this->classID])->andWhere(['<', 'examTime', date("Y-m-d", time())])->active()->count();
        return $finishExamMem;
    }

    /**
     * 查询所有答疑数
     * @return int|string
     */
    public function getAnswerAllCount()
    {
        $cache = Yii::$app->cache;
        $key = WebDataKey::CLASS_ANSWER_ALL_COUNT_CACHE_KEY . $this->classID;
        $answerAllCount = $cache->get($key);
        if ($answerAllCount == false) {
            $answerAllCount = SeAnswerQuestion::find()->where(['classID' => $this->classID])->active()->count();
            $cache->set($key, $answerAllCount, 3600);
        }
        return $answerAllCount;
    }

    /**
     * 查询已解决的答疑数
     * @return int|string
     */
    public function getResolvedAnswer()
    {
        $cache = Yii::$app->cache;
        $key = WebDataKey::CLASS_RESOLVED_ANSWER_COUNT_CACHE_KEY . $this->classID;
        $resolvedAnswer = $cache->get($key);
        if ($resolvedAnswer == false) {
            $resolvedAnswer = SeAnswerQuestion::find()->where(['classID' => $this->classID])->andWhere(['isSolved' => 1])->active()->count();
            $cache->set($key, $resolvedAnswer, 3600);
        }
        return $resolvedAnswer;
    }

    /**
     * 查询文件总数
     * @return int|string
     */
    public function getFileCount()
    {
        $cache = Yii::$app->cache;
        $key = WebDataKey::CLASS_FILE_COUNT_CACHE_KEY . $this->classID;
        $fileCount = $cache->get($key);
        if ($fileCount == false) {
            $fileCount = SeShareMaterial::find()->where(['classId' => $this->classID])->active()->count();
            $cache->set($key, $fileCount, 3600);
        }
        return $fileCount;
    }

    /**
     * 查询阅读数~
     * @return mixed
     */

    public function getReadCount()
    {
        $cache = Yii::$app->cache;
        $key = WebDataKey::CLASS_READ_COUNT_CACHE_KEY . $this->classID;
        $readCount = $cache->get($key);
        if ($readCount == false) {
            //查询文件
            $fileMatId = SeShareMaterial::find()->where(['classId' => $this->classID])->active()->select('matId')->column();
            //阅读数
            $readCount = SrMaterial::find()->where(['id' => $fileMatId])->sum('readNum');
            $cache->set($key, $readCount, 3600);
        }
        return $readCount;
    }

    /**
     * 查询班级教师
     * @return array|SeClassMembers[]
     */
    public function getClassTeacherList()
    {
        $cache = Yii::$app->cache;
        $key = WebDataKey::WEB_CLASS_VIEW_TEACHER_CACHE_KEY . $this->classID;
        $data = $cache->get($key);
        if ($data == false) {
            $classMemberQuery = SeClassMembers::find()->where(['classID' => $this->classID]);
            $classMemberQuery->andWhere(['>', 'userID', '']);
            $data = $classMemberQuery->andWhere(['identity' => [20402, 20401]])->all();
            if ($data != null) {
                $cache->set($key, $data, 600);
            }
        }

        return $data;
    }

    /**
     * 查询班级学生
     * @return array|SeClassMembers[]
     */
    public function getClassStudentList(int $limit = 0)
    {
        $cache = Yii::$app->cache;
        $key = WebDataKey::WEB_CLASS_VIEW_STUDENT_CACHE_KEY . $this->classID . '_' . $limit;
        $data = $cache->get($key);
        if ($data == false) {
            $classMemberQuery = SeClassMembers::find()->where(['classID' => $this->classID]);
            $classMemberQuery->andWhere(['>', 'userID', '']);
            if ($limit > 0) {
                $data = $classMemberQuery->andWhere(['identity' => 20403])->limit($limit)->all();
            } else {
                $data = $classMemberQuery->andWhere(['identity' => 20403])->all();
            }
            if ($data != null) {
                $cache->set($key, $data, 600);
            }
        }

        return $data;
    }


    /**
     * 成员所在班级及班级名
     * @param integer $userId 用户ID
     * @return array|SeClassMembers[]
     */
    public static function getClasses(int $userId)
    {
        return SeClass::findBySql("select class.className,class.classID
                               from se_class class
                               INNER JOIN se_classMembers classMembers
                               ON class.classID=classMembers.classID

                                WHERE classMembers.userID=:userId", [":userId" => $userId])->all();

    }


    /**
     * 判断是否创建过该班级
     * @param $schoolID
     * @param $departmentId
     * @param $gradeId
     * @param $classNumber
     * @return array|SeClass|null
     */
    public static function isCreateClass($schoolID, $departmentId, $gradeId, $classNumber)
    {

        $classData = SeClass::find()->where(['schoolID' => $schoolID, 'department' => $departmentId, 'gradeID' => $gradeId, 'classNumber' => $classNumber])->active()->limit(1)->one();
        return $classData;
    }


    /**
     * 获取班级名称
     * @param int $school 学校ID
     * @param string|null $grade 年级
     * @param string|null $department 学部
     * @return array|SeClass[]
     */
    public static function getClassList(int $school, string $grade = null, string $department = null)
    {
        if (!isset($school)) {
            return [];
        }
        $classQuery = SeClass::find()->where(['schoolID' => $school])->active()->isDelete()->select('classID,className');
        if (!empty($department)) {
            $classQuery->andWhere(['department' => $department]);
        }

        if (!empty($grade)) {
            $classQuery->andWhere(['gradeID' => $grade]);
        }

        $ClassList = null;
        $ClassList = $classQuery->orderBy('gradeID asc,`classNumber`+0 asc')->all();

        return $ClassList;
    }


    /**
     * 获取班级管理列表数据
     * @param int $school 学校ID
     * @param string $grade 年级
     * @param string $classId 班级
     * @param string $department 学段
     * @param int $status 状态
     * @return array
     * @throws \yii\db\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function getClassInfoList(int $school, string $grade = '', string $classId = '', string $department = '', int $status)
    {

        if (!isset($school)) {
            return [];
        }
        $classQuery = SeClass::find()->where(['schoolID' => $school])->select('classID,className,joinYear,gradeID,status');

        if (!empty($department)) {
            $classQuery->andWhere(['department' => $department]);
        }
        if (!empty($grade)) {
            $classQuery->andWhere(['gradeID' => $grade]);
        }
        if (!empty($classId)) {
            $classQuery->andWhere(['classID' => $classId]);
        }
        if (!empty($status)) {
            $classQuery->andWhere(['status' => $status - 1]);
        }
        $modelList = $classQuery->isDelete()->orderBy('gradeID asc,`classNumber`+0 asc')->all();
        $classIds = ArrayHelper::getColumn($modelList,'classID');
        $query = new Query();
        $query->select('count(CASE WHEN b.identity = 20401 OR b.identity = 20402 THEN b.identity END) teacherNum,count(CASE WHEN b.identity = 20403 THEN b.identity END) studentNum,a.classID,(select userID from se_classMembers cm where  cm.identity = 20401 and cm.classID=a.classID limit 1) classAdviser')
            ->from('se_class a')
            ->join('LEFT JOIN','se_classMembers b', 'a.classID = b.classID')
            ->groupBy('a.classID');
        $query->where(['in', 'a.classID', $classIds]);
        /** @var Query $query */
        $classIdss = $query->createCommand(Yii::$app->get('db_school'))->queryAll();

        $classArr = [];
        if ($modelList) {
            foreach ($modelList as $k => $v) {
                foreach ($classIdss as $val) {
                    $classArr[$k]['joinYear'] = $v['joinYear'];
                    $classArr[$k]['gradeID'] = $v['gradeID'];
                    $classArr[$k]['classID'] = $v['classID'];
                    $classArr[$k]['className'] = $v['className'];
                    if ($v['classID'] == $val['classID']) {
                        $classArr[$k]['teacherNum'] = $val['teacherNum'];
                        $classArr[$k]['studentNum'] = $val['studentNum'];
                        $classArr[$k]['classAdviser'] = !empty($val['classAdviser']) ? WebDataCache::getTrueNameByuserId($val['classAdviser']) : '--';
                    }
                    $classArr[$k]['status'] = $v['status'];
                }
            }
        }
        return $classArr;
    }

    /**
     * 获取班级状态
     * @param $status
     * @return string
     */
    public static function getClassStatus($status)
    {
        $classStatus = '活动';
        if ($status == 0) {
            $classStatus = '活动';
        } else if ($status == 1) {
            $classStatus = '已封班';
        } else if ($status == 2) {
            $classStatus = '已毕业';
        }

        return $classStatus;

    }

    /**
     * 查询班级教师总数
     * @return int|mixed|string
     */
    public function getClassTeacherCount()
    {
        $cache = Yii::$app->cache;
        $key = WebDataKey::WEB_CLASS_COUNT_TEACHER_CACHE_KEY . $this->classID;
        $data = $cache->get($key);
        if ($data == false) {
            $classMemberQuery = SeClassMembers::find()->where(['classID' => $this->classID])->andWhere(['>', 'userID', 0]);
            $data = $classMemberQuery->andWhere(['identity' => [20402, 20401]])->count();
            if ($data != null) {
                $cache->set($key, $data, 600);
            }
        }

        return $data;
    }

    /**
     * 查询班级学生总数
     * @return int|mixed|string
     */
    public function getClassStudentCount()
    {
        $cache = Yii::$app->cache;
        $key = WebDataKey::WEB_CLASS_COUNT_STUDENT_CACHE_KEY . $this->classID;
        $data = $cache->get($key);
        if ($data == false) {
            $classMemberQuery = SeClassMembers::find()->where(['classID' => $this->classID])->andWhere(['>', 'userID', 0]);
            $data = $classMemberQuery->andWhere(['identity' => 20403])->count();
            if ($data != null) {
                $cache->set($key, $data, 600);
            }
        }
        return $data;
    }

    /**
     * 根据班级获取学部
     * @param integer $classId
     * @return string
     */
    public static function getClassDepartment($classId)
    {
        $classModel = self::find()->where(['classID' => $classId])->limit(1)->one();
        $departmentName = '';
        if (!empty($classModel)) {
            $department = $classModel->department;
            if ($department == 20203) {
                $departmentName = '高中';
            } else if ($department == 20202) {
                $departmentName = '初中';
            } else {
                $departmentName = '小学';
            }
        }
        return $departmentName;
    }

    /**
     * 根据 学校id 入学年份 学部id 获取学校班级名称和id
     * @param integer $schoolId 学校id
     * @param integer $joinYear 入学年份
     * @param integer $departmentId 学部，学段
     * @return array|SeClass[]
     */
    public static function getClassIdAndClassNameAll(int $schoolId, int $joinYear, int $departmentId)
    {
        return self::find()->where(['schoolID' => $schoolId, 'joinYear' => $joinYear, 'department' => $departmentId, 'status' => 0])->select('classID,className')->all();
    }


    /**
     * 根据班级id获取学部
     * wgl
     * @param int $classID 班级id
     * @return array|SeClass|null
     */
    public static function accordingToClassIdGetDepartment(int $classID)
    {
        return self::find()->where(['classID' => $classID])->select('department')->limit(1)->one();
    }

    /**
     * 根据班级查询所属年级
     * @param array $classId 班级id
     * @return array
     */
    public static function getGradeIds(array $classId)
    {
        $gradeIdArr = [];
        $clsssInfo = self::find()->select('gradeID')->where(['classID' => $classId])->orderBy('gradeID')->all();
        foreach ($clsssInfo as $v) {
            $gradeIdArr[] = $v->gradeID;
        }
        return $gradeIdArr;
    }

}
