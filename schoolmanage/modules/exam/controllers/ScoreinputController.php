<?php
declare(strict_types=1);
namespace schoolmanage\modules\exam\controllers;
use common\helper\DateTimeHelper;
use common\helper\ExcelHelper;
use common\models\pos\SeExamClassSubject;
use common\clients\PublishScoreService;
use common\models\JsonMessage;
use common\models\pos\SeClass;
use common\models\pos\SeClassMembers;
use common\models\pos\SeExamClass;
use common\models\pos\SeExamPersonalScore;
use common\models\pos\SeExamSchool;
use common\models\pos\SeExamScoreInput;
use common\models\pos\SeExamSubject;
use common\models\pos\SeUserinfo;
use common\components\WebDataCache;
use common\models\dicmodels\SubjectModel;
use schoolmanage\components\SchoolManageBaseAuthController;
use Yii;
use yii\db\Exception;
use yii\db\Transaction;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * UserController implements the CRUD actions for SeUserinfo model.
 */
class ScoreinputController extends SchoolManageBaseAuthController
{

    /**
     * @var string
     */
    public $layout = 'lay_exam_score';
    /**
     * @var bool
     */
    public $enableCsrfValidation = false;

    /**
     *成绩录入页面
     * @param $schoolExamId
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     */
    public function actionIndex()
    {
        //查询班级
        $schoolExamId = (int)app()->request->get('examId',0);
        $examSchoolData = $this->getSeExamSchoolModel($schoolExamId);
        $examName = '';
        $department = 0;
        if(!empty($examSchoolData)){
            $examName = $examSchoolData->examName;
            $department = $examSchoolData->departmentId;
        }
        $result = $this->examClass($schoolExamId);

        return $this->render('index',['examClass'=>$result,'schoolExamId'=>$schoolExamId,'examName'=>$examName,'department'=>$department]);
    }

    /**
     * 录入成绩增加教师关联
     */
    public function actionTeacherlink()
    {
        $postArray = $_POST['teacherlink'];
        $classId = (int)$postArray['classId'];
        $schoolExamId = (int)$postArray['schoolExamId'];
        $subjectIdArray = $postArray['subjectId'];
        $userIDArray = $postArray['userID'];
        $examSubIdArray = [];
        //科目ID转换为考试科目主键ID
        foreach($subjectIdArray as $subjectId){
            $seExamSubjectModel =  SeExamSubject::find()->where(['schoolExamId'=>$schoolExamId,'subjectId'=>(int)$subjectId])->one();
            if(!empty($seExamSubjectModel)){
                $examSubIdArray[] = $seExamSubjectModel->examSubId;
            }
        }
        //班级ID转换为班级考试ID
        $seExamClassModel = SeExamClass::find()->where(['schoolExamId'=>$schoolExamId,'classId'=>$classId])->one();
        $classExamId = 0;
        if(!empty($seExamClassModel)){
            $classExamId = $seExamClassModel->classExamId;
        }
        if(SeExamClassSubject::addTeacherLink($examSubIdArray, $classExamId, $schoolExamId, $userIDArray) === true){

            header('location: '.$_SERVER['HTTP_REFERER']);
        }


    }

