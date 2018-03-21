<?php

namespace schoolmanage\components;
use yii\filters\AccessControl;

/**
 *  学校权限基类 is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class BaseAuthController extends BaseController
{


    public function filterAccessControl()
    {



    }


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [

                    [

                        'allow' => true,
                        'roles' => ['@'],
//                        'matchCallback' => function ($rule, $action) {
//                            $this->filterAccessControl();
//                            return true;
//                        }
                    ],
                ],
            ]
        ];
    }




}