<?php
namespace common\models\dicmodels;

use common\models\sanhai\SeDateDictionary;
use yii\helpers\ArrayHelper;

/**
 * 班级职务
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-8-6
 * Time: 下午6:44
 */
class ClassDutyModel extends DicModelBase
{


    /**
     * 查询所有数据
     * @return array
     */
    public function getDataList()
    {
        return $this->getSourceDataList('classduty_dataV2', 201);
    }


}