    /**
     * 选择班级
     * @throws \yii\web\HttpException
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\ExitException
     */
    public function actionCheckClass(){
        $classId = (int)Yii::$app->request->getParam('classId',0);

        $schoolExamId = (int)Yii::$app->request->getParam('examId',0);
        //班级ID转换为班级考试ID
        $classExamId = SeExamClass::find()->where(['schoolExamId'=>$schoolExamId,'classId'=>$classId])->one()->classExamId;
        $subjectList = SeExamSubject::find()->where(['schoolExamId' => $schoolExamId])->asArray()->select('subjectId')->all();
        $schoolId = $this->schoolId;
        $examSchoolModel = $this->getSeExamSchoolModel($schoolExamId);
        $examName = '';
        $department = 0;
        if(!empty($examSchoolModel)){
            $examName = $examSchoolModel->examName;
            $department = $examSchoolModel->departmentId;
        }
        //查询班级
        $result = $this->examClass($schoolExamId);
        $examClassData = SeExamClass::find()->select(['classId'])->where(['schoolExamId'=>$schoolExamId])->all();
        $examClassId = [];
        foreach($examClassData as $v){
            $examClassId[] = $v->classId;
        }
        //判断当前考试下是否有这个班级
        if(!in_array($classId,$examClassId,false)){
            $this->notFound('不存在考试');
        }

        //查询输入状态
        $status = SeExamClass::find()->where(['schoolExamId'=>$schoolExamId,'classId'=>$classId])->one()->inputStatus;

        if($status == 0){
            return $this->render('input_select', ['examClass'=>$result,'schoolExamId'=>$schoolExamId,'classId'=>$classId,'examName'=>$examName,'department'=>$department,'subjectList'=>$subjectList,'schoolId'=>$schoolId,'classExamId'=>$classExamId]);

        }elseif($status == 1){

            //科目-满分值
            $data = $this->studentScore($examSchoolModel,$classId,$status);
            $data['classId'] = $classId;
            $data['examId'] = $schoolExamId;
            return $this->render('input_half', ['examClass'=>$result,'schoolExamId'=>$schoolExamId,'data'=>$data,'classId'=>$classId,'examName'=>$examName,'department'=>$department,'subjectList'=>$subjectList,'schoolId'=>$schoolId,'classExamId'=>$classExamId]);
        }elseif($status == 2){

            //科目-满分值
            $data = $this->studentScore($examSchoolModel,$classId,$status);

            return $this->render('input_finish', ['examClass'=>$result,'schoolExamId'=>$schoolExamId,'data'=>$data,'classId'=>$classId,'examName'=>$examName,'department'=>$department,'subjectList'=>$subjectList,'schoolId'=>$schoolId,'classExamId'=>$classExamId]);
        }


    }

    /**
     * 手动录入成绩
     * @throws \yii\web\HttpException
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\ExitException
     */
    public function actionManualInput(){
        $classId = (int)Yii::$app->request->getParam('classId',0);
        $schoolExamId = (int)Yii::$app->request->getParam('examId',0);
        //班级ID转换为班级考试ID
        $subjectList = SeExamSubject::find()->where(['schoolExamId' => $schoolExamId])->asArray()->select('subjectId')->all();
        $schoolId = $this->schoolId;
        $examSchoolModel = $this->getSeExamSchoolModel($schoolExamId);
        $examName = '';
        $department = 0;
        if(!empty($examSchoolModel)){
            $examName = $examSchoolModel->examName;
            $department = $examSchoolModel->departmentId;
        }

        $examClassData = SeExamClass::find()->select(['classId'])->where(['schoolExamId'=>$schoolExamId])->all();
        $examClassId = [];
        foreach($examClassData as $v){
            $examClassId[] = $v->classId;
        }
        //判断当前考试下是否有这个班级
        if(!in_array($classId,$examClassId,false)){
            $this->notFound('不存在考试');
        }

        //查询输入状态
        $status = SeExamClass::find()->where(['schoolExamId'=>$schoolExamId,'classId'=>$classId])->one()->inputStatus;

        //查询临时表是否有数据，无责插入数据库，有则读取
        $classExamId = SeExamClass::find()->where(['schoolExamId'=>$schoolExamId,'classId'=>$classId])->one()->classExamId;
        $scoreInput = SeExamScoreInput::find()->where(['classExamId'=>$classExamId])->count();
        if($scoreInput > 0){
            //科目-满分值
            $data = $this->studentScore($examSchoolModel,$classId,$status);

        }else{
            //根据班级id查询本班成员
            $studentData = SeClassMembers::find()->select(['userID','memName'])->where(['classID' => $classId, 'identity' => SeClassMembers::STUDENT])->andWhere(['>','userID',0])->all();
            $examSubject = SeExamSubject::find()->where(['schoolExamId'=>$schoolExamId])->all();
            $subjectId = [];
            foreach ($examSubject as $v) {
                $subjectId[] = $v->subjectId;
            }
            foreach($studentData as $v){
                $examScoreInput = new SeExamScoreInput();
                $examScoreInput->classExamId = $classExamId;
                $examScoreInput->userName = $v->memName;
                $examScoreInput->userNameInput = $v->memName;
                $examScoreInput->userId = $v->userID;
                $examScoreInput->createTime = DateTimeHelper::timestampX1000();
                foreach ($subjectId as $value) {
                    ExcelHelper::setSubjectScore($examScoreInput , $value , '0.00');
                }

                $examScoreInput->totalScore = 0.00;

                if($examScoreInput->save()){

                    $examClassModel = SeExamClass::find()->where(['schoolExamId'=>$schoolExamId,'classId'=>$classId])->one();
                    $examClassModel->inputStatus = 1;

                    if($examClassModel->save()){
                        $status = $examClassModel->inputStatus;
                    }
                    $data = $this->studentScore($examSchoolModel,$classId,$status);

                }
            }

        }
        //查询班级
        $result = $this->examClass($schoolExamId);
        if(empty($data)){
           $data = '';
        }else{
            $data['classId'] = $classId;
            $data['examId'] = $schoolExamId;
        }

        return $this->render('input_manual',['examClass'=>$result,'schoolExamId'=>$schoolExamId,'classId'=>$classId,'data'=>$data,'examName'=>$examName,'department'=>$department,'subjectList'=>$subjectList,'schoolId'=>$schoolId,'classExamId'=>$classExamId]);
    }

