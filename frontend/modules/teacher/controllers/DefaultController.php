<?php
namespace frontend\modules\teacher\controllers;
use common\helper\DateTimeHelper;
use common\models\JsonMessage;
use common\models\pos\SeFavoriteMaterial;
use common\models\sanhai\SrMaterial;
use frontend\components\BaseAuthController;
use frontend\services\pos\pos_AnswerQuestionManagerService;
use frontend\services\pos\pos_ClassMembersService;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;


/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-12-1
 * Time: 下午2:30
 */
class DefaultController extends BaseAuthController
{
    public $layout = 'lay_user_home';

    /**
     * 教师首页 xin
     * @param $teacherId
     * @return string
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     * @throws \yii\base\InvalidParamException
     */
	public function actionIndex($teacherId=0)
	{
        $proFirstime = microtime(true);
		$this->isInto($teacherId);
		$pages = new Pagination();$pages->validatePage=false;
		$pages->pageSize = 10;

		$type = app()->request->getParam('type', '');
		if($type == 0 || $type== ''){
			$type = null;
		}
		//老师答疑个数
		$answer = new pos_AnswerQuestionManagerService();
		$answerResult = $answer->stasticUserQues($teacherId);

		//查询文件
		$teacherFile = SrMaterial::find()->where(['creator'=>$teacherId]);

		$teacherFile->andFilterWhere(['matType'=>$type]);
        $teacherFileList = [];
        $pages->totalCount = $teacherFile->count();
        if($teacherId == user()->id){
            $teacherFileList = $teacherFile->orderBy('createTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->all();
        }elseif($teacherId != user()->id){
            $teacherFileList = $teacherFile->andWhere(['access'=> 1])->orderBy('createTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->all();
        }

		$listType = 1;
        \Yii::info('教师空间 '.(microtime(true)-$proFirstime),'service');
		if (app()->request->isAjax) {
			return $this->renderPartial('_teacher_file_list', array('result' => $teacherFileList, 'teacherId'=>$teacherId, 'listType'=>$listType, 'pages' => $pages));

		}
		 return $this->render('index', array('result' => $teacherFileList, 'teacherId'=>$teacherId, 'listType'=>$listType, 'answerResult'=>$answerResult, 'pages' => $pages));
	}

    /**
     * @param $teacherId
     * @return string
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     * @throws \yii\base\InvalidParamException
     * 教师主页 收藏列表
     */
	public function actionCollectList($teacherId)
	{
		$this->isInto($teacherId);
		$pages = new Pagination();$pages->validatePage=false;
		$pages->pageSize = 10;
		$type = app()->request->getParam('type', '');

		if($type == 0 || $type == ''){
			$type = null;
		}
		//老师答疑个数
		$answer = new pos_AnswerQuestionManagerService();
		$answerResult = $answer->stasticUserQues($teacherId);

		//查询收藏数据
		$seFavoriteFolderList = SeFavoriteMaterial::find()->where(['userId'=>$teacherId,'isDelete'=>0])->select('favoriteId')->all();
	    $arr = ArrayHelper::getColumn($seFavoriteFolderList,'favoriteId');

		$teacherQuery = SrMaterial::find()->where(['id'=>$arr]);

		$pages->totalCount = $teacherQuery->count();
		$result = $teacherQuery->andFilterWhere(['matType'=>$type])->offset($pages->getOffset())->limit($pages->getLimit())->all();

		$listType = 2;
		if (app()->request->isAjax) {
			return $this->renderPartial('_teacher_file_list', array('result' => $result, 'teacherId'=>$teacherId, 'listType'=>$listType, 'pages' => $pages));

		}
		return $this->render('indexCollectList', array('result' => $result, 'listType'=>$listType , 'teacherId'=>$teacherId, 'answerResult'=>$answerResult, 'pages' => $pages));
	}


    /**
     *AJAX获取班级成员
     *
     * @throws \yii\base\InvalidParamException
     */
    public function actionGetClassMember()
    {
	    $teacherId = app()->request->getParam('teacherId','');
        $classID = app()->request->getParam('classID','');
        $classServer = new pos_ClassMembersService();
        $classResult = $classServer->loadRegisteredMembers($classID, '' , $teacherId);
        return $this->renderPartial('_class_member', array('classResult' => $classResult, 'classId'=>$classID,'teacherId'=>$teacherId));
    }


    /**
     *添加收藏或取消收藏
     * @throws \Exception
     */
    public function actionAddMaterial()
    {
	    $jsonResult = new JsonMessage();

		$favoriteId = app()->request->getParam('id', 0);
        $userId = user()->id;
        $favoriteType = app()->request->getParam('type', '');
        $action = app()->request->getParam('action', '');
        if ($action == 1) {

	        $addFavor = new SeFavoriteMaterial();
	        $addFavor->favoriteId = $favoriteId;
	        $addFavor->matType = $favoriteType;
	        $addFavor->userId = $userId;
	        $addFavor->createTime = DateTimeHelper::timestampX1000();
	        if ($addFavor->save()) {
		        $jsonResult->success = true;
		        $jsonResult->message = '收藏成功！';
	        } else {
		        $jsonResult->success = false;
		        $jsonResult->message = '收藏失败！';
	        }
        } else {
			$result = SeFavoriteMaterial::materialCancelCollect($favoriteId, $userId);     //取消收藏课件操作
			if ($result == false) {
				$jsonResult->message = '取消收藏失败！';
			} else {
				$jsonResult->success = true;
				$jsonResult->message = '取消收藏成功！';
			}
        }

	    return $this->renderJSON($jsonResult);

    }


    /**
     * @param $teacherId
     * @return \yii\web\Response
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
    public function isInto($teacherId)
    {
        $user = loginUser()->getUserInfo($teacherId);
        if ($user == null) {
            return $this->notFound();
        }
        if ($user->isStudent()) {
            return $this->redirect(url('student/default/index', ['studentId' => $teacherId]));
        }
    }
}