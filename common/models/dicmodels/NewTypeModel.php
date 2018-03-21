<?php
namespace common\models\dicmodels;

use common\models\sanhai\SeDateDictionary;
use yii\helpers\ArrayHelper;

/**
 * 资讯类型
 * Created by PhpStorm.
 * User: yangjie
 * Date: 2014/11/13
 * Time: 16:30
 */
class NewTypeModel extends DicModelBase
{
    /**
     * 题型
     * @return array
     */
    public function getDataList()
    {
        $cacheId = 'newTypeV2__data';
        $modelList = \Yii::$app->cache->get($cacheId);

        if ($modelList === false) {
            $modelList = SeDateDictionary::find()->where(['firstCode' => 501])->select('secondCode,secondCodeValue')->all();
            if (!empty($modelList)) {
                \Yii::$app->cache->set($cacheId, $modelList, 3600);
            }
        }
        return is_null($modelList) ? array() : $modelList;

    }


}