    /**
     * 手动临时保存成绩
     * @throws \Exception
     */
    public function actionTempSaveScore(){

        $flag = false;
        if($_POST){

            $scoreInput = app()->request->post('scoreInput');

            foreach($scoreInput as $key=>$val){
                $seExamScoreInput = SeExamScoreInput::find()->where(['tempScoreId'=>$key])->one();
                foreach($val as $k=>$v){
                    ExcelHelper::setSubjectScore($seExamScoreInput , $k , $v);
                }
                if($seExamScoreInput->update() !== false){
                    $flag = true;
                }

            }
        }
        return $flag;
    }

    /**
     * 手动完成录入
     * @throws \Exception
     */
    public function actionFinalSaveScore(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $flag['success'] = false;
        if($_POST){
            /** @var Transaction $transaction */
            $transaction = Yii::$app->db_school->beginTransaction();
            $scoreInput = app()->request->post('scoreInput');
            try {
                foreach ($scoreInput as $key => $val) {
                    $seExamScoreInput = SeExamScoreInput::find()->where(['tempScoreId' => $key])->one();
                    $classExamId = $seExamScoreInput->classExamId;
                    $userId = $seExamScoreInput->userId;

                    $personalScoreModel = SeExamPersonalScore::find()->where(['classExamId' => $classExamId,'userId'=>$userId])->one();
                    if(!empty($personalScoreModel)){
                        foreach ($val as $k => $v) {
                            ExcelHelper::setSubjectScore($personalScoreModel, $k, $v);
                        }
                        $personalScoreModel->update(false);

                    }else{
                        $personalScoreModel = new SeExamPersonalScore();
                        $seExamScoreInput = SeExamScoreInput::find()->where(['tempScoreId' => $key])->one();
                        if(empty($seExamScoreInput->userId)){
                            continue;
                        }
                        $personalScoreModel->userId = $seExamScoreInput->userId;
                        $personalScoreModel->classExamId = $seExamScoreInput->classExamId;
                        foreach ($val as $k => $v) {
                            ExcelHelper::setSubjectScore($personalScoreModel, $k, $v);
                        }
                        $personalScoreModel->totalScore = array_sum($val);
                        $personalScoreModel->save(false);
                    }
                }
                //更新成功或保存成功更改examClass的状态
                foreach($scoreInput as $key => $val){
                    $seExamScoreInput = SeExamScoreInput::find()->where(['tempScoreId' => $key])->one();

                    $examClassModel = SeExamClass::find()->where(['classExamId'=>$seExamScoreInput->classExamId])->one();
                    $examClassModel->inputStatus = 2;
                    if($examClassModel->update()){
                        $flag['success'] = true;
                        $flag['examId'] = $examClassModel->schoolExamId;
                        $flag['classId'] = $examClassModel->classId;

                    }

                }


                //删除临时表的数据
                foreach($scoreInput as $key => $val){
                    $classExamId = SeExamScoreInput::find()->where(['tempScoreId' => $key])->one()->classExamId;
                }
                if(!empty($classExamId)){
                    SeExamScoreInput::deleteAll('classExamId=:classExamId' , [':classExamId'=>$classExamId]);
                }


                $transaction->commit();

            }catch (Exception $e) {
                $transaction->rollBack();
                \Yii::error('考试成绩手动完成录入失败错误信息' . '------' . $e->getMessage());
            }
        }
        return $flag;
    }

