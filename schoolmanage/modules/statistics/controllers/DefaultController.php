<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/2/22
 * Time: 16:47
 */

namespace schoolmanage\modules\statistics\controllers;

use common\business\homework\ClassContrastModel;
use common\helper\ExcelHelper;
use common\helper\MathHelper;
use common\models\pos\SeExamClass;
use common\models\pos\SeExamPersonalScore;
use common\models\pos\SeExamReportBaseInfo;
use common\models\pos\SeExamSchool;
use common\models\pos\SeExamSubject;
use common\models\pos\SeSchoolUpGrade;
use schoolmanage\components\helper\GradeHelper;
use schoolmanage\components\SchoolManageBaseAuthController;
use Yii;
use yii\data\Pagination;

class DefaultController extends SchoolManageBaseAuthController
{
	public $layout = 'lay_statistics_index';
	public $enableCsrfValidation = false;

	/**
	 * 后台考务管理主页
	 * @return string
	 * @throws \yii\base\ExitException
	 * @throws \yii\base\InvalidParamException
	 * @throws \yii\web\HttpException
	 */
	public function actionIndex()
	{
		$schoolId = $this->schoolId;
		$pages = new Pagination();
		$pages->validatePage = false;
		$pages->pageSize = 10;

		$year = app()->request->get('examYear', null); //获取 年份
		$examType = app()->request->get('examType', null); //获取考试类型
		$gradeId = app()->request->get('gradeId', '');//获取年级id
		$joinYear = app()->request->get('joinYear');//加入年份
		$schoolData = $this->schoolModel;
		if ($schoolData == null) {
			return $this->notFound();
		}

		$department = $schoolData->department;
		$lengthOfSchooling = $schoolData->lengthOfSchooling;
		$departmentId = substr($department, 0, 5);//获取学校里的_index_exam_right_list第一个学段
		$schoolLevelId = (string)app()->request->get('schoolLevel', $departmentId);//获取学部 当学部为空时 给默认学校中的第一个学部

		if (empty($schoolLevelId)) {
			return $this->redirect(url('/statistics/default/index', ['schoolLevel' => $departmentId, 'gradeId' => '']));
		}

		$gradeData = GradeHelper::getGradeByDepartmentAndLengthOfSchooling($schoolLevelId, $lengthOfSchooling);

		$gradeModel = GradeHelper::getGradeByDepartmentAndLengthOfSchooling($schoolLevelId, $lengthOfSchooling, 1); //获取 学部和学制 相对的年级列表
		//根据年级 获取 年份列表
		$gradeArr = explode(',', $gradeId);
		$yearArr = GradeHelper::getYearList($gradeArr, $schoolId,$schoolLevelId);

		//查询学段升级时间
		$upTime = SeSchoolUpGrade::findSchoolUpGradeIsExists($schoolId, (int)$schoolLevelId);

		//查询考试列表
		$examSchoolQuery = SeExamSchool::find()->where(['schoolId' => $schoolId, 'departmentId' => $schoolLevelId, 'reportStatus' => 2]);

		//加入年份筛选
		if (!empty($joinYear)) {
			$examSchoolQuery->andWhere(['joinYear' => $joinYear]);
		}
		//年份筛选
		if (!empty($year)) {
			$examSchoolQuery->andWhere(['schoolYear' => $year]);
		}
		//考试筛选
		if (!empty($examType)) {
			$examSchoolQuery->andWhere(['examType' => $examType]);
		}
		$pages->totalCount = $examSchoolQuery->count();
		$examSchoolModel = $examSchoolQuery->orderBy('createTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->all();

		if (app()->request->isAjax) {
			return $this->renderPartial('_index_exam_right_list', ['examSchoolModel' => $examSchoolModel, 'schoolData' => $schoolData, 'lengthOfSchooling' => $lengthOfSchooling, 'schoolID' => $schoolId, 'gradeId' => $gradeId, 'pages' => $pages]);
		}
		return $this->render('index', [
			'gradeData' => $gradeData,
			'schoolData' => $schoolData,
			'examSchoolModel' => $examSchoolModel,
			'gradeModel' => $gradeModel,
			'schoolID' => $schoolId,
			'gradeId' => $gradeId,
			'lengthOfSchooling' => $lengthOfSchooling,
			'department' => $department,
			'yearArr' => $yearArr,
			'pages' => $pages,
			'departmentId' => $schoolLevelId,
			'upTime' => $upTime,
			'joinYear' => $joinYear,
		]);
	}

	/**
	 * @return string
	 * @throws \yii\base\InvalidParamException
	 * @throws \yii\web\HttpException
	 * 统计概览
	 */
	public function actionOverview()
	{

		$schoolExamId = (int)app()->request->get('examId');
		$classId = (int)app()->request->get('classId', null);
		$subjectId = (int)app()->request->get('subjectId', null);

		$this->getSeExamSchoolModel($schoolExamId);

		//查询班级
		$examClass = SeExamClass::find()->where(['schoolExamId' => $schoolExamId])->all();
		//查询当前考试下科目
		$seExamSubject = SeExamSubject::find()->where(['schoolExamId' => $schoolExamId])->all();

		$rankListDesc = [];
		$rankListAsc = [];
		if (!empty($classId) && !empty($subjectId)) { //单年级，单科目
			$data = SeExamReportBaseInfo::getSingleClassSingleSubjectInfo($schoolExamId, $classId, $subjectId);
			$seExamReprotBaseInfoList = $data['seExamReprotBaseInfoList'];
			$rankListDesc = $data['rankListDesc'];
			$rankListAsc = $data['rankListAsc'];

		} elseif (empty($classId) && !empty($subjectId)) { //全部年级单科目
			$seExamReprotBaseInfoList = SeExamReportBaseInfo::getAllClassSingleSubjectInfo($schoolExamId, $subjectId);

		} elseif (!empty($classId) && empty($subjectId)) { //单年级全部科目
			$seExamReprotBaseInfoList = SeExamReportBaseInfo::getSingleClassAllSubjectInfo($schoolExamId, $classId);
		} else {  //全部年级全部科目

			$seExamReprotBaseInfoList = SeExamReportBaseInfo::getAllClassAllSubjectInfo($schoolExamId);

		}

		//查询考试标题
		$examSchoolData = SeExamSchool::find()->where(['schoolExamId' => $schoolExamId])->one();
		$examName = '';
		if (!empty($examSchoolData)) {
			$examName = $examSchoolData->examName;
		}

		//班级总分分数段占比
		$scoreSectionCount = $this->classTotalScore($schoolExamId, $classId, $subjectId);
		$section = [];
		$count = [];
		$allCount = 0;
		foreach ($scoreSectionCount as $v) {
			$allCount += $v['total'];
		}

		foreach ($scoreSectionCount as $k => $v) {
			if ($k == 0) {
				$section[] = '[' . $v['min'] . ',' . $v['max'] . ']';
			} else {
				$section[] = '(' . $v['min'] . ',' . $v['max'] . ']';
			}
			$count[] = sprintf('%.2f', MathHelper::division($v['total'], $allCount) * 100);
		}

		if (app()->request->isAjax) {
			if (!empty($subjectId)) {
				return $this->renderPartial('_score_overview_info', [
					'seExamReprotBaseInfoList' => $seExamReprotBaseInfoList,
					'subjectId' => $subjectId,
					'classId' => $classId,
					'examId' => $schoolExamId,
					'section' => $section,
					'count' => $count,
					'rankListDesc' => $rankListDesc,
					'rankListAsc' => $rankListAsc
				]);
			} else {
				return $this->renderPartial('_score_overview_info', [
					'seExamReprotBaseInfoList' => $seExamReprotBaseInfoList,
					'subjectId' => $subjectId,
					'classId' => $classId,
					'examId' => $schoolExamId,
					'section' => $section,
					'count' => $count,
				]);
			}

		}

		return $this->render('score_overview', [
			'seExamReprotBaseInfoList' => $seExamReprotBaseInfoList,
			'examClass' => $examClass,
			'seExamSubject' => $seExamSubject,
			'subjectId' => $subjectId,
			'classId' => $classId,
			'examId' => $schoolExamId,
			'section' => $section,
			'count' => $count,
			'examName' => $examName
		]);
	}


	/**
	 * 班级总分分数段占比
	 * @param int $examId 考试ID
	 * @param int $classId 班级ID
	 * @param int $subjectId 科目ID
	 * @return array
     */
	public function classTotalScore(int $examId, int $classId, int $subjectId)
	{

		$examClassModel = SeExamClass::find()->where(['schoolExamId' => $examId]);
		if (!empty($classId)) {
			$examClassModel->andWhere(['classId' => $classId]);
		}
		$examClassData = $examClassModel->all();
		$data = [];
		foreach ($examClassData as $v) {
			$personalScore = SeExamPersonalScore::find()->where(['classExamId' => $v->classExamId])->all();
			foreach ($personalScore as $v1) {
				if (!empty($subjectId)) {

					$data[] = ExcelHelper::getSubjectScore($subjectId, $v1);

				} else {
					$data[] = $v1->totalScore;
				}

			}
		}
		if (!empty($subjectId)) {
			$examSubject = SeExamSubject::find()->where(['schoolExamId' => $examId, 'subjectId' => $subjectId])->one();
			if (!empty($examSubject)) {
				$totalScore = $examSubject->fullScore;
			}
			$scoreSection = 10;

			$scoreSectionCount = $this->scoreSectionCount($data, $scoreSection, (float)$totalScore);
		} else {
			$examSubject = SeExamSubject::find()->select(['fullScore'])->where(['schoolExamId' => $examId])->all();
			$totalScore = 0;
			if (!empty($examSubject)) {
				foreach ($examSubject as $v) {
					$totalScore += $v->fullScore;
				}
			}
			$scoreSection = 50;
			$scoreSectionCount = $this->scoreSectionCount($data, $scoreSection, (float)$totalScore);
		}

		//data : ['[0,50]','[50,100]','[100,150]','[150,200]','[200,250]','[250,300]']


		return $scoreSectionCount;
	}


	/**
	 * 班级对比
	 * @return string
	 * @throws \yii\base\InvalidParamException
	 * @throws \yii\web\HttpException
	 */
	public function actionClassesContrast()
	{

		$schoolExamId = (int)app()->request->get('examId');
		$subjectId = (int)app()->request->get('subjectId');
		$num = app()->request->get('num');

		$this->getSeExamSchoolModel($schoolExamId);

		$examSchool = SeExamSchool::find()->where(['schoolExamId' => $schoolExamId])->one();
		$class = SeExamClass::find()->where(['schoolExamId' => $schoolExamId])->select('classExamId,schoolExamId,classId')->all();
		//显示科目
		$subject = SeExamSubject::find()->where(['schoolExamId' => $schoolExamId])->select('subjectId')->column();
		$classModel = new ClassContrastModel();
		$subList = $classModel->showSubject($subject);
		$studentAnalyze = [];
		if (empty($subjectId)) {
			//总成绩
			$dataList = $classModel->classSumScore($class, $schoolExamId);
			//优良率
			$contrastList = $classModel->classGoodNum($class, $schoolExamId);
			//及格率
			$passList = $classModel->classPassList($class, $schoolExamId);
			//低分率
			$lowList = $classModel->classLowList($class, $schoolExamId);
			//高分人数对比
			$topList = $classModel->classTopList($class, $schoolExamId);
			//不及格人数对比
			$lowScoreList = $classModel->classNoPassList($class, $schoolExamId);
			//学生构成分析
			$studentAnalyze = $classModel->classAnalyze($schoolExamId);
		} else {
			//单科成绩
			$dataList = $classModel->subjectScoreSum($subjectId, $schoolExamId);
			//优良率
			$contrastList = $classModel->subjectExcellent($schoolExamId, $subjectId);
			//及格率
			$passList = $classModel->subjectNoPass($schoolExamId, $subjectId);
			//低分率
			$lowList = $classModel->subjectLow($schoolExamId, $subjectId);
			//高分人数对比
			$topList = $classModel->subjectTopList($schoolExamId, $subjectId);
			//单科不及格人数对比
			$lowScoreList = $classModel->subjectLowList($schoolExamId, $subjectId);
		}
		if (app()->request->isAjax) {
			if ($num == 1) {
				return $this->renderPartial('_average_class', ['dataList' => $dataList]);
			} elseif ($num == 2) {
				return $this->renderPartial('_three_contrast_class', ['contrastList' => $contrastList, 'passList' => $passList, 'lowList' => $lowList]);
			} elseif ($num == 3) {
				return $this->renderPartial('_top_low_class', ['topList' => $topList, 'lowScoreList' => $lowScoreList]);
			}

		}
		return $this->render('classes_contrast', [
			'examSchool' => $examSchool,
			'examId' => $schoolExamId,
			'subList' => $subList,
			'dataList' => $dataList,
			'contrastList' => $contrastList,
			'passList' => $passList,
			'lowList' => $lowList,
			'topList' => $topList,
			'lowScoreList' => $lowScoreList,
			'studentAnalyze' => $studentAnalyze]);
	}


	/**
	 * @param string $schoolLevelId
	 * @return array|\yii\web\Response
	 * @throws \yii\base\ExitException
	 * @throws \yii\web\HttpException
	 * 左侧--班级学段选择
	 */
	public function selectClass(string $schoolLevelId)
	{
		$data = [];

		$schoolData = $this->schoolModel;
		if ($schoolData == null) {
			return $this->notFound();
		}

		$department = $schoolData->department;

		$lengthOfSchooling = $schoolData->lengthOfSchooling;

		$departmentId = substr($department, 0, 5);//获取学校里的_index_exam_right_list第一个学段
		if (empty($schoolLevelId)) {
			return $this->redirect(url('/statistics/default/index', ['schoolLevel' => $departmentId, 'gradeId' => '']));
		}
		$gradeModel = GradeHelper::getGradeByDepartmentAndLengthOfSchooling($schoolLevelId, $lengthOfSchooling, 1); //获取 学部和学制 相对的年级列表

		$data['department'] = $department;
		$data['gradeModel'] = $gradeModel;
		return $data;
	}


	/**
	 * 每个分数段的人数
	 * @param array $data 学生考试各个科目成绩
	 * @param int $scoreSection 分段
	 * @param float $totalScore 满分
	 * @return array
     */
	public function scoreSectionCount(array $data, int $scoreSection, float $totalScore)
	{
		$num = ceil($totalScore / $scoreSection);
		$scoreSectionData = [];
		for ($i = 0; $i < $num; $i++) {
			$min = $scoreSection * $i;
			$max = $scoreSection * ($i + 1);
			$total = 0;
			if ($i === 0) {
				foreach ($data as $v) {
					if ($v >= $min && $v <= $max) {
						$total += 1;
					}
				}
			} else {
				foreach ($data as $v) {
					if ($i === $num - 1) {
						$max = $totalScore;
					}
					if ($v > $min && $v <= $max) {
						$total += 1;
					}
				}
			}

			$scoreSectionData[] = ['min' => $min, 'max' => $max, 'total' => $total];
		}

		return $scoreSectionData;
	}

}