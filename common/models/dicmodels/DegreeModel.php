<?php
namespace common\models\dicmodels;

use common\models\sanhai\SeDateDictionary;
use yii\helpers\ArrayHelper;

/**
 * 获取题目难度信息
 * Created by PhpStorm.
 * User: liquan
 * Date: 2014/11/13
 * Time: 16:39
 */
class DegreeModel extends  DicModelBase
{


    /**
     * 获取全部数据
     * @return array|ServiceJsonResult
     */
    public function getDataList()
    {
        return $this->getSourceDataList('degree__dataV2', 211);

    }



    /**
     * 根据难度id获取难度图标
     * @param $id
     * @return mixed
     */
    public function getIcon($id)
    {
        $iconArray = [
            '21101' => 'dif_easy',
            '21102' => 'dif_easy_v',
            '21103' => 'dif_mid',
            '21104' => 'dif_hard',
            '21105' => 'dif_hard_v',
        ];
        if ($id != null && array_key_exists($id, $iconArray)) {
            return $iconArray[$id];
        }
        return '';
    }



}