    /**
     * $status =2状态
     * 手动编辑成绩
     * @throws \Exception
     */
    public function actionFinalUpdateScore(){
        $flag = false;
        if($_POST){

            $scoreInput = app()->request->post('scoreInput');
            foreach($scoreInput as $key=>$val){
                $seExamScoreInput = SeExamPersonalScore::find()->where(['perScoreId'=>$key])->one();
                foreach($val as $k=>$v){
                        if($v === '' ){
                            return $flag;
                        }
                    ExcelHelper::setSubjectScore($seExamScoreInput , $k , $v);
                }
                $seExamScoreInput->totalScore = array_sum($val);
                if($seExamScoreInput->update(false) !== false){
                    $flag = true;
                }

            }
        }
        return $flag;
    }

    /**
     *自动录入成绩（页面展示）
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
    public function actionAutoInput(){


        $classId = (int)Yii::$app->request->getParam('classId',0);
        $schoolExamId = (int)Yii::$app->request->getParam('examId',0);
        $subjectList = SeExamSubject::find()->where(['schoolExamId' => $schoolExamId])->asArray()->select('subjectId')->all();
        $schoolId = $this->schoolId;
        //判断当前考试是否是这个学校的
        $seExamSchoolModel = $this->getSeExamSchoolModel($schoolExamId);
        $examName = $seExamSchoolModel->examName;
        $department = $seExamSchoolModel->departmentId;


        //查询班级
        $result = $this->examClass($schoolExamId);
        $examClassData = SeExamClass::find()->select(['classId'])->where(['schoolExamId'=>$schoolExamId])->all();
        $examClassId = [];
        foreach($examClassData as $v){
            $examClassId[] = $v->classId;
        }
        //判断当前考试下是否有这个班级
        if(!in_array($classId,$examClassId,false)){
            $this->notFound('不存在考试');
        }

        //根据学校考试id和班级id查询班级考试id
        $examClassInfo = SeExamClass::find()->where(['schoolExamId'=>$schoolExamId , 'classId'=>$classId])->one();
        if($examClassInfo){
            $classExamId = $examClassInfo->classExamId;
        }else{
            //匹配错误
            echo $this->notFound('',403);
            return false;
        }

        $subjectData = SeExamSubject::find()->select(['subjectId','fullScore'])->where(['schoolExamId'=>$schoolExamId])->all();
        $subject = [];
        $nameMax= [];
        foreach($subjectData as $v){
            $nameMax['name'] = $v->subjectId;
            $nameMax['max'] = $v->fullScore;
            $subject[] = $nameMax;
        }
        ArrayHelper::multisort($subject, 'name');

        //匹配的名单
        $scoreInputHasUserList = SeExamScoreInput::find()->where(['classExamId'=>$classExamId ])->andWhere(['>','userId',0])->all();
       $studentScore = $this->setAutoScoreInputData($scoreInputHasUserList , $subjectData);

        //未匹配的名单
        $scoreInputNoUserList = SeExamScoreInput::find()->where(['classExamId'=>$classExamId ])->andWhere(['userId'=>0])->all();
        $otherStudentScore = $this->setAutoScoreInputData($scoreInputNoUserList , $subjectData);

        //最终格式
        $data = [];
        $data['classExamId'] = $classExamId;
        $data['sysName'] = [];
        $data['subject'] = $subject;
        $data['student'] = $studentScore;
        $data['other_student'] = $otherStudentScore;
        $data['examId'] = $schoolExamId;
        $data['classId'] = $classId;
        return $this->render('input_excel',['examClass'=>$result,'schoolExamId'=>$schoolExamId,'classId'=>$classId ,'data'=>$data ,'examName'=>$examName,'department'=>$department,'subjectList'=>$subjectList,'schoolId'=>$schoolId]);
    }


    /**
     * 生成自动录入数据格式
     * @param array $scoreInputList 分数
     * @param array $subjectData 科目
     * @return array
     */
    public function setAutoScoreInputData(array $scoreInputList , array $subjectData){
        $student = [];
        $studentScore = [];
        /** @var  \common\models\pos\SeExamScoreInput  $scoreInputHasUser  */
        foreach($scoreInputList as $scoreInputHasUser){
            $student['userId'] = $scoreInputHasUser->userId;
            $student['num'] = $scoreInputHasUser->tempScoreId;
            $student['sysName'] = $scoreInputHasUser->userName;
            $student['name'] = $scoreInputHasUser->userNameInput;
            $student['excelName'] = $scoreInputHasUser->userNameInput;
            $subjectScore = [];
            $total = 0;
            foreach($subjectData as $v1){
                //根据班级考试id查询和学生id查询本次考试每科成绩
                $score = $scoreInputHasUser->getAttribute("sub$v1->subjectId");
                $subjectScore["$v1->subjectId"] = $score;
                $total += (int)$score;
            }
            $student['total'] = $total;
            $student['subject'] = $subjectScore;
            $studentScore[] = $student;
        }
        return $studentScore;
    }

