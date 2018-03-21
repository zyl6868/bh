<?php
/**
 * Created by PhpStorm.
 * User: yangjie
 * Date: 15/8/17
 * Time: 下午1:55
 */

namespace common\models\search;

use common\elasticsearch\es_ActiveRecord;
use common\models\pos\SeQuestionFavoriteFolderNew;
use common\models\sanhai\ShTestquestion;
use common\models\TestQuestion;
use yii\elasticsearch\ActiveQuery;
use yii\elasticsearch\Query;

/**
 * This is the model class for table "testQuestion".
 *
 * @property integer $id
 * @property string $provience
 * @property string $city
 * @property string $country
 * @property integer $gradeid
 * @property integer $subjectid
 * @property string $versionid
 * @property string $kid
 * @property integer $tqtid
 * @property string $provenance
 * @property string $year
 * @property string $school
 * @property integer $complexity
 * @property integer $capacity
 * @property integer $operater
 * @property integer $createTime
 * @property integer $updateTime
 * @property string $content
 * @property string $analytical
 * @property string $mainQusId
 * @property integer $status
 * @property integer $isDelete
 * @property integer $quesLevel
 * @property string $quesFrom
 * @property string $chapterId
 * @property integer $noNum
 * @property integer $showType
 * @property integer $backendOperater
 * @property integer $paperId
 * @property string $answer
 * @property string $jsonAnswer
 * @property integer $isAuto
 * @property integer $keHaiUseNum
 * @property string $mediaId
 * @property integer $mediaType
 **/
class Es_testQuestion extends es_ActiveRecord
{
    use TestQuestion;


    /**
     * @return string
     */
    public static function index()
    {
        return 'test-questions';
    }

    /**
     * @return string the name of the type of this record.
     */
    public static function type()
    {
        return 'test-question';

    }

    /**
     * @return array the list of attributes for this record
     */
    public function attributes()
    {
        // path mapping for '_id' is setup to field 'id'
        return [
            'id',
            'provience',
            'city',
            'country',
            'gradeid',
            'subjectid',
            'versionid',
            'kid',
            'tqtid',
            'provenance',
            'year',
            'school',
            'complexity',
            'capacity',
            'operater',
            'createTime',
            'updateTime',
            'content',
            'analytical',
            'mainQusId',
            'status',
            'isDelete',
            'quesLevel',
            'quesFrom',
            'chapterId',
            'noNum',
            'showType',
            'backendOperater',
            'paperId',
            'answer',
            'jsonAnswer',
            'isAuto',
            'keHaiUseNum',
            'mediaId',
            'mediaType'

        ];
    }

    /**
     * @return array
     */
    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * 判断当前题目是否被当前用户收藏了
     * @return bool
     */
    public function isCollected()
    {
        return $this->hasOne(SeQuestionFavoriteFolderNew::className(), ['questionId' => 'id'])->where(['userId' => user()->id, 'isDelete' => 0])->exists();
    }


    /**
     * Defines a scope that modifies the `$query` to return only active(status = 1) customers
     */
    public static function active($query)
    {
        $query->andWhere(['status' => 1]);
    }


    /**
     * 前台搜索
     * @return Query
     */
    public static function forFrondSearch()
    {
        return self::find()->where(['operater' => 0, 'mainQusId' => 0, 'isDelete' => 0, 'status' => 1,'mediaType'=>0]);
    }

    /**
     * 课海题目查询条件
     * @return Es_testQuestion|ActiveQuery
     */
    public static function forKeHaiSearch()
    {
        return self::find()->where(['operater' => 0, 'mainQusId' => 0, 'status' => 1]);
    }

    /**
     * 题库题目同步到elasticsearch
     * @param int $id 题目id
     * @return bool
     */
    public static function questionRefreshElasticSearch(int $id)
    {
        //查询题库是否有此题
        $db_testQuestionModel = ShTestquestion::find()->where(['id' => $id, 'mainQusId' => 0])->one();
        if (empty($db_testQuestionModel)) {
            return false;
        }
        if ($db_testQuestionModel) {

            if ($db_testQuestionModel->id > 0) {
                self::deleteAll(['mainQusId' => $db_testQuestionModel->id]);
            }

            $childQuestionList = $db_testQuestionModel->getQuestionChild();
            $childQuestionList[] = $db_testQuestionModel;
            /** @var TestQuestion $questionModel */
            foreach ($childQuestionList as $questionModel) {
                $questionModel->clearQuestionChildCache();

                $es_questionModel = self::get($questionModel->id);

                if ($es_questionModel == null) {
                    $es_questionModel = new self();
                }
                $es_questionModel->letItem($questionModel);
                $es_questionModel->save(false);

            }

        }
        return true;
    }


    /**
     * elasticsearch插入新数据
     * @param ShTestquestion $item
     */
    protected function letItem(ShTestquestion $item)
    {
        $this->id = $item->id;
        $this->provience = $item->provience;
        $this->city = $item->city;
        $this->country = $item->country;
        $this->gradeid = $item->gradeid;
        $this->subjectid = $item->subjectid;
        $this->versionid = $item->versionid;
        $this->kid = $item->kid;
        $this->tqtid = $item->tqtid;
        $this->provenance = $item->provenance;
        $this->year = $item->year;
        $this->school = $item->school;
        $this->complexity = $item->complexity;
        $this->capacity = $item->capacity;
        $this->operater = $item->operater;
        $this->createTime = $item->createTime;
        $this->updateTime = $item->updateTime;
        $this->content = $item->content;
        $this->analytical = $item->analytical;
        $this->mainQusId = $item->mainQusId;
        $this->status = $item->status;
        $this->isDelete = $item->isDelete;
        $this->quesLevel = $item->quesLevel;
        $this->quesFrom = $item->quesFrom;
        $this->chapterId = $item->chapterId;
        $this->noNum = $item->noNum;
        $this->showType = $item->showType;
        $this->backendOperater = $item->backendOperater;
        $this->paperId = $item->paperId;
        $this->keHaiUseNum = $item->keHaiUseNum;
        $this->isAuto = $item->isAuto;
        $this->answer = $item->answer;
        $this->jsonAnswer = $item->jsonAnswer;
        $this->mediaId = $item->mediaId;
        $this->mediaType = $item->mediaType;


    }


    /**
     * 以数组形式获取题目的知识点id
     * @param Es_testQuestion $questionModel
     * @return array
     */
    public static function getQuestionKnowledge(Es_testQuestion $questionModel)
    {
        if (empty($questionModel)) {
            return [];
        }
        $kidArray = explode(',', $questionModel->kid);
        return $kidArray;
    }

    /**
     * 以数组形式获取题目的章节id
     * @param Es_testQuestion $questionModel
     * @return array
     */
    public static function getQuestionChapter(Es_testQuestion $questionModel)
    {
        if (empty($questionModel)) {
            return [];
        }
        $chapterArray = explode(',', $questionModel->chapterId);
        return $chapterArray;
    }

}
