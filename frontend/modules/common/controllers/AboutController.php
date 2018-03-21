<?php
namespace frontend\modules\common\controllers;

use common\models\pos\SeCustomerSuggestion;
use frontend\components\BaseAuthController;
use Yii;

/**
 * Created by PhpStorm.
 * User: mahongru
 * Date: 15-9-6
 * Time: 下午15:51
 */
class AboutController extends BaseAuthController
{
    public $layout = "lay_common";

    /**
     * 试卷列表
     */
    public function actionIndex()
    {
        return $this->render('about_us');
    }

    /**
     * 反馈意见
     */
    public function actionSuggestion()
    {
        $suggestion = new SeCustomerSuggestion();
        if ($_POST) {
            $userID = user()->id;
            $suggestion->load(yii::$app->request->post());
            $suggestion->time = times();
            $suggestion->userID = $userID;
            $suggestion->title = 'title';
            $suggestion->userName = \common\components\WebDataCache::getTrueNameByuserId($userID);
            if ($suggestion->save()) {
                Yii::$app->getSession()->setFlash('success', '提交成功');
                return $this->refresh();
            }
        }
        return $this->render('feedback', ['suggestion' => $suggestion]);
    }
}