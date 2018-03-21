<?php
declare(strict_types = 1);
namespace frontend\modules\teacher\controllers;

use common\models\dicmodels\SchoolLevelModel;
use common\models\JsonMessage;
use common\models\pos\SeClassMembers;
use common\models\pos\SeFavoriteMaterial;
use common\models\pos\SeHomeworkTeacher;
use common\models\pos\SeQuestionFavoriteFolderNew;
use common\models\sanhai\SrMaterial;
use common\clients\ClassChangeService;
use common\clients\JfManageService;
use frontend\components\TeacherBaseController;
use common\components\WebDataCache;
use frontend\models\BasicInformationForm;
use common\models\dicmodels\LoadTextbookVersionModel;
use common\models\dicmodels\SubjectModel;
use frontend\models\EditPasswordForm;
use frontend\services\pos\pos_MessageSentService;
use frontend\services\pos\pos_PaperManageService;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

/**
 * Created by wangchunlei
 * User: Administrator
 * Date: 14-9-23
 * Time: 上午9:52
 */
class SettingController extends TeacherBaseController
{
    /**
     *  学段—小学
     */
    const DEPARTMENT = 20201;

    /**
     * 学科—语文
     */
    const SUBJECT = 10010;

    public $layout = 'lay_user_new';

    public function actionIndex()
    {
        return $this->actionPersonalCenter();
    }

    /**
     * 个人中心
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
    public function actionPersonalCenter()
    {
        $userId = user()->id;

        //获取用户所在学校
        $userModel = loginUser();
        $schoolId = $userModel->schoolID;
        $schoolModel = $this->getSchoolModel($schoolId);
        //获取用户所在班级
        $classArr = $userModel->getClassInfo();


		//总积分和可用积分和今日积分
		$jfManageHelperModel = new JfManageService();
		$userScore = $jfManageHelperModel->UserScore($userId);
		$points = $userScore->points ?? 0;
		$totalPonits = $userScore->totalPoints ?? 0;
		$todayPonits = $jfManageHelperModel->UserDayScore($userId)??0;
		$gradePonits = $jfManageHelperModel->JfGrade($userId);
		return $this->render('teacher_home', [
			'classArr' => $classArr,
			'schoolModel' => $schoolModel,
			'points' => $points,
			'totalPoints' => $totalPonits,
			'todayPoints' => $todayPonits,
			'gradePonits' => $gradePonits
		]);
	}


    /**
     * 教师个人中心 系统消息
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionGetMessages()
    {
        $userId = app()->request->get('userId');

        //系统消息3条
        $pages = new Pagination();
        $pages->validatePage = false;
        $pages->pageSize = 3;
        $data = new pos_MessageSentService();
        $sysResult = $data->readerQuerySentMessageInfo($userId, 508, '', $pages->getPage() + 1, $pages->pageSize);

        return $this->renderPartial('teacher_message', ['sysResult' => $sysResult->data->list]);

    }

    /**
     *修改密码
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidParamException
     */
    public function actionChangePassword()
    {
        $model = new EditPasswordForm();
        if ($_POST) {
            $model->attributes = $_POST['EditPasswordForm'];
            $model->userId = user()->id;
            if ($model->validate()) {
                app()->getSession()->setFlash('success', '密码修改成功！');
                return $this->redirect(['change-password']);
            }
        }
        return $this->render('//publicView/setting/changePassword', array('model' => $model));
    }

    /**
     *修改头像
     * @return string
     * @throws \yii\base\InvalidParamException
     */

    public function actionSetHeadPic()
    {
        return $this->render('//publicView/setting/setHeadPic');
    }

    /**
     * 教师基本信息页面
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionBasicInformation()
    {
        return $this->render('teacher_basic_information');
    }

    /**
     * 教师修改基本信息页面
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidParamException
     */
    public function actionTeacherEditBasicInformation()
    {
        $userModel = loginUser();
        $model = new BasicInformationForm();
        $model->trueName = $userModel->trueName;
        $model->bindphone = $userModel->bindphone;
        $model->phoneReg = $userModel->phoneReg;
        $model->sex = $userModel->sex;
        $model->department = $userModel->department;
        $model->subjectID = $userModel->subjectID;
        $model->textbookVersion = $userModel->textbookVersion;

        $department = $userModel->department ?: self::DEPARTMENT;
        $subjectId = $userModel->subjectID ?: self::SUBJECT;
        // 查询学部列表
        $departmentDetails = SchoolLevelModel::model()->getDataList();
        $departmentArray = ArrayHelper::map($departmentDetails, 'secondCode', 'secondCodeValue');
        // 查询科目列表
        $subjectDetails = SubjectModel::getSubjectByDepartmentCache($department);
        $subjectArray = ArrayHelper::map($subjectDetails, 'secondCode', 'secondCodeValue');
        //查询版本
        $versionArray = LoadTextbookVersionModel::model($subjectId, null, $department)->getListData();

        if (isset($_POST['BasicInformationForm'])) {
            $model->attributes = $_POST['BasicInformationForm'];
            if ($model->validate() && $model->save()) {
                return $this->redirect(['basic-information']);
            }
        }
        return $this->render('teacher_edit_basic_information', [
            'model' => $model,
            'departmentArray' => $departmentArray,
            'subjectArray' => $subjectArray,
            'versionArray' => $versionArray]);
    }

