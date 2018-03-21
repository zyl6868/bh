<?php
declare(strict_types = 1);
namespace frontend\modules\mobiles\controllers;

use common\controller\YiiController;

/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 17-6-7
 * Time: 上午11:07
 */
class PrivilegeController extends YiiController
{
    public $layout = 'lay_static';

    /**
     * 特权页面
     * @return string
     */
    public function actionIndex(){

        return $this->render('index');

    }
}