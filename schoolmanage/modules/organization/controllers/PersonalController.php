<?php
declare(strict_types=1);
namespace schoolmanage\modules\organization\controllers;

use common\clients\OrganizationService;
use common\models\JsonMessage;
use common\models\pos\SeClass;
use common\models\pos\SeClassMembers;
use common\models\pos\SeUserinfo;
use common\clients\ClassChangeService;
use schoolmanage\components\SchoolManageBaseAuthController;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/7/13
 * Time: 13:54
 */
class PersonalController extends SchoolManageBaseAuthController
{
    public $layout = 'lay_organization_index';
    public $enableCsrfValidation = false;

    /**
     * 组织管理的教师和学生列表
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     * @throws \yii\web\HttpException
     */
    public function actionManageList()
    {
        $classID = (int)app()->request->getQueryParam('classId');
        $classModel = $this->getSchoolClassModel($classID);

        $teacherQuery = SeClassMembers::find()->where(['classId' => $classID, 'identity' => ['20402', '20401']])->select('userID,identity');
        $teacherList = $teacherQuery->asArray()->all();
        $teacherUserIds = ArrayHelper::getColumn($teacherList, 'userID');
        $query = new Query();
        $query->select('a.userID,a.trueName,a.sex,a.bindphone,a.phoneReg,a.subjectID')
            ->from('se_userinfo a');
        $query->where(['in', 'a.userID', $teacherUserIds]);
        $teacherInfo = $query->createCommand(Yii::$app->get('db_school'))->queryAll();
        foreach ($teacherInfo as $k => $v) {
            foreach ($teacherList as $k1 => $val) {
                if ($v['userID'] == $val['userID']) {
                    $teacherInfo[$k]['identity'] = $val['identity'];
                    unset($teacherList[$k1]);
                }
            }

        }

        $teacherCount = $teacherQuery->count();
        $studentQuery = SeClassMembers::find()->where(['classId' => $classID, 'identity' => '20403'])->select('ID,userID,stuID,memName,job');
        $studentList = $studentQuery->asArray()->all();

        $studentUserIds = ArrayHelper::getColumn($studentList, 'userID');

        $query->select('a.userID,a.sex,a.bindphone')
            ->from('se_userinfo a');
        $query->where(['in', 'a.userID', $studentUserIds]);
        $studentInfo = $query->createCommand(Yii::$app->get('db_school'))->queryAll();
        foreach ($studentList as $k => $v) {
            foreach ($studentInfo as $k2 => $val) {
                if ($v['userID'] == $val['userID']) {
                    $studentList[$k]['sex'] = $val['sex'];
                    $studentList[$k]['bindphone'] = $val['bindphone'];
                    unset($teacherList[$k2]);
                }
            }

            if (!isset($studentList[$k]['sex'])) {
                $studentList[$k]['sex'] = 0;
                $studentList[$k]['bindphone'] = '';
            }

        }
        $studentCount = $studentQuery->count();

        $inviteCode = $classModel->inviteCode;
        return $this->render('manageList', [
            'teacherList' => $teacherInfo,
            'teacherCount' => $teacherCount,
            'studentList' => $studentList,
            'studentCount' => $studentCount,
            'classID' => $classID,
            'inviteCode' => $inviteCode
        ]);
    }

    /**
     * 搜索老师列表
     * @return string
     * @throws \yii\base\ExitException
     * @throws \yii\base\InvalidParamException
     */
    public function actionGetTeachers()
    {

        $jsonResult = new JsonMessage();
        $keywords = app()->request->getBodyParam('keywords',null);
        $schoolId = $this->schoolId;
        if ($keywords !== null) {
            //搜索手机号
            $userResult = SeUserinfo::searchTeacher($keywords, $schoolId);

            if ($userResult) {
                $jsonResult->data = $this->renderPartial('_teacher_list', ['userResult' => $userResult]);
                $jsonResult->success = true;
            }
        }
        return $this->renderJSON($jsonResult);
    }

    /**
     * 添加老师到班级
     * @return string
     * @throws \yii\base\ExitException
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \yii\web\HttpException
     */
    public function actionAddTeacherToClass()
    {
        $jsonResult = new JsonMessage();

        $classID = (int)app()->request->getBodyParam('classID');

        $classModel = $this->getSchoolClassModel($classID);

        if ($classModel instanceof JsonMessage) {
            return $classModel;
        }
        $userID = (int)app()->request->getBodyParam('userID');

        $userModel = $this->getSchoolUserModel($userID);

        if ($userModel instanceof JsonMessage) {

            return $userModel;
        }
        $service = new OrganizationService();

        $result = $service->ChangeTeacherClass($userID, (string)$classID, true);

        $jsonResult->message = $result->message;

        $jsonResult->success = $result->success;

        \Yii::info('班级添加老师操作, 操作人Id：'.Yii::$app->user->id . '; teacherId:'.$userID.'; classId:'.$classID.', 方法：' . __METHOD__  , 'userHandler');

        return $this->renderJSON($jsonResult);

    }