    /**
     * 自动保存成绩(临时保存)
     * @throws \yii\db\Exception
     */
    public function actionAutoSaveScore(){

        Yii::$app->response->format = Response::FORMAT_JSON;
        $flag = [];
        $flag['success'] = false;
        if($_POST){
            /** @var Transaction $transaction */
            $transaction = Yii::$app->db_school->beginTransaction();
            try {
                $scoreInput = app()->request->post('scoreInput');
                $classExamId = app()->request->post('num');
                foreach($scoreInput as $key=>$val){
                    $examScoreInput = SeExamScoreInput::find()->where(['tempScoreId'=>$key])->one();
                    $examScoreInput->totalScore = 0;
                    foreach($val as $k=>$v){
                        ExcelHelper::setSubjectScore($examScoreInput , (int)$k , $v);
                        $examScoreInput->totalScore += (int)$v;
                    }
                    $examScoreInput->save(false);
                }

                //修改班级录入状态
                $seExamClass = SeExamClass::find()->where(['classExamId'=>$classExamId])->one();
                $seExamClass->inputStatus = 1;
                $seExamClass->save(false);

                $transaction->commit();
                $flag['success'] = true;
                $flag['data'] = $seExamClass->schoolExamId;
            }catch (Exception $e) {
                $transaction->rollBack();
                \Yii::error('自动保存成绩(临时保存)失败错误信息' . '------' . $e->getMessage());
            }

        }
        return $flag;
    }

    /**
     * 自动保存成绩(正式保存)
     * @throws \yii\db\Exception
     */
    public function actionAutoSaveScoreFinish(){

        Yii::$app->response->format = Response::FORMAT_JSON;
        $flag = [];
        $flag['success'] = false;
        if($_POST){
            $scoreInput = app()->request->post('scoreInput');
            $classExamId = app()->request->post('num');

            /** @var Transaction $transaction */
            $transaction = Yii::$app->db_school->beginTransaction();
            try {

                //保存到正式表
                foreach($scoreInput as $key=>$val){
                        $examScoreInput = SeExamScoreInput::find()->where(['tempScoreId'=>$key])->one();
                        $classExamIdTemp = $examScoreInput->classExamId;
                        $userId = $examScoreInput->userId;
                        $examPersonalScore = SeExamPersonalScore::find()->where(['classExamId'=>$classExamIdTemp , 'userId'=>$userId])->one();
                        if(!$examPersonalScore){
                            $examPersonalScore = new SeExamPersonalScore();
                        }
                        $examPersonalScore->classExamId = $classExamIdTemp;
                        $examPersonalScore->userId = $userId;
                        $examPersonalScore->totalScore = 0;
                        $examPersonalScore->createTime = DateTimeHelper::timestampX1000();
                        foreach($val as $k=>$v){
                            ExcelHelper::setSubjectScore($examPersonalScore , (int)$k , $v);
                            $examPersonalScore->totalScore += (int)$v;
                        }
                        $examPersonalScore->save(false);
                }

                //删除临时表的数据
                SeExamScoreInput::deleteAll('classExamId=:classExamId' , [':classExamId'=>$classExamId]);

                //修改班级录入状态
                $seExamClass = SeExamClass::find()->where(['classExamId'=>$classExamId])->one();
                $seExamClass->inputStatus = 2;
                $seExamClass->save(false);

                $transaction->commit();
                $flag['success'] = true;
                $flag['examId'] = $seExamClass->schoolExamId;
                $flag['classId'] = $seExamClass->classId;
            }catch (Exception $e) {
                $transaction->rollBack();
                \Yii::error('自动保存成绩(正式保存)失败错误信息' . '------' . $e->getMessage());
            }

        }
        return $flag;
    }


