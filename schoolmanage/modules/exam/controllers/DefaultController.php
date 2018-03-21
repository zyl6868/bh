<?php
declare(strict_types=1);
namespace schoolmanage\modules\exam\controllers;

use common\helper\DateTimeHelper;
use common\models\dicmodels\SubjectModel;
use common\models\JsonMessage;
use common\models\pos\SeClass;
use common\models\pos\SeClassMembers;
use common\models\pos\SeExamClass;
use common\models\pos\SeExamClassSubject;
use common\models\pos\SeExamPersonalScore;
use common\models\pos\SeExamSchool;
use common\models\pos\SeExamScoreInput;
use common\models\pos\SeExamSubject;
use common\models\pos\SeSchoolInfo;
use common\models\pos\SeSchoolUpGrade;
use common\models\pos\SeUserinfo;
use common\models\sanhai\SeDateDictionary;
use common\models\sanhai\SeSchoolGrade;
use common\components\WebDataCache;
use common\models\dicmodels\SchoolLevelModel;
use PhpOffice\PhpWord\Exception\Exception;
use schoolmanage\components\helper\GradeHelper;
use schoolmanage\components\SchoolManageBaseAuthController;
use Yii;
use yii\data\Pagination;
use yii\db\Transaction;
use yii\web\Response;

/**
 * UserController implements the CRUD actions for SeUserinfo model.
 */
class DefaultController extends SchoolManageBaseAuthController
{

