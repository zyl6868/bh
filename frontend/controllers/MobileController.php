<?php

namespace frontend\controllers;

use yii\web\Controller;

/**
 * Created by PhpStorm.
 * User: a
 * Date: 14-6-24
 * Time: 下午2:45
 */
class MobileController extends Controller
{
    public function actions()
    {

        return [
            'pic' => [
                'class' => '\frontend\widgets\xupload\actions\XUploadAction',
                'path' => \Yii::getAlias('@webroot') . "/uploads/pic",
                'publicPath' => \Yii::getAlias('@web') . "/uploads/pic",
                'subfolderVar' => "parent_id",
                'options' => ['accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'max_file_size' => 1024 * 1024 * 2]
            ],
        ];
    }

}