    /**
     * 查询班级列表
     * @param integer $schoolExamId 学校考试ID
     * @return array
     */
    public function examClass(int $schoolExamId){
        //查询班级
        $examClass = SeExamClass::find()->where(['schoolExamId'=>$schoolExamId])->all();
        $result = [];
        foreach($examClass as $v){
            $result[$v->classExamId][] = SeClass::find()->where(['classID'=>$v->classId])->one()->className;
            $result[$v->classExamId][] = $v->inputStatus;
            $result[$v->classExamId][] = $v->classId;
        }
        return $result;
    }

    /**
     *
     *  查询班级学生及成绩
     * @param SeExamSchool $seExamSchoolModel 学校考试
     * @param integer $classId 班级ID
     * @param integer $status 成绩录入状态，0未录入，1录入中，2录入完成
     * @return array
     */
    public function studentScore(SeExamSchool $seExamSchoolModel, int $classId, int $status){
        $subjectData = $seExamSchoolModel->getExamSubject()->orderBy('subjectId')->all();
        //数据
        $subject = [];
        $nameMax= [];
        foreach($subjectData as $v){
            $nameMax['name'] = $v->subjectId;
            $nameMax['max'] = $v->fullScore;
            $subject[] = $nameMax;
        }

        //根据学校考试id和班级id查询班级考试id
       $seExamClassModel= SeExamClass::find()->where(['schoolExamId'=>$seExamSchoolModel->schoolExamId,'classId'=>$classId])->one();
        $classExamId = $seExamClassModel->classExamId;

        if($status == 2){
            $ScoreData = SeExamPersonalScore::find()->where(['classExamId'=>$classExamId])->all();
        }else{
            $ScoreData = SeExamScoreInput::find()->where(['classExamId'=>$classExamId])->andWhere(['>','userId',0])->all();
        }

        $sysName = [];

        //学生成绩
        $studentScore = [];
        foreach($ScoreData as $v){

            $userName = WebDataCache::getTrueNameByuserId($v->userId);
            $sysName[] = $userName;

            $classMember = SeClassMembers::find()->where(['userID'=>$v->userId])->one();
            $stuID = '';
            if($classMember){
                $stuID = $classMember->stuID;
            }
            $student = [];
            if($status == 2){
                $student['autoId'] = $v->perScoreId;
            }else{
                $student['autoId'] = $v->tempScoreId;
            }
            $student['num']= !empty($stuID)?$stuID:'(未设置)';
            $student['name'] = $userName;
            $subjectScore = [];
            foreach($subjectData as $v1){

                $score = $v->getAttribute("sub$v1->subjectId");
                $subjectScore["$v1->subjectId"] = $score;

            }
            $student['subject'] = $subjectScore;
            $studentScore[] = $student;
        }

        //结果
        $data = [];
        $data['sysName'] = $sysName;
        $data['subject'] = $subject;
        $data['student'] = $studentScore;

        return $data;
    }


