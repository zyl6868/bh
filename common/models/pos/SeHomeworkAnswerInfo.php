<?php

namespace common\models\pos;

use common\helper\DateTimeHelper;
use common\models\sanhai\ShTestquestion;
use common\clients\JfManageService;
use frontend\services\pos\pos_HomeWorkManageService;
use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "se_homeworkAnswerInfo".
 *
 * @property integer $homeworkAnswerID
 * @property integer $homeworkId
 * @property integer $getType
 * @property integer $studentID
 * @property string $homeworkScore
 * @property integer $uploadTime
 * @property integer $isCheck
 * @property integer $teacherID
 * @property integer $checkTime
 * @property string $summary
 * @property integer $isDelete
 * @property integer $isUploadAnswer
 * @property string $otherHomeworkAnswerID
 * @property integer $relId
 * @property int $correctLevel
 * @property int $correctRate
 */
class SeHomeworkAnswerInfo extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_homeworkAnswerInfo';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_school');
    }

    /**
     * @return \yii\db\ActiveQuery
     * 根据relId 查询se_homework_teacher表信息
     */
    public function getHomeWorkTeacher()
    {
        return $this->hasOne(SeHomeworkTeacher::className(), ['id' => 'homeworkId'])
            ->viaTable('se_homework_rel', ['id' => 'relId']);

    }

    /**
     *主观题批改完成以后修改表状态
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function updateInfoStatus(){
        if($this->isCheck==0) {

            $this->isCheck = 1;
            $this->teacherID=user()->id;
            //批改作业增加积分
            $jfHelper=new JfManageService();
            $jfHelper->addJfXuemi('pos-correctWork',user()->id);
        }
        $homeworkServer = new pos_HomeWorkManageService();
        $homeworkServer->autoHomeworkCorrectResult($this->homeworkAnswerID);
        $this->checkTime = DateTimeHelper::timestampX1000();
    }

    /**
     * 纸质作业
     * @return \yii\db\ActiveQuery
     */
    public function getHomeworkAnswerDetailImage()
    {
        return $this->hasMany(SeHomeworkAnswerDetailImage::className(), ['homeworkAnswerID' => 'homeworkAnswerID']);
    }

    /**
     * 电子作业
     * @return \yii\db\ActiveQuery
     */
    public function getHomeworkAnswerImage()
    {
        return $this->hasMany(SeHomeworkAnswerImage::className(), ['homeworkAnswerID' => 'homeworkAnswerID']);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHomeworkAnswerQuestionAll()
    {
        return $this->hasMany(SeHomeworkAnswerQuestionAll::className(), ['homeworkAnswerID' => 'homeworkAnswerID']);
    }

    /**
     * 获取该答题卡
     * @return \yii\db\ActiveQuery
     */
    public function getHomeworkAnswerCorrectAudio()
    {
        return $this->hasMany(SeHomeworkAnswerCorrectAudio::className(),['homeworkAnswerID' => 'homeworkAnswerID']);
    }

    /**
     * 生成作业答题卡
     * @return array
     */
    public function getHomeworkQuestion()
    {
        //作业推送到班级
        $homeworkRel = SeHomeworkRel::find()->where(['id' => $this->relId])->limit(1)->one();
        $homeworkID = $homeworkRel->homeworkId;

        //作业下的题目
        $homeworkQuestionList = SeHomeworkQuestion::find()->where(['homeworkId' => $homeworkID])->all();

        $questionArr = [];
        foreach ($homeworkQuestionList as $mainQuestion) {

            $childQuestionList = ShTestquestion::find()->where(['mainQusId' => $mainQuestion->questionId])->all();

            if (empty($childQuestionList)) {
                //无小题
                $questionArr[] = $mainQuestion->questionId;
            } else {
                //有小题
                foreach ($childQuestionList as $childQuestion) {
                    $questionArr[] = $childQuestion->id;
                }
            }

        }
        return $questionArr;
    }



    /**
     * @inheritdoc
     * @return SeHomeworkAnswerInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeHomeworkAnswerInfoQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['homeworkAnswerID'], 'required'],
            [['homeworkAnswerID'], 'integer'],
            [['homeworkId', 'studentID', 'homeworkScore', 'uploadTime', 'teacherID', 'checkTime'], 'string', 'max' => 20],
            [['getType', 'isCheck', 'isDelete', 'isUploadAnswer'], 'string', 'max' => 2],
            [['correctLevel'], 'integer', 'max' => 6],
            [['summary'], 'string', 'max' => 500],
            [['otherHomeworkAnswerID'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'homeworkAnswerID' => '作业答案ID',
            'homeworkId' => '作业ID',
            'getType' => '作业类型（0上传，1组卷）',
            'studentID' => '学生ID',
            'homeworkScore' => '作业分数',
            'uploadTime' => '上传时间',
            'isCheck' => '是否批阅0未批 1已批',
            'teacherID' => '批阅教师ID',
            'checkTime' => '批阅时间',
            'summary' => '总结',
            'isDelete' => '是否已删除',
            'isUploadAnswer' => '是否有答案，有此条记录时就为1',
            'otherHomeworkAnswerID' => '他人答案Id',
            'relId' => '',
            'correctLevel' => '0未分等级，1差，2中，3良，4优'
        ];
    }

    /**
     * @param integer $k 学生id
     * @param integer $relId
     * @return array|SeHomeworkAnswerInfo|null
     * 查询学生所答的每到题的信息
     */
    public static function homeworkAnswerID(int $k,int $relId){
        return self::find()->select('homeworkAnswerID')->where(['studentID'=>$k,'relId'=>$relId])->answerStatus()->limit(1)->one();
    }

    /**
     * 获取该作业答题总数
     * @param integer $relId 班级作业ID
     * @return int|string
     */
    public static function getFinishHomeworkTotalNum(int $relId){
        if($relId > 0){
            $data = self::find()->where(['relId' => $relId ,'isCheck'=>1])->count();
            return $data;
        }
        return null;
    }

    /**
     * 获取该作业客观题回答人数
     * @param integer $relId
     * @return int|string
     */
    public static function getUploadHomeworkNum(int $relId){
        $data = self::find()->where(['relId' => $relId ,'isUploadAnswer'=>1])->count();
        return $data;
    }

    /**
     * 获取比当前用户正确率高的人数
     * @param integer $relId 班级作业ID
     * @param integer $nowTeamNum 当前梯队数
     * @return int|string
     */
    public static function getFinishHomeworkOverNum(int $relId , int $nowTeamNum){
        $data = self::find()->where(['relId' => $relId,'isCheck'=>1])->andWhere(['>','correctRate',$nowTeamNum])->count();
        return $data;
    }

    /**
     * 获取作业详情
     * @param integer $homeworkAnswerId 作业答案id
     * @return array|SeHomeworkAnswerInfo|null
     */
    public static function getHomeworkInfoDe(int $homeworkAnswerId)
    {
        if($homeworkAnswerId > 0){
            return self::find()->where(['homeworkAnswerID' => $homeworkAnswerId])->limit(1)->one();
        }
        return null;
    }

    /**
     * 根据relId 获取作答列表
     * @param integer $relId 作答id
     * @param integer $type 已批1/未批0
     * @return array|SeHomeworkAnswerInfo[]
     */
    public static function getHomeworkInfoList(int $relId, int $type)
    {
        $homeworkInfoList = self::find()->where(['relId' => $relId,'isUploadAnswer'=>1,'isCheck'=>$type])->all();
        if($type == 0){
            $homeworkInfoList = self::find()->where(['relId' => $relId,'isUploadAnswer'=>1])->andWhere(["isCheck" => [0,2]])->all();
        }
        return $homeworkInfoList;
    }

    /**
     * 根据作答id和学生id获取作答详情
     * @param string $relId 作答id
     * @param string $studentId 学生id
     * @return array|SeHomeworkAnswerInfo|null
     */
    public static function accordingToRelIdAndStudentIdGetHomeworkAnswerInfo($relId, $studentId)
    {
        return self::find()->where(['relId' => $relId, 'studentId' => $studentId])->limit(1)->one();
    }

    /**
     * 获取学生的作业优秀率 （数）
     * @param string $userId 用户id
     * @param string $startTime 开始时间（周一）
     * @param string $endTime 结束时间（周日）
     * @return array|SeHomeworkAnswerInfo[]
     */
    public static function getStudentHomeworkProficiencyOfStatistical($userId, $startTime, $endTime)
    {
        return self::find()->where(['studentID' => $userId, 'isDelete' => 0, 'isCheck' => 1, 'isUploadAnswer'=>1])->andWhere(['between', 'checkTime', $startTime, $endTime])->andWhere(['>', 'correctLevel', 0])->groupBy('correctLevel')->select('correctLevel,COUNT(*) countMem')->asArray()->all();
    }
}
