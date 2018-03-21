<?php
namespace common\models\dicmodels;

use common\models\sanhai\SeDateDictionary;


/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-8-6
 * Time: 下午1:38
 */
class EditionModel extends DicModelBase
{


    /**
     * 版本 获取全部数据
     * @return array
     */
    public function getDataList()
    {
        return $this->getSourceDataList('edition__dataV2', 206);

    }


}