    /**
     * @return bool|JsonMessage
     * @throws \yii\db\Exception
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\ExitException
     * @throws \yii\web\HttpException
     * excel文件内容插入的数据库中
     */
    public function actionExcelToDb(){
        Yii::$app->response->format = Response::FORMAT_JSON;

        $flag= new JsonMessage();
        if(Yii::$app->request->post('flag') === 'save'){
            $url = Yii::$app->request->post('url');
            if($url){

                /** @var Transaction $transaction */
                $transaction = Yii::$app->db_school->beginTransaction();
                try {

                    $classId = (int)app()->request->get('classId',0);
                    $examId = (int)app()->request->get('examId',0);
                    //判断当前考试是否是这个学校的
                    $this->getSeExamSchoolModel($examId);

                    //获取班级考试id
                    $examClassInfo = SeExamClass::find()->where(['schoolExamId'=>$examId , 'classId'=>$classId])->one();
                    if($examClassInfo){
                        $examClassId = $examClassInfo->classExamId;
                    }else{
                        //匹配错误
                        $this->notFound('',403);
                        return false;
                    }
                    $fileUrl = \Yii::getAlias('@webroot').$url;
                    //获取上传的excel文件中的内容
                    $data = ExcelHelper::excelToArray($fileUrl);

                    foreach($data as $key=>$val) {
                        $examScoreInput = new SeExamScoreInput();
                        $examScoreInput->classExamId = $examClassId;
                        if(!isset($val['姓名'])){
                            $flag->message = '内容格式不匹配';
                            return $flag;
                        }
                        $examScoreInput->userNameInput = $val['姓名'];
                        $examScoreInput->createTime = DateTimeHelper::timestampX1000();

                        //判断格式
                        foreach($val as $k=>$v){
                            if($k !== '姓名'){
                                if(!$this->judgeExcelFormat($flag,(string)$v)){
                                    return $flag;
                                }
                            }
                        }

                        //保存数据
                        $arr = [];
                        foreach($val as $k=>$v){
                            $id = SubjectModel::model()->getIdBySubjectName($k);
                            $arr[$id] = $v;
                            //set score for subject
                            ExcelHelper::setSubjectScore($examScoreInput , (int)$id , (string)$v);
                            $examScoreInput->totalScore += (int)$v;

                        }
                        $examScoreInput->save(false);
                    }

                    //修改班级录入状态
                    $seExamClass = SeExamClass::find()->where(['classExamId'=>$examClassId])->one();
                    $seExamClass->inputStatus = 1;
                    $seExamClass->save(false);

                    //插入用户id
                    $result1 = $this->getScoreData( $classId , $examClassId);

                    //补全班级用户id
                    $result2 = $this->completeScore( $classId , $examClassId);

                    $transaction->commit();
                    $flag->data=['classId'=>$classId,'examId'=> $examId];
                    $flag->success = true;

                }catch (Exception $e) {
                    $transaction->rollBack();
                    \Yii::error('excel文件考试成绩内容插入到数据库中失败错误信息' . '------' . $e->getMessage());
                }
            }
        }
        return $flag;

    }


    /**
     * 判断excel中数据的格式是否正确
     * @param JsonMessage $flag
     * @param string $val 分数
     * @return bool
     */
    public function judgeExcelFormat(JsonMessage $flag, string $val){
        $result = true;
        if(strlen($val) ==0){
            $flag->message = '表内数据不能为空';
            $result = false;
        }
        elseif(!is_numeric($val)){
            $flag->message = '表内数据不是数字';
            $result = false;
        }
        return $result;
    }

    /*
     * 导入的excel数据添加用户id
     */
    /**
     * @param integer $classId 班级ID
     * @param integer $examId 班级考试ID
     * @return bool
     */
    public function getScoreData(int $classId , int $examId){

        $flag = false;
        //excel保存到数据库中的数据
        $examScoreInputData = SeExamScoreInput::find()->where(['classExamId'=>$examId])->all();

        foreach($examScoreInputData as $examScore){
            //数据是否有重名的
            $examScoreData = SeExamScoreInput::find()->where(['classExamId'=>$examId , 'userNameInput'=>$examScore->userNameInput])->all();

            if(count($examScoreData) == 1){
                //匹配班级成员
                $userInfo = SeClassMembers::find()->where(['classID'=>$classId , 'memName'=>$examScoreData[0]->userNameInput])->all();
                $userId = 0;
                $userName = '';
                if(count($userInfo) == 1){
                    $userId = $userInfo[0]->userID;
                    $userName = $userInfo[0]->memName;
                }
                $examScore->userName = $userName;
                $examScore->userId = $userId;

                if($examScore->save(false)){
                    $flag = true;
                }

            }
        }

        return $flag;
    }


