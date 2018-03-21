<?php
/**
 * Created by wsk.
 * User: Administrator
 * Date: 2016/5/27
 * Time: 15:10
 */

namespace frontend\modules\teacher\controllers;

use common\helper\DateTimeHelper;
use common\models\JsonMessage;
use common\models\pos\SePaperQuesTypeRlts;
use common\models\pos\SeQuestionFavoriteFolderNew;
use common\models\pos\SeQuestionGroup;
use common\models\search\Es_testQuestion;
use frontend\components\helper\DepartAndSubHelper;
use frontend\components\TeacherBaseController;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;


class QuestionController extends TeacherBaseController
{
    /**
     * 小学
     */
    const DEPARTMENT = 20201;

    /**
     * 语文
     */
    const SUBJECT = 10010;

    /**
     * 自定义分组
     */
    const DEFINE_GROUP_TYPE = 1;

    /**
     * 最多40自定义分组
     */
    const MAX_GROUP_NUM = 40;

    public $layout = 'lay_user_new';


    /**
     * 我的资源的题目页面
     * @throws \yii\base\InvalidParamException
     */
    public function actionIndex()
    {
        //学部
        $departments = app()->request->getParam('department', self::DEPARTMENT);
        $subjectid = app()->request->getParam('subjectId', self::SUBJECT);
        $userId = user()->id;
        //题型id
        $type = app()->request->getParam('type', null);
        //难度
        $complexity = app()->request->getParam('complexity', null);
        //根据学段科目展示题型
        $SePaperQuesTypeRltsModel = new SePaperQuesTypeRlts();
        $result = $SePaperQuesTypeRltsModel->questionType($departments, $subjectid);
        //更换学科
        $departAndSubArray = DepartAndSubHelper::getTopicSubArray();
        //我的收藏分组id
        $SeQuestionGroupModel = new SeQuestionGroup();
        $collectGroup = $SeQuestionGroupModel->collectGroup($userId,$subjectid, $departments);
        //各个学段学科下默认-我的收藏分组id
        $collectGroupId = $collectGroup['groupId'];
        //默认我的收藏分组id
        $groupId = app()->request->getParam('groupId', $collectGroupId);
        //我的收藏分组题目份数
        $defaultGroupNum = $SeQuestionGroupModel->defGroupQuesNum($collectGroupId);
        //当前学段科目下所有分组id
        $groupIds = $SeQuestionGroupModel::defineGroup($userId,$subjectid, $departments);
        //通过groupId查询groupName
        $groupModel = $SeQuestionGroupModel->groupName($groupId);
        //通过groupId查询当前组中题目数量
        $nowGroupNum = $SeQuestionGroupModel->defGroupQuesNum($groupId);
        if (!empty($groupModel)) {
            $groupName = $groupModel->groupName;
        } else {
            $groupName = '我的收藏';
        }
        //分页
        $pages = new Pagination();
        $pages->validatePage = false;
        $pages->pageSize = 10;
        //分组下的题目列表
        $SeQuestionFavoriteFolderNewModel = new SeQuestionFavoriteFolderNew();
        $questionIdList = $SeQuestionFavoriteFolderNewModel->questionIdList($userId,$groupId);
        $questionArr = ArrayHelper::getColumn($questionIdList, 'questionId', false);

        $Es_testQuestionQuery = Es_testQuestion::forFrondSearch()->where(['id' => $questionArr]);
        if ($type != null) {
            $Es_testQuestionQuery->andWhere(['tqtid' => $type]);
        }
        if ($complexity != null) {
            $Es_testQuestionQuery->andWhere(['complexity' => $complexity]);
        }

        $pages->totalCount = (int)$Es_testQuestionQuery->count();

        $dataList = $Es_testQuestionQuery->orderBy('createTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->all();

        $pages->params = ['type' => $type, 'complexity' => $complexity, 'department' => $departments, 'subjectId' => $subjectid, 'groupId' => $groupId];
        $searchArrMore = array(
            'type' => $type,
            'complexity' => $complexity,
            'department' => $departments,
            'subjectId' => $subjectid,

        );
        if (app()->request->isAjax) {
            return $this->renderPartial('topic_list', [
                'result' => $result,
                'groupIds' => $groupIds,
                'groupId' => $groupId,
                'groupName' => $groupName,
                'defaultGroupNum' => $defaultGroupNum,
                'nowGroupNum' => $nowGroupNum,
                'department' => $departments,
                'subjectId' => $subjectid,
                'searchArr' => $searchArrMore,
                'type' => $type,
                'complexity' => $complexity,
                'pages' => $pages,
                'dataList' => $dataList,]);
        }
        return $this->render('teacherCollectQuestionManage', [
            'result' => $result,
            'groupIds' => $groupIds,
            'groupId' => $groupId,
            'groupName' => $groupName,
            'defaultGroupNum' => $defaultGroupNum,
            'nowGroupNum' => $nowGroupNum,
            'collectGroupId' => $collectGroupId,
            'department' => $departments,
            'subjectId' => $subjectid,
            'searchArr' => $searchArrMore,
            'type' => $type,
            'complexity' => $complexity,
            'pages' => $pages,
            'dataList' => $dataList,
            'departAndSubArray' => $departAndSubArray
        ]);

    }


    /**
     * 查询所有自定义组
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\ExitException
     */
    public function actionDefineGroup()
    {
        $jsonMessage = new JsonMessage();
        $subjectId = app()->request->getBodyParam('subjectId');
        $department = app()->request->getBodyParam('department');
        $groupId = app()->request->getBodyParam('groupId');
        $userId = user()->id;
        $defineGroups = SeQuestionGroup::defineGroup($userId, $subjectId, $department);
        if (empty($defineGroups)) {
            $jsonMessage->message = '显示组名失败，请刷新页面';
            return $this->renderJSON($jsonMessage);
        }
        $jsonMessage->success = true;
        $jsonMessage->data = $this->renderPartial('_defineGroup', ['groupId' => $groupId, 'subjectId' => $subjectId, 'department' => $department, 'groupIds' => $defineGroups]);
        return $this->renderJSON($jsonMessage);
    }


    /**
     * 查询所有可以移动到的分组
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionMoveGroupOther()
    {
        $subjectId = app()->request->getBodyParam('subjectId');
        $department = app()->request->getBodyParam('department');
        $userId = user()->id;
        $moveGroupIds = SeQuestionGroup::defineGroup($userId,$subjectId, $department);

        return $this->renderPartial('_moveGroup', ['moveGroupIds' => $moveGroupIds]);
    }


    /**
     * 删除题目
     * @return string
     * @throws \yii\base\ExitException
     * @throws \yii\db\Exception
     */
    public function actionBatchDelQuestion()
    {
        $jsonResult = new JsonMessage();
        $questionsIds = app()->request->getBodyParam('questionIds');
        $groupId = app()->request->getBodyParam('groupId');
        $userId = user()->id;

        $SeQuestionFavoriteFolderNewModel = new SeQuestionFavoriteFolderNew();
        if ($SeQuestionFavoriteFolderNewModel->delQuestion($userId,$questionsIds, $groupId)) {
            $jsonResult->success = true;
            $jsonResult->message = '题目删除成功';
        } else {
            $jsonResult->success = false;
            $jsonResult->message = '题目删除失败';
        }
        return $this->renderJSON($jsonResult);
    }


    /**
     * 新建组
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionAddGroup()
    {
        $jsonResult = new JsonMessage();
        $userId = user()->id;
        $department = app()->request->getBodyParam('department');
        $subjectId = app()->request->getBodyParam('subjectId');
        $groupName = app()->request->getBodyParam('groupName');
        $groupType = self::DEFINE_GROUP_TYPE;
        $createTime = DateTimeHelper::timestampX1000();
        $qusGroupModel = new SeQuestionGroup();
        $groupInfo = $qusGroupModel::defineGroup($userId,$subjectId, $department);
        $groupNameList = [];
        foreach ($groupInfo as $group) {
            $groupNameList[] = $group['groupName'];
        }
        $groupCount = $qusGroupModel->defineGroupNum($userId);
        if (!in_array($groupName, $groupNameList)) {
            if ($groupCount < self::MAX_GROUP_NUM) {
                if ($qusGroupModel->addGroupNew($userId, $department, $subjectId, $groupName, $groupType, $createTime)) {
                    $jsonResult->success = true;
                    $jsonResult->message = '创建成功';
                } else {
                    $jsonResult->success = false;
                    $jsonResult->message = '创建失败';
                }
            } else {
                $jsonResult->success = false;
                $jsonResult->message = '自定义分组限制40个';
            }
        } else {
            $jsonResult->success = false;
            $jsonResult->message = '自定义分组不能重名';
        }
        return $this->renderJSON($jsonResult);
    }


    /**
     * 修改组名
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionModifyGroupName()
    {
        $jsonResult = new JsonMessage();
        $groupId = app()->request->getBodyParam('groupId');
        $groupName = app()->request->getBodyParam('groupName');
        $userId = user()->id;
        $department = app()->request->getBodyParam('department');
        $subjectId = app()->request->getBodyParam('subjectId');
        $updateTime = DateTimeHelper::timestampX1000();
        $seQuestionGroupModel = new SeQuestionGroup();
        $groupInfo = $seQuestionGroupModel::defineGroup($userId,$subjectId, $department);
        $groupNameList = [];
        foreach ($groupInfo as $group) {
            $groupNameList[] = $group['groupName'];
        }
        if (!in_array($groupName, $groupNameList)) {
            $qusGroupModel = $seQuestionGroupModel->groupOne($userId, $groupId);
            if ($qusGroupModel['groupType'] == self::DEFINE_GROUP_TYPE) {
                if ($seQuestionGroupModel->modifyGroupName($userId, $groupId, $groupName, $updateTime)) {
                    $jsonResult->success = true;
                    $jsonResult->message = '修改组名成功';
                } else {
                    $jsonResult->success = false;
                    $jsonResult->message = '修改组名失败';
                }
            } else {
                $jsonResult->success = false;
                $jsonResult->message = "不能修改系统默认'我的收藏'分组组名";
            }
        } else {
            $jsonResult->success = false;
            $jsonResult->message = '修改分组不能重名';
        }
        return $this->renderJSON($jsonResult);
    }


    /**删除组
     * @return string
     * @throws \Exception
     */
    public function actionDelGroup()
    {
        $jsonResult = new JsonMessage();
        $groupId = app()->request->getParam('groupId');
        $userId = user()->id;
        $SeQuestionGroupModel = new SeQuestionGroup();
        $groupInfoModel = $SeQuestionGroupModel->groupOne($userId,$groupId);
        if (empty($groupInfoModel)) {
            $jsonResult->message = '删除失败';
            return $this->renderJSON($jsonResult);
        }
        if ($groupInfoModel->groupType != self::DEFINE_GROUP_TYPE) {
            $jsonResult->message = '不能删除系统默分组';
            return $this->renderJSON($jsonResult);
        }
        $result = $groupInfoModel->deleteGroup($userId,$groupId);
        if ($result == false) {
            $jsonResult->message = '删除失败';
            return $this->renderJSON($jsonResult);
        }
        $jsonResult->success = true;
        $jsonResult->message = '删除成功';

        return $this->renderJSON($jsonResult);

    }


    /**移动组
     * @return string
     * @throws \yii\base\ExitException
     * @throws \yii\db\Exception
     */
    public function actionBatchMoveGroup()
    {
        $jsonResult = new JsonMessage();
        $questionIds = app()->request->getBodyParam('questionIds');
        $groupId = app()->request->getBodyParam('groupId');
        $userId = user()->id;
        $seQuestionFavoriteFolderNewModel = new SeQuestionFavoriteFolderNew();
        if ($seQuestionFavoriteFolderNewModel->moveQuestionGroup($userId,$questionIds, $groupId)) {
            $jsonResult->success = true;
            $jsonResult->message = '题目移动成功';
        } else {
            $jsonResult->success = false;
            $jsonResult->message = '题目移动失败';
        }
        return $this->renderJSON($jsonResult);
    }

}