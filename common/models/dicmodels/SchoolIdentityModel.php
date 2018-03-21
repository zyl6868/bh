<?php
namespace common\models\dicmodels;
use common\models\sanhai\SeDateDictionary;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-8-6
 * Time: 下午1:38
 */
class SchoolIdentityModel extends  DicModelBase
{


    /**
     * 版本 获取全部数据
     * @return array
     */
    public function getDataList()
    {
        $cacheId = 'schoolIdentity__dataV2';
        $modelList = \Yii::$app->cache->get($cacheId);

        if ($modelList === false) {
            $modeList=SeDateDictionary::find()->where(['firstCode'=>207])->select('secondCode,secondCodeValue')->all();
            if (!empty($modelList)) {
                \Yii::$app->cache->set($cacheId, $modelList, 3600);
            }
        }
        return is_null($modelList) ? array() : $modelList;

    }


}
