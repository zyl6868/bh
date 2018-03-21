<?php
namespace common\models\dicmodels;

use common\models\sanhai\SeDateDictionary;
use common\models\sanhai\SeSchoolGrade;
use common\components\WebDataKey;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-8-6
 * Time: 下午6:44
 */
class SubjectModel extends DicModelBase
{
    /**
     * 科目
     * @param $id
     * @return mixed|string
     */
    public static function getClassSubject($id)
    {
        if (empty($id)) {
            return '';
        }
        $cache = Yii::$app->cache;
        $key = WebDataKey::CLASS_SUBJECT_ID_CACHE_KEY . $id;
        $data = $cache->get($key);
        if ($data === false) {
            $data = SeDateDictionary::find()->where(['firstCode' => 100, 'secondCode' => $id])->select('secondCode,secondCodeValue')->limit(1)->one()->secondCodeValue;
            if ($data != null) {
                $cache->set($key, $data, 6000);
            }
        }
        return $data;
    }


    /**
     * 查询所有科目数据
     * @return array
     */
    public function getDataList()
    {
        $cacheKey = 'subject_dataV2';
        $modelList = \Yii::$app->cache->get($cacheKey);
        if ($modelList === false) {
            $modelList = SeDateDictionary::find()->where(['firstCode' => 100])->select('secondCode,secondCodeValue')->all();
            if (!empty($modelList)) {
                \Yii::$app->cache->set($cacheKey, $modelList, 3600);
            }
        }

        return is_null($modelList) ? array() : $modelList;

    }


    public function getListData()
    {
        return ArrayHelper::map($this->data, 'secondCode', 'secondCodeValue');
    }


    /*
     * 通过年级获取科目
     */
    static public function getSubByGrade($id = '', $notHasComp = '')
    {
        $department = SeSchoolGrade::find()->where(['gradeId' => $id])->select('schoolDepartment')->limit(1)->one();
        if (empty($notHasComp)) {
            if (empty($department)) {
                $data = SeDateDictionary::find()->where(['firstCode' => 100])->select('secondCode,secondCodeValue')->all();
            } else {
                $data = SeDateDictionary::find()->where(['firstCode' => 100])->andFilterWhere(['like', 'reserve1', $department->schoolDepartment])->select('secondCode,secondCodeValue')->all();
            }
        } else {
            if (empty($department)) {
                $data = SeDateDictionary::find()->where(['firstCode' => 100])->andFilterWhere(['and', 'secondCode!=10027', 'secondCode!=10028'])->select('secondCode,secondCodeValue')->all();
            } else {
                $data = SeDateDictionary::find()->where(['firstCode' => 100])->andFilterWhere(['like', 'reserve1', $department->schoolDepartment])->andFilterWhere(['and', 'secondCode!=10027', 'secondCode!=10028'])->select('secondCode,secondCodeValue')->all();
            }
        }
        return $data;
    }

    /**
     * 根据学部获取科目
     * @param $department
     * @return array
     */
    static public function getSubjectByDepartment($department, $notHasComp = '')
    {
        if ($department == null) {
            return array();
        } else {
            if (empty($notHasComp)) {
                $result = SeDateDictionary::find()->where(['firstCode' => 100])->andFilterWhere(['like', 'reserve1', $department])->select('secondCode,secondCodeValue')->all();
            } else {
                $result = SeDateDictionary::find()->where(['firstCode' => 100])->andFilterWhere(['like', 'reserve1', $department])->andFilterWhere(['and', 'secondCode!=10027', 'secondCode!=10028'])->select('secondCode,secondCodeValue')->all();
            }
            return $result;
        }
    }

    /**
     * 根据学部获取科目缓存
     * @param $department
     * @param string $notHasComp
     * @return array
     */
    static public function getSubjectByDepartmentCache($department, $notHasComp = '')
    {
        $cache = Yii::$app->cache;
        $key = WebDataKey::SUBJECT_DATA_BY_DEPARTMENT_KEY . $department . '__' . $notHasComp;
        $data = $cache->get($key);
        if ($data == false) {
            $data = self::getSubjectByDepartment($department, $notHasComp);
            if ($data != null) {
                $cache->set($key, $data, 6000);
            }

        }
        return $data;

    }

    static public function getSubjectByDepartmentListData($department, $notHasComp = '')
    {
        $list = self::getSubjectByDepartment($department, $notHasComp);
        return ArrayHelper::map($list, 'secondCode', 'secondCodeValue');
    }


    /**
     * 根据科目名字查找对应的科目id
     * @param string $subjectName 科目名
     * @return int|string
     */
    public function getIdBySubjectName(string $subjectName)
    {

        if (empty($subjectName)) {
            return 0;
        }

        $data = from($this->data)->firstOrDefault(null, function ($v) use ($subjectName) {
            return $v->secondCodeValue == $subjectName;
        });
        return isset($data) ? $data->secondCode : 0;
    }

    /**
     * 根据科目id查询科目数据
     * @param $subjectId
     * @return array|SeDateDictionary[]
     */
    public function getSubjectById($subjectId)
    {
        return SeDateDictionary::find()->where(['in', 'secondCode', $subjectId])->select('secondCode,secondCodeValue')->all();

    }
}
