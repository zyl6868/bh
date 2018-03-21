<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/3/3
 * Time: 13:20
 */
namespace common\models\dicmodels;

use common\models\pos\SeClass;
use common\models\pos\SeClassMembers;
use common\components\WebDataCache;
use yii\helpers\ArrayHelper;

class ClassListModel
{
    private $data = array();


    public function __construct($school, $department, $grade)
    {
        $this->data = $this->getData($school, $department, $grade);
    }

    /**
     * 获取班级人员数据
     * @param integer $school 學校ID
     * @param integer $grade 年級
     * @param integer $department 學段
     * @return array|\common\models\pos\SeClass[]|mixed
     */
    public function getData(int $school, int $grade = null, int $department = null)
    {
        if (!isset($school)) {
            $school = 0;
        }
        if (!isset($department)) {
            $department = 0;
        }
        if (!isset($grade)) {
            $grade = 0;
        }
        $classQuery = SeClass::find()->where(['schoolID' => $school, 'status' => 0])->select('classID,className');

        if (!empty($department)) {
            $classQuery->andWhere(['department' => $department]);
        }
        if (!empty($grade)) {
            $classQuery->andWhere(['gradeID' => $grade]);
        }
        $modelList = null;
        $modelList = $classQuery->all();

        return $modelList;
    }

    /**
     * 获取班级列表数据
     * @return \YaLinqo\Enumerable
     */
    public function getList()
    {
        return from($this->data)->where(function ($v) {
            return true;
        })->toList();
    }

    /**
     * @return array
     */
    public function getListData()
    {
        return ArrayHelper::map($this->data, 'classID', 'className');
    }


    /**
     * 调用静态方法
     * @param integer $school 学校ID
     * @param string $grade 年级
     * @param string $department 学段
     * @return ClassListModel
     */
    public static function model(int $school = null, string $grade = null, string $department = null)
    {
        $staticModel = null;
        $staticModel = new self($school, $grade, $department);
        return $staticModel;
    }


}