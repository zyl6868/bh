<?php
declare(strict_types = 1);
namespace frontend\modules\teacher\controllers;

use common\clients\MessageService;
use common\models\JsonMessage;
use common\models\pos\SeClassMembers;
use common\models\pos\SeHomeworkPlatform;
use common\models\pos\SeHomeworkPlatformMaterials;
use common\models\pos\SeHomeworkPlatformSuggest;
use common\models\pos\SeHomeworkPlatformVideos;
use common\models\pos\SeHomeworkQuestionPlatform;
use common\models\pos\SeHomeworkRel;
use common\models\pos\SeHomeworkTeacher;
use common\models\sanhai\ShTestquestion;
use common\models\sanhai\ShVideolesson;
use common\models\sanhai\SrMaterial;
use common\models\search\Es_testQuestion;
use common\clients\JfManageService;
use frontend\components\TeacherBaseController;
use Exception;
use Yii;
use yii\db\Transaction;
use yii\helpers\ArrayHelper;

/**
 * Created by wangchunlei
 * User: Administrator
 * Date: 14-11-3
 * Time: 下午6:34
 */
class ManagetaskController extends TeacherBaseController
{
    public $layout = 'lay_user';

    /**
     * 获取选择班级弹框
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionGetClassBoxNew()
    {
        $homeworkId = app()->request->post('homeworkid');
        $type = app()->request->getBodyParam('type', 0);
        $SeHomeworkTeacherQuery = SeHomeworkTeacher::find();
        $homeworkTeaOne = null;
        if ($type) {
            $homeworkTeaOne = $SeHomeworkTeacherQuery->where(['homeworkPlatformId' => $homeworkId, 'creator' => user()->id])->one();
        } else {
            $homeworkTeaOne = $SeHomeworkTeacherQuery->where(['id' => $homeworkId])->one();
        }
        if ($type == 0) {
            $getType = $homeworkTeaOne->getType;
        } else {

            $getType = 0;
        }
        $homeworkRelList = SeHomeworkRel::find()->where(['homeworkId' => $homeworkTeaOne->id])->all();
        $homeworkarr = ArrayHelper::getColumn($homeworkRelList, 'classID');
        $classInfo = loginUser()->getClassInfo();
        $unassignClass = [];
        foreach ($classInfo as $key => $val) {
            if (!in_array($val->classID, $homeworkarr)) {
                $unassignClass[] = $val->classID;
            }
        }
        return $this->renderPartial('_getclassbox_new',
            [
                'homeworkRelList' => $homeworkRelList,
                'unassignClass' => $unassignClass,
                'homeworkTeaOne' => $homeworkTeaOne,
                'getType' => $getType,
                'hmwid' => $homeworkId
            ]);
    }

    /**
     * 作业分配到班
     * @return string
     * @throws \yii\base\ExitException
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function actionSendHomework()
    {

        $homeworkId = (int)app()->request->post('homeworkId');
        $userId = user()->id;
        $jsonResult = new JsonMessage();

        if (isset($_POST['isShare']) && $_POST['isShare'] == 1) {
            //共享到平台
            SeHomeworkTeacher::updateAll(['isShare' => '1'], ['creator' => user()->id, 'id' => $homeworkId]);
        }

        $isSignature = (int)Yii::$app->request->post('isSignature');

        if (isset($_POST['TeacherClassForm']) && !empty($_POST['TeacherClassForm'])) {
            //作业分配的到班级
            $relIdArr = [];
            /** @var Transaction $transaction */
            $transaction = Yii::$app->db_school->beginTransaction();
            try {
                foreach ($_POST['TeacherClassForm'] as $val) {
                    if (isset($val) && !empty($val['classID']) && !empty($val['deadlineTime'])) {
                        $isExists = SeHomeworkRel::actionGetOneRecord((int)$val['classID'], $homeworkId);
                        if (!$isExists) {
                            $homeworkRelModel = new SeHomeworkRel();
                            $homeworkRelModel->instertRecord($val, $homeworkId,$isSignature);
                            if ($homeworkRelModel->save(false)) {
                                $relIdArr[] = $homeworkRelModel->id;
                            }
                        }
                    }
                }
                $jsonResult->success = true;
                $jsonResult->message = '布置成功';
                $transaction->commit();
                try {
                    foreach ($relIdArr as $id) {
                        //发送消息
                        $work = new  MessageService();
                        $work->assignHomeworkMessage((int)$id, 507001);
                        //增加积分
                        $jfHelper = new JfManageService();
                        $jfHelper->addJfXuemi('pos-upl-orgWork', $userId,1);
                    }
                } catch (Exception $e) {
                    \Yii::error('布置作业消息/积分错误信息' . $homeworkId . '------' . $e->getMessage());
                }

            } catch (Exception $e) {
                $jsonResult->message = '布置失败';
                $transaction->rollBack();
                \Yii::error('作业布置失败错误信息' . $homeworkId . '------' . $e->getMessage());
            }

        } else {
            $jsonResult->message = '该班级已经布置过作业';
        }
        return $this->renderJSON($jsonResult);
    }

    /**
     * 上传作业详细页
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionNewUpdateWorkDetail()
    {
        $this->layout = 'lay_user_new';
        $homeworkId = (int)app()->request->getParam('homeworkid');
        $homeworkData = SeHomeworkTeacher::getHomeworkTeacherDetails($homeworkId);
        //         是否布置给学生
        $isAssignStu = SeHomeworkRel::checkHomeworkRelExists($homeworkId);
        return $this->render('newupdateworkdetail',
            array('homeworkData' => $homeworkData,
                'homeworkId' => $homeworkId,
                'isAssignStu' => $isAssignStu
            ));
    }

    /**
     *组织作业预览页
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\ExitException
     * @throws \yii\web\HttpException
     */
    public function actionOrganizeWorkDetailsNew()
    {
        $this->layout = 'lay_user_new';
        $homeworkID = (int)app()->request->getParam('homeworkid', '');
        $homeworkData = SeHomeworkTeacher::getHomeworkTeacherDetails($homeworkID);
        if (empty($homeworkData)) {
            return $this->notFound();
        }
//        根据homeworkID查询questionid
        $questionList = $homeworkData->getHomeworkQuestion()->select('questionId')->all();
        if (empty($questionList)) {
            return $this->notFound();
        }
//        查询题目的具体内容
        $homeworkResult = [];
        foreach ($questionList as $v) {
            $oneHomework = Es_testQuestion::getTestQuestionDetails($v['questionId']);
            $homeworkResult[] = $oneHomework;
        }
//         是否布置给学生
        $isAssignStu = SeHomeworkRel::checkHomeworkRelExists($homeworkID);

        return $this->render('organizeWorkdetailsnew', array('homeworkResult' => $homeworkResult, 'homeworkData' => $homeworkData, 'isAssignStu' => $isAssignStu));
    }

    /**
     * 后台推送的作业的详情页
     * @param integer $homeworkID
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\ExitException
     * @throws \yii\web\HttpException
     */
    public function actionPushedLibraryDetails(int $homeworkID)
    {
        $this->layout = 'platform_blank';
        $homeworkData = SeHomeworkPlatform::getHomeworkPlatformPortion($homeworkID);
//        根据homeworkID查询questionid
        $questionList = SeHomeworkQuestionPlatform::getHomeworkQuePlatformQuestionIdAll($homeworkID);
        if (empty($questionList)) {
            return $this->notFound('未找到该作业！');
        }
//        查询题目的具体内容
        $homeworkResult = [];
        foreach ($questionList as $v) {
            $oneHomework = ShTestquestion::getTestQuestionDetails_Cache((int)$v['questionId']);
            $homeworkResult[] = $oneHomework;
        }
//        判断是否已经加入作业
        $homeworkIsExist = SeHomeworkTeacher::checkHomeworkExists($homeworkID, user()->id);
//        查询作业关联的资料列表
        $materialIdArray = SeHomeworkPlatformMaterials::getHomeworkPlatformMaterialsIdAll($homeworkID);
        $materialList = SrMaterial::find()->where(['id' => ArrayHelper::getColumn($materialIdArray, 'materialId')])->all();
//        查询作业关联的视频列表
        $videoIdArray = SeHomeworkPlatformVideos::getHomeworkPlatformVideosIdAll($homeworkID);
        $videoList = ShVideolesson::find()->where(['lid' => ArrayHelper::getColumn($videoIdArray, 'videoId')])->all();
        return $this->render('pushedLibraryDetails', ['homeworkData' => $homeworkData,
            'homeworkResult' => $homeworkResult,
            'homeworkIsExist' => $homeworkIsExist,
            'materialList' => $materialList,
            'videoList' => $videoList
        ]);
    }

    /**
     * 提出意见
     * @return string
     * @throws \yii\base\ExitException
     * @throws \yii\db\Exception
     */
    public function actionAddSuggest()
    {
        $homeworkID = app()->request->getBodyParam('homeworkID');
        $suggestion = app()->request->getBodyParam('suggestion');
        $userId = user()->id;
        $jsonResult = new JsonMessage();
        $model = SeHomeworkPlatformSuggest::addSuggest($homeworkID, $suggestion, $userId);
        if ($model) {
            $jsonResult->success = true;
        }
        return $this->renderJSON($jsonResult);
    }

    /**
     * 判断是否已经加入作业
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionIsExist()
    {
        $jsonResult = new JsonMessage();
        $homeworkID = (int)app()->request->getBodyParam('homeworkID');
        $userId = user()->id;
        $homeworkIsExist = SeHomeworkTeacher::checkHomeworkExists($homeworkID, $userId);
        $jsonResult->success = $homeworkIsExist;
        return $this->renderJSON($jsonResult);
    }

    /**
     * 加入作业
     * @return string
     * @throws \yii\base\ExitException
     * @throws \yii\db\Exception
     */
    public function actionLibraryJoinTeacher()
    {
        $userID = user()->id;
        $jsonResult = new JsonMessage();
        $homeworkID = (int)app()->request->getBodyParam('homeworkID');
        //        判断是否已经加入作业
        $homeworkIsExist = SeHomeworkTeacher::checkHomeworkExists($homeworkID, $userID);
        if ($homeworkIsExist) {
            $jsonResult->message = '您已经加入当前作业了';
        } else {
            $jsonResult->success = SeHomeworkTeacher::collectHomework($homeworkID, $userID);
        }
        return $this->renderJSON($jsonResult);
    }

}