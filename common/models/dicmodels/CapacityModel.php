<?php
namespace common\models\dicmodels;

use common\models\sanhai\SeDateDictionary;
use Yii;
use yii\helpers\ArrayHelper;


/**
 * Created by PhpStorm.
 * User: liquan
 * Date: 2014/12/5
 * Time: 11:11
 */
class CapacityModel extends DicModelBase
{


    /**
     * 查询题目掌握程度数据
     * @return array
     */
    public function getDataList()
    {
        return $this->getSourceDataList('capacity_dataV2', 212);
    }




    /**
     * 根据题目掌握程度查询下拉列表
     * @param array $arr
     * @return array
     */
    public function getListInData($arr = array())
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