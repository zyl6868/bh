<?php
namespace mobileWeb\modules\api\modules\courseware\controllers;

use common\controller\YiiController;
use mobileWeb\components\AuthController;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Cookie;

/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 17-10-10
 * Time: 下午3:23
 */
class DefaultController extends YiiController
{

    public $layout = false;

    public function actionIndex()
    {
        $getData = Yii::$app->request->getQueryParams();
        $writeCookie = new Cookie();
        $writeCookie->name = 'auth';
        $writeCookie->expire = -1;
        $writeCookie->httpOnly = false;

        $authorization = "";
        if (isset($getData['token']) && !empty($getData['token'])) {
            $token = $getData['token'];
            $authorization = base64_encode($token);
        }
        $writeCookie->value = $authorization;
        Yii::$app->response->getCookies()->add($writeCookie);

        if ($getData != [] && isset($getData['vp'])) {

            $vp = $getData['vp'];
            unset($getData['vp']);
            $paramsStr = http_build_query($getData);

            return $this->redirect('/courseware/' . '?' . $paramsStr . '#/' . $vp);
        }

        $indexhtml = $this->render('index');


        $indexhtml = str_replace('src=', 'src=' . BH_CDN_RES, $indexhtml);

        return $indexhtml;

    }

}