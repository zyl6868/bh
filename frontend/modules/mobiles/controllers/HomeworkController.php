<?php
declare(strict_types = 1);
namespace frontend\modules\mobiles\controllers;

use common\components\CaptchaAction;
use common\components\WebDataCache;
use common\models\pos\SeHomeworkTeacher;
use frontend\components\BaseController;
use yii\web\HttpException;


/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 17-5-24
 * Time: 下午3:8
 */
class HomeworkController extends BaseController
{

    public $layout = 'lay_static';

    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => CaptchaAction::class,
                'backColor' => 0x55FF00,
                'maxLength' => 4,
                'height' => 40,
                'width' => 83,
                'minLength' => 4,
                'disturbCharCount' => 0

            ),
        );
    }

    /**
     * 家长签字分享页面
     * @return string
     * @throws HttpException
     */
    public function actionSignature()
    {
        $homeworkId = (int)app()->request->get('homework-id');
        if ($homeworkId == ''){
            return $this->notFound('不存在该作业');
        }
        $homeworkTeacherModel = SeHomeworkTeacher::getHomeworkTeacherDetails($homeworkId);

        if ($homeworkTeacherModel == null) {
            return $this->notFound('不存在该作业');
        }
        $creatorId = (int)$homeworkTeacherModel->creator;

        $creatorName = WebDataCache::getUserTrueNameByUserId($creatorId);
        $creatorHeadImgUrl = WebDataCache::getFaceIconUserId($creatorId,70);

        if ($homeworkTeacherModel == null){
            return $this->notFound('不存在该作业');
        }
        $homeworkName = $homeworkTeacherModel->name;
        return $this->render('signature',['creatorName'=>$creatorName,'creatorHeadImgUrl'=>$creatorHeadImgUrl,'homeworkName'=>$homeworkName]);
    }


    public function actionHowSignature()
    {
        return $this->render('howSignature');
    }

}