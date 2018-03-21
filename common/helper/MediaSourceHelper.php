<?php
/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 17-7-12
 * Time: 下午12:15
 */

namespace common\helper;


use Yii;

class MediaSourceHelper
{

    /**
     * 根据资源id获取地址
     * @param string $mediaId
     * @return string
     */
    public static function getMediaSource(string $mediaId){


        if($mediaId){
            if(YII_ENV_PROD){
                return resCdn('/mfs/'.$mediaId);
            }
            return 'http://'.Yii::$app->params['mediaSource'].'/mfs/'.$mediaId;
        }
        return '';

    }


}