<?php
namespace mobileWeb\modules\api\modules\courseware\controllers;

/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 17-11-27
 * Time: 下午1:57
 */

use common\controller\YiiController;
use Yii;
use yii\web\Cookie;


class V2Controller extends YiiController
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

        $tokenCookie = new Cookie();
        $tokenCookie->name = 'token';
        $tokenCookie->expire = 0;
        $tokenCookie->value = $authorization;

        Yii::$app->response->getCookies()->add($tokenCookie);

        if ($getData != [] && isset($getData['vp'])) {

            $vp = $getData['vp'];
            unset($getData['vp']);
            $paramsStr = http_build_query($getData);

            return $this->redirect('/courseware/v2' . '?' . $paramsStr . '#/' . $vp);
        }

        $indexhtml = $this->render('index');


        $indexhtml = str_replace('src=', 'src=' . BH_CDN_RES, $indexhtml);

        return $indexhtml;

    }
}