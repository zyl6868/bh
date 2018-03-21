<?php

namespace common\models\pos;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "se_questionGroup".
 *
 * @property integer $groupId
 * @property integer $userId
 * @property integer $subjectId
 * @property integer $departmentId
 * @property string $groupName
 * @property integer $groupType
 * @property integer $updateTime
 * @property integer $createTime
 */
class SeQuestionGroup extends \yii\db\ActiveRecord
{
    /**
     *0 默认我的收藏分组类型
     */
    const DEFAULT_GROUP_TYPE = 0;
    /**
     *1 自定义分组类型
     */
    const DEFINE_GROUP_TYPE = 1;
    /**
     *是删除
     */
    const IS_DELETE = 1;
    /**
     *否删除
     */
    const NOT_DELETE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_questionGroup';
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
            [['groupId', 'userId', 'subjectId', 'departmentId', 'groupName', 'updateTime', 'createTime'], 'required'],
            [['groupId', 'userId', 'subjectId', 'departmentId', 'groupType', 'updateTime', 'createTime'], 'integer'],
            [['groupName'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'groupId' => '题目分组id',
            'userId' => '用户id',
            'subjectId' => '科目id',
            'departmentId' => '学段id',
            'groupName' => '分组名',
            'groupType' => '分组类型：0我的收藏1自定义分组',
            'updateTime' => '更新时间',
            'createTime' => '添加时间',
        ];
    }

    /**
     * @inheritdoc
     * @return SeQuestionGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeQuestionGroupQuery(get_called_class());
    }


    /**
     * 获取我的收藏分组id
     * @param $subjectid
     * @param $departments
     * @return array|SeQuestionGroup|null
     */
    public function collectGroup($userId,$subjectid,$departments)
    {
        return self::find()
            ->where(['userId'=>$userId, 'subjectId'=>$subjectid, 'departmentId'=>$departments, 'groupType'=>self::DEFAULT_GROUP_TYPE])
            ->select('groupId')
            ->one();
    }


    /**
     * 各个学段学科下所有自定义分组信息
     * @param $userId
     * @param $subjectId
     * @param $department
     * @return array|\common\models\pos\SeQuestionGroup[]
     */
    public static function defineGroup($userId, $subjectId, $department)
    {
        $collectGroupQuery = SeQuestionGroup::find()->where(['userId' => $userId, 'subjectId' => $subjectId, 'departmentId' => $department]);
        $customGroupArray = $collectGroupQuery->andWhere(['groupType'=>1])->orderBy('groupType')->orderBy('createTime')->asArray()->indexBy('groupId')->all();
        $groupIdArray = array_column($customGroupArray,'groupId');
        $everyGroupCount = SeQuestionFavoriteFolderNew::everyGroupCount($groupIdArray,$userId);
        foreach($customGroupArray as $key => $value){
            if(empty($everyGroupCount[$key])){
                $customGroupArray[$key]['QuestionNum'] = 0;
            }else{
                $customGroupArray[$key]['QuestionNum'] = $everyGroupCount[$key]['QuestionNum'];
            }
        }
        return $customGroupArray;
    }


    /**
     * 查询分组里的题目数量
     * @param $groupId
     * @return int|string
     */
    public function defGroupQuesNum($groupId){
        if($groupId){
            $questionNum = SeQuestionFavoriteFolderNew::find()->where(['groupId'=>$groupId,'isDelete'=>self::NOT_DELETE])->count();
            return $questionNum;
        }else{
            return 0;
        }
    }


    /**
     * 通过groupId查询groupName
     * @param $groupId
     * @return array|SeQuestionGroup|null
     */
    public function groupName($groupId)
    {
        return self::find()->where(['groupId'=>$groupId])->select('groupName')->limit(1)->one();
    }


    /**
     * 自定义分组个数
     * @return int|string
     */
    public function defineGroupNum($userId)
    {
        return self::find()->where(['userId'=>$userId,'groupType'=>self::DEFINE_GROUP_TYPE])->count();
    }


    /**
     * 根据groupId查询组
     * @param $groupId
     * @return array|SeQuestionGroup|null
     */
    public function groupOne($userId,$groupId)
    {
        return self::find()->where(['groupId'=>$groupId,'userId'=>$userId])->limit(1)->one();
    }


    /**
     * 新建组
     * @param $userId
     * @param $department
     * @param $subjectId
     * @param $groupName
     * @param $groupType
     * @param $createTime
     * @return bool
     */
    public function addGroupNew($userId,$department,$subjectId,$groupName,$groupType,$createTime)
    {
        $this->userId = $userId;
        $this->subjectId = $subjectId;
        $this->departmentId = $department;
        $this->groupName = $groupName;
        $this->groupType = $groupType;
        $this->createTime = $createTime;
        if(self::save(false)) {
            $groupId = $this->attributes['groupId'];
            return $groupId;
        }else{
            return false;
        }
    }


    /**
     * 修改组名
     * @param $groupId
     * @param $groupName
     * @param $updateTime
     * @return bool
     */
    public function modifyGroupName($userId,$groupId,$groupName,$updateTime)
    {
        $groupinfo = $this->groupOne($userId,$groupId);
        $groupinfo->groupName = $groupName;
        $groupinfo->updateTime = $updateTime;
        if($groupinfo->save(false)) {
            return true;
        }else{
            return false;
        }
    }


    /**
     * 删除组
     * @param $groupId
     * @return bool
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function  deleteGroup($userId,$groupId)
    {
        $transaction = Yii::$app->db_school->beginTransaction();
        try {
            $SeQuestionFavoriteFolderNewModel = new SeQuestionFavoriteFolderNew();
            $questionIds = $SeQuestionFavoriteFolderNewModel->questionList($userId,$groupId);
            foreach ($questionIds as $value) {
                $seQuestionFavoriteFolderNewModelOne =SeQuestionFavoriteFolderNew::find()->where(['questionId'=>$value->questionId,'userId'=>$userId])->limit(1)->one();
                $seQuestionFavoriteFolderNewModelOne->isDelete = SeQuestionGroup::IS_DELETE;
                $seQuestionFavoriteFolderNewModelOne->save(false);
            }
            $this->delete();
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
        return true;
    }



}
