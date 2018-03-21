<?php
declare(strict_types=1);
namespace frontend\modules\teacher\controllers;

use common\models\JsonMessage;
use common\models\pos\SeHomeworkRel;
use common\models\pos\SeHomeworkTeacher;
use Exception;
use frontend\components\TeacherBaseController;
use Yii;
use yii\data\Pagination;
use yii\db\Transaction;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/5/30
 * Time: 10:52
 */
class ResourcesController extends TeacherBaseController
{
	public $layout = 'lay_user_new';


    /**
     * 教师个人中心-我的资源-作业列表-我的收藏
     * @return string
     * @throws \yii\base\InvalidParamException
     */
	public function actionCollectWorkManage()
	{
		$pages = new Pagination();
		$pages->validatePage = false;
		$pages->pageSize = 10;
		$userInfo = loginUser()->getModel();
		$department = app()->request->get('department', $userInfo->department);
		$subjectId = app()->request->get('subjectId', $userInfo->subjectID);

		$homeworkQuery = SeHomeworkTeacher::find()->where(['department' => $department, 'subjectId' => $subjectId])->source_platform(user()->id);

		$pages->totalCount = $homeworkQuery->count();
		$homeworkList = $homeworkQuery->orderBy('createTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->all();
		if (app()->request->isAjax) {
			return $this->renderPartial('_teacher_work_manage_list', ['homeworkList' => $homeworkList, 'pages' => $pages]);
		}
		return $this->render('teacherCollectWorkManage',
			[
				'homeworkList' => $homeworkList,
				'pages' => $pages,
				'department' => $department,
				'subjectId' => $subjectId
			]);
	}

    /**
     * 教师个人中心-我的资源-作业列表-我的创建
     * @return string
     * @throws \yii\base\InvalidParamException
     */
	public function actionMyCreateWorkManage()
	{
		$pages = new Pagination();
		$pages->validatePage = false;
		$pages->pageSize = 10;
		$userInfo = loginUser()->getModel();
		$department = app()->request->get('department', $userInfo->department);
		$subjectId = app()->request->get('subjectId', $userInfo->subjectID);
		$type = app()->request->get('type');
		$homeworkQuery = SeHomeworkTeacher::find()->where(['department' => $department, 'subjectId' => $subjectId])->source_user(user()->id);
		//纸质和电子
		if (isset($type) && $type != null) {
			$homeworkQuery = $homeworkQuery->andWhere(['getType' => $type]);
		}

        $pages->totalCount = $homeworkQuery->count();
        $homeworkList = $homeworkQuery->orderBy('createTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->all();

		if (app()->request->isAjax) {
			return $this->renderPartial('_teacher_work_manage_list', ['homeworkList' => $homeworkList, 'pages' => $pages]);
		}
		return $this->render('teacherMyCreateWorkManage',
			[
				'department' => $department,
				'subjectId' => $subjectId,
				'homeworkList' => $homeworkList,
				'pages' => $pages
			]);
	}

    /**
     * 获取选择班级弹框
     * @return string
     * @throws \yii\base\InvalidParamException
     */
	public function actionGetClassBox()
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
		return $this->renderPartial('_getclassbox',
			[
				'homeworkRelList' => $homeworkRelList,
				'unassignClass' => $unassignClass,
				'homeworkTeaOne' => $homeworkTeaOne,
				'getType' => $getType,
				'hmwid' => $homeworkId
			]);
	}

    /**
     * 删除布置后的班级作业
     * @return string
     * @throws \yii\base\ExitException
     */

	public function actionDeleteRel()
	{
		$jsonResult = new JsonMessage();
		$relId = app()->request->post('relId');

        /** @var Transaction $transaction */
        $transaction = Yii::$app->db_school->beginTransaction();
		try {
			$homeworkRel = SeHomeworkRel::getHomeworkRelDetails($relId,user()->id);
			$homeworkAnswerInfo = $homeworkRel->getHomeworkAnswerInfo()->exists();
			if (empty($homeworkRel)) {
				$jsonResult->success = false;
				$jsonResult->message = '删除失败，您删除的作业信息有误，请检查！';
			} elseif (!empty($homeworkAnswerInfo)) {
				$jsonResult->success = false;
				$jsonResult->message = '该作业已有学生作答，不能再删除！';
			} else {
				$deleteHomeworkRel = $homeworkRel->delete();
				if ($deleteHomeworkRel == 1) {
					$jsonResult->success = true;
					$jsonResult->message = '删除成功！';
				} else {
					$jsonResult->success = false;
					$jsonResult->message = '删除失败！';
				}
			}
			$transaction->commit();

		} catch (Exception $e) {
			$transaction->rollBack();
            \Yii::error('删除布置后的班级作业错误信息' . $relId . '------' . $e->getMessage());
		}
		return $this->renderJSON($jsonResult);

	}

    /**
     * 用于
     * 布置作业
     * 和
     * 删除已布置到班级的作业 后 刷新单条作业信息
     * wgl
     * @return bool|string
     * @throws \yii\base\InvalidParamException
     *
     */
	public function actionOneWorkContent()
	{
		$id = (int)app()->request->get("hmwid");
		$userId = user()->id;
		$homeworkQuery = SeHomeworkTeacher::getUserIdHomeworkTeacherDetails($id,$userId);
		if (empty($homeworkQuery)) {
			return false;
		}
		return $this->renderPartial('_teacher_work_manage_list_content', ['val' => $homeworkQuery]);
	}
}
