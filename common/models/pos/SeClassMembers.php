<?php

namespace common\models\pos;

use common\components\WebDataKey;
use common\models\sanhai\SeSchoolGrade;
use Yii;

/**
 * This is the model class for table "se_classMembers".
 *
 * @property integer $ID
 * @property string $classID
 * @property string $userID
 * @property string $identity
 * @property string $job
 * @property string $stuID
 * @property string $memName
 * @property string $createTime
 */
class SeClassMembers extends PosActiveRecord
{
	/**
	 * 班主任
	 */
	const  TEACHER = 20401;
	/**
	 * 学生
	 */
	const  STUDENT = 20403;
	/**
	 * 任课老师
	 */
	const  TEACHER_COURSE = 20402;
	/**
	 * 0  未删除
	 */
	const  IS_DELETE = 0;

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'se_classMembers';
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
	 * @return SeClassMembersQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new SeClassMembersQuery(get_called_class());
	}


	/**
	 * 成员所在班级信息
	 * @return \yii\db\ActiveQuery
	 */
	public function getSeClass()
	{

		return $this->hasOne(SeClass::className(), ['classID' => 'classID']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getSeClassSubject()
	{
		return $this->hasOne(SeClassSubject::className(), ['userID' => 'teacherID']);
	}

	/**
	 * 查询班级成员信息
	 * @return \yii\db\ActiveQuery
	 */
	public function getUserInfo()
	{
		return $this->hasOne(SeUserinfo::className(), ['userID' => 'userID']);
	}

	/**
	 * 根据classID查询班级老师和学生数
	 * @param integer $classId
	 * @param integer $identity
	 * @return int|string
	 */
	public static function getClassNumByClassId(int $classId,int $identity = 0)
	{
		$classQuery = self::find()->where(['classID' => $classId])->andWhere(['>', 'userID', 0]);
		if ($identity != null) {
			$classQuery = $classQuery->andWhere(['identity' => $identity]);
		}
		$classMemNum = $classQuery->count();
		return $classMemNum;
	}

	/**
	 * @inheritdoc
	 * @return array
	 */
	public function rules()
	{
		return [
			[['ID'], 'required'],
			[['ID'], 'integer'],
			[['classID', 'userID', 'identity', 'job', 'stuID', 'createTime'], 'string', 'max' => 20],
			[['memName'], 'string', 'max' => 40]
		];
	}

	/**
	 * @inheritdoc
	 * @return array
	 */
	public function attributeLabels()
	{
		return [
			'ID' => 'id',
			'classID' => '班级id',
			'userID' => '用户ID',
			'identity' => '角色班内职务',
			'job' => '班级职务编码_职务名称',
			'stuID' => '学号。',
			'memName' => '成员姓名',
			'createTime' => '创建时间',
		];
	}

	/**
	 * 查询班级班主任
	 * @param integer $classId 班级ID
	 * @return array|SeClassMembers|null
	 */
	public function selectClassAdviser(int $classId)
	{
		if ($classId > 0) {
			return self::find()->where(['classID' => $classId, 'identity' => 20401])->andWhere(['>', 'userID', 0])->limit(1)->one();
		}
		return null;
	}

	/**
	 * 查询教师列表
	 * 缓存10分钟
	 * @param integer $classId 班级ID
	 * @return array|SeClassMembers[]|mixed
	 */
	public function selectClassTeacherList(int $classId)
	{
		if ($classId <= 0) {
			return [];
		}
		$cache = Yii::$app->cache;
		$key = WebDataKey::CLASS_TEACHER_LIST_CACHE_KEY . "_" . $classId;
		$data = $cache->get($key);
		//20402 教师身份
		if ($data === false) {
			$data = self::find()->where(['classID' => $classId, 'identity' => 20402])->andWhere(['>', 'userID', 0])->all();
			if (!empty($data)) {
				$cache->set($key, $data, 600);
			}
		}
		return $data;
	}

	/**
	 * 成员所在班级
	 * @param integer $userId 用户ID
	 * @return array|SeClassMembers[]
	 */
	public static function getClass(int $userId)
	{
		return self::find()->where(['userID' => $userId])->limit(1)->one();
	}

	/**
	 * 获取个人所在所有班级信息 用户ID 班级ID 角色班内职务  成员姓名
	 * @param $userId
	 * @return array|SeClassMembers[]
	 */

	public static function getIndividualClassInfo($userId)
	{
		return self::find()->where(['userID' => $userId])->select('userID,classID,identity,memName')->all();
	}

	/**
	 * 查询班级学生列表
	 * 缓存10分钟
	 * @param integer $classId 班级ID
	 * @return array|SeClassMembers[]|mixed|string
	 */
	public function selectClassStudentList(int $classId)
	{
		if ($classId <= 0) {
			return [];
		}
		$cache = Yii::$app->cache;
		$key = WebDataKey::CLASS_STUDENT_LIST_CACHE_KEY . "_" . $classId;
		$data = $cache->get($key);
		//20403 学生身份
		if ($data === false) {
			$data = self::find()->where(['classID' => $classId, 'identity' => 20403])->andWhere(['>', 'userID', 0])->all();
			if (!empty($data)) {
				$cache->set($key, $data, 600);
			}
		}
		return $data;
	}

	/**
	 * 查询班级科目
	 * @return \yii\db\ActiveQuery
	 */
	public function getClassSubject()
	{
		return $this->hasMany(SeClassSubject::className(), ["teacherID" => "userID"]);
	}

    /**
     * 根据班级id和用户id查询班级
     * @param int $classId
     * @param int $userId
     * @return array|SeClassMembers|null
     */
	public static function getOneClassInfo(int $classId,int $userId)
	{
		return self::find()->where(["classID" => $classId, "userID" => $userId])->select("classID")->limit(1)->one();
	}

	/**
	 * 查询班级成员信息列表
	 * @param $classId
	 * @return array|SeClassMembers[]
	 */
	public static function getClassMemberInfo($classId)
	{
		return self::find()->where(['classID' => $classId])->all();
	}

    /**
     * 获取用户所交年级
     * @param integer $userId 用户id
     * @return array
     */
	public static function getGradeInfoByUserId(int $userId)
    {

        $cache = Yii::$app->cache;
        $key = WebDataKey::GET_GRADE_INFO_BY_USER_CACHE_KEY . '_' . $userId;
        $gradeInfo = $cache->get($key);
        if($gradeInfo === false) {
            $classInfo = self::find()->select('classID')->where(['userID' => $userId])->all();
            $classIdArr = [];
            foreach ($classInfo as $v) {
                $classIdArr[] = $v->classID;
            }
            $gradeIdArr = SeClass::getGradeIds($classIdArr);
            $gradeInfo = SeSchoolGrade::getGradeName($gradeIdArr);
            $cache->set($key,$gradeInfo,3600);
        }
        return $gradeInfo;
	}


}