    /**
     *改变学生和老师班内职务
     * @throws \yii\web\HttpException
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \yii\base\ExitException
     */
    public function actionChangeIdentity()
    {


        $jsonResult = new JsonMessage();

        $userID = (int)app()->request->getBodyParam('userID');

        $userModel = $this->getSchoolUserModel($userID);

        if ($userModel instanceof JsonMessage) {
            return $userModel;
        }
        $classID = (int)app()->request->getBodyParam('classID');

        $classModel = $this->getSchoolClassModel($classID);

        if ($classModel instanceof JsonMessage) {
            return $classModel;
        }
        $identity = (int)app()->request->getBodyParam('identity');

        $service = new ClassChangeService();

        $result = $service->ChangeIdentity($userID, $classID, $identity);

        $jsonResult->message = $result->message;

        $jsonResult->success = $result->success;

        \Yii::info('修改班内职务操作, 操作人Id：'.Yii::$app->user->id . '; userId:'.$userID.'; classId:'.$classID.'; identity:'.$identity.',方法：' . __METHOD__  , 'userHandler');

        return $this->renderJSON($jsonResult);


    }

    /**
     *教师和学生移除班级
     * @throws \yii\web\HttpException
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \yii\base\ExitException
     */
    public function actionLeaveClass()
    {
        $jsonResult = new JsonMessage();

        $classID = (int)app()->request->getBodyParam('classID');

        $classModel = $this->getSchoolClassModel($classID);

        if ($classModel instanceof JsonMessage) {
            return $classModel;
        }
        $userID = (int)app()->request->getBodyParam('userID');

        $userModel = $this->getSchoolUserModel($userID);

        if ($userModel instanceof JsonMessage) {

            return $userModel;
        }
        $service = new OrganizationService();

        $result = $service->OutClass($userID, $classID);

        $jsonResult->success = $result->success;

        $jsonResult->message = $result->message;

        \Yii::info('移除班级操作, 操作人Id：'.Yii::$app->user->id . '; userId:'.$userID.'; classId:'.$classID.', 方法：' . __METHOD__  , 'userHandler');

        return $this->renderJSON($jsonResult);

    }

    /**
     * 添加学生
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     */
    public function actionAddStudent()
    {
        $classID = (int)app()->request->getQueryParam('classID');
        $classModel = $this->getSchoolClassModel($classID);

        if ($classModel instanceof JsonMessage) {
            return $classModel;
        }

        return $this->render('addStudent', ['classID' => $classID]);

    }

    /**
     * 检索出学生列表
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionQueryStudents()
    {

        $classID = app()->request->getBodyParam('classID');
        $phone = (string)app()->request->getBodyParam('phone');

        //检索学生
        $studentList = SeUserinfo::searchStudentPhone($phone);

        return $this->renderPartial('_stu_list', ['studentList' => $studentList, 'classID' => $classID]);
    }

    /**
     * 新建账号时候弹出的学生信息
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionGetStuHtml()
    {

        $trueName = app()->request->getBodyParam('trueName');
        $bindphone = app()->request->getBodyParam('bindphone');
        $phoneReg = $trueName . $bindphone;

        //检测账号
        $userIsExisted = SeUserinfo::existsPhoneReg($phoneReg);

        if ($userIsExisted) {

            $phoneReg = $trueName . random_int(1, 99) . $bindphone;
        }
        return $this->renderPartial('_stu_html',
            [
                'trueName' => $trueName,
                'bindphone' => $bindphone,
                'phoneReg' => $phoneReg
            ]);
    }

    /**
     * 修改学生信息时候弹出的学生信息
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionGetStuDetails()
    {

        $userID = (int)app()->request->getBodyParam('userID');

        $userDetails = SeUserinfo::getUserDetails($userID);

        return $this->renderPartial('_stu_details', ['userDetails' => $userDetails]);
    }

    /**
     * 添加和修改学生并且把学生拉到当前班级
     * @return string
     * @throws \yii\base\ExitException
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \yii\web\HttpException
     */
    public function actionMoveStuToClass()
    {

        $jsonResult = new JsonMessage();

        $classID = (int)app()->request->getBodyParam('classID');

        $classModel = $this->getSchoolClassModel($classID);

        if ($classModel instanceof JsonMessage) {
            return $classModel;
        }

        $type = app()->request->getBodyParam('type');

        $stuID = (string)app()->request->getBodyParam('stuID');

        $trueName = (string)app()->request->getBodyParam('trueName');

        $bindphone = (string)app()->request->getBodyParam('bindphone');

        $sex = (int)app()->request->getBodyParam('sex', 0);

        $phoneReg = (string)app()->request->getBodyParam('phoneReg');

        $parentsName = (string)app()->request->getBodyParam('parentsName');

        $phone = (string)app()->request->getBodyParam('phone');

        $department = 0;

        $classDetails = SeClass::accordingToClassIdGetDepartment($classID);

        if ($classDetails) {
            $department = $classDetails->department;
        }

        $service = new ClassChangeService();

        $result = $type ? $service->AddStudent($this->schoolId, $classID, $stuID, $trueName, $phone, $sex, $phoneReg, $parentsName, $bindphone, $department) : $service->ModifyStudent($this->schoolId, $classID, $stuID, $trueName, $phone, $sex, $phoneReg, $parentsName, $bindphone, $department);

        $jsonResult->success = $result->success;

        $jsonResult->message = $result->message;

        \Yii::info('添加和修改学生并且把学生拉到当前班级, 操作人Id：'.Yii::$app->user->id . 'studentId:'.$stuID.'; classId:'.$classID.', 方法：' . __METHOD__  , 'userHandler');


        return $this->renderJSON($jsonResult);
    }
}