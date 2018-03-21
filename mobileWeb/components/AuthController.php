<?php
namespace mobileWeb\components;

use common\controller\YiiController;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 17-10-11
 * Time: 上午10:12
 */
class AuthController extends YiiController
{


    public function behaviors()
    {


        return ArrayHelper::merge(parent::behaviors(), [


            'access' => [
                'class' => AccessControlToken::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [],
                        'matchCallback' =>
                            function ($rule, $action) {
                                return $this->filterAccessControl();

                            }
                    ],
                ],
            ],


            'bearerAuth' => [
                'class' => HttpAndCookiesBearerAuth::className()

            ]
        ]);
    }

    /**
     * @return bool
     */
    protected function filterAccessControl():bool
    {

        $token = Yii::$app->request->getQueryParam('token');
        $authCooker = Yii::$app->request->cookies->getValue('token');
//        var_dump(base64_encode($token));
//        var_dump($authCooker);
//        var_dump(base64_encode($token) != $authCooker);die;


//        if ($token && (base64_encode($token) != $authCooker)) {
//            return false;
//        }


        $authCooker = Yii::$app->request->cookies->getValue('token');
        return $authCooker != null;
    }


    /**
     * @return \mobileWeb\models\User
     */
    public function getUser()
    {
        return Yii::$app->getUser()->identity;
    }


}