<?php

namespace common\models\pos;

use common\models\sanhai\ShTestquestion;
use common\components\WebDataKey;
use Yii;

/**
 * This is the model class for table "{{%se_homework_platform}}".
 *
 * @property string $id
 * @property string $uploadTime
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
 * @property integer $creator
 * @property integer $status
 * @property string $chapterId
 * @property integer $department
 * @property string $sourceHomeworkTeacherId
 * @property string $memo
 * @property integer $level
 * @property integer $sourceType
 * @property integer $difficulty
 * @property string $backendOperater
 * @property integer $homeworkType
 * @property integer $createTime
 * @property integer $updateTime
 * @property integer $showType
 * @property integer $hasMedia
 */
class SeHomeworkPlatform extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%se_homework_platform}}';
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
            [['uploadTime', 'isDelete', 'subjectId', 'gradeId', 'getType', 'author', 'creator', 'status', 'department', 'sourceHomeworkTeacherId', 'level', 'sourceType', 'difficulty', 'backendOperater','homeworkType','createTime','updateTime','showType','hasMedia'], 'integer'],
            [['provience', 'city', 'country', 'version'], 'string', 'max' => 50],
            [['knowledgeId', 'chapterId'], 'string', 'max' => 300],
            [['name'], 'string', 'max' => 200],
            [['homeworkDescribe'], 'string', 'max' => 500],
            [['memo'], 'string', 'max' => 30]
        ];
    }
    public function getHomeworkQuestion()
    {
        return $this->hasMany(SeHomeworkQuestionPlatform::className(), ['homeworkId' => 'id'])->orderBy('orderNumber');
    }

    /**
     * 判断当前作业是否是最近一周内创建的
     * @return bool
     */
    public function isNewHomework(){
        $week_ago = strtotime('-1 week')*1000;
        if($this->uploadTime > $week_ago){
            return true;
        }
        return false;
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

    public  function   getQuestionListKeysCache(){

        $cache = Yii::$app->cache;
        $key = WebDataKey::QUESTION_CHILDREN_PLATFORM_LIST_KEY . $this->id;
        $data = $cache->get($key);
        if ($data == false) {
            $data = $this->getQuestionListKeys();;
            if ($data != null) {
                $cache->set($key, $data, 60);
            }
        }
        return $data;
    }
    public function getQuestionNo($questionId){
        $list= $this->getQuestionListKeysCache();
        if   (array_key_exists($questionId,$list)){

            return   $list[$questionId]->no;
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
            'uploadTime' => 'Upload Time',
            'isDelete' => 'Is Delete',
            'subjectId' => 'Subject ID',
            'provience' => 'Provience',
            'city' => 'City',
            'country' => 'Country',
            'gradeId' => 'Grade ID',
            'version' => 'Version',
            'knowledgeId' => 'Knowledge ID',
            'name' => 'Name',
            'getType' => 'Get Type',
            'author' => 'Author',
            'homeworkDescribe' => 'Homework Describe',
            'creator' => 'Creator',
            'status' => 'Status',
            'chapterId' => 'Chapter ID',
            'department' => 'Department',
            'sourceHomeworkTeacherId' => 'Source Homework Teacher ID',
            'memo' => 'Memo',
            'level' => 'Level',
            'sourceType' => 'Source Type',
            'difficulty' => 'Difficulty',
            'backendOperater' => 'Backend Operater',
            'homeworkType' => 'homeworkType',
            'createTime' => 'createTime',
            'updateTime' => 'updateTime',
            'showType' => '展示类型',
            'hasMedia' => '是否有朗读原音',
        ];
    }

    /**
     * @inheritdoc
     * @return SeHomeworkPlatformQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeHomeworkPlatformQuery(get_called_class());
    }

    /**
     * 根据作业id获取部分内容详情
     * wgl
     * @param integer $homeworkID 作业id
     * @return array|SeHomeworkPlatform|null
     */
    public static function getHomeworkPlatformPortion(int $homeworkID)
    {
        return self::find()->where(['id' => $homeworkID])->select('subjectId,gradeId,version,homeworkDescribe,id,name,difficulty')->limit(1)->one();
    }
}
