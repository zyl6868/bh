<?php
namespace common\models\dicmodels;

use common\models\pos\SePaperQuesTypeRlts;
use common\models\sanhai\SeDateDictionary;
use common\models\sanhai\SeSchoolGrade;

/**
 * 题目题型
 * Created by PhpStorm.
 * User: liquan
 * Date: 2014/11/13
 * Time: 16:30
 */
class ItemTypeModel extends DicModelBase
{



    /**
     * 题型
     * @return array
     */
    public function getDataList()
    {
        $cacheId = 'ItemType__dataV2';
        $modelList = \Yii::$app->cache->get($cacheId);

        if ($modelList === false) {
            $modelList = SeDateDictionary::find()->where(['firstCode' => 209])->select('secondCode,secondCodeValue')->all();
            if (!empty($modelList)) {
                \Yii::$app->cache->set($cacheId, $modelList, 3600);
            }
        }
        return is_null($modelList) ? array() : $modelList;

    }


}
