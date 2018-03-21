<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 17-4-12
 * Time: 下午7:43
 */
namespace frontend\controllers;

use common\clients\TestMicroService;
use frontend\components\BaseController;

class MicroServiceTestController extends BaseController
{
    public function actionIndex()
    {
        $practiceService = new TestMicroService();
        $result = $practiceService->getLevelRankings();
        var_dump($result);
    }
}