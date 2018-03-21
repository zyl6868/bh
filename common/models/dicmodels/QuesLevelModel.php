<?php
namespace common\models\dicmodels;
use common\models\sanhai\SeDateDictionary;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: liquan
 * Date: 2014/12/5
 * Time: 11:02
 */
class QuesLevelModel extends DicModelBase
{


    /**
     * 查询题目等级 数据
     * @return array
     */
    public function getDataList()
    {
        $cacheKey = 'quesLevel_dataV2';
        $modelList = \Yii::$app->cache->get($cacheKey);
        if ($modelList === false) {
            $modelList=SeDateDictionary::find()->where(['firstCode'=>216])->select('secondCode,secondCodeValue')->all();
            if (!empty($modelList)) {
                \Yii::$app->cache->set($cacheKey, $modelList, 3600);
            }
        }

        return is_null($modelList) ? array() : $modelList;

    }





    /**
     * 根据等级查询下拉列表
     * @return array
     */
    public function getListInData($arr=array())
    {
        $listData=  $this->getListData();
        if (empty($arr)){
            return $listData;
        }
        $list=array();

        foreach($arr as $v){
            foreach($listData as $key=>$val){
                if ($v==$key){
                    $list[$key]=$val;
                }
            }
        }
        return $list;
    }

}