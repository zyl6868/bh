<?php
namespace common\models\dicmodels;

use common\models\sanhai\SeDateDictionary;
use yii\helpers\ArrayHelper;

/**
 * 学期
 * Created by PhpStorm.
 * User: liquan
 * Date: 2014/11/13
 * Time: 16:43
 */
class TermModel extends DicModelBase
{


    /**
     * 学期 获取全部数据
     * @return array
     */
    public function getDataList()
    {
        return $this->getSourceDataList('term__dataV2', 213);
    }

}