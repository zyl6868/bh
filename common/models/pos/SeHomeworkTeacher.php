<?php

namespace common\models\pos;

use common\helper\DateTimeHelper;
use common\models\sanhai\ShTestquestion;
use Exception;
use common\components\WebDataKey;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "se_homework_teacher".
 *
 * @property string $id
 * @property string $createTime
 * @property integer $isDelete
 * @property integer $subjectId
 * @property string $provience
 * @property string $city
 * @property string $country
 * @property integer $gradeId
 * @property string $version
 * @property string $knowledgeId
 * @property string $name
 * @property integer $getType
 * @property integer $author
 * @property string $homeworkDescribe
 * @property string $creator
 * @property integer $status
 * @property integer $isSend
 * @property string $pro_homeworkId
 * @property string $chapterId
 * @property string $updateTime
 * @property integer $isShare
 * @property integer $shareAudit
 * @property integer $sourceType
 * @property string $shareAuditTime
 * @property string $difficulty
 * @property  integer $department
 * @property string $homeworkPlatformId
 * @property integer $homeworkType
 * @property integer $showType
 */
class SeHomeworkTeacher extends PosActiveRecord
{

    /**
     * 听力作业
     */
    const LISTEN_HOMEWORK = 2241120;
    /**
     * 口语作业
     */
    const SPOKEN_HOMEWORK = 2241121;
    /**
     * 朗读作业
     */
    const READ_HOMEWORK = 2241130;

    /**
     * 自组作业
     */
    const SELF_HOMEWORK = 2241000;
    /**
     * 10：普通组题类型
     */
    const COMMON_HOMEWORK = 10;
	/**
     *我创建的作业条件
     */
    const  SOURCE_USER = 0;

	/**
     *我收藏的平台作业条件
     */
    const  SOURCE_PLATFORM = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_homework_teacher';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHomeworkRel()
    {
        return $this->hasMany(SeHomeworkRel::className(), ['homeworkId' => 'id']);
    }

    /**
     * @param integer $relId
     * @return SeHomeworkTeacher
     */
    public  static function   getOneByRel(int $relId){
      return  self::findBySql('select * from se_homework_teacher as t where  t.id  in (select homeworkId from  se_homework_rel where id=:relId)', [":relId" => $relId])->limit(1)->one();
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
            [['createTime', 'isDelete', 'subjectId', 'gradeId', 'getType', 'author', 'creator', 'status', 'isSend', 'homeworkPlatformId', 'updateTime', 'isShare', 'shareAudit', 'shareAuditTime', 'sourceType','homeworkType'], 'integer'],
            [['provience', 'city', 'country', 'version'], 'string', 'max' => 50],
            [['knowledgeId'], 'string', 'max' => 300],
            [['name'], 'string', 'max' => 200],
            [['homeworkDescribe'], 'string', 'max' => 500],
            [['chapterId'], 'string', 'max' => 100]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHomeworkImages()
    {
        return $this->hasMany(SeHomeworkImage::className(), ['homeworkId' => 'id']);
    }


    /**
     * @return  Query $this
     */
    public function getHomeworkQuestion()
    {
        return $this->hasMany(SeHomeworkQuestion::className(), ['homeworkId' => 'id'])->orderBy('orderNumber');
    }

    /**
     *  获取作业题表题目
     * @return SeHomeworkQuestion[]
     */
    public function  getHomeworkQuestionCache(){

        $cache = Yii::$app->cache;
        $key = WebDataKey::PLATFORM_HOMEWORK_TEACHER .$this->id ;
        $data = $cache->get($key);
        if ($data == false) {
            $data = $this->getHomeworkQuestion()->all();
            if ($data != null) {
                $cache->set($key, $data, 600);
            }
        }
        return $data;


    }

    //获取平台作业$homeworkId对应的全部的教师作业
    /**
     * @param integer $homeworkId 作业ID
     * @return array|SeHomeworkTeacher[]|mixed
     */
    public static function getPlatformHomeworkTeacherNum(int $homeworkId)
    {
        $cache = Yii::$app->cache;
        $key = WebDataKey::PLATFORM_HOMEWORK_TEACHER . $homeworkId;
        $data = $cache->get($key);
        if ($data == false) {
            $data = SeHomeworkTeacher::find()->where(['homeworkPlatformId' => $homeworkId])->all();
            if ($data != null) {
                $cache->set($key, $data, 600);
            }
        }
        return $data;
    }

    /**
     * @return array
     */
    public function getQuestionListKeys()
    {
        $i = 0;
        $allList = [];
        $homeworkQuestionList = $this->getHomeworkQuestion()->all();
        foreach ($homeworkQuestionList as $v) {
//            判断有没有小题
            $questionResult = ShTestquestion::find()->where(['id' => $v->questionId])->orWhere(['mainQusId' => $v->questionId])->select('id,tqtid,mainQusId')->orderBy('id')->all();

            if ($questionResult) {
                if (count($questionResult) > 1) {

                    foreach ($questionResult as $item) {
                        if ($item->mainQusId > 0) {
                            $i++;
                            $m = new SeHomeworkQuestionNo();
                            $m->no = $i;
                            $m->model = $item;
                            $allList[$item->id] = $m;
                        }
                    }

                } else {
                    $i++;
                    $m = new SeHomeworkQuestionNo();
                    $m->no = $i;
                    $m->model = $questionResult[0];
                    $allList[$questionResult[0]->id] = $m;
                }
            }
        }

        return $allList;
    }

    /**
     * @return array|mixed
     */
    public function getQuestionListKeysCache()
    {

        $cache = Yii::$app->cache;
        $key = WebDataKey::QUESTION_NO_OBJECT_KEY . $this->id;
        $data = $cache->get($key);
        if ($data == false) {
            $data = $this->getQuestionListKeys();
            if ($data != null) {
                $cache->set($key, $data, 3600);
            }
        }
        return $data;
    }

    /**
     * @param integer $questionId 题目ID
     * @return string
     */
    public function getQuestionNo(int $questionId)
    {
        $list = $this->getQuestionListKeysCache();
        if (array_key_exists($questionId, $list)) {

            return $list[$questionId]->no;
        }
        return '';
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'createTime' => '创建时间',
            'isDelete' => '是否删除0：否1：是默认0',
            'subjectId' => '科目id',
            'provience' => '省',
            'city' => '市',
            'country' => '区县',
            'gradeId' => '年级id',
            'version' => '版本',
            'knowledgeId' => '知识点',
            'name' => '作业名称',
            'getType' => '作业组织类型（0上传，1组卷）',
            'author' => '作者（数据字典 0本校 1教师）',
            'homeworkDescribe' => ' 作业简介',
            'creator' => '创建人',
            'status' => '作业状态(0临时，1正式)',
            'isSend' => '是否发送作业， 0未发送，1已发送',
            'homeworkPlatformId' => '作业库作业id',
            'chapterId' => '章节id',
            'updateTime' => '更新时间',
            'isShare' => '是否分享到平台，0未分享，1以分享',
            'shareAudit' => '是否通过审核 0未，1已通过',
            'shareAuditTime' => '共享审核时间',
            'department' => '学部',
            'sourceType' => '作业来源：0个人，1平台',
            'homeworkType' => '作业类型',
            'showType'=>'展示类型'
        ];
    }

    /**
     * @inheritdoc
     * @return SeHomeworkTeacherQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeHomeworkTeacherQuery(get_called_class());
    }


    /**
     * 加入作业
     * @param integer $homeworkID  平台作业ID
     * @param integer $userID 用户ID
     * @return bool
     * @throws \yii\db\Exception
     */
    public static function collectHomework(int $homeworkID ,int $userID)
    {
        $tran = SeHomeworkTeacher::getDb()->beginTransaction();
        try {
            $platDetails = SeHomeworkPlatform::findOne(['id' => $homeworkID]);
            if (empty($platDetails)) {
                return false;
            }
            $teaHom = new SeHomeworkTeacher();
            $teaHom->createTime = DateTimeHelper::timestampX1000();
            $teaHom->subjectId = $platDetails->subjectId;
            $teaHom->provience = $platDetails->provience;
            $teaHom->city = $platDetails->city;
            $teaHom->country = $platDetails->country;
            $teaHom->gradeId = $platDetails->gradeId;
            $teaHom->version = $platDetails->version;
            $teaHom->knowledgeId = $platDetails->knowledgeId;
            $teaHom->name = $platDetails->name;
            $teaHom->getType = $platDetails->getType;
            $teaHom->author = $platDetails->author;
            $teaHom->homeworkDescribe = $platDetails->homeworkDescribe;
            $teaHom->creator = $userID;
            $teaHom->status = $platDetails->status;
            $teaHom->homeworkPlatformId = $platDetails->id;
            $teaHom->chapterId = $platDetails->chapterId;
            $teaHom->difficulty = $platDetails->difficulty;
            $teaHom->department = $platDetails->department;
            $teaHom->knowledgeId = $platDetails->knowledgeId;
            $teaHom->chapterId = $platDetails->chapterId;
            $teaHom->homeworkType = $platDetails->homeworkType;
            $teaHom->showType = $platDetails->showType;
            $teaHom->isShare = 0;
            $teaHom->sourceType = 1;
            if ($teaHom->save(false)) {
                $teacherHomeworkID = $teaHom->id;
                $questionPlatArray = SeHomeworkQuestionPlatform::find()->where(['homeworkId' => $homeworkID])->select('questionId,orderNumber')->asArray()->all();
                if (empty($questionPlatArray)) {
                    return false;
                }
                foreach ($questionPlatArray as $v) {
                    $questionModel = new SeHomeworkQuestion();
                    $questionModel->homeworkId = $teacherHomeworkID;
                    $questionModel->questionId = $v['questionId'];
                    $questionModel->orderNumber = $v['orderNumber'];
                    $questionModel->save(false);
                }
            }
            $tran->commit();
            return true;

        } catch (Exception $e) {
            $tran->rollBack();
            return false;
        }

    }

    /**
     * 获取教师个人创建的作业数
     * @param integer $userId
     * @return int|string
     */
    public static function getCreateHomeworkNum(int $userId)
    {
        return  self::find()->source_user($userId)->count();
    }

    /**
     * @param integer $userId
     * @return int|string
     */
    public static function getCollectHomeworkNum(int $userId)
    {
        return self::find()->source_platform($userId)->count();
    }


    /**
     * 根据作业id 和 用户id 查询平台作业是否加入
     * @param integer $homeworkID 作业id
     * @param integer $userId 用户id
     * @return bool
     */
    public static function checkHomeworkExists(int $homeworkID,int $userId)
    {
        return self::find()->where(['homeworkPlatformId' => $homeworkID, 'creator' => $userId])->exists();
    }

    /**
     * 根据作业id 查询平台作业 获取作业详情
     * wgl
     * @param integer $homeworkId 作业id
     * @return array|SeHomeworkTeacher|null
     */
    public static function getUserIdHomeworkDetail(int $homeworkId)
    {
        return self::find()->where(['homeworkPlatformId' => $homeworkId])->limit(1)->one();
    }

    /**
     * 根据作业id 查询教师布置的作业 获取单个作业详情
     * wgl
     * @param integer $homeworkID 作业id
     * @return array|SeHomeworkTeacher|null
     */
    public static function getHomeworkTeacherDetails(int $homeworkID)
    {
        if($homeworkID > 0){
            return self::find()->where(['id' => $homeworkID])->limit(1)->one();
        }
        return null;
    }

    /**
     * 根据homeworkId 和 用户id查询作业详情
     * @param integer $homeworkId 作业id
     * @param integer $userId 用户id
     * @return array|SeHomeworkTeacher|null
     */
    public static function getUserIdHomeworkTeacherDetails(int $homeworkId,int $userId){
        return self::find()->where([ 'id' => $homeworkId,'creator' => $userId])->limit(1)->one();
    }
}