    public $layout = 'lay_exam_index';
    public $enableCsrfValidation = false;
	public function actionIndex()
	{
		$schoolID = $this->schoolId;
		$pages = new Pagination();
		$pages->validatePage = false;
		$pages->pageSize = 10;
		$year = app()->request->get('examYear', ''); //获取 年份
		$examType = app()->request->get('examType', ''); //获取考试类型
		$isSolved = app()->request->get('isSolved', ''); //获取录入状态
		$gradeId = app()->request->get('gradeId', '');//获取年级id
		$joinYear = app()->request->get('joinYear', '');//加入年份
		$schoolData = $this->schoolModel;
		if (empty($schoolData)) {
			return $this->notFound();
		}
		$department = (string)$schoolData->department; //学部id
		$lengthOfSchooling = (string)$schoolData->lengthOfSchooling; //学制id
		$departmentId = substr($department, 0, 5);//获取学校里的第一个学段
		$schoolLevelId = (string)app()->request->get('schoolLevel', $departmentId);//获取学部 当学部为空时 给默认学校中的第一个学部

		if (empty($schoolLevelId)) {
			return $this->redirect(url('/exam/default/index', ['schoolLevel' => $departmentId, 'gradeId' => '']));
		}
		$gradeData = GradeHelper::getGradeByDepartmentAndLengthOfSchooling($schoolLevelId, $lengthOfSchooling);
		$departmentArray = explode(',', $department);
		$schoolLevelList = SchoolLevelModel::model()->getListInData($departmentArray);//根据学校id 获取该校的学部

		$gradeModel = GradeHelper::getGradeByDepartmentAndLengthOfSchooling($schoolLevelId, $lengthOfSchooling, 1); //获取 学部和学制 相对的年级列表
		//根据年级 获取 年份列表
		$gradeArr = explode(',' , $gradeId);
		$yearArr = GradeHelper::getYearList($gradeArr, $schoolID,$schoolLevelId);

		//查询学段升级时间
		$upTime = SeSchoolUpGrade::findSchoolUpGradeIsExists($schoolID, (int)$schoolLevelId);

		//查询考试列表
		$examSchoolQuery = SeExamSchool::find()->where(['schoolId' => $schoolID, 'departmentId' => $schoolLevelId]);

		//加入年份筛选
		if (!empty($joinYear) ) {
			$examSchoolQuery->andWhere(['joinYear' => $joinYear]);
		}

		//年份筛选
		if (!empty($year) ) {
			$examSchoolQuery->andWhere(['schoolYear' => $year]);
		}
		//考试筛选
		if (!empty($examType) ) {
			$examSchoolQuery->andWhere(['examType' => $examType]);
		}
		//状态筛选
		if ($isSolved !== '' ) {
			$examSchoolQuery->andWhere(['inputStatus' => $isSolved]);
		}
		$pages->totalCount = $examSchoolQuery->count();
		$examSchoolModel = $examSchoolQuery->orderBy('createTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->all();

		if (app()->request->isAjax) {
			return $this->renderPartial('_index_exam_right_list', ['examSchoolModel' => $examSchoolModel, 'department' => $schoolLevelId, 'pages' => $pages]);
		}
		return $this->render('index', [
			'gradeData' => $gradeData,
			'schoolData' => $schoolData,
			'examSchoolModel' => $examSchoolModel,
			'gradeModel' => $gradeModel,
			'schoolID' => $schoolID,
			'gradeId' => $gradeId,
			'joinYear' => $joinYear,
			'lengthOfSchooling' => $lengthOfSchooling,
			'yearArr' => $yearArr,
			'schoolLevelList' => $schoolLevelList,
			'pages' => $pages,
			'department' => $schoolLevelId,
			'upTime' => $upTime
		]);
	}


    /**
     * 获取创建考试弹窗
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionGetExamBox(){
        $schoolID = $this->schoolId;
        $department=(string)app()->request->getBodyParam('department');
        $schoolData = $this->schoolModel;
        $lengthOfSchooling=(string)$schoolData->lengthOfSchooling;
        $gradeData=GradeHelper::getGradeByDepartmentAndLengthOfSchooling($department,$lengthOfSchooling);
        return $this->renderPartial('get_exam_box',[
                'schoolID'=>$schoolID,
                'department'=>$department,
                'gradeData'=>$gradeData,
            'schoolData'=>$schoolData
            ]);
    }

    /**
     *获取学年
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionGetSchoolYearList()
    {
        $schoolID = (int)app()->request->getBodyParam('schoolID');
        $gradeArray = app()->request->getBodyParam('gradeArray');
        $department = (string)app()->request->getBodyParam('department');
        $yearArray = GradeHelper::getYearList($gradeArray, $schoolID,$department);

        return $this->renderPartial('school_year_list', ['yearArray' => $yearArray]);
    }

    /**
     *获取考试名称
     */
    public function actionProduceExamName()
    {
        $schoolID = (int)app()->request->getBodyParam('schoolID');
        $lengthOfSchooling = (string)SeSchoolInfo::find()->where(['schoolID' => $schoolID])->one()->lengthOfSchooling;
        $gradeArray = app()->request->getBodyParam('gradeArray');
        $schoolYear = app()->request->getBodyParam('schoolYear');
        $semester = app()->request->getBodyParam('semester');
        $wenli = (int)app()->request->getBodyParam('wenli');
        $monthArray = app()->request->getBodyParam('monthArray');
        $department = (int)app()->request->getBodyParam('department');
        $examNameArray = [];
        foreach ($gradeArray as $v) {
            $yearOutGradeName = GradeHelper::getYearOutGrade((int)$v, $schoolYear,$schoolID,$department);
            $comingYear = GradeHelper::getComingYearByGrade((int)$v, $lengthOfSchooling,$schoolID,$department);
            foreach ($monthArray as $item) {
                $examName = $schoolYear . '学年' . $yearOutGradeName . '（' . $comingYear . '级）' . WebDataCache::getDictionaryName($semester) . $item . '月月考';
                if ($wenli === 1) {
                    $examNameArray[] = $examName;
                } else {
                    $examNameArray[] = $examName . '（文科）';
                    $examNameArray[] = $examName . '（理科）';
                }
            }
        }
        foreach ($examNameArray as $v) {
            echo '<li>' . $v . '</li>';
        }
    }

    /**
     *创建考试
     * @throws \yii\db\Exception
     * @throws \yii\base\ExitException
     */
    public function actionCreateExam()
    {
        $jsonResult=new JsonMessage();
        $schoolID = (int)app()->request->getBodyParam('schoolID');
        $lengthOfSchooling = (string)SeSchoolInfo::getOne($schoolID)->lengthOfSchooling;
        $gradeArray = app()->request->getBodyParam('gradeArray');
        $schoolYear = app()->request->getBodyParam('schoolYear');
        $semester = app()->request->getBodyParam('semester');
        $wenli = (int)app()->request->getBodyParam('wenli');
        $department=(int)app()->request->getBodyParam('department');
        $monthArray = app()->request->getBodyParam('monthArray');
        foreach ($gradeArray as $v) {
            $yearOutGradeName = GradeHelper::getYearOutGrade((int)$v, $schoolYear,$schoolID,$department);
            $comingYear = GradeHelper::getComingYearByGrade((int)$v, $lengthOfSchooling,$schoolID,$department);
            foreach ($monthArray as $item) {
                /** @var Transaction $transaction */
                $transaction = Yii::$app->db_school->beginTransaction();
                try {
                    $examName = $schoolYear . '学年' . $yearOutGradeName . '（' . $comingYear . '级）' . WebDataCache::getDictionaryName($semester) . $item . '月月考';
                    if ($wenli === 1) {
                        $isExisted = SeExamSchool::existsExamSchool($schoolID, $examName);
                        if (!$isExisted) {
                            $examModel = new SeExamSchool();
                            $examModel->examType = '21903';
                            $examModel->departmentId=$department;
                            $examModel->createTime = DateTimeHelper::timestampX1000();
                            $examModel->schoolId = $schoolID;
                            $examModel->semester = $semester;
                            $examModel->schoolYear = $schoolYear;
                            $examModel->examMonth = $item;
                            $examModel->createrId = user()->id;
                            $examModel->gradeId = $v;
                            $examModel->subjectType = '22401';
                            $examModel->examName = $examName;
                            $examModel->joinYear =$comingYear;
                            $examModel->save();
                        }
                    } else {
                        for ($i = 0; $i < 2; $i++) {

                            if ($i === 0) {
                                $finalExamName = $examName . '（文科）';
                                $subjectType = '22403';

                            } else {
                                $finalExamName = $examName . '（理科）';
                                $subjectType = '22402';
                            }
                            $isExisted = SeExamSchool::existsExamSchool($schoolID, $finalExamName);
                            if (!$isExisted) {
                                $examModel = new SeExamSchool();
                                $examModel->examType = '21903';
                                $examModel->departmentId=$department;
                                $examModel->createTime = DateTimeHelper::timestampX1000();
                                $examModel->schoolId = $schoolID;
                                $examModel->semester = $semester;
                                $examModel->schoolYear = $schoolYear;
                                $examModel->examMonth = $item;
                                $examModel->createrId = user()->id;
                                $examModel->gradeId = $v;
                                $examModel->subjectType = $subjectType;
                                $examModel->examName = $finalExamName;
                                $examModel->joinYear = $comingYear;
                                $examModel->save();
                            }

                        }

                    }
                    $transaction->commit();
                    $jsonResult->success=true;
                }catch (Exception $e) {
                    $transaction->rollBack();
                    \Yii::error('创建考试失败错误信息' . '------' . $e->getMessage());
                }
            }
        }
        return $this->renderJSON($jsonResult);
    }

    /*
     *设置科目和分数线
     */
    public function actionSetScore() {
        $this->layout = 'lay_exam_score';
        $schoolId = (int)$this->schoolId;
        $schoolExamId = (int)app()->request->get('examId',0);
        $this->getSeExamSchoolModel($schoolExamId);

        $SeExamSchool=SeExamSchool::accordingToSchoolExamIdAndSchoolIdGetSchoolExamDetails($schoolExamId, $schoolId);

        //学段
        $Department=SeSchoolGrade::accordingToGradeIdGetSchoolDepartment($SeExamSchool->gradeId);

        //班级和科目
        $class = SeClass::getClassIdAndClassNameAll($schoolId,$SeExamSchool->joinYear,$SeExamSchool->departmentId);

        $subject=null;
        if($class !== null){
            $subject=SubjectModel::model()->getSubjectByDepartment($Department->schoolDepartment);
        }
            //考试科目和班级(回显选中的班级，科目，分数，总分数)
            $subjectModel = SeExamSubject::getExamSubjectAll($schoolExamId);
            $classModel = SeExamClass::getClassId($schoolExamId);
            $score=$this->sumScore($subjectModel);
            return $this->render('score',['class'=>$class,'score'=>$score,'subject'=>$subject,'SeExamSchool'=>$SeExamSchool,'schoolExamId'=>$schoolExamId,'classModel'=>$classModel,'subjectModel'=>$subjectModel]);

    }


    /**
     * 接受数据
     * @return bool
     * @throws \yii\db\Exception
     */
    public function actionReceive(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $schoolExamId = (int)Yii::$app->request->post('school');
        $checked = Yii::$app->request->post('checkbox');
        $man=Yii::$app->request->post('man');
        /** @var Transaction $transaction */
        $transaction = Yii::$app->db_school->beginTransaction();
        try{
            $this->subjectList($schoolExamId,$man);
            $this->classList($schoolExamId,$checked);
            $this->subjectTeacher($schoolExamId,$man,$checked);
            $transaction->commit();
            return true;
        }catch (Exception $e){
            $transaction->rollBack();
            \Yii::error('接收数据失败错误信息' . '------' . $e->getMessage());
            return false;
        }
    }


    /**
     * 考试科目
     * @param integer $schoolExamId 学校考试id
     * @param array $man 科目
     * @throws \Exception
     */
    public function subjectList(int $schoolExamId, array $man){
        if( $man !== null ) {
            //删除科目
            $array = array_values($man);
            SeExamSubject::deleteAll(['and','schoolExamId= :school',['not in', 'subjectId', $array]],[':school' => $schoolExamId]);
            //添加或更新科目
            foreach($man as $val){
                $subjectModel=SeExamSubject::accordingToSchoolExamIdSubjectIdGetExamSubDetails($schoolExamId,$val);
                if(empty($subjectModel)){
                    $subject=new SeExamSubject();
                    $subject->schoolExamId=$schoolExamId;
                    $subject->subjectId=$val;
                    $subject->fullScore=Yii::$app->request->post($val.'_full');
                    $subject->borderlineOne=Yii::$app->request->post($val.'_cutLine');
                    $subject->createTime=DateTimeHelper::timestampX1000();
                    $subject->save();
                }else{
                    $subjectModel->fullScore=Yii::$app->request->post($val.'_full');
                    $subjectModel->borderlineOne=Yii::$app->request->post($val.'_cutLine');
                    $subjectModel->updateTime=DateTimeHelper::timestampX1000();
                    $subjectModel->update();
                }
            }
        }
    }


    /**
     * 考试班级
     * @param integer $schoolExamId 学校考试id
     * @param array $checked 选择的班级
     * @throws \Exception
     */
    public function classList(int $schoolExamId, array $checked) {
        if( $checked != null ) {
            //删除班级和成绩
            $array=array_values($checked);
            $delClass=SeExamClass::find()->where(['and','schoolExamId=:schoolExamId',['not in','classId',$array]],[':schoolExamId'=>$schoolExamId])->select('classExamId')->column();
            $examClass=SeExamClass::deleteAll(['and','schoolExamId=:schoolExamId',['not in','classId',$array]],[':schoolExamId'=>$schoolExamId]);
            if ($examClass > 0) {
                $classArray=array_values($delClass);
                SeExamPersonalScore::deleteAll(['in','classExamId',$classArray]);
                SeExamScoreInput::deleteAll(['in','classExamId',$classArray]);
            }
            //添加或更新班级
            foreach ($checked as $val) {
                $classModel=SeExamClass::find()->where(['schoolExamId'=>$schoolExamId,'classId'=>$val])->one();
                if(empty($classModel)){
                    $class=new SeExamClass();
                    $class->schoolExamId=$schoolExamId;
                    $class->classId=$val;
                    $class->inputStatus=0;
                    $class->createTime=DateTimeHelper::timestampX1000();
                    $class->save();
                }else{
                    $classModel->updateTime=DateTimeHelper::timestampX1000();
                    $classModel->update();
                }
            }
            $inputStatus=SeExamClass::find()->where(['schoolExamId'=>$schoolExamId])->select('inputStatus')->column();
            $statusSum=SeExamClass::find()->where(['schoolExamId'=>$schoolExamId,'inputStatus'=>2])->select('inputStatus')->count();
           if(in_array(1,$inputStatus,false)){
               $this->upSchool($status=1,$schoolExamId);
           }elseif((float)count($inputStatus) ===(float)($statusSum)){
               $this->upSchool($status=2,$schoolExamId);
           }else{
               $this->upSchool($status=0,$schoolExamId);
           }
        }
    }


    /**
     * 设置科目和分数线回显总分
     * @param array $subjectModel 学校考试科目列表
     * @return array
     */
    public function sumScore(array $subjectModel){
        $sum=0;
        $scoreLine=0;
        if($subjectModel !== null){
            foreach($subjectModel as $val){
                $sum+=$val->fullScore;
                $scoreLine+=$val->borderlineOne;
            }
        }
        $list = null;
        $list = ['sum'=>$sum,'scoreLine'=>$scoreLine];
        return $list;
    }


    /**
     * 更新考试状态
     * @param integer $status 成绩录入状态，0未录入，1录入中，2录入完成
     * @param integer $schoolExamId 学校考试id
     * @return int
     */
    public function upSchool(int $status, int $schoolExamId){
        return  SeExamSchool::updateAll(['inputStatus'=>$status],'schoolExamId=:schoolExamId',[':schoolExamId'=>$schoolExamId]);
    }


    /**
     * 考试班级，科目老师
     * @param integer $schoolExamId 学校考试id
     * @param array $man 科目
     * @param array $checked 选择的班级
     * @throws \Exception
     */
    public function subjectTeacher(int $schoolExamId, array $man, array $checked){
        if($schoolExamId !== null && $man !== null && $checked !== null) {
            $class = [];
            $subject = [];
            //班级和科目
            foreach($checked as $val){
               $class[]= SeExamClass::find()->where(['schoolExamId'=>$schoolExamId,'classId'=>$val])->select('classExamId,classId')->one();
            }
            foreach($man as $v){
                $subject[]=  SeExamSubject::find()->where(['schoolExamId'=>$schoolExamId,'subjectId'=>$v])->select('examSubId,subjectId')->one();
            }
           //删除考试班级科目老师
            $subjectId = [];
            foreach($subject as $val){
                $subjectId[] = $val->examSubId;
            }
            $classId = [];
            foreach($class as $val){
                $classId[] = $val->classExamId;
            }
            $examSubId = array_values($subjectId);
            $classExamId = array_values($classId);
            SeExamClassSubject::deleteAll(['and','schoolExamId=:schoolExamId',['or',['not in','examSubId',$examSubId],['not in','classExamId',$classExamId]]],[':schoolExamId'=>$schoolExamId]);
            //添加或更新考试班级科目老师
            if($class !== null && $subject !== null){
                foreach($class as $val){
                    foreach($subject as $v){
                       $subjectTeacher= SeExamClassSubject::find()->where(['examSubId'=>$v->examSubId,'classExamId'=>$val->classExamId])->one();
                       if($subjectTeacher === null){
                           $this->subTeacher($v,$val,$schoolExamId);

                       } else{
                           $subjectTeacher->updateTime=DateTimeHelper::timestampX1000();
                           $subjectTeacher->update();
                       }
                    }
                }
            }

        }
    }


    /**
     * 学校老师或校长ID
     * @param SeExamClass $val 班级考试
     * @param integer $subjectID 科目id
     * @return array|SeUserinfo|null
     */
    public function user(SeExamClass $val, int $subjectID) {
        $classResult=SeClassMembers::find()->where(['classID'=>$val->classId])->select('userID')->column();
         return SeUserinfo::find()->where(['userID'=>$classResult,'subjectID'=>$subjectID])->active()->select('userID')->one();
    }


    /**
     * 考试班级科目老师
     * @param SeExamSubject $v 学校考试科目列表
     * @param SeExamClass $val 班级考试
     * @param integer $schoolExamId 学校考试id
     */
    public  function subTeacher(SeExamSubject $v, SeExamClass $val, int $schoolExamId) {
        $teacherID=$this->user($val,$v->subjectId);

        $teacher=new SeExamClassSubject();
        $teacher->examSubId=$v->examSubId;
        $teacher->classExamId=$val->classExamId;
        $teacher->schoolExamId=$schoolExamId;
        $teacher->createTime=DateTimeHelper::timestampX1000();
        if($teacherID){
            $teacher->teacherId=$teacherID->userID;
        }else{
            $teacher->teacherId=0;
        }
        $teacher->save();
    }


}

