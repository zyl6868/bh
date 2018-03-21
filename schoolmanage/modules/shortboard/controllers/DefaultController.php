<?php
declare(strict_types=1);
namespace schoolmanage\modules\shortboard\controllers;

use common\helper\dt\Carbon;
use common\models\databusiness\SdUserWeaknessKid;
use common\models\pos\SeSchoolUpGrade;
use frontend\components\helper\DepartAndSubHelper;
use common\components\WebDataKey;
use common\models\dicmodels\KnowledgePointModel;
use schoolmanage\components\helper\GradeHelper;
use schoolmanage\components\SchoolManageBaseAuthController;
use Yii;
use yii\db\Query;

class DefaultController extends SchoolManageBaseAuthController
{
    public $layout = 'lay_statistics_index';
    public $enableCsrfValidation = false;

    public function actionIndex()
    {

        $schoolData = $this->schoolModel;
        if ($schoolData == null) {
            return $this->notFound();
        }

        $department = $schoolData->department;  //学部id(20201,20202,20203)
        $lengthOfSchooling = $schoolData->lengthOfSchooling; //学制id
        $schoolId = $schoolData->schoolID;      //学校id

        $defaultDepartmentId = substr($department, 0, 5);//默认为学校里的_index_exam_right_list第一个学段

        $schoolLevelId = app()->request->get('schoolLevel', '');//获取学部 当学部为空时 给默认学校中的第一个学部

        //判断是否有学部id，没有默认为小学
        if($schoolLevelId == ''){

            //查询默认的学段是否升级
            $upTime = SeSchoolUpGrade::findSchoolUpGradeIsExists($schoolId, (int)$defaultDepartmentId);

           return $this->isEmptySchoolLevelId($defaultDepartmentId,$lengthOfSchooling,$upTime);
        }


        //获取 学部和学制 相对的年级列表
        $gradeModel = GradeHelper::getGradeByDepartmentAndLengthOfSchooling($schoolLevelId,$lengthOfSchooling,1);

        //查询学段是否升级
        $upTime = SeSchoolUpGrade::findSchoolUpGradeIsExists($schoolId, (int)$schoolLevelId);


        $joinYear = app()->request->get('joinYear', '');//获取年级id
        $gradeId = app()->request->get('gradeId', null);//获取年级id

        //获取当前学部下的所有科目
        $subjectNumber = $this->getSubjectNumber($schoolLevelId);

        //科目
        $subjectId = app()->request->get('subjectId',empty($subjectNumber)?[]:key($subjectNumber[0]));

        $time = date('Y-m-d H:i:s',time());
        $timeModel=  Carbon::parse($time);
        $firstDay = $timeModel->firstOfMonth()->addMonthNoOverflow(-1)->toDateTimeString();  //上个月第一天
        $lastDay = $timeModel->lastOfMonth()->addMonthNoOverflow(-1)->toDateTimeString();   //上个月最后一天


        $month = app()->request->get('month');
        if(!empty($month)){
            $firstDay = $month . '-01';
            $timeModel=  Carbon::parse($firstDay);
            $lastDay = $timeModel->lastOfMonth()->toDateTimeString();
        }

        $monthShortBoard = $this->getKnowledgePoint($schoolId,$schoolLevelId,$joinYear,(int)$subjectId,$firstDay,$lastDay);

        if(app()->request->isAjax) {
            return $this->renderPartial('short_board',['monthShortBoard'=>$monthShortBoard]);
        }

        return $this->render('index',[
            'joinYear'=>$joinYear,
            'gradeId'=>$gradeId,
            'schoolLevelId'=>$schoolLevelId,
            'gradeModel' => $gradeModel,
            'department'=>$department,
            'subjectNumber'=>$subjectNumber,
            'monthShortBoard'=>$monthShortBoard,
            'lengthOfSchooling'=>$lengthOfSchooling,
            'upTime'=>$upTime,
            'firstDay'=>$firstDay
        ]);
    }

    /**
     * 周短板
     * @return string
     * @throws \yii\db\Exception
     * @throws \yii\base\InvalidParamException
     * @internal param $classId
     */
    public function actionWeekShort()
    {
        $schoolData = $this->schoolModel;
        $department = $schoolData->department;
        $schoolId = $schoolData->schoolID;
        $lengthOfSchooling = $schoolData->lengthOfSchooling; //学制id

        $joinYear = app()->request->get('joinYear', null);//获取年级id
        $gradeId = app()->request->get('gradeId', null);//获取年级id
        $schoolLevelId = app()->request->get('schoolLevel', '');//获取学部 当学部为空时 给默认学校中的第一个学部

        $defaultDepartmentId = substr($department, 0, 5);//获取学校里的_index_exam_right_list第一个学段

        //判断是否有学部id，没有默认为小学
        if($schoolLevelId == ''){

            //查询默认的学段是否升级
            $upTime = SeSchoolUpGrade::findSchoolUpGradeIsExists($schoolId, (int)$defaultDepartmentId);

            return $this->isEmptySchoolLevelId($defaultDepartmentId,$lengthOfSchooling,$upTime);
        }

        $gradeModel = GradeHelper::getGradeByDepartmentAndLengthOfSchooling($schoolLevelId,$lengthOfSchooling,1); //获取 学部和学制 相对的年级列表

        //查询学段是否升级
        $upTime = SeSchoolUpGrade::findSchoolUpGradeIsExists($schoolId, (int)$schoolLevelId);

        //获取当前学部下的所有科目
        $subjectNumber = $this->getSubjectNumber($schoolLevelId);

        $subjectId = app()->request->get('subjectId',empty($subjectNumber)?[]:key($subjectNumber[0]));

        $n = time() - 86400 * date('N', time());
        $week_start = date('Y-m-d', $n - 86400 * 6 );
        $week_end = date('Y-m-d', $n);

        $weekstart = app()->request->get('weekstart', $week_start);
        $weekend = app()->request->get('weekend', $week_end);
        $defaultTime = $weekstart .','.$weekend;

        $monthShortBoard = $this->getKnowledgePoint($schoolId,$schoolLevelId,$joinYear,(int)$subjectId,$weekstart,$weekend);

        if(app()->request->isAjax) {
            return $this->renderPartial('short_board',['monthShortBoard'=>$monthShortBoard]);
        }
        return $this->render('weekshort', [
            'weekstart'=>$weekstart,
            'weekend'=>$weekend,
            'defaultTime'=>$defaultTime,
            'joinYear'=>$joinYear,
            'gradeId'=>$gradeId,
            'schoolLevelId'=>$schoolLevelId,
            'gradeModel' => $gradeModel,
            'department'=>$department,
            'subjectNumber'=>$subjectNumber,
            'monthShortBoard'=>$monthShortBoard,
            'lengthOfSchooling'=>$lengthOfSchooling,
            'upTime'=>$upTime
        ]);
    }


    /**
     * 如果学部为空，默认为显示小学
     * @param $defaultDepartmentId
     * @param $lengthOfSchooling
     * @return \yii\web\Response
     */
    public function isEmptySchoolLevelId(string $defaultDepartmentId,string $lengthOfSchooling,$upTime){

        $defaultGradeModel = GradeHelper::getGradeByDepartmentAndLengthOfSchooling($defaultDepartmentId,$lengthOfSchooling,1);
        $defaultGradeId = $defaultGradeModel[0]->gradeId;
        $no = count($defaultGradeModel);
        $yDate = date('Y', time());//年
        if ($upTime) {
            $joinYear = $yDate - $no + 1;
        } else {
            $joinYear = $yDate - $no;
        }

        return $this->redirect(url('/shortboard/default/index', ['schoolLevel' => $defaultDepartmentId, 'gradeId' => $defaultGradeId, 'joinYear' => $joinYear]));

    }


    /**
     * 获取当前学部下的所有学科
     * @param string $schoolLevelId 学部
     * @return array
     */
    public function getSubjectNumber(string $schoolLevelId){
        $subjectNumber=[];
        $subjects=DepartAndSubHelper::getTopicSubArray();
        foreach($subjects as $k=>$v){
            if($schoolLevelId == $k){
                $subjectNumber[] = $v;
            }
        }
        return $subjectNumber;
    }


    /**
     * 短板知识点
     * @param int $schoolId 学校ID
     * @param string $schoolLevelId 学部
     * @param string $joinYear 入学年份
     * @param int $subjectId 学科
     * @param string $BeginTime 开始时间
     * @param string $endTime 结束时间
     * @param int $limit 偏移数
     * @return array|mixed
     * @throws \yii\db\Exception
     */
    public  function  getKnowledgePoint(int $schoolId, string $schoolLevelId, string $joinYear, int $subjectId, string $BeginTime, string $endTime, $limit=15){

        $cache = Yii:: $app->cache;
        $key = WebDataKey::SCHOOL_SHORTBOARD_CACHE_KEY . $schoolId.'_'.$schoolLevelId.'_'.$joinYear.'_'.$subjectId.'_'.$BeginTime.'_'.$endTime;
        $shortBoard = $cache->get($key);
        if ($shortBoard === false) {
            $shortBoard = [];
            $db = SdUserWeaknessKid::getDb();
            $userWeaknessModel = new Query();
            $userWeaknessModel->select(['a.kid', 'count(a.kid) num'])
                ->from('sd_user_weakness_kid a')
                ->join('INNER JOIN', 'sd_user_weakness b', 'a.weakId=b.weakId')
                ->where('b.correctResult<3')
                ->andWhere('a.schoolId=:schoolId ',[':schoolId'=>$schoolId])
                ->andWhere('a.department=:department ',[':department'=>$schoolLevelId])
                ->andWhere('a.subjectId=:subjectId ',[':subjectId'=>$subjectId]);

            $userWeaknessModel->andWhere('a.joinYear=:joinYear ',[':joinYear'=>$joinYear]);
            $userWeaknessModel->andWhere(['between','a.createTime',$BeginTime,$endTime]);

            $monthWeaknessData = $userWeaknessModel->groupBy('kid')->orderBy('num desc')->limit($limit)->createCommand($db)->queryAll();

            foreach($monthWeaknessData as $k =>$v){
                $shortBoard[$k]['num'] = $v['num'];
                $shortBoard[$k]['name'] = KnowledgePointModel::getNamebyId($v['kid']);
                $shortBoard[$k]['kid'] = $v['kid'];
            }

            if ($shortBoard != null) {
                $cache ->set($key, $shortBoard, 86400);
            }
        }
        return $shortBoard;
    }

}
