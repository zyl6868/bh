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
class ExamTypeModel extends DicModelBase
{


    /**
     * 获取全部数据
     * @return array
     */
    public function getDataList()
    {
        return $this->getSourceDataList('examtype__dataV2', 219);
    }


    public function getSubListData()
    {
        $typeArray = array(
            '21906' => '随堂测验',
            '21907' => '一周测验',
            '21908' => '单元测验',
        );
        return $typeArray;

    }

    /**
     * 是否是大考
     * @param $id
     * @return bool
     */
    public function isBigExam($id)
    {

        $m = from($this->data)->firstOrDefault(null, function ($v) use ($id) {
            return $v->secondCode == $id;
        });
        if ($m != null) {
            return $m->reserveTwo == 0;
        }
        return false;
    }


    /**
     * 获取手动创建考试类型
     * @return array
     */
    public function getManualType()
    {
        $array = array('21901', '21902', '21904', '21905', '21906');
        $manualArray = array();
        foreach ($this->data as $v) {
            if (!in_array($v->secondCode, $array)) {
                $manualArray[] = $v;
            }
        }
        return $manualArray;
    }
}