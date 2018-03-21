<?php

namespace frontend\components;

use common\behaviors\BehaviorsTracking;
use frontend\services\pos\pos_PersonalInformationService;
use yii\filters\AccessControl;

/**
 *  学校权限基类 is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class BaseAuthController extends BaseController
{

    /**
     * @return bool|\yii\web\Response
     */
    public function filterAccessControl()
    {
        if ($this->isLogin()) {
            $userInfo = loginUser()->getModel();

            if (!$userInfo->IsExistClass()) {
                return $this->redirect(url('register/join-class'));
            }
        }
        return true;

    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
//                    [
//                        'allow' => false,
//                        'roles' => ['*'],
//                    ],
                    [

                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $this->filterAccessControl();
                            return true;
                        }
                    ],
                ],
            ],
            'behaviors' => [
                'class' => BehaviorsTracking::className()
            ]
        ];
    }

    /**
     * 判断其他老师和当前用户是否在同一个班级
     * @param $otherUserID
     * @return array
     */
    public function isSameClass($otherUserID)
    {
        $personServer = new pos_PersonalInformationService();
        $personResult = $personServer->querySameClassByTwoUser(user()->id, $otherUserID);
        if ($personResult->data['classListSize'] > 0) {
            return $personResult->data['classList'];
        }
        return array();

    }

}