<?php

namespace common\models\pos;

use common\components\WebDataKey;
use Yii;

/**
 * This is the model class for table "se_homework_rel".
 *
 * @property integer $id
 * @property integer $createTime
 * @property integer $isDelete
 * @property integer $creator
 * @property integer $deadlineTime
 * @property integer $classID
 * @property integer $homeworkId
 * @property integer $memberTotal
 * @property integer $isSendMsgStudent
 * @property integer $isSendMsgTea
 * @property integer $isHide
 * @property string $audioUrl
 * @property integer $signature
 * @property string $requirement
 * @property integer $uploadNum
 * @property integer $checkNum
 * @property integer $signatureNum
 */
class SeHomeworkRel extends \yii\db\ActiveRecord
{

	/**
	 * 班级教师作业详情
	 * @var array
	 */
	public $homeworkTeacherInfo = [];

	/**
	 * 该作业是否作答过
	 * @var int
	 */
	public $existsStuIsUpload = 0;

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'se_homework_rel';
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
	 * @return \yii\db\ActiveQuery
	 * 根据homeworkId 查询se_homework_teacher表信息
	 */
	public function getHomeWorkTeacher()
	{
		return $this->hasOne(SeHomeworkTeacher::className(), ['id' => 'homeworkId']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 * 查询答案数
	 */

	public function getHomeworkAnswerInfo()
	{
		return $this->hasMany(SeHomeworkAnswerInfo::className(), ['relId' => 'id']);
	}

	/**
	 * 根据用户查找用户答题信息
	 * @param integer $userId 用户ID
	 * @return SeHomeworkAnswerInfo
	 */
	public function getHomeworkAnswerInfoByUserId(int $userId)
	{
		if($userId > 0){
			return $this->getHomeworkAnswerInfo()->where(['studentID' => $userId])->limit(1)->one();
		}
		return null;
	}


	/**
	 * 获取已答学生数
	 * @return int|mixed|string
	 */
	public function homeworkAnswerInfoCountCache()
	{
		$cache = Yii::$app->cache;
		$key = WebDataKey::HOMEWORK_ANSWER_INFO_COUNT_KEY . $this->id;
		$data = $cache->get($key);
		if ($data === false) {
			$data = SeHomeworkAnswerInfo::find()->where(['relId' => $this->id, 'isUploadAnswer' => '1'])->count();
			$cache->set($key, $data, 300);
		}
		return $data;
	}

	/**
	 * 判断当前学生是否已答
	 * @return bool
	 */
	public function stuIsComplete()
	{
		$isComplete = SeHomeworkAnswerInfo::find()->where(['relId' => $this->id, 'studentID' => user()->id, 'isUploadAnswer' => '1'])->exists();
		return $isComplete;
	}


	/**
	 * 获取已批改学生数
	 * @return int|mixed|string
	 */
	public function isCheckedStudentCountCache()
	{
		$cache = Yii::$app->cache;
		$key = WebDataKey::IS_CHECKED_STUDENT_COUNT_KEY . $this->id;
		$data = $cache->get($key);
		if ($data === false) {
			$data = SeHomeworkAnswerInfo::find()->where(['relId' => $this->id, 'isCheck' => '1', 'isUploadAnswer' => '1'])->count();
			$cache->set($key, $data, 300);
		}
		return $data;
	}

	/**
	 * 通过作业id获取到relId 获取作业列表
	 * @param integer $homeworkId 作业ID
	 * @return array|SeHomeworkRel[]
	 *
	 */
	public static function getRelData(int $homeworkId)
	{
		if($homeworkId > 0){
			return self::find()->where(['homeworkId' => $homeworkId])->select('id')->limit(10000)->asArray()->all();
		}
		return [];
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['createTime', 'isDelete', 'creator', 'deadlineTime', 'classID', 'homeworkId','memberTotal','isSendMsgStudent','isSendMsgTea','isHide','signature','uploadNum','checkNum','signatureNum'], 'integer']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'createTime' => '上传时间',
			'isDelete' => '是否删除0：否1：是默认0',
			'creator' => '创建人',
			'deadlineTime' => '交作业截至时间',
			'classID' => '班级id',
			'homeworkId' => ' 作业表，关联教师作业库',
			'memberTotal' => '当前班级学生数',
			'isSendMsgStudent' => '0:未催作业 1：已催作业',
			'isSendMsgTea' => '发送提醒消息，0:未发送 1：已发送',
			'isHide' => '布置作业是否展示，0:展示 1：隐藏',
			'audioUrl' => '语音地址',
			'signature' => '签字，1:需要签,0:不需要签',
            'requirement' => '作业要求',
            'uploadNum' => '作业提交数',
            'checkNum' => '作业批改数',
            'signatureNum' => '签字数'
		];
	}

