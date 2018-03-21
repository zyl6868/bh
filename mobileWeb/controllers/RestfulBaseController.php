<?php
/**
 * restful 基类
 * Created by PhpStorm.
 * User: zyl
 * Date: 17/10/12
 * Time: 下午7:35
 */

namespace mobileWeb\controllers;

use mobileWeb\components\HttpAndCookiesBearerAuth;
use yii\filters\auth\CompositeAuth;
use yii\filters\ContentNegotiator;
use yii\filters\RateLimiter;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\Response;

class RestfulBaseController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'verbFilter' => [
                'class' => VerbFilter::className(),
                'actions' => $this->verbs(),
            ],
            'rateLimiter' => [
                'class' => RateLimiter::className(),
            ],
        ];
    }

}