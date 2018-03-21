<?php
namespace common\models\dicmodels;

use common\models\sanhai\SeDateDictionary;
use yii\helpers\ArrayHelper;

/**
 * 名校数据
 * Created by PhpStorm.
 * User: liquan
 * Date: 2014/11/13
 * Time: 16:54
 */
class EliteModel extends  DicModelBase
{


    /**
     * 名校数据 获取全部数据
     * @return array
     */
    public function getDataList()
    {
        return $this->getSourceDataList('elite__dataV2', 208);

    }


}