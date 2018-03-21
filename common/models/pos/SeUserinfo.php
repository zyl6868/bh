<?php

namespace common\models\pos;

use common\helper\DateTimeHelper;
use common\helper\StringHelper;
use frontend\components\UserClass;
use frontend\components\UserGroup;
use common\components\WebDataCache;
use common\components\WebDataKey;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "se_userinfo".
 *
 * @property integer $userID 用户id
 * @property string $phoneReg 账号
 * @property string $email 邮箱
 * @property string $passWd 密码
 * @property string $trueName 真实姓名
 * @property string $parentsName 父母姓名
 * @property string $phone 家长手机
 * @property integer $schoolID 学校id
 * @property integer $status1 是否填写完注册信息，0表示未写完，1表示已写完，默认：0
 * @property integer $status2 是否初步完成个人信息，0表示未写完，1表示已写完，默认：0
 * @property integer $createTime 创建时间
 * @property integer $updateTime 信息最后一次修改时间
 * @property integer $isDelete 是否已删除，0表示未删除，1表示已删除，默认：0
 * @property integer $type 登录人信息，0表示学生，1表示老师
 * @property string $provience 省，直辖市
 * @property string $city 城市'
 * @property string $country 区县
 * @property integer $department 学段/学部(见数据字典表)
 * @property string $headImgUrl 个人头像url
 * @property integer $textbookVersion 教材版本
 * @property integer $disabled 是否已经禁用 0：未禁用/激活/解禁/审核通过  1：已经禁用
 * @property string $resetPasswdToken 重置密码验证
 * @property string $resetPasswdTm
 * @property integer $subjectID 教师教授科目
 * @property string $username
 * @property string $bindphone 绑定手机
 * @property integer $sex 1男， 2女
 * @property integer $pid 父ID
 * @property string $inviteCode 邀请码
 * @property integer $memberLevel 0普通会员1高级会员
 */
class SeUserinfo extends \yii\db\ActiveRecord
{
    /**
     * 班主任
     */
    const  TEACHER_HEAD = '20401';
    /**
     * 任课老师
     */
    const  TEACHER_COURSE = '20402';
    /**
     * 学生
     */
    const  STUDENT = '20403';
    /**
     * 班海学校
     */
    const  SCHOOL_ID = 1000;
    /**
     * 是否填写完注册信息，0表示未写完，1表示已写完
     */
    const REGISTER_STATUS_FINISHED = 1;

    /**
     * 是否填写完注册信息，0表示未写完，1表示已写完
     */
    const REGISTER_STATUS_UNFINISHED = 0;


    /**
     * 是否删除  0 未删除  1 已删除
     */
    const  IS_DELETE = 0;
    /**
     * 身份  0 学生  1 老师
     */
    const  TYPE_STUDENT = 0;
    const  TYPE_TEACHER = 1;

    /**
     * 学校id 1000 班海学校
     */
    const BAN_HAI_SCHOOL = 1000;

    /**
     * 和教育信息创建人
     */
    const  HE_EDU_CREATOR = 300;


    /**
     * @return string
     */
    public static function tableName()
    {
        return 'se_userinfo';
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
     */
    public function rules()
    {
        return [
            [['phoneReg'], 'required'],
            [['userID', 'pid', 'memberLevel'], 'integer'],
            [['phoneReg', 'email'], 'string', 'max' => 200],
            [['passWd'], 'string', 'max' => 36],
            [['trueName', 'username', 'parentsName', 'provience', 'city', 'country', 'department'], 'string', 'max' => 50],
            [['phone', 'bindphone', 'schoolID', 'createTime', 'updateTime', 'resetPasswdTm', 'subjectID'], 'string', 'max' => 20],
            [['status1', 'status2', 'isDelete', 'disabled', 'sex'], 'string', 'max' => 2],
            [['type'], 'string', 'max' => 10],
            [['headImgUrl', 'resetPasswdToken'], 'string', 'max' => 500],
            [['textbookVersion'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userID' => '用户id',
            'phoneReg' => 'Phone Reg',
            'email' => '邮箱',
            'passWd' => '密码',
            'trueName' => '真实姓名',
            'parentsName' => '父母姓名',
            'phone' => '手机',
            'schoolID' => '学校id',
            'status1' => '是否填写完注册信息，0表示未写完，1表示已写完，默认：0',
            'status2' => '是否初步完成个人信息，0表示未写完，1表示已写完，默认：0',
            'createTime' => '创建时间',
            'updateTime' => '信息最后一次修改时间',
            'isDelete' => '是否已删除，0表示未删除，1表示已删除，默认：0',
            'type' => '登录人信息，0表示学生，1表示老师',
            'provience' => '省，直辖市',
            'city' => '城市',
            'country' => '区县',
            'department' => '学段/学部(见数据字典表)',
            'headImgUrl' => '个人头像url',
            'textbookVersion' => '教材版本 来自数据字典',
            'disabled' => '是否已经禁用 0：未禁用/激活/解禁/审核通过  1：已经禁用',
            'resetPasswdToken' => '重置密码验证',
            'resetPasswdTm' => 'Reset Passwd Tm',
            'subjectID' => '教师教授科目',
            'username' => '用户名',
            'bindphone' => '绑定手机号',
            'sex' => '性别',
            'pid' => '父ID',
            'inviteCode' => '邀请码',
            'memberLevel' => '会员',
        ];
    }

    /**
     * /todo 老方法移值
     * 获取教研组
     */
    public function getGroupInfo()
    {
        $groupMemberList = SeGroupMembers::find()->where(['teacherID' => $this->userID])->active()->all();
        $items = array();
        $groupArray = ArrayHelper::getColumn($groupMemberList, 'groupID');
        $seTeachingGroupList = SeTeachingGroup::find()->where(['ID' => $groupArray])->all();
        $findOneTeachingGroupFunction = function ($seTeachingGroupLst, $groupId) {
            foreach ($seTeachingGroupLst as $i) {
                if ($i->ID == $groupId) {
                    return $i;
                }
            }
            return null;
        };
        foreach ($groupMemberList as $key => $item) {
            $seTeachingGroupModel = $findOneTeachingGroupFunction($seTeachingGroupList, $item->groupID);
            if ($seTeachingGroupModel != null) {
                $group = new  UserGroup();
                $group->groupID = $item->groupID;
                $group->groupName = $seTeachingGroupModel->groupName;
                $group->identity = $item->identity;
                $items[] = $group;
            }
        }
        return $items;
    }


    /**
     *  /todo 老方法移值
     *  所在班级
     */
    public function getClassInfo()
    {

        $seClassMembers = SeClassMembers::find()->where(['userID' => $this->userID])->all();
        $items = array();
        foreach ($seClassMembers as $key => $item) {
            $teachClass = new  UserClass();
            $teachClass->classID = $item->classID;
            $teachClass->identity = $item->identity;
            $seClassSubject = SeClassSubject::find()->where(['teacherID' => $this->userID, 'classID' => $item->classID])->limit(1)->one();
            $seClassModel = SeClass::find()->where(['classID' => $item->classID])->limit(1)->one();
            $teachClass->subjectNumber = ArrayHelper::getValue($seClassSubject, 'subjectNumber');
            $teachClass->className = $seClassModel->className;
            $teachClass->joinYear = $seClassModel->joinYear;
            $teachClass->classNumber = $seClassModel->classNumber;
            $items[] = $teachClass;
        }

        return $items;
    }

    /**
     * 获取用户所在班级缓存
     * @return array|mixed
     */
    public function getClassInfoCache()
    {
        $cache = Yii::$app->cache;
        $key = WebDataKey::CLASS_INFO_DATA_BY_USERID_KEY . $this->userID;
        $data = $cache->get($key);
        if ($data == false) {
            $data = $this->getClassInfo();
            if ($data != null) {
                $cache->set($key, $data, 600);
            }
        }
        return $data;
    }

    /**
     * 修改头像
     * @param string $header
     * @throws \Exception
     */
    public function UpdateHeader(string $header)
    {
        $this->headImgUrl = $header;
        $this->update(false);
        WebDataCache::clearUserCache($this->userID);
    }

    /**
     * 用户所在班级及信息
     * @return array
     */
    public function getClassAndMember()
    {
        $seClassMembers = SeClassMembers::find()->where(['userID' => $this->userID])->all();
        return $seClassMembers;
    }

    /**
     * 查询班级（查询默认第一个班级），无班级的时候默认为0
     * @return int
     */
    public function getFirstClass()
    {
        $classMemberList = $this->getClassAndMember();
        if ($classMemberList) {
            return $classMemberList[0]->classID;
        }
        return 0;
    }


    /**
     * 获取用户所在班级中相关信息
     * @return array|SeClassMembers[]
     */
    public function getUserInfoInClass()
    {
        $seClassMembers = SeClassMembers::find()->where(['userID' => $this->userID])->all();
        $items = [];
        foreach ($seClassMembers as $item) {

            $seClassSubject = SeClassSubject::find()->where(['teacherID' => $this->userID])->limit(1)->one();

            $items[] = ['classID' => $item->classID,
                'identity' => $item->identity,
                'stuID' => $item->stuID,
                'job' => $item->job,
                'gradeID' => ArrayHelper::getValue($item->seClass, 'gradeID'),
                'subjectNumber' => ArrayHelper::getValue($seClassSubject, 'subjectNumber')
            ];

        }
        return $items;
    }


    /**
     *  /todo 老方法移值
     * 是否在包括在班级中
     * @param integer $classId 班级ID
     */
    public function getInClassInfo(int $classId)
    {
        if ($classId > 0) {
            return SeClassMembers::find()->where(['classID' => $classId])->andWhere(['userID' => $this->userID])->exists();
        }
        return null;
    }


    /**
     * /todo 老方法移值
     * 用户是否该组中
     *
     */
    public function getInGroupInfo($groupId)
    {
        /** @var $items UserGroup[] */
        $items = $this->getGroupInfo();
        foreach ($items as $key => $item) {
            if ($item->groupID == $groupId) {
                return $item;
            }
        }
        return null;
    }

    /**
     * 获取学校模型
     */
    public function getSchoolName()
    {
        return SeSchoolInfo::find()->findNameById($this->userID);
    }

    /**
     *  是老师
     * @return bool|int
     */
    public function isTeacher()
    {
        return $this->type == 1;
    }


    /**
     * /todo 老方法移值
     * 学用所在的班级
     * @return array|SeClassMembers[]
     */
    public function getUserClassGroup()
    {
        return SeClassMembers::find()->where(['userID' => $this->userID])->all();
    }


    /**
     * 是学生
     * @return bool|int
     */
    public function isStudent()
    {
        return $this->type == 0;
    }


    /**
     * 获取头像
     */
    public function getFaceIcon()
    {
        $faceIcon = "/pub/images/tx.jpg";
        if ($this->headImgUrl != null && trim($this->headImgUrl) != '') {
            return $this->headImgUrl;
        }
        return $faceIcon;
    }


    /**
     * @return mixed
     * 获取真实姓名
     */
    public function getTrueName()
    {
        return $this->trueName;
    }


    /**
     * @inheritdoc
     * @return SeUserinfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeUserinfoQuery(get_called_class());
    }

    /**
     * 获取单个用户信息
     * @param integer $userId 用戶ID
     * @param integer $schoolId 學校ID
     * @return array|SeUserinfo|null
     */
    public static function getOne(int $userId, int $schoolId)
    {
        return self::find()->where(['userID' => $userId, 'schoolID' => $schoolId, 'disabled' => self::IS_DELETE])->limit(1)->one();
    }

    /**
     * 获取 se_userControl 信息
     * @return \yii\db\ActiveQuery
     */
    public function getSeUserControl()
    {
        return $this->hasMany(SeUserControl::className(), ["userID" => "userID"]);
    }

    /**
     * 获取 se_classMembers
     * @return \yii\db\ActiveQuery
     */
    public function getSeClassMembers()
    {
        return $this->hasMany(SeClassMembers::className(), ["userID" => "userID"]);
    }


    /**
     * 查询用户是否存在班级
     * @return mixed
     */
    public function IsExistClass()
    {
        return $this->getSeClassMembers()->exists();
    }

    /**
     * 学生调班时班级信息的修改
     * @param $classID
     */
    public function updateClassMember($classID)
    {

        $classMember = SeClassMembers::find()->where(['userID' => $this->userID, 'identity' => 20403])->limit(1)->one();

        $classMember->classID = $classID;
        $classMember->save(false);
    }

    /**
     * 获取 se_groupMembers
     * @return \yii\db\ActiveQuery
     */
    public function getSeGroupMembers()
    {
        return $this->hasMany(SeGroupMembers::className(), ["teacherID" => "userID"]);
    }


    /**
     * 全校该学科所有教师
     * @param int $schoolId
     * @param string $subjectId
     * @return array|SeUserinfo[]
     */
    public static function getSchoolTeacher($schoolId, $subjectId)
    {
        $teacherList = self::find()->where(['schoolID' => $schoolId, 'subjectID' => $subjectId, 'type' => 1, 'disabled' => 0])->asArray()->select('userID')->all();
        //增加一个空选项值
        $teacherList[]['userID'] = 0;
        return $teacherList;
    }

    /**
     * 查询学生的家长
     * @param $userId
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getParentAccount($userId)
    {
        return self::findBySql("SELECT se_userinfo.phoneReg
                                  FROM se_userinfo
                                  INNER JOIN se_userChildRel
                                   ON se_userinfo.userID =se_userChildRel.parentUserID
                                  WHERE se_userChildRel.userID = :userId", [":userId" => $userId])->limit(1)->one();

    }


    /**
     * 根据用户id和学校id 获取 教师部分信息
     *  ！！！该条查询可以添加相关数据，请勿删除其中数据！！！
     * @param integer $userId 用户id
     * @param integer $schoolId 学校id
     * @param integer $type 用户身份 0学生， 1教师
     * @return array|SeUserinfo|null
     */

    public static function accordingToUserIdAndSchoolIdToGetSomeInformation(int $userId, int $schoolId, int $type)
    {
        return self::find()->where(["userID" => $userId, "schoolID" => $schoolId, "type" => $type])->select("userID,trueName,department,sex,subjectID,bindphone,textbookVersion,phoneReg")->limit(1)->one();
    }

    /**
     * 根据用户id和学校id 获取 教师的userId和真实姓名
     * @param integer $userId 用户id
     * @param integer $schoolId 学校id
     * @param integer $type 用户身份 0学生， 1教师
     * @return array|SeUserinfo|null
     */
    public static function accordingToUserIdAndSchoolIdToGetUserIdAndTrueName(int $userId, int $schoolId, int $type)
    {
        return self::find()->where(['userID' => $userId, 'schoolID' => $schoolId, 'type' => $type])->select('userID,trueName')->limit(1)->one();
    }

    /**
     * 根据用户id和学校id 修改 用户密码为12345
     * @param integer $userId 用户id
     * @param integer $schoolId 学校id
     * @param integer $type 用户身份 0学生， 1教师
     * @return int
     */
    public static function accordingUserIdAndSchoolIdUpdatePassword(int $userId, int $schoolId, int $type)
    {
        return self::updateAll(['passWd' => self::GetDefaultPassword(), 'updateTime' => DateTimeHelper::timestampX1000()], 'userID=:userId and schoolID=:schoolId and type=:type', [':userId' => $userId, ':schoolId' => $schoolId, ':type' => $type]);
    }

    /**
     * 修改密码公共
     * @return string
     */
    public static function GetDefaultPassword()
    {
        return strtoupper(md5('123456'));
    }

    /**
     * 检测账号是否存在
     * wgl
     * @param string $phoneReg 账号
     * @return bool
     */
    public static function existsPhoneReg(string $phoneReg)
    {
        return self::find()->where(['phoneReg' => $phoneReg])->exists();
    }

    /**
     * 根据账号查询详情
     * wgl
     * @param string $phoneReg 账号
     * @return array|SeUserinfo|null
     */
    public static function accordingPhoneRegGetUserInfo(string $phoneReg)
    {
        return self::find()->where(['phoneReg' => $phoneReg])->limit(1)->one();
    }


    /**
     * 根据用户id和学校id 获取 用户信息
     * wgl
     * @param integer $userId 用户id
     * @param integer $schoolId 学校id
     * @return array|SeUserinfo|null
     */
    public static function accordingUserIdAndSchoolIdGetUserInfo(int $userId, int $schoolId)
    {
        return self::find()->where(['userID' => $userId, 'schoolID' => $schoolId])->active()->asArray()->limit(1)->one();
    }

    /**
     * 查询用户详情
     * @param integer $userId 用户id
     * @return array|SeUserinfo|null
     */
    public static function getUserDetails(int $userId)
    {
        return self::find()->where(['userID' => $userId])->limit(1)->one();
    }

    /**
     * 关键字搜索 学校教师
     * @param string $keywords 搜索关键字
     * @param int $schoolId 学校id
     * @return array|SeUserinfo[]
     */
    public static function searchTeacher(string $keywords, int $schoolId)
    {
        return self::find()->where(['phoneReg' => $keywords])->orWhere(['trueName' => $keywords])->orWhere(['bindphone' => $keywords])->andWhere(['type' => 1, 'schoolID' => $schoolId])->all();
    }

    /**
     * 检索学生的绑定手机号
     * @param string $phone 手机号
     * @return array|SeUserinfo[]
     */
    public static function searchStudentPhone(string $phone)
    {
        return self::find()->where(['bindphone' => $phone, 'type' => '0'])->all();
    }


    /**
     * 判断用户是否存在
     * @param int $userId
     * @return bool
     */
    public static function isExistUser(int $userId)
    {
        return self::find()->where(['userID' => $userId])->andWhere(['type' => self::TYPE_TEACHER])->active()->exists();
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\AttributeBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['createTime', 'updateTime'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updateTime'],
                ],
                'value' => DateTimeHelper::timestampX1000(),
            ],
        ];
    }

    /**
     * 创建用户邀请码
     * @param int $userId 用户id
     * @return string
     */
    public static function getUserInviteCode(int $userId)
    {
        $userInviteCode = '';
        $userInviteCodeArray = StringHelper::short($userId);
        //判断邀请码是否已经存在，若存在取邀请码数组的第二个元素，不存在取第一个元素，以此类推
        foreach ($userInviteCodeArray as $code) {
            $userInfoModel = self::getUserByInviteCode($code);
            if ($userInfoModel != null) {
                continue;
            }
            $userInviteCode = $code;
        }
        return $userInviteCode;
    }

    /**
     * 根据邀请码查询用户信息
     * @param string $inviteCode 邀请码　　
     * @return mixed
     */
    public static function getUserByInviteCode(string $inviteCode)
    {
        return SeUserinfo::find()->where(['inviteCode' => $inviteCode])->active()->limit(1)->one();
    }
}

