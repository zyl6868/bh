<?php
namespace common\models\dicmodels;
use common\models\pos\SeSchoolInfo;
use common\models\sanhai\SeSchoolGrade;
use yii\helpers\ArrayHelper;

/**
 * Created by unizk.
 * User: ysd
 * Date: 2015/5/3
 * Time: 10:13
 */


class SchoolGradeModel
{
    private $data = array();

    function __construct($schoolId)
    {
        $this->data = $this->getDate($schoolId);
    }

    /**
     * 静态方法获取数据
     * @return SchoolGradeModel
     */
    public static function model($schoolId)
    {
        $staticModel = new self($schoolId);
        return $staticModel;
    }

    /**
     * 获取学校下的年级信息
     * @return array|ServiceJsonResult
     */
    public function getDate($schoolId)
    {
        $cacheId = 'schoolclass_dataV2';
        $modelList = \Yii::$app->cache->get($cacheId);

        if ($modelList === false) {
            $department= SeSchoolInfo::find()->where(['schoolID'=>$schoolId])->select('department')->limit(1)->one();
            if(empty($department)){ return [];}
            $arr=explode(',',$department->department);
            $modelList=SeSchoolGrade::find()->where(['in','schoolDepartment',$arr])->select('gradeId,gradeName')->all();
            foreach($modelList as $key=>$val){
                if($val['gradeId']==1007)unset($modelList[$key]);
            }

            if (!empty($modelList)) {
                \Yii::$app->cache->set($cacheId, $modelList, 3600);
            }
        }
        return is_null($modelList) ? array() : $modelList;

    }

    /**
     * 获取数据列表
     * @param $id
     * @return array
     */
    public function getList()
    {
        return from($this->data)->where(function ($v) {
            return true;
        })->toList();
    }

    public function  getListData()
    {
        return ArrayHelper::map($this->data, 'gradeId', 'gradeName');
    }


}
?>

