<?php
namespace common\models\dicmodels;

use common\models\sanhai\SeDateDictionary;
use yii\helpers\ArrayHelper;

/**
 * 题目出处
 * Created by PhpStorm.
 * User: liquan
 * Date: 14-11-13
 * Time: 下午16:18
 */
class FromModel extends DicModelBase
{

    /**
     * 题目出处
     * @return array
     */
    public function getDataList()
    {
        $cacheId = 'From__dataV2';
        $modelList = \Yii::$app->cache->get($cacheId);

        if ($modelList === false) {
            $modelList = SeDateDictionary::find()->where(['firstCode' => 210])->select('secondCode,secondCodeValue')->all();
            if (!empty($modelList)) {
                \Yii::$app->cache->set($cacheId, $modelList, 3600);
            }
        }
        return is_null($modelList) ? array() : $modelList;

    }


}