	/**
	 * 根据homeworkRel的homeworkId查询教师作业相关信息
	 * @param array $homeworkRelArr 作业信息
	 */
	public static function getHomeworkTeacherInfo(array $homeworkRelArr)
	{
		$homeworkIdArr = [];
		foreach ($homeworkRelArr as $key => $item) {
			$homeworkIdArr[$key] = $item['homeworkId'];
		}
		$homeworkTeacherData = SeHomeworkTeacher::find()->where(['id' => $homeworkIdArr])->active()->select('getType,name,id,homeworkType')->all();
		foreach ($homeworkTeacherData as $hmTeaVal) {
			foreach ($homeworkRelArr as $key => $hmRelVal) {
				if ($hmRelVal->homeworkId == $hmTeaVal['id']) {
					$hmRelVal->homeworkTeacherInfo = $hmTeaVal;
				}
			}
		}
	}

	/**
	 * 判断当前学生是否已答
	 * @param array $homeworkRelArr 作业列表
	 */
	public static function existsStuIsComplete(array $homeworkRelArr)
	{
		$homeworkRelIdArr = [];
		foreach ($homeworkRelArr as $key => $item) {
			$homeworkRelIdArr[$key] = $item['id'];
		}
		$isComplete = SeHomeworkAnswerInfo::find()->where(['relId' => $homeworkRelIdArr, 'studentID' => user()->id, 'isUploadAnswer' => '1'])->select('relId')->asArray()->all();

		foreach ($isComplete as $isCVal) {
			foreach ($homeworkRelArr as $key => $hmRelVal) {
				if ($hmRelVal->id == $isCVal['relId']) {
					$hmRelVal->existsStuIsUpload = 1;
				}
			}
		}
	}

	/**
	 * @inheritdoc
	 * @return SeHomeworkRelQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new SeHomeworkRelQuery(get_called_class());
	}

	/**
	 * 查询单条班级作业
	 * @param integer $classId 班级ID
	 * @return array|SeHomeworkRel|null
	 */
	public function selectOneClassHomework(int $classId)
	{
		if($classId > 0){
			return self::find()->where(['classID' => $classId])->active()->orderBy('createTime desc')->limit(1)->one();
		}
		return null;
	}

	/**
	 * 学生个人中心展示作业查询
	 * @param integer $userId 用户id
	 * @param integer $classId 用户所在班级id
	 * @return array|SeHomeworkRel[]
	 */
	public function selectStuCenterHomework($userId, $classId)
	{
		$query = self::find()->where(['classID' => $classId])->active()->andWhere('id not in (select relId from se_homeworkAnswerInfo where isUploadAnswer=1 and studentID=:userId)', [':userId' => $userId]);
		$stuCenterHomework = $query->orderBy(['createTime' => SORT_DESC])->limit(3)->all();
		if (empty($stuCenterHomework)) {
			return [];
		}
		return $stuCenterHomework;
	}

	/**
	 * 根据 homeworkID 检测作业是否存在
	 * wgl
	 * @param integer $homeworkID 作业id
	 * @return bool
	 */
	public static function checkHomeworkRelExists(int $homeworkID)
	{
		return self::find()->where(['homeworkId' => $homeworkID])->exists();
	}

