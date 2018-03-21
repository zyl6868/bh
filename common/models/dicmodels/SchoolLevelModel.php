<?php
namespace common\models\dicmodels;

use common\components\WebDataKey;
use common\models\sanhai\SeDateDictionary;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-8-18
 * Time: 下午2:32
 */
class SchoolLevelModel extends DicModelBase
{
    /**
     * 学段
     * @param integer $id 學段ID
     * @return mixed|string
     */
    public static function getClassDepartment(int $id)
    {
        if (empty($id)) {
            return '';
        }
        $cache = Yii::$app->cache;
        $key = WebDataKey::CLASS_DEPARTMENT_ID_CACHE_KEY . $id;
        $data = $cache->get($key);
        if ($data === false) {
            $data = SeDateDictionary::find()->where(['firstCode' => 202, 'secondCode' => $id])->select('secondCode,secondCodeValue')->limit(1)->one()->secondCodeValue;
            if ($data != null) {
                $cache->set($key, $data, 6000);
            }
        }
        return $data;
    }

    /**
     * 查询学段 数据
     * @return array
     */
    public function getDataList()
    {
        $cacheKey = 'schoolLevel_data-new';
        $modelList = \Yii::$app->cache->get($cacheKey);
        if ($modelList === false) {
            $modelList = SeDateDictionary::find()->where(['firstCode' => 202])->select('secondCode,secondCodeValue')->all();
            if (!empty($modelList)) {
                \Yii::$app->cache->set($cacheKey, $modelList, 3600);
            }
        }

        return $modelList;

    }


    /**
     * 根据学校学部查询下拉列表
     * @return array
     */
    public function getListInData(array $arr = array())
    {
        $listData = $this->getListData();
        if (empty($arr)) {
            return $listData;
        }
        $list = array();

        foreach ($arr as $v) {
            foreach ($listData as $key => $val) {
                if ($v == $key) {
                    $list[$key] = $val;
                }
            }
        }
        return $list;
    }

}