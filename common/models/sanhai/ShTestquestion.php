<?php

namespace common\models\sanhai;

use common\models\pos\SeQuestionFavoriteFolderNew;
use common\models\search\Es_testQuestion;
use common\models\TestQuestion;
use common\components\WebDataKey;
use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "sh_testquestion".
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
 */
class ShTestquestion extends \yii\db\ActiveRecord
{
    use TestQuestion;


    /**
     *单选题（1）
     */
    const QUESTION_DAN_XUAN_TI = 1;
    /**
     *多选题(2)
     */
    const QUESTION_DUO_XUAN_TI = 2;
    /**
     *不可判填空题(3)
     */
    const QUESTION_BU_KE_PAN_TIAN_KONG_TI = 3;
    /**
     *解答题(5)
     */
    const QUESTION_JIE_DA_TI = 5;
    /**
     *判断题(9)
     */
    const QUESTION_PAN_DUAN_TI = 9;
    /**
     *可判填空题（10）
     */
    const QUESTION_KE_PAN_TIAN_KONG_TI = 10;
    /**
     *可判选填题（11）
     */
    const QUESTION_KE_PAN_XUAN_TIAN_TI = 11;
    /**
     *可判连线题（12）
     */
    const QUESTION_KE_PAN_LIAN_XIAN_TI = 12;
    /**
     *可判应用题（13）
     */
    const QUESTION_KE_PAN_YING_YONG_TI = 13;
    /**
     *不可判应用题（14）
     */
    const QUESTION_BU_KE_PAN_YING_YONG_TI = 14;

    /*
     * 可判口语题
     */
    const QUESTION_KE_PAN_KOU_YU_TI = 15;

    /*
     * 不可判朗读题
     */
    const QUESTION_BU_KE_PAN_LANG_DU_TI = 16;

    /**
     *可判填空题需要替换的内容
     */
    const TIAN_KONG_TI_REPLACE_CONTENT = '(#______#)';
    /**
     *可判填空题替换成XX格式
     */
    const TIAN_KONG_TI_REPLACE_TO_CONTENT = '&nbsp;______&nbsp;';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sh_testquestion';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_sanku');
    }


    /**
     * 题目详细缓存
     * @param integer $id 题目id
     * @return array|ShTestquestion|mixed|null
     */
    public static function getTestQuestionDetails_Cache(int $id)
    {
        $cache = Yii::$app->cache;
        $key = WebDataKey::HOMEWORK_GET_QUESTION_DATA_BY_ID_KEY . $id;
        $data = $cache->get($key);
        if ($data === false) {
            $data = self::getTestQuestionDetails($id);
            $cache->set($key, $data, 600);
        }
        return $data;

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
     * 获取大题下面的小题
     * @return \yii\db\ActiveQuery
     */
    public function getSmallQuestion()
    {
        return $this->hasMany(ShTestquestion::className(), ['mainQusId' => 'id']);
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'mainQusId', 'paperId', 'noNum', 'showType', 'backendOperater', 'isAuto', 'keHaiUseNum'], 'integer'],
            [['content', 'analytical', 'answer', 'jsonAnswer'], 'string'],
            [['provience', 'city', 'country', 'gradeid', 'subjectid', 'tqtid', 'provenance', 'year', 'complexity', 'operater', 'createTime', 'updateTime', 'isDelete', 'quesLevel'], 'string', 'max' => 20],
            [['versionid', 'kid'], 'string', 'max' => 300],
            [['school'], 'string', 'max' => 30],
            [['capacity'], 'string', 'max' => 200],
            [['status'], 'string', 'max' => 5],
            [['quesFrom'], 'string', 'max' => 800],
            [['chapterId'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'provience' => 'Provience',
            'city' => 'City',
            'country' => 'Country',
            'gradeid' => 'Gradeid',
            'subjectid' => 'Subjectid',
            'versionid' => 'Versionid',
            'kid' => 'Kid',
            'tqtid' => 'Tqtid',
            'provenance' => 'Provenance',
            'year' => 'Year',
            'school' => 'School',
            'complexity' => 'Complexity',
            'capacity' => 'Capacity',
            'operater' => 'Operater',
            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',
            'content' => 'Content',
            'analytical' => 'Analytical',
            'mainQusId' => 'Main Qus ID',
            'status' => 'Status',
            'isDelete' => 'Is Delete',
            'quesLevel' => 'Ques Level',
            'quesFrom' => 'Ques From',
            'chapterId' => 'Chapter ID',
            'noNum' => 'noNum',
            'showType' => 'showType',
            'backendOperater' => 'backendOperater',
            'paperId' => 'Paper ID',
            'answer' => 'answer',
            'jsonAnswer' => 'jsonAnswer',
            'isAuto' => 'isAuto',
            'keHaiUseNum' => 'Ke Hai Use Num',
            'mediaId' => '媒体资源',
            'mediaType' => '0没有附加媒体，1音频，2视频'
        ];
    }

    /**
     * @inheritdoc
     * @return ShTestquestionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShTestquestionQuery(get_called_class());
    }


    /**
     * 根据 questionId 获取详情
     * @param integer $questionId 题id
     * @return array|ShTestquestion|null
     */
    public static function getTestQuestionDetails(int $questionId)
    {
        if ($questionId > 0) {
            return self::find()->where(['id' => $questionId])->limit(1)->one();
        }
        return null;
    }

}
