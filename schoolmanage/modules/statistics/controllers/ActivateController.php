<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2016/4/27
 * Time: 19:21
 */
namespace schoolmanage\modules\statistics\controllers;

use common\models\pos\SeUserinfo;
use common\components\WebDataKey;
use common\models\dicmodels\LoadSubjectModel;
use schoolmanage\components\SchoolManageBaseAuthController;
use Yii;
use yii\data\Pagination;
use yii\db\Query;
use yii\helpers\Html;


class ActivateController extends SchoolManageBaseAuthController
{
    public $layout = 'lay_statistics_index';
    /*
     * 激活统计--教师
     */
    public function actionIndex()
    {
        //总人数
        $teacherNum = $this->peopleSum();
        //激活人数
        $activateNum = $this->activateSum();
        if($activateNum['teacher']==0){
            $proportion = 0;
        }else{
            $proportion = round(($activateNum['teacher']/$teacherNum['teacher'])*100,2);
        }
        $noActivate = (float)$teacherNum['teacher'] - (float)$activateNum['teacher'];
        //学部 科目
        $department = (int)app()->request->get('department');
        $subjectId = (int)app()->request->get('subjectId');

        $pages = new Pagination();
        $pages->validatePage = false;
        $pages->pageSize = 10;
        $schoolData = $this->schoolModel;
        $departmentId = $schoolData->department;
        $departmentArray = explode(',', $departmentId);
        //未注册名单表
        $teacherList = SeUserinfo::find()->where(['schoolID'=>$this->schoolId,'type'=>1])->andWhere(' userID not in (SELECT userID FROM se_userControl u WHERE u.userID)')
                      ->select('userID,trueName,sex,department,subjectID,bindphone,phoneReg');
        //搜学部
        if (!empty($department)) {
            $teacherList->andWhere(['department' =>$department]);
        }
        //搜学科
        if (!empty($subjectId)) {
            $teacherList->andWhere(['subjectID' =>$subjectId]);
        }
        $numberOfPeople = $teacherList->count();
        $pages->totalCount = $numberOfPeople;
        $userInfo = $teacherList->offset($pages->getOffset())->limit($pages->getLimit())->all();

        $pages->params = [ 'department' => $department, 'subjectId' => $subjectId];
        if (app()->request->isAjax) {
            return $this->renderPartial('_teacher_list',['userInfo' => $userInfo,'pages' => $pages, 'numberOfPeople' => $numberOfPeople]);
        }
        return $this->render('index',['teacherNum'=>$teacherNum['teacher'],
                                        'activateNum'=>$activateNum['teacher'],
                                        'proportion'=>$proportion,
                                        'noActivate'=>$noActivate,
                                        'pages'=>$pages,
                                        'departmentArray' => $departmentArray,
                                        'numberOfPeople' => $numberOfPeople,
                                        'userInfo'=>$userInfo]);
    }

    /**
     *根据学部获取科目
     * @param string $department 学部
     */
    public function actionGetSubject(string $department)
    {
        echo Html::tag('option', '请选择', array('value' => ''));
        if (empty($department)) {
            return;
        }
        $data = LoadSubjectModel::model()->getData($department, 1);
        foreach ($data as $item) {
            echo Html::tag('option', Html::encode($item->secondCodeValue), array('value' => $item->secondCode));
        }
    }

    /*
     * 激活统计--学生
     */
    public function actionStudent(){
        //总人数
        $studentNum = $this->peopleSum();
        //激活人数
        $activateNum = $this->activateSum();
        if($activateNum['student']==0){
            $proportion = 0;
        }else{
            $proportion = round(($activateNum['student']/$studentNum['student'])*100,2);
        }
        $noActivate = (float)$studentNum['student'] - (float)$activateNum['student'];
        return $this->render('student',['studentNum'=>$studentNum['student'],
                                          'activateNum'=>$activateNum['student'],
                                          'proportion'=>$proportion,
                                          'noActivate'=>$noActivate]);
    }


    /*
     * 激活统计--家长
     */
    public function actionHome(){
        //总人数
        $homeNum = $this->peopleSum();
        //未激活
        $register = $this->registerSum();
        $noRegister = (float)$homeNum['home'] - (float)$register['home'];
        if($register['home']==0){
            $proportion = 0;
        }else{
            $proportion = round($register["home"]/$homeNum['home']*100,2);
        }
        return $this->render('home',['homeNum'=>$homeNum['home'],
                                            'register'=>$register['home'],
                                            'proportion'=>$proportion,
                                            'noRegister'=>$noRegister]);
    }

    /*
     * 家长激活人数
     */
    public function registerSum()
    {
        $cache = Yii::$app->cache;
        $cacheKey = WebDataKey::HOMEREGISTERSUM_CACHE_KEY.$this->schoolId;
        $registerSum = $cache->get($cacheKey);
        if($registerSum === false)
        {
            $query = new Query();
            $query->select('count(0) home,a.schoolID')
                  ->from('(SELECT bindphone, trueName,p.schoolID,(SELECT userID FROM se_userinfo u WHERE u.phone=p.phoneReg AND type=0 LIMIT 1) childuserID
                          FROM se_userinfo p WHERE type=3 AND status1=1) a ')
                  ->leftJoin(' (se_userinfo c)','c.userID = a.childuserID ');
            $query->where(['a.schoolID'=>$this->schoolId]);
            $registerSum = $query->createCommand(Yii::$app->get('db_school'))->queryAll();
            $cache->set($cacheKey,$registerSum,3600);
        }
        return $registerSum[0];
    }



    /*
     * 学校注册总人数
     */
    public function peopleSum()
    {
        $cache = Yii::$app->cache;
        $cacheKey = WebDataKey::PEOPLESUM_CACHE_KEY.$this->schoolId;
        $peopleSum = $cache->get($cacheKey);
        if($peopleSum === false)
        {
            $query = new Query();
            $query->select('count(case when type=1 then 1 end ) teacher,count(case when type=0 then 0 end ) student,
                     count(case when type=3 then 3 end ) home')->from('se_userinfo')->where(['schoolID'=>$this->schoolId,'status1'=>1]);
            $peopleSum = $query->createCommand(Yii::$app->get('db_school'))->queryAll();
            $cache->set($cacheKey,$peopleSum,3600);
        }
        return $peopleSum[0];
    }


    /*
     * 激活人数
     */
    public function activateSum()
    {
        $cache = Yii::$app->cache;
        $cacheKey = WebDataKey::ACTIVATESUM_CACHE_KEY.$this->schoolId;
        $activateSum = $cache->get($cacheKey);
        if($activateSum === false)
        {
            $query = new Query();
            $query->select('count(case when type=1 then 1 end ) teacher,count(case when type=0 then 0 end ) student')
                ->from('se_userinfo a')
                ->where(['schoolID'=>$this->schoolId])
                ->andWhere('userID in (SELECT userID FROM se_userControl u WHERE u.userID)');
            $activateSum = $query->createCommand(Yii::$app->get('db_school'))->queryAll();
            $cache->set($cacheKey,$activateSum,3600);
        }
        return $activateSum[0];
    }


}
