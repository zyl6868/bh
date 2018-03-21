<?php
namespace common\models\dicmodels;

use common\models\sanhai\SeDateDictionary;


/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 15-4-10
 * Time: 下午5:57
 */
class LengthSchoolModel extends DicModelBase
{


    /**
     * 查询学制数据源
     * @return array
     */
    public function getDataList()
    {
        $cacheKey = 'lengthSchool_dataV2';
        $modelList = \Yii::$app->cache->get($cacheKey);
        if ($modelList === false) {
            $modelList = SeDateDictionary::find()->where(['firstCode' => 205])->select('secondCode,secondCodeValue')->all();
            if (!empty($modelList)) {
                \Yii::$app->cache->set($cacheKey, $modelList, 3600);
            }
        }

        return is_null($modelList) ? array() : $modelList;

    }


}