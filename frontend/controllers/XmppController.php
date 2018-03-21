<?php

namespace frontend\controllers;

use common\models\JsonMessage;
use frontend\components\BaseController;
use Yii;

/**
 * Created by PhpStorm.
 * User: a
 * Date: 14-6-24
 * Time: 下午2:45
 */
class XmppController extends BaseController
{
    /**
     *
     * xmpp  前置绑定
     */
    public function actionXmppBind()
    {

        $json = new JsonMessage();

        Yii::import('ext.xmppRebind.XmppPrebind');
        if ($this->isLogin()) {
            try {
                $pos_UserRegisterService = new pos_UserRegisterService();
                $UserXmppInfo = $pos_UserRegisterService->getXmppPasswd(user()->id);
                if ($UserXmppInfo) {
                    $XmppPreBind = new XmppPrebind(Yii::$app->params['xmpp_host'], Yii::$app->params['xmpp_Uri'], 'web');
                    $XmppPreBind->connect($UserXmppInfo['id'], $UserXmppInfo['pw']);
                    $XmppPreBind->auth();
                    $sessionInfo = $XmppPreBind->getSessionInfo();
                    Yii::$app->request->cookies['jid'] = new  CHttpCookie('jid', $sessionInfo['jid']);
                    Yii::$app->request->cookies['sid'] = new  CHttpCookie('sid', $sessionInfo['sid']);
                    Yii::$app->request->cookies['rid'] = new  CHttpCookie('rid', $sessionInfo['rid']);
                    $json->success = true;

                }

            } catch (Exception $e) {
                \Yii::error('Xmpp绑定失败错误信息' . '------' . $e->getMessage());
            }

        }
        return $this->renderJSON($json);

    }
} 