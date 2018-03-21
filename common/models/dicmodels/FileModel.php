<?php
namespace common\models\dicmodels;

use common\models\sanhai\SeDateDictionary;


/**
 * 文件类型
 * Created by unizk.
 * User: ysd
 * Date: 14-8-6
 * Time: 下午6:44
 */
class FileModel extends DicModelBase
{


    /**
     * 查询所有数据
     * @return array
     */
    public function getDataList()
    {
        $cacheKey = 'file_dataV2';
        $modelList = \Yii::$app->cache->get($cacheKey);
        if ($modelList === false) {
            $modelList = SeDateDictionary::find()->where(['firstCode' => 502, 'status' => '1'])->select('secondCode,secondCodeValue')->all();
            if (!empty($modelList)) {
                \Yii::$app->cache->set($cacheKey, $modelList, 3600);
            }
        }

        return is_null($modelList) ? array() : $modelList;

    }


    public function getListFirst()
    {
        $list = $this->getList();
        if ($list) {
            return reset($list);
        }
        return '';
    }


}
