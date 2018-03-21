<?php

namespace frontend\components;

use common\behaviors\BehaviorsTracking;
use yii\filters\AccessControl;

/**
 * 学生权限基类 is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class StudentBaseController extends BaseAuthController
{

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return loginUser()->isStudent() && $this->filterAccessControl();
                        }
                    ],
                ],
            ],
            'behaviors' => [
                'class' => BehaviorsTracking::className()
            ]
        ];
    }
}