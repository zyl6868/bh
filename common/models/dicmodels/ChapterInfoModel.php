<?php
namespace common\models\dicmodels;

use common\clients\material\ChapterService;
use common\components\WebDataKey;
use common\models\sanhai\SeSchoolGrade;
use common\models\sanhai\SrChapterbasenode;
use frontend\components\helper\StringHelper;
use stdClass;
use Yii;

/**
 * 章节信息模型
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-7-28
 * Time: 下午6:22
 */
class ChapterInfoModel
{
    /**
     * 通过知识点ID组成的字符串获取知识点点名称组成的字符串
     * @param $str
     * @return string
     */
    public static function findChapterStr($str)
    {
        $strarr = StringHelper::splitNoEMPTY($str);
        $result = array();
        foreach ($strarr as $key => $v) {
            $result[] = self::chapterName((int)$v);
        }
        return implode(',', $result);

    }


    /**
     * 查询书转树形结点
     * @param integer $subjectID 科目
     * @param integer $departmentID 学籍（小学\初中\高中等）
     * @param integer $bookVersionID 教材版本（人教版\北师大版等）
     * @param integer $grade 年级
     * @param integer $bookAtt
     * @return mixed
     */
    public static function searchChapterPointToTree(int $subjectID, int $departmentID, int $bookVersionID, int $grade, int $bookAtt = null)
    {
        $chapterService = new ChapterService();
        $chapterTree = [];
        $treeResult = $chapterService->chapter($departmentID, $subjectID, $bookVersionID, (int)$bookAtt);
        if ($treeResult->code == 200) {
            $chapterTree = $treeResult->body;
        }

        return $chapterTree;
    }


    /**
     * 单个章节名称
     * @param int $id
     * @return mixed
     */
    public static function chapterName(int $id)
    {
        $knowledgeName = '';
        $chapterResult = self::chapterInfoCache($id);

        if ($chapterResult) {
            $knowledgeName = $chapterResult->chaptername;
        }
        return $knowledgeName;
    }

    /**
     * 章节信息缓存
     * @param integer $id
     * @return mixed
     */
    public static function chapterInfoCache(int $id){

        $cache = Yii::$app->cache;
        $key = WebDataKey::GET_CHAPTER_INFO_CACHE_BY_ID . '_' .$id;
        $result = $cache->get($key);
        if($result === false){
            $chapterService = new ChapterService();
            $result = $chapterService->chapterInfo($id);
            $cache->set($key,$result,3600);
        }
        return $result;
    }


    /**
     * 根据章节id  获取章节名称 ，id多个逗号分隔
     * @param string $id
     * @return array
     */
    public static function getChapterNameByIdMany(string $id)
    {
        $questionId = explode(',', $id);
        $arrayChapterName = [];
        if (!empty($questionId)) {
            foreach ($questionId as $value) {
                $chapterName = self::chapterName((int)$value);
                //去除空格
                $chapterName = str_replace(' ', '', strip_tags($chapterName));
                array_push($arrayChapterName, ['chapterId' => $value, 'chapter' => $chapterName]);
            }
        }
        return $arrayChapterName;
    }

    /**
     * 获取分册
     * @param integer $subjectID
     * @param integer $departmentID
     * @param integer $bookVersionID
     * @param integer $grade
     * @return array
     */
    public static function getMajorChapter(int $subjectID, int $departmentID, int $bookVersionID, int $grade)
    {
        $resultArr = [];
        if (empty($subjectID) || empty($bookVersionID)) {
            return [];
        }
        if (empty($departmentID)) {
            if (empty($grade)) {
                return [];
            } else {
                $gradeid = SeSchoolGrade::find()->where(['gradeId' => $grade])->select('schoolDepartment')->limit(1)->one();
                $departmentId = $gradeid->schoolDepartment;
                $arr = SrChapterbasenode::tomeAll($subjectID, $departmentId, $bookVersionID);
            }
        } else {
            $arr = SrChapterbasenode::tomeAll($subjectID, $departmentID, $bookVersionID);
        }
        $callback =
            function ($item) {
                $c = new  stdClass();
                $c->id = $item->cid;
                $c->name = $item->chaptername;
                $c->image = $item->image;
                return $c;
            };
        foreach ($arr as $item) {
            $resultArr[] = $callback($item);
        }
        return $resultArr;
    }

    /**
     * 根据科目，版本，学部获取章节数组
     * @param integer $subject
     * @param integer $version
     * @param integer $department
     * @return array
     */
    public static function getChapterArray(int $subject, int $version, int $department)
    {
        $chapterTomeResult = [];
        $chapterService = new ChapterService();
        $tomeResult = $chapterService->tome($department, $subject, $version);

        if ($tomeResult->code == 200) {
            $chapterTomeResult = $tomeResult->body;
        }

        $chapterArray = [];
        foreach ($chapterTomeResult as $v) {
            $chapterArray[$v->id] = $v->name;
        }
        $chapterArray[''] = '请选择';
        return $chapterArray;
    }


    /**
     * 章节树对象
     * @param $knowledgePoint
     * @param $id　　　　　
     * @return array
     */
    public function treeChapter(&$knowledgePoint, $id)
    {
        $array = [];
        $list = from($knowledgePoint)->where(function ($v) use ($id) {
            return $v->pId == $id;
        })->toList();

        if (count($list) > 0) {
            foreach ($list as $chapter) {
                $this->treeChapter($knowledgePoint, $chapter->id);
                $chapterModel = new stdClass();
                $chapterModel->chapterId = $chapter->id;
                $chapterModel->chapterName = $chapter->name;
                $chapterModel->pid = $chapter->pId;
                $chapterModel->list = [];
                $childChapter = $this->treeChapter($knowledgePoint, $chapter->id);
                if (count($childChapter) != 0) {
                    $chapterModel->list = $childChapter;
                }
                array_push($array, $chapterModel);
            }
        }
        return $array;
    }


    /**
     * 单个分册名称
     * @param integer $id
     * @return string
     */
    public static function tomeName(int $id)
    {
        $knowledgeName = '';

        $tomeInfo = self::tomeInfoCache($id);

        if (!empty($tomeInfo)) {
            $knowledgeName = $tomeInfo->chaptername;
        }
        return $knowledgeName;
    }

    /**
     * 分册信息缓存
     * @param integer $id
     * @return mixed
     */
    public static function tomeInfoCache(int $id){

        $cache = Yii::$app->cache;
        $key = WebDataKey::GET_TOME_INFO_CACHE_BY_ID . '_' .$id;
        $result = $cache->get($key);
        if($result === false){
            $chapterService = new ChapterService();
            $result = $chapterService->tomeInfo($id);
            $cache->set($key,$result,3600);
        }
        return $result;
    }

}