    /**
     * 补全班级成员的成绩
     * @param integer $classId 班级ID
     * @param integer $examId 班级考试ID
     * @return bool
     */
    public function completeScore(int $classId , int $examId){

        $flag = false;
        //excel保存到数据库中的数据
        $examScoreInputData = SeExamScoreInput::find()->where(['classExamId'=>$examId])->andWhere([ '>', 'userId',0 ])->all();
        $scoreUserArr = [];
        foreach($examScoreInputData as $scoreUser){
            $scoreUserArr[] = $scoreUser->userId;
        }

        //班级成员表
        $memInfo = SeClassMembers::find()->where(['classID'=>$classId,'identity'=>SeClassMembers::STUDENT])->all();
        $memArr = [];
        foreach($memInfo as $mem){
            $memArr[$mem->userID] = $mem->memName;
        }

        if(count($scoreUserArr) < count($memArr)){
            $completeUserArr = [];
            foreach($memArr as $userId => $user){
                if(!in_array($userId , $scoreUserArr , false)){
                    $completeUserArr[$userId] = $user;
                }
            }

            foreach($completeUserArr as $completeUserId => $completeUser){
                $examScoreInput = new SeExamScoreInput();

                $examScoreInput->userId = $completeUserId;
                $examScoreInput->userName = $completeUser;
                $examScoreInput->classExamId = $examId;
                $examScoreInput->totalScore = 0;
                $examScoreInput->userNameInput = '';
                $examScoreInput->createTime = DateTimeHelper::timestampX1000();;

                $examScoreInput->save(false);

                if($examScoreInput->save(false)){
                    $flag = true;
                }

            }
        }

        return $flag;

    }


    /**
     * 自动录入展示学生信息展示
     * @param integer $userId 学生ID
     * @return array
     */
    public function actionGetStudentInfo(int $userId){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $userInfo = SeUserinfo::find()->where(['userID'=>$userId])->one();
        $seClassMember = SeClassMembers::find()->where(['userID'=>$userId])->one();
        $stuId = '无';
        if($seClassMember && $seClassMember->stuID){
            $stuId = $seClassMember->stuID;
        }
        $data = [];
        $sex = '无信息';
        if($userInfo->sex == 1){
            $sex = '女';
        }elseif($userInfo->sex == 0){
            $sex = '男';
        }
        $data['sex'] = $sex;
        $data['name'] = $userInfo->trueName;
        $data['phone'] = $userInfo->bindphone;
        $data['num'] = $stuId;
        return $data;
    }


    /**
     * 发布成绩
     * @param integer $examId 考试ID
     * @return array
     * @throws \yii\base\ExitException
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \yii\web\HttpException
     */
    public function actionPublishScore(int $examId){

        //判断当前考试是否是这个学校的
        $this->getSeExamSchoolModel($examId);

        Yii::$app->response->format = Response::FORMAT_JSON;
        $flag = [];
        $flag['success'] = false;
        $flag['data']['message'] = '还有没完成录入的班级';
        $seExamSchool = SeExamSchool::find()->where(['schoolExamId'=>$examId])->one();
        if(!$seExamSchool){
            $this->notFound('403');
        }
        $inputStatus = $seExamSchool->inputStatus;
        if($inputStatus == 2){
            $result = PublishScoreService::model()->publishScore($examId);
            if($result == '000000'){
                $flag['success'] = true;
                $flag['data']['message'] = '成绩发布完成,生成统计过程需要持续几分钟，请耐心等待';
            }else{
                $flag['data']['message'] = '成绩发布失败!';
            }
        }

        return $flag;

    }


    /**
     * 清空临时保存的数据
     * @param integer $schoolExamId 学校考试ID
     * @param integer $classId 班级ID
     * @return JsonMessage
     * @throws \yii\db\Exception
     */
    public function actionDeleteScoreInput(int $schoolExamId , int $classId){

        Yii::$app->response->format = Response::FORMAT_JSON;
        $flag= new JsonMessage();

        $seExamClass = SeExamClass::find()->where(['schoolExamId'=>$schoolExamId , 'classId'=>$classId])->one();
        if(!$seExamClass){
            return $flag;
        }

        /** @var Transaction $transaction */
        $transaction = Yii::$app->db_school->beginTransaction();
        try {

            //删除临时表的对应数据
            SeExamScoreInput::deleteAll('classExamId=:classExamId',[':classExamId'=>$seExamClass->classExamId]);

            //修改班级录入状态
            $seExamClass->inputStatus = 0;
            $seExamClass->save(false);

            $transaction->commit();
            $flag->success = true;

        }catch (Exception $e) {
            $transaction->rollBack();
            \Yii::error('清空临时保存的数据失败错误信息' . '------' . $e->getMessage());
        }
        return $flag;

    }


}


?>
