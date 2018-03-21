<?php
namespace common\models\dicmodels;

use common\models\sanhai\SeSchoolGrade;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-8-6
 * Time: 下午12:11
 */
class GradeModel
{
    /**
     *  学段—小学
     */
    const PRIMARY_SCHOOL = 20201;

    /**
     * 学科—语文
     */
    const CHINESE_SUBJECT = 10010;
    /**
     * 学科—英语
     */
    const ENGLISH_SUBJECT = 10012;


    private $data = array();


    function __construct($department, $lengthOfSchooling)
    {
        $this->data = $this->getData($department, $lengthOfSchooling);
    }


    /**
     * 年级数据源
     * @return array
     *
     * 年级信息查询
     * @param string $department 学部
     *  20201    小学部
     * 20202    初中部
     * 20203    高中部
     * @param string $lengthOfSchooling 学制
     *  20501    六三学制
     * 20502    五四学制
     * 02503    五三学制
     * @return array
     *
     */
    public function getData($department, $lengthOfSchooling)
    {
        $cacheId = 'grade_data_V2' . $department . '_' . $lengthOfSchooling;
        $modelList = \Yii::$app->cache->get($cacheId);
        if ($modelList === false) {
            if (!isset($department)) {
                $department = '';
            }
            if (!isset($lengthOfSchooling)) {
                $lengthOfSchooling = '';
            }
            if ($lengthOfSchooling == 20503) {
                $List = SeSchoolGrade::find()->where(['schoolDepartment' => $department])->select('gradeId,gradeName,schoolDepartment')->all();
                $modelList = $this->pub($List, $schDepName = '高中部', $lenOfSch = 20503, $lenOfSchName = '五三学制');
            } elseif ($lengthOfSchooling == 20502) {
                $List = SeSchoolGrade::find()->where(['schoolDepartment' => $department])->select('gradeId,gradeName,schoolDepartment')->all();
                $modelList = $this->pub($List, $schDepName = '初中部', $lenOfSch = 20502, $lenOfSchName = '五四学制');
                foreach ($modelList as $key => $val) {
                    if ($val['gradeId'] == 1007) {
                        unset($modelList[$key]);
                    }
                }
            } elseif ($lengthOfSchooling == 20501) {
                $List = SeSchoolGrade::find()->where(['schoolDepartment' => $department])->select('gradeId,gradeName,schoolDepartment')->all();
                $modelList = $this->pub($List, $schDepName = '小学部', $lenOfSch = 20501, $lenOfSchName = '六三学制');
            } else {
                $List = SeSchoolGrade::find()->select('gradeId,gradeName,schoolDepartment')->all();
                $modelList = [];
                foreach ($List as $val) {
                    if ($val->schoolDepartment == 20201) {
                        $modelList = $this->departmentEmpty($modelList, $val, $schDepName = '小学部', $lenOfSch = 20501, $lenOfSchName = '六三学制');
                    } elseif ($val->schoolDepartment == 20202) {
                        $modelList = $this->departmentEmpty($modelList, $val, $schDepName = '初中部', $lenOfSch = 20502, $lenOfSchName = '六三学制');
                    } else {
                        $modelList = $this->departmentEmpty($modelList, $val, $schDepName = '高中部', $lenOfSch = 20503, $lenOfSchName = '六三学制');
                    }
                }
                foreach ($modelList as $key => $val) {
                    if ($val['gradeId'] == 1007) {
                        unset($modelList[$key]);
                    }
                }
            }
            if (!empty($modelList)) {
                \Yii::$app->cache->set($cacheId, $modelList, 3600);
            }
        }
        return is_null($modelList) ? array() : $modelList;
    }


    /**
     * 获取年级列表数据
     * @return \YaLinqo\Enumerable
     */
    public function getList()
    {
        return from($this->data)->where(function ($v) {
            return true;
        })->toList();
    }

    public function getListData()
    {
        return ArrayHelper::map($this->data, 'gradeId', 'gradeName');
    }


    /**
     * 获取年级一条数据
     * @param $id
     * @return mixed
     */
    public function getOne($id)
    {
        return from($this->data)->firstOrDefault(null, function ($v) use ($id) {
            return $v['gradeId'] == $id;
        });
    }

    public function getGradeName($id)
    {
        if (!is_numeric($id)) return;

        $arr = $this->getOne($id);
        return isset($arr) ? $arr['gradeName'] : '';
    }

    /**
     * 调用静态方法
     * @return GradeModel
     */
    public static function model($department = null, $lengthOfSchooling = null)
    {
        $staticModel = new self($department, $lengthOfSchooling);
        return $staticModel;
    }


    /**
     * 根据学籍和学制查询年级
     * @param null $schoolLength
     * @param null $lengthOfSchooling
     * @return array
     */
    public function getWithList($schoolLength = null, $lengthOfSchooling = null)
    {
        return $this->getData($schoolLength, $lengthOfSchooling);
    }

    /*
     * 学部调用
     */
    public function pub($List, $schDepName, $lenOfSch, $lenOfSchName)
    {
        $modelList = [];
        foreach ($List as $val) {
            $arr['gradeId'] = $val->gradeId;
            $arr['gradeName'] = $val->gradeName;
            $arr['schDep'] = $val->schoolDepartment;
            $arr['schDepName'] = $schDepName;
            $arr['lenOfSch'] = $lenOfSch;
            $arr['lenOfSchName'] = $lenOfSchName;
            $modelList[] = $arr;
        }
        return $modelList;
    }

    /*
     * 学部，年级，都为空
     */
    public function departmentEmpty($modelList, $val, $schDepName, $lenOfSch, $lenOfSchName)
    {
        $arr['gradeId'] = $val->gradeId;
        $arr['gradeName'] = $val->gradeName;
        $arr['schDep'] = $val->schoolDepartment;
        $arr['schDepName'] = $schDepName;
        $arr['lenOfSch'] = $lenOfSch;
        $arr['lenOfSchName'] = $lenOfSchName;
        $modelList[] = $arr;
        return $modelList;
    }

}
