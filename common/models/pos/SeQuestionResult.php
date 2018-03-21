<?php
namespace common\models\pos;

use common\helper\DateTimeHelper;
use common\clients\KeyWordsService;
use common\components\WebDataCache;
use Yii;

/**
 * This is the model class for table "se_questionResult".
 *
 * @property integer $resultID
 * @property string $creatorID
 * @property string $rel_aqID
 * @property string $resultDetail
 * @property string $createTime
 * @property string $isUse
 * @property string $useTime
 * @property string $isDelete
 * @property string $imgUri
 * @property string $creatorName
 */
class SeQuestionResult extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_questionResult';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Yii::$app->get('db_school');
    }

    /**
     * @inheritdoc
     * @return SeQuestionResultQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeQuestionResultQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['resultID'], 'integer'],
            [['resultDetail'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'resultID' => '回答ID',
            'creatorID' => '回答人',
            'rel_aqID' => '关联问题表的ID',
            'resultDetail' => '回答内容',
            'createTime' => '创建时间',
            'isUse' => '是否采用0：未采用，1采用',
            'useTime' => '采用时间',
            'isDelete' => '是否删除，0未删除，1已删除',
            'imgUri' => '图片地址',
	        'creatorName' => '回答人名'
        ];
    }

    /**
     * 回答答疑
     * @param integer $userId
     * @param integer $aqid
     * @param string $answerContent
     * @param string $imgPath
     * @return bool
     */
    public function addResultQuestion(int $userId, int $aqid, string $answerContent, string $imgPath)
    {
        $this->creatorID = $userId;
        $this->rel_aqID = $aqid;
        $this->resultDetail = KeyWordsService::ReplaceKeyWord($answerContent);
        $this->createTime = DateTimeHelper::timestampX1000();
        $this->imgUri = $imgPath;
        $this->creatorName = WebDataCache::getTrueNameByuserId($userId);
        if($this->save(false)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 查询答疑回答列表是否有 最佳答案 存在
     * @param integer $aqId
     * @return bool
     */
    public function checkQuestionResult(int $aqId)
    {
        return self::find()->where(['rel_aqID'=>$aqId,'isUse'=>1])->exists();
    }

    /**
     * 设置最佳答案
     * @param integer $resultId 回答id
     * @return bool
     */
    public function updateUseAnswer(int $resultId)
    {

        $answerQuestionModel = new SeAnswerQuestion();

        $resultDetails = $this->getQuestionResultRelDetails($resultId);
        $isUse = self::updateAll(['isUse' => 1, 'useTime' => DateTimeHelper::timestampX1000()], 'resultID=:resultId', [':resultId' => $resultId]);
        if ($isUse) {
            // 设置最佳答案  修改答疑为解决状态
            $answerQuestionModel->updateAnswerQuestionsSolve($resultDetails->rel_aqID);
        }
        return true;


    }

    /**
     * 查询答案列表
     * @param integer $aqId
     * @param integer $pages
     * @return array|SeQuestionResult[]
     */
    public function selectQuestionResultList(int $aqId,int $pages)
    {
        return self::find()->where(['rel_aqID'=>$aqId])->orderBy('isUse desc,createTime desc')->active()->limit($pages)->all();
    }

    /**
     * 答疑详情页查询答案列表
     * @param int $aqId
     * @return SeQuestionResultQuery
     */
    public function getQuestionResultList(int $aqId)
    {
        return self::find()->where(['rel_aqID'=>$aqId])->orderBy('isUse desc,createTime desc')->active();
    }

    /**
     * 当前用户回答问题被采纳的总数
     * @param integer $userId
     * @return int|string
     */
    public static  function getUserRelyQuestion(int $userId){
        return self::find()->where(['creatorID' => $userId, 'isUse' => 1])->active()->count();
    }

    /**
     * 当前用户回答问题的总数
     * @param int $userId
     * @return int|string
     */
	public static function getUserAnswerQuestion(int $userId)
	{
		return self::find()->where(['creatorID' => $userId])->active()->count();
	}

    /**
     * 根据问题id和回答id查询单条回答内容
     * @param $aqId
     * @param $resultId
     * @return array|SeQuestionResult|null
     */
    public function selectOneQuestionResult($aqId,$resultId)
    {
        return self::find()->where(['resultID'=>$resultId, 'rel_aqID'=>$aqId])->active()->limit(1)->one();
    }

    /**
     * 根据 回答id 查询未采用的单条回答内容
     * @param integer $resultId
     * @return array|SeQuestionResult|null
     */
    public function getQuestionResultRelDetails(int $resultId)
    {
        return self::find()->where(['resultID'=>$resultId])->active()->limit(1)->one();
    }

    /**
     * 查询答疑
     * @return \yii\db\ActiveQuery
     */
    public function getAnswerQuestions()
    {
        return $this->hasOne(SeAnswerQuestion::className(),['aqID'=>'rel_aqID']);
    }

    /**
     * 查询回答总数
     * @param integer $aqId
     * @return int|string
     */
    public static function getAnswerResultSum(int $aqId)
    {
        return self::find()->where([ 'rel_aqID'=>$aqId])->active()->count();
    }
}
