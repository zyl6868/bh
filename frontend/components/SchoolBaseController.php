<?php

namespace frontend\components;

use yii\filters\AccessControl;

/**
 *  学校权限基类 is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class SchoolBaseController extends BaseAuthController
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
                        'allow' => false,
                        'roles' => ['*'],
                        'matchCallback' => function ($rule, $action) {
                            return loginUser()->isSchool();
                        }
                    ],
                    [

                        'allow' => true,
                        'roles' => ['@'],

                    ],
                ],
            ]
        ];

    }
}