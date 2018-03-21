<?php
namespace common\models\dicmodels;

use common\clients\material\ChapterService;
use common\models\sanhai\SeDateDictionary;
use common\models\sanhai\SeSchoolGrade;
use common\models\sanhai\SrKnowledgepoint;
use frontend\components\helper\StringHelper;
use stdClass;


/**
 *
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-7-28
 * Time: 下午6:22
 */
class KnowledgePointModel
{

    /**
     *获取知识点查询主树
     */
    public static function findKnowledge($str)
    {
        $strarr = StringHelper::splitNoEMPTY($str);
        $resultArr = array();
        foreach ($strarr as $key => $v) {
            $obj = new KnowledgePointModel();
            $result = $obj->pub($v);
            if ($result != null)
                $resultArr[] = $result;
        }

        return $resultArr;

    }

    /**
     *  查询书转树形结点
     * @param $subjectID
     * @param $departmentID
     * @return array
     */
    public static function searchKnowledgePointToTree($subjectID, $departmentID)
    {
        $resultArr = [];
        if (empty($subjectID) && empty($departmentID)) {
            return [];
        }
        $arr = SrKnowledgepoint::find()->where(['subject' => $subjectID, 'grade' => $departmentID])->select('kid,pid,kpointname')->all();
        $callback =
            function ($item) {
                $k = new  stdClass();
                $k->id = $item->kid;
                $k->pId = $item->pid;
                $k->name = $item->kpointname;
                $k->nocheck = false;
                if ($k->pId == 0) {
                    $k->nocheck = true;
                }
                return $k;
            };
        foreach ($arr as $item) {
            $resultArr[] = $callback($item);
        }
        return $resultArr;
    }

    /**
     * 查询知识点，返回全部的属性数据
     * {"id":"1","pId":"0","name":"语文"，subject’科目’,schoolLevel学籍},
     * @param integer $subjectID    科目
     * @param integer $departmentID 学籍
     * @return array
     */
    public static function searchAllKnowledgePoint(int $subjectID,int $departmentID)
    {
        $chapterService = new ChapterService();
        $chapterTree = [];
        $treeResult = $chapterService->knowledge($departmentID, $subjectID);
        if ($treeResult->code == 200) {
            $chapterTree = $treeResult->body;
        }

        return $chapterTree;
    }

    /**
     * 树形结构分层只显示二级内容
     * @param $subjectID
     * @param $schoolLevel
     * @return array
     */
    public static function searchLevelKnowledgePointToTree($subjectID, $schoolLevel)
    {
        $resultArr = [];
        if (empty($subjectID) && empty($schoolLevel)) {
            return [];
        }
        $arr = SrKnowledgepoint::find()->where(['subject' => $subjectID, 'grade' => $schoolLevel])->select('kid,pid,kpointname')->all();
        $callback =
            function ($item) {
                $k = new  stdClass();
                $k->id = $item->kid;
                $k->pId = $item->pid;
                $k->name = $item->kpointname;
                return $k;
            };
        foreach ($arr as $item) {
            $resultArr[] = $callback($item);
        }
        return $resultArr;
    }

    /**
     * 根据年级，科目查询数据
     * @param $subject  科目
     * @param $grade    年级
     * @return array
     */
    public static function searchKnowledgePointGradeToTree($subject, $grade)
    {
        $resultArr = [];
        if (empty($subject) || empty($grade)) {
            return [];
        }
        $gradeID = SeSchoolGrade::find()->where(['gradeId' => $grade])->select('schoolDepartment')->limit(1)->one();
        $arr = SrKnowledgepoint::find()->where(['subject' => $subject, 'grade' => $gradeID->schoolDepartment])->select('kid,pid,kpointname')->all();
        $callback =
            function ($item) {
                $k = new  stdClass();
                $k->id = $item->kid;
                $k->pId = $item->pid;
                $k->name = $item->kpointname;
                $k->nocheck = false;
                if ($k->pId == 0) {
                    $k->nocheck = true;
                }
                return $k;
            };
        foreach ($arr as $item) {
            $resultArr[] = $callback($item);
        }
        return $resultArr;
    }


    /**
     * @param $id
     * @return string
     */
    public static function getNamebyId($id)
    {
        $obj = new KnowledgePointModel();
        $result = $obj->pub($id);
        return is_null($result) ? '' : $result['name'];
    }

    /**
     * 通过知识点ID组成的字符串获取知识点点名称组成的字符串
     * @param $str
     * @return string
     */
    public static function findKnowledgeStr($str)
    {
        $strarr = StringHelper::splitNoEMPTY($str);
        $resultArr = array();
        foreach ($strarr as $key => $v) {
            $obj = new KnowledgePointModel();
            $result = $obj->pub($v);
            if ($result != null)
                $resultArr[] = $result;
        }
        $knowledgeArray = array();
        foreach ($resultArr as $v) {
            $knowledgeArray[] = $v['name'];
        }
        return implode(',', $knowledgeArray);

    }

    /**
     * 通过知识点ID组成的字符串获取知识点点名称组成的数组
     * @param $str
     * @return array()
     */
    public static function findKnowledgeArr($str)
    {
        $strarr = StringHelper::splitNoEMPTY($str);
        $resultArr = [];
        foreach ($strarr as $key => $v) {
            $obj = new KnowledgePointModel();
            $result = $obj->pub($v);
            if ($result != null)
                $resultArr[] = $result;
        }
        $knowledgeArray = array();
        foreach ($result as $v) {
            array_push($knowledgeArray, $v['name']);
        }
        return $knowledgeArray;

    }

    public static function findKnowledgeArrVal($str)
    {
        $knowledgeArray = array();
        $arr = explode(',', $str);
        foreach ($arr as $val) {
            $obj = new KnowledgePointModel();
            $result = $obj->pub($val);
            $knowledgeArray[$val] = is_null($result) ? '' : $result['name'];
        }
        return $knowledgeArray;

    }

    /*
     * 公共
     */
    public function pub($v)
    {
        $cacheId = 'knowledgepoint_idV2' . $v;
        $result = app()->cache->get($cacheId);
        if ($result === false) {
            $arr = SrKnowledgepoint::find()->where(['kid' => $v])->limit(1)->one();
            if (empty($arr)) {
                return null;
            }
            $subjectName = SeDateDictionary::find()->where(['secondCode' => $arr->subject])->select('secondCodeValue')->limit(1)->one();
            $gradeName = SeDateDictionary::find()->where(['secondCode' => $arr->grade])->select('secondCodeValue')->limit(1)->one();
            $result['id'] = $arr->kid;
            $result['pId'] = $arr->pid;
            $result['name'] = $arr->kpointname;
            $result['gradeName'] = $gradeName->secondCodeValue;
            $result['subjectName'] = $subjectName->secondCodeValue;
            $result['subject'] = $arr->subject;
            $result['grade'] = $arr->grade;
            if ($result != null) {
                app()->cache->set($cacheId, $result, 120);
            }
        }
        return $result;
    }

}