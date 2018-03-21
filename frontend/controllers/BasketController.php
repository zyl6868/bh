<?php
declare(strict_types=1);
namespace frontend\controllers;

use common\helper\DateTimeHelper;
use common\models\JsonMessage;
use common\models\pos\SeHomeworkPlatformPushRecord;
use common\models\pos\SeHomeworkQuestion;
use common\models\pos\SeHomeworkTeacher;
use common\models\pos\SeQuestionCart;
use common\models\pos\SeQuestionCartQeustions;
use common\clients\JfManageService;
use frontend\components\BaseAuthController;
use frontend\components\helper\TreeHelper;
use common\models\dicmodels\ChapterInfoModel;
use common\models\dicmodels\LoadTextbookVersionModel;
use Yii;
use yii\base\Exception;
use yii\db\Transaction;
use yii\helpers\Html;

/**
 * 选题栏相关操作
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/2/24
 * Time: 13:41
 */
Class BasketController extends BaseAuthController
{
    public $layout = '@app/modules/platform/views/layouts/lay_platform';

    /**
     * 选题篮列表
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
    public function actionIndex()
    {
        $cartId = (int)app()->request->getQueryParam('cartId');
        $cartResult = SeQuestionCart::findByUserAndCardId(user()->id,$cartId);
        if($cartResult==null){
            return $this->notFound('此选题篮不存在');
        }
        $subject = (int)$cartResult->subjectId;
        $department = (int)$cartResult->departmentId;
        //根据科目获取版本
        $versionList = LoadTextbookVersionModel::model($subject, null, $department)->getListData();
        $version = (int)key($versionList);
        //分冊
        $chapterArray = ChapterInfoModel::getChapterArray($subject, $version, $department);
        //查询选题
        $questionCartQuestion = $cartResult->getQuestionCartQuestion()->all();
        return $this->render('index', ['questionCartQuestion' => $questionCartQuestion, 'subject' => $subject, 'department' => $department, 'versionList' => $versionList, 'chapterArray' => $chapterArray, 'cartId' => $cartId]);
    }

    /**
     * 查询选题蓝中的题目数量，不能少于5道
     * @return string
     */
    public function actionGetBasketNum(){
        $jsonResult = new JsonMessage();
        $cartId = (int)app()->request->get('cartId');
        $questionCount = SeQuestionCartQeustions::find()->where(['cartId'=>$cartId])->count();
        if($questionCount < 5){
            $jsonResult->message = '单份作业请不要少于5道题';
        }else{
            $jsonResult->success=true;
        }
        return $this->renderJSON($jsonResult);
    }


    /**
     *保存选题篮排序
     */
    public function actionSaveBasketOrder()
    {
        $dataArray = app()->request->getBodyParam('dataArray');
        foreach ($dataArray as $v) {
            SeQuestionCartQeustions::updateAll(['orderNumber' => $v['orderNumber']], ['cartQuestionId' => $v['cartQuestionId']]);
        }
    }

    /**
     *根据版本查询分册
     */
    public function actionGetTomeList()
    {
        $subject = app()->request->getBodyParam('subject');
        $version = app()->request->getBodyParam('version');
        $department = app()->request->getBodyParam('department');
        $chapterArray = ChapterInfoModel::getChapterArray((int)$subject,(int) $version,(int) $department);
        echo ' 分册：' . Html::dropDownList('', '', $chapterArray, array(
                'id' => 'tome',
                'data-validation-engine' => 'validate[required]'
            ));
    }

    /**
     * 章节树列表
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionGetChapterList()
    {
        $tome = app()->request->getBodyParam('tome');
        $subject = app()->request->getBodyParam('subject');
        $version = app()->request->getBodyParam('version');
        $department = app()->request->getBodyParam('department');
        //章节树 查询章节
        $chapterTree = ChapterInfoModel::searchChapterPointToTree((int)$subject, (int)$department, (int)$version, 0, (int)$tome);
        $tree = TreeHelper::streefun($chapterTree, [], 'tree pointTree');
        return $this->renderPartial('get_chapter_list', ['tree' => $tree]);
    }

    /**
     *创建作业
     * @return string
     * @throws \yii\db\Exception
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \yii\base\ExitException
     */
    public function actionCreateHomework()
    {
        $jsonResult = new JsonMessage();
        $cartId = app()->request->getBodyParam('cartId');
        $version = app()->request->getBodyParam('version');
        $subject = app()->request->getBodyParam('subject');
        $department = app()->request->getBodyParam('department');
        $chapterId = app()->request->getBodyParam('chapterId');
        $homeworkName = app()->request->getBodyParam('homeworkName');
        $difficulty = app()->request->getBodyParam('difficulty');
        /** @var Transaction $transaction */

        $transaction = Yii::$app->db_school->beginTransaction();
        $questionArray = SeQuestionCartQeustions::find()->where(['cartId' => $cartId])->select('questionId,orderNumber')->asArray()->all();
        if (empty($questionArray)) {
            $jsonResult->message = '选题篮不能为空';
            return $this->renderJSON($jsonResult);
        }
        if(count($questionArray) < 5){
            $jsonResult->message = '单份作业请不要少于5道题';
            return $this->renderJSON($jsonResult);
        }
        try {
            $homeworkModel = new SeHomeworkTeacher();
            $homeworkModel->chapterId = $chapterId;
            $homeworkModel->getType = 1;
            $homeworkModel->createTime = DateTimeHelper::timestampX1000();
            $homeworkModel->creator = user()->id;
            $homeworkModel->name = $homeworkName;
            $homeworkModel->subjectId = $subject;
            $homeworkModel->version = $version;
            $homeworkModel->department = $department;
            $homeworkModel->difficulty = $difficulty;
            $homeworkModel->homeworkType = SeHomeworkTeacher::SELF_HOMEWORK;
            $homeworkModel->showType = SeHomeworkTeacher::COMMON_HOMEWORK;
            if ($homeworkModel->save()) {
                $homeworkId = $homeworkModel->id;
                foreach ($questionArray as $v) {
                    $homeworkQuestionModel = new SeHomeworkQuestion();
                    $homeworkQuestionModel->questionId = $v['questionId'];
                    $homeworkQuestionModel->homeworkId = $homeworkId;
                    $homeworkQuestionModel->orderNumber = $v['orderNumber'];
                    $homeworkQuestionModel->save();
                }
                SeQuestionCartQeustions::deleteAll(['cartId' => $cartId]);
                SeQuestionCart::deleteAll(['cartId' => $cartId]);
                $transaction->commit();
                $jsonResult->success = true;
                //          创建电子作业增加积分
                $jfHelper = new JfManageService;
                $jfHelper->addJfXuemi('pos-ele-question', user()->id);
            }

        } catch (Exception $e) {
            $transaction->rollBack();
            \Yii::error('创建电子作业失败错误信息' . '------' . $e->getMessage());
        }
        return $this->renderJSON($jsonResult);

    }

    /**
     * 更新选题篮
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionGetQuestionCart()
    {
        $subject = app()->request->getBodyParam('subject');
        $department = app()->request->getBodyParam('department');
        $cartQuery = SeQuestionCart::find()->where(['departmentId' => $department, 'subjectId' => $subject, 'userId' => user()->id]);
        $cartIsExisted = $cartQuery->exists();
        if (!$cartIsExisted) {
            $cartModel = new SeQuestionCart();
            $cartModel->departmentId = $department;
            $cartModel->subjectId = $subject;
            $cartModel->userId = user()->id;
            $cartModel->createTime = DateTimeHelper::timestampX1000();
            $cartModel->save();
            $num = 0;
            $cartId = $cartModel->cartId;
        } else {
            $cartId = $cartQuery->one()->cartId;
            $cartQuestionQuery = SeQuestionCartQeustions::find()->where(['cartId' => $cartId]);
            $num = $cartQuestionQuery->count();
        }
        $array = array('num' => $num, 'cartId' => $cartId);
        $jsonResult = new JsonMessage();
        $jsonResult->data = $array;
        return $this->renderJSON($jsonResult);
    }

    /**
     * 题目放到选题篮
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionAddCartQuestions()
    {
        $jsonResult = new JsonMessage();
        $cartId = app()->request->getBodyParam('cartId');
        $questionID = app()->request->getBodyParam('questionID');
//        判断当前题目是否已经在选题篮里面
        $isExisted = SeQuestionCartQeustions::find()->where(['cartId' => $cartId, 'questionId' => $questionID])->exists();
        if (!$isExisted) {
            $cartQuestionModel = new SeQuestionCartQeustions();
            $cartQuestionModel->cartId = $cartId;
            $cartQuestionModel->questionId = $questionID;
            $cartQuestionModel->createTime = DateTimeHelper::timestampX1000();
            $cartQuestionModel->orderNumber = (int)(microtime(true)*1000);
            if ($cartQuestionModel->save()) {
                $jsonResult->success = true;
            }
        }
        return $this->renderJSON($jsonResult);
    }

    /**
     *加载整个页面判断是否放入选题篮了
     * @throws \yii\base\ExitException
     */
    public function actionIfInCart()
    {
        $jsonResult = new JsonMessage();
        $department = app()->request->getBodyParam('department');
        $subject = app()->request->getBodyParam('subject');

        $cartId = null;

        $cartResult = SeQuestionCart::find()->where(['subjectId' => $subject, 'departmentId' => $department, 'userId' => user()->id])->one();
        if(!empty($cartResult)){
            $cartId = $cartResult->cartId;
        }

        $questionIDArray = app()->request->getBodyParam('questionIDArray');
        $isInCartArray = [];
        $isInCart = SeQuestionCartQeustions::find()->where(['cartId' => $cartId, 'questionId' => $questionIDArray])->select('questionId')->asArray()->all();
        foreach ($isInCart as $v) {
            $isInCartArray[] = $v['questionId'];
        }
        $jsonResult->data = $isInCartArray;
        return $this->renderJSON($jsonResult);
    }

    /**
     * 移出选题篮
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionDelQuestion()
    {
        $cartQuestionId = app()->request->get('cartQuestionId');
        $jsonResult = new JsonMessage();
        if ($cartQuestionId == null) {
            $cartId = app()->request->getBodyParam('cartId');
            $questionID = app()->request->getBodyParam('questionID');
            $cartResult = SeQuestionCartQeustions::find()->where(['cartId' => $cartId, 'questionId' => $questionID])->one();
            if ($cartResult) {
                $cartQuestionId = $cartResult->cartQuestionId;
            }
        }
        $checkQuestionCart = SeQuestionCartQeustions::find()->where(['cartQuestionId' => $cartQuestionId])->one();
        if (empty($checkQuestionCart)) {
            $jsonResult->success = false;
            $jsonResult->message = '请正确删除！';
        } else {
            $delQuestion = SeQuestionCartQeustions::deleteAll(['cartQuestionId' => $cartQuestionId]);
            if ($delQuestion == 1) {
                $jsonResult->success = true;
                $jsonResult->message = '删除成功！';
            } else {
                $jsonResult->success = false;
                $jsonResult->message = '删除失败！';
            }
        }
        return $this->renderJSON($jsonResult);
    }
}