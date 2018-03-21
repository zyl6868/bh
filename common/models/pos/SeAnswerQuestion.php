<?php

namespace common\models\pos;

use common\helper\DateTimeHelper;
use common\clients\KeyWordsService;
use common\components\WebDataCache;
use Yii;

/**
 * This is the model class for table "se_answerQuestion".
 *
 * @property integer $aqID 问题ID
 * @property integer $creatorID 创建人ID
 * @property string $aqName 问题名称
 * @property string $aqDetail 问题详情
 * @property integer $createTime 创建时间
 * @property integer $subjectID 科目ID
 * @property integer $classID 班级ID
 * @property integer $sameQueNumber 同问数
 * @property integer $sendToWorld 抛向宇宙
 * @property integer $isDelete 是否删除，0已删除，1未删除
 * @property string $imgUri imgUri
 * @property integer $schoolID 学校ID
 * @property integer $isSolved 解决状态; 0: 未解决; 1:解决
 * @property integer $answerResultNum 回复人员
 * @property string $country 地区
 * @property string $creatorName 创建人名称
 */
class SeAnswerQuestion extends PosActiveRecord
{
	/**
	 * 答疑答案数
	 * @var int
	 */
	public $answerCount = 0;

	/**
	 * 答疑同问数
	 * @var int
	 */
	public $sameCount = 0;

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'se_answerQuestion';
	}

	/**
	 * @return \yii\db\Connection the database connection used by this AR class.
	 */
	public static function getDb()
	{
		return Yii::$app->get('db_school');
	}

	/**
	 * @inheritdoc
	 * @return SeAnswerQuestionQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new SeAnswerQuestionQuery(get_called_class());
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['aqID'], 'integer'],
			[['aqDetail'], 'string'],
			[['aqName'], 'string', 'max' => 500],
			[['imgUri'], 'string', 'max' => 400]
		];
	}

	/**
	 * @param $studentId
	 * @return bool
	 */
	public function ifSelfAsked($studentId)
	{
		$ifSelfAsked = self::find()->where(['aqID' => $this->aqID])->andWhere(['creatorID' => $studentId])->active()->exists();
		return $ifSelfAsked;
	}

	/**
	 * @return mixed
	 */
	public function ifAccepted()
	{
		return SeQuestionResult::find()->where(['rel_aqID' => $this->aqID])->max('isUse');
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'aqID' => '问题ID',
			'creatorID' => '创建人ID',
			'aqName' => '问题名称',
			'aqDetail' => '问题详情',
			'createTime' => '创建时间',
			'subjectID' => '科目ID',
			'classID' => '班级ID',
			'sameQueNumber' => '同问数',
			'sendToWorld' => '抛向宇宙',
			'isDelete' => '是否删除，0已产生，1未删除',
			'imgUri' => 'Img Uri',
			'schoolID' => '学校ID',
			'creatorName' => '创建人名称',
			'isSolved' => '解决状态',
			'country' => '地区'
		];
	}


	/**
	 * 根据答疑类表 其中的问题id获取答疑的答案数
	 * @param array $answerArr 答疑信息数组
	 */

	public static function getAnswerCount(array $answerArr)
	{
		$aqIdArr = [];
		//SeAnswerQuestion表的aqID
		foreach ($answerArr as $key => $item) {
			$aqIdArr[] = $item['aqID'];
		}
		if (empty($aqIdArr)) {
			$answerCount = [];
		} else {
			$answerCount = SeQuestionResult::find()->andWhere(['rel_aqID' => $aqIdArr])->active()->groupBy("rel_aqID")->select(['rel_aqID', ' nullif(COUNT(*),0) countNum'])->asArray()->all();
		}

		foreach ($answerCount as $answerCountVal) {
			foreach ($answerArr as $key => $item) {
				if ($item->aqID == $answerCountVal['rel_aqID']) {
					$item->answerCount = $answerCountVal["countNum"];
				}
			}
		}
	}

	/**
	 * 根据aqID数组查询答疑的同问数
	 * @param array $answerArr 答疑信息数组
	 */
	public static function getAlsoAskCount(array $answerArr)
	{
		$aqIdArr = [];
		//SeAnswerQuestion表的aqID
		foreach ($answerArr as $key => $item) {
			$aqIdArr[] = $item['aqID'];
		}
		if (empty($aqIdArr)) {
			$resultSameCount = [];
		} else {
			$resultSameCount = SeSameQuestion::find()->where(['aqID' => $aqIdArr])->groupBy("aqID")->select(['aqID', ' nullif(COUNT(*),0) countNum'])->asArray()->all();
		}

		foreach ($resultSameCount as $sameCountVal) {
			foreach ($answerArr as $key => $item) {
				if ($item->aqID == $sameCountVal['aqID']) {
					$item->sameCount = $sameCountVal["countNum"];
				}
			}

		}
	}

	/**
	 * 根据回答的问题id 查询答疑详情
	 * @param array $arr
	 * @return array|SeAnswerQuestion[]
	 */
	public static function getAnswerQuestionInfo(array $arr)
	{
		$aqIdArr = [];
		foreach ($arr as $key => $item) {
			$aqIdArr[$key] = $item['rel_aqID'];
		}
		$data = self::find()->where(['aqID' => $aqIdArr])->active()->orderBy('createTime desc')->all();
		return $data;
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getQuestionResult()
	{
		return $this->hasMany(SeQuestionResult::className(), ['rel_aqID' => 'aqID']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getSameQuestionResult()
	{
		return $this->hasMany(SeSameQuestion::className(), ['aqID' => 'aqID']);
	}


	/**
	 *
	 * 当前用户提问问题的总数
	 * @param integer $userId 用户id
	 * @return int|string
	 */
	public static function getUserAskQuestion(int $userId)
	{
		return self::find()->where(['creatorID' => $userId])->active()->count();
	}


	/**
	 * 同步答疑回答数
	 * @param $answerResultNum
	 */
	public function setAnswerResultNum($answerResultNum)
	{
		$this->answerResultNum = $answerResultNum;
		$this->save(false);
	}

	/**
	 * 查询当天用户提问数
	 * @param    integer $userId 用户id
	 * @internal datetime  $startTime    开始时间
	 * @internal datetime  $endTime      结束时间
	 * @return   int|string
	 */

	public function checkAnswerNum(int $userId)
	{
		$startTime = strtotime(date("Y-m-d 00:00:00", time())) * 1000;
		$endTime = strtotime(date("Y-m-d 23:59:59", time())) * 1000;
		return self::find()->where(['between', 'createTime', $startTime, $endTime])->andWhere(['creatorID' => $userId])->count();
	}


	/**
	 * 新建答疑
	 * @param SeSchoolInfo $schoolInfo 学校信息
	 * @param string $classID 班级id
	 * @param string $schoolID 学校id
	 * @param        $dataBag
	 * @param string $subjectID 科目id
	 * @param string $moreIdea 提交到 联盟，学校，班级
	 * @param string $picurls 图片地址
	 * @param string $userid 用户id
	 * @return bool
	 */
	public function addAnswer(SeSchoolInfo $schoolInfo, $classID, $schoolID, $dataBag, $subjectID, $moreIdea, $picurls, $userid)
	{
		if (!empty($schoolInfo)) {
			$country = $schoolInfo->country;
			$this->country = $country;
		}
		$this->classID = $classID;
		$this->schoolID = $schoolID;
		$this->aqDetail = KeyWordsService::ReplaceKeyWord($dataBag->detail);
		$this->aqName = KeyWordsService::ReplaceKeyWord($dataBag->title);
		$this->subjectID = $subjectID;
		$this->sendToWorld = $moreIdea;
		$this->imgUri = $picurls;
		$this->creatorName = WebDataCache::getTrueNameByuserId($userid);
		$this->createTime = DateTimeHelper::timestampX1000();
		$this->creatorID = $userid;
		if (self::save(false)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 查询单条答疑信息
	 * @param integer $aqId 问题id
	 * @return array|SeAnswerQuestion|null
	 */
	public function selectAnswerOne(int $aqId)
	{
        return self::find()->where(['aqID' => $aqId])->active()->limit(1)->one();
	}

	/**
	 * 设置最佳答案 修改答疑 为解决状态
	 * @param integer $aqId 问题id
	 * @return int
	 */
	public function updateAnswerQuestionsSolve($aqId)
	{
		return self::updateAll(['isSolved' => 1], 'aqID=:aqId', [":aqId" => $aqId]);
	}

	/**
	 * 查询单条班级答疑
	 * @param integer $classId 班级id
	 * @return array|SeAnswerQuestion|null
	 */
	public function selectOneClassAnswer(int $classId)
	{
		if($classId > 0){
			return self::find()->where(['classID' => $classId])->active()->orderBy('createTime desc')->limit(1)->one();
		}
		return null;
	}

	/**
	 * 学生个人中心展示答疑的查询
	 * @param string $userId 用户id
	 * @return array|SeAnswerQuestion[]
	 */
	public function selectStuCenterAnswer($userId)
	{
		$answerQuestionList = self::find()->where(['creatorID' => $userId])->active()->orderBy(['createTime' => SORT_DESC])->limit(2)->all();
		if (empty($answerQuestionList)) {
			return [];
		}
		return $answerQuestionList;
	}

	/**
	 * 查询班级答疑提问排名 只查询提问的前十名排名 提问数
	 * wgl
	 * @param integer $classId 班级id
	 * @return array|\yii\db\ActiveRecord[]
	 */
	public static function getClassAnswerRanking(int $classId)
	{
		if($classId > 0){
			return self::findBySql("SELECT creatorID,creatorName,COUNT(aqID) as answerCount FROM se_answerQuestion WHERE classID=:classID AND isDelete=0 GROUP BY creatorID ORDER BY COUNT(*) DESC LIMIT 10", ['classID' => $classId])->asArray()->all();
		}
		return null;
	}

	/**
	 * 随机一条班级答疑
	 * @param integer $classId 班级id
	 * @return array|SeAnswerQuestion|null
	 */
	public static function randAnswerQuestion(int $classId)
	{
		if($classId > 0){
			return self::find()->where(['classID' => $classId])->active()->orderBy('rand()')->limit(1)->one();
		}
		return null;
	}

	/**
	 * 查询提问数各科的提问数
	 * wgl
	 * @param integer $userId 用户id
	 * @return array|\yii\db\ActiveRecord[]
	 */
	public static function getStatisticalGraph(int $userId)
	{
		return self::findBySql('SELECT subjectID,COUNT(*) mem FROM se_answerQuestion WHERE subjectID IN (SELECT subjectID FROM se_answerQuestion WHERE creatorID=:userId AND isDelete=0 GROUP BY subjectID) AND creatorID=:userId AND isDelete=0 GROUP BY subjectID ORDER BY subjectID ASC', ['userId' => $userId])->asArray()->all();
	}

	/**
	 * 查询回答过的问题 各科数
	 * wgl
	 * @param integer $userId 用户id
	 * @return array|\yii\db\ActiveRecord[]
	 */
	public static function getReplyStatSubject(int $userId)
	{
		return SeQuestionResult::findBySql('SELECT aQ.subjectID,COUNT(*) AS num FROM se_questionResult AS qR INNER JOIN se_answerQuestion AS aQ ON qR.rel_aqID=aQ.aqID  WHERE qR.creatorID=:userId AND qR.isDelete=0 GROUP BY aQ.subjectID', [':userId' => $userId])->asArray()->all();
	}

	/**
	 * 查询回答过被采用的回答问题 各科数
	 * wgl
	 * @param integer $userId 用户id
	 * @return array|\yii\db\ActiveRecord[]
	 */
	public static function getReplyIsUseSubject(int $userId)
	{
		return self::findBySql('select subjectID,COUNT(*) mem from se_answerQuestion where aqID IN (SELECT rel_aqID FROM se_questionResult WHERE creatorID=:userId AND isUse=1 AND isDelete=0 GROUP BY rel_aqID) AND subjectID IS NOT NULL AND isDelete=0 GROUP BY subjectID', ['userId' => $userId])->asArray()->all();
	}
}