	/**
	 * 根据 作答relId 用户id 查询详情
	 * @param string $relId 作答作业id
	 * @param string $userId 用户id
	 * @return array|SeHomeworkRel|null
	 */
	public static function getHomeworkRelDetails($relId, $userId)
	{
		return self::find()->where(['id' => $relId, 'creator' => $userId])->limit(1)->one();
	}

	/**
	 * 随机一条新班级作业
	 * @param integer $classId 班级id
	 * @return array|SeHomeworkRel|null
	 */
	public static function randHomeworkRelDetails(int $classId)
	{
		if($classId > 0){
			return self::find()->where(['classID' => $classId])->active()->orderBy('rand()')->limit(1)->one();
		}
		return null;
	}

	/**
	 * 根据 作业id 查询作业详情
	 * @param integer $relId 作答作业id
	 * @return SeHomeworkRel|null
	 */
	public static function getOneHomeworkRelDetails(int $relId)
	{
		if($relId > 0){
			return self::find()->where(['id' => $relId])->active()->limit(1)->one();
		}
		return null;
	}

	/**
	 * 根据 班级id 作业id 获取该作业中的 语音 和 班级作业id
	 * @param integer $classId 班级id
	 * @param integer $homeworkId 作业id
	 * @return array|SeHomeworkRel|null
	 */
	public static function getAudioUrl(int $classId, int $homeworkId)
	{
		if($classId > 0 && $homeworkId > 0){
			return self::find()->where(['classID' => $classId, 'homeworkId' => $homeworkId])->select('id,audioUrl')->limit(1)->one();
		}
		return null;
	}

	/**
	 * 查询该作业是否被催过
	 * @param integer $relId 作业作答id
	 * @return array|SeHomeworkRel|null
	 */
	public static function isSendMsgStudent(int $relId)
	{
		return SeHomeworkRel::find()->where(['id' => $relId, 'isSendMsgStudent' => 0])->limit(1)->one();
	}

	/**
	 * 联合查询se_homeworkAnswerInfo 查询作业已完成和未完成
	 * wgl
	 * @param string $userId 用户id
	 * @param string $classId 班级id
	 * @param integer $startTime 开始时间戳（周一）
	 * @param integer $endTime 结束时间戳（周日）
	 * @return array|\yii\db\ActiveRecord[]
	 */
	public static function unHomework($userId, $classId, $startTime, $endTime)
	{
		return SeHomeworkRel::findBySql('SELECT isUploadAnswer,count(*) countMem FROM se_homework_rel AS rel LEFT JOIN se_homeworkAnswerInfo as answerInfo ON rel.id=answerInfo.relId AND answerInfo.studentID=:userId AND answerInfo.isUploadAnswer=1 WHERE rel.classID=:classId AND (rel.deadlineTime BETWEEN :startTime AND :endTime) GROUP BY isUploadAnswer', [':userId' => $userId, ':classId' => $classId, ':startTime' => $startTime, ':endTime' => $endTime])->asArray()->all();
	}

    /**
     * 根据班级和作业id查询记录
     * @param int $classId 班级id
     * @param int $homeworkId  作业id
     * @return array|SeHomeworkRel|null
     */
	public static function actionGetOneRecord(int $classId, int $homeworkId)
    {
	    if($classId > 0 && $homeworkId > 0){
            return self::find()->where(['homeworkId' => $homeworkId,'classID' => $classId])->limit(1)->one();
        }
        return null;
    }

    /**
     * 保存数据
     * @param array $val 分配班级信息
     * @param int $homeworkId 作业id
     */
    public function instertRecord(array $val,int $homeworkId,int $isSignature)
    {
        $this->classID = $val['classID'];
        $classMembers = SeClassMembers::getClassNumByClassId((int)$val['classID'], SeClassMembers::STUDENT);
        $this->memberTotal = $classMembers;
        $this->deadlineTime = strtotime($val['deadlineTime']) ? strtotime($val['deadlineTime']) * 1000 : strtotime('-2 day') * 1000;
        $this->homeworkId = $homeworkId;
        $this->createTime = time() * 1000;
        $this->creator = user()->id;
        $this->signature = $isSignature;


    }
}
