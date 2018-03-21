<?php
namespace common\models\dicmodels;
use common\models\sanhai\SeDateDictionary;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-8-18
 * Time: 下午2:32
 */
class TeachingResearchDutyModel extends  DicModelBase
{


    /**
     * 查询教研组职务 数据
     * @return array
     */
    public function getDataList()
    {
        $cacheKey = 'teachingResearchDuty_dataV2';
        $modelList = \Yii::$app->cache->get($cacheKey);
        if ($modelList === false) {
            $modelList=SeDateDictionary::find()->where(['firstCode'=>203])->select('secondCode,secondCodeValue')->all();
            if (!empty($modelList)) {
                \Yii::$app->cache->set($cacheKey, $modelList, 3600);
            }
        }

        return is_null($modelList) ? array() : $modelList;

    }


    /**
     * 获取教研组职务名称
     * @param string $id
     * @return mixed
     */
    public function getSchoolLevelhName($id)
    {
        if (empty($id)) return '';

        $arr = $this->getOne($id);
        return isset($arr)?$arr->secondCodeValue:'';
    }


}