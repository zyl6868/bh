<?php

namespace common\models\pos;

use common\models\sanhai\ShTestquestion;
use Yii;

/**
 * This is the model class for table "se_wrongQuestionBookInfo".
 *
 * @property integer $wrongQuestionId
 * @property integer $wrongSubjectId
 * @property integer $userId
 * @property integer $questionId
 * @property integer $createTime
 * @property integer $updateTime
 * @property integer $isDetete
 */
class SeWrongQuestionBookInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_wrongQuestionBookInfo';
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
            [['wrongSubjectId', 'userId', 'questionId', 'createTime'], 'required'],
            [['wrongSubjectId', 'userId', 'questionId', 'createTime', 'updateTime', 'isDetete'], 'integer']
        ];
    }
    public function getQuestion(){
        return $this->hasOne(ShTestquestion::className(),['id'=>'questionId']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'wrongQuestionId' => '错题记录id',
            'wrongSubjectId' => '错题本科目主键',
            'userId' => '用户id',
            'questionId' => '错题id',
            'createTime' => '创建时间',
            'updateTime' => 'Update Time',
            'isDetete' => '是否删除，0未删除，1已删除',
        ];
    }

    /**
     * @inheritdoc
     * @return SeWrongQuestionBookInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeWrongQuestionBookInfoQuery(get_called_class());
    }

    /**
     * 查询学生个人中心展示的错题id
     * @param integer $userId 用户id
     * @param integer $wrongSubjectId  错题科目的编号
     * @return array|SeWrongQuestionBookInfo[]
     */
    public function selectWrongQuestion($userId, $wrongSubjectId){
        $wrongQuestionQuery = self::find()->where(['userId'=>$userId,'isDetete'=>0]);
        if(!empty($wrongSubjectId)){
            $wrongQuestionQuery->andWhere(['wrongSubjectId' => $wrongSubjectId]);
        }
        $wrongQuestion = $wrongQuestionQuery->orderBy(['createTime' => SORT_DESC, 'questionId' => SORT_ASC])->limit(2)->all();
        if(empty($wrongQuestion)){
            return [];
        }
        return $wrongQuestion;
    }
}