    /**
     * 修改班级
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionChangeClass()
    {
        $pages = new Pagination();
        $pages->validatePage = false;
        $pages->pageSize = 10;
        $userId = user()->id;

        $classInfoQue = SeClassMembers::find()->where(['userID' => $userId])->select('userID,classID,identity,memName');
        $pages->totalCount = $classInfoQue->count();
        $classInfo = $classInfoQue->orderBy('createTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->all();

        if (app()->request->isAjax) {
            return $this->renderPartial('_teacher_change_class_list', array('classInfo' => $classInfo, 'pages' => $pages));
        }
        return $this->render('teacherChangeClass',
            [
                'classInfo' => $classInfo,
                'pages' => $pages
            ]);
    }

    /**
     * 用于打开查找班级页面
     * wgl
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionFindClassView()
    {
        return $this->renderPartial('_teacher_find_class_code_view');
    }

    /**
     * 查找班级
     * wgl
     * @return string
     * @throws \yii\base\ExitException
     * @throws \Httpful\Exception\ConnectionErrorException
     */

    public function actionInviteCode()
    {
        $jsonResult = new JsonMessage();
        $userId = user()->id;
        $code = app()->request->get('code');
        $model = new ClassChangeService();

        $result = $model->classInviteCode($userId, (string)$code);
        if ($result->success) {
            $jsonResult->success = true;
            $jsonResult->message = $result->message;
        } else {
            $jsonResult->success = false;
            $jsonResult->message = $result->message;
        }
        return $this->renderJSON($result);

    }

    /**
     * 用于退出班级确认弹窗~
     * wgl
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\ExitException
     * @throws \yii\web\HttpException
     */
    public function actionFindClassInfo()
    {
        $classId = (int)app()->request->get('classId');
        $userId = user()->id;
        $classInfo = SeClassMembers::getOneClassInfo($classId, $userId);
        if (empty($classInfo)) {
            return $this->notFound('未找到该班级,请正确输入！');
        }
        return $this->renderPartial('_teacher_del_class_view', ['classInfo' => $classInfo]);
    }

    /**
     * 我的资源统计
     * @return string
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
    public function actionResourcesStatistics()
    {

        $jsonResult = new JsonMessage();
        $userId = (int)user()->id;

        //自己创建的作业数
        $creatHomeworkNum = SeHomeworkTeacher::getCreateHomeworkNum($userId);

        //收藏的平台作业数
        $collectHomeworkNum = SeHomeworkTeacher::getCollectHomeworkNum($userId);

        //获取收藏的题目
        $favoriteTitleNum = SeQuestionFavoriteFolderNew::getfavoriteQuestionNum($userId);

        //获取收藏的课件数
        $favoriteFileNum = SeFavoriteMaterial::favoriteFileNum($userId);

        //获取创建的课件数
        $createFileNum = SrMaterial::getCreateFileCount($userId);

        //获取创建的试卷的数量
        $pages = new Pagination();
        $pagerServer = new pos_PaperManageService();
        $result = $pagerServer->searchPapeer($userId, $pages->getPage() + 1, $pages->pageSize, '', '', '', '', '');
        $createTestNum = intval($result->countSize);

        $jsonResult->creatHomeworkNum = $creatHomeworkNum;
        $jsonResult->collectHomeworkNum = $collectHomeworkNum;
        $jsonResult->favoriteTitleNum = $favoriteTitleNum;
        $jsonResult->favoriteFileNum = $favoriteFileNum;
        $jsonResult->createFileNum = $createFileNum;
        $jsonResult->createTestNum = $createTestNum;

        return $this->renderJSON($jsonResult);
    }

}