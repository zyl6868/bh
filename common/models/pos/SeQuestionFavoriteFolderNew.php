<?php

namespace common\models\pos;

use PhpOffice\PhpWord\Exception\Exception;
use Yii;

/**
 * This is the model class for table "se_questionFavoriteFolderNew".
 *
 * @property integer $collectId
 * @property integer $groupId
 * @property integer $questionId
 * @property integer $createTime
 * @property integer $isDelete
 */
class SeQuestionFavoriteFolderNew extends \yii\db\ActiveRecord
{
    /**
     * 是删除
     */
    const IS_DELETE = 1;

    /**
     * 否删除
     */
    const NOT_DELETE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_questionFavoriteFolderNew';
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
            [['collectId', 'groupId', 'questionId', 'createTime'], 'required'],
            [['collectId', 'groupId', 'questionId', 'createTime', 'isDelete'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'collectId' => '题目收藏夹id',
            'groupId' => '关联分组表groupId',
            'questionId' => '题目id',
            'createTime' => '添加时间',
            'isDelete' => '是否已删除:0否1是',
        ];
    }


    /**
     * @inheritdoc
     * @return SeQuestionFavoriteFolderNewQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeQuestionFavoriteFolderNewQuery(get_called_class());
    }


    /**
     * 分组下的未删除题目id
     * @param $groupId
     * @return array|SeQuestionFavoriteFolderNew[]
     */
    public function questionIdList($userId,$groupId)
    {
        return self::find()
            ->where(['userId'=>$userId,'groupId'=>$groupId, 'isDelete'=>self::NOT_DELETE])
            ->select('questionId')
            ->asArray()
            ->all();
    }


    /**
     * 选择要删除的题目
     * @param $groupId
     * @param $questionsIds
     * @return array|SeQuestionFavoriteFolderNew[]
     */
    public function selectQuestion($userId,$groupId,$questionsIds)
    {
        return self::find()
            ->where(['userId'=>$userId,'groupId'=>$groupId,'questionId'=>$questionsIds])
            ->all();
    }


    /**
     * 分组下的未删除题目记录
     * @param $groupId
     * @return array|SeQuestionFavoriteFolderNew[]
     */
    public function questionList($userId,$groupId)
    {
        return self::find()
            ->where(['userId'=>$userId,'groupId'=>$groupId, 'isDelete'=>self::NOT_DELETE])
           // ->select('questionId')
            ->all();
    }


    /**
     * 批量移动题目
     * @param $questionIds
     * @param $groupId
     * @return bool
     * @throws \yii\db\Exception
     */
    public function moveQuestionGroup($userId, $questionIds, $groupId)
    {
        if (!is_array($questionIds)) {
            return false;
        }
        $transaction = Yii::$app->db_school->beginTransaction();
        try{
            foreach ($questionIds as $v) {
                self::updateAll(['groupId' => $groupId], ['questionId' => $v, 'userId' => $userId]);
            }
            $transaction->commit();
            return true;
        } catch (Exception $e){
            $transaction->rollBack();
            return false;
        }
        return true;
    }


    /**
     * 批量删除题目
     * @param $questionsIds
     * @param $groupId
     * @return bool
     * @throws \yii\db\Exception
     */
    public function delQuestion($userId,$questionsIds,$groupId)
    {
        $tran = SeHomeworkTeacher::getDb()->beginTransaction();
        try{
            $questionList = $this->selectQuestion($userId,$groupId,$questionsIds);
            foreach ($questionList as $val){
                $val['isDelete'] = self::IS_DELETE;
                $val->save();
            }
            $tran->commit();
            return true;
        } catch (Exception $e){
            $tran->rollBack();
            return false;
        }
    }


    /**
     * 查询用户收藏题目数量
     * @param $userId
     * @return int|string
     */
    public static  function getfavoriteQuestionNum($userId){
        return SeQuestionFavoriteFolderNew::find()->where(['userId'=>$userId,'isDelete'=>self::NOT_DELETE])->count();
    }

    /**
     * 各个分组下的数量
     * @param $groupIdArray
     * @param $userId
     * @return array|SeQuestionFavoriteFolderNew[]
     */
    public static function everyGroupCount($groupIdArray, $userId)
    {
        $everyGroupCount = self::find()->where([ 'userId' => $userId, 'isDelete' => self::NOT_DELETE])->andWhere(['in','groupId',$groupIdArray])->groupBy('groupId')->select('groupId,COUNT(*) QuestionNum')->asArray()->indexBy('groupId')->all();
        return $everyGroupCount;
    }

}
