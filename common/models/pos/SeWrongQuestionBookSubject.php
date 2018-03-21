<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_wrongQuestionBookSubject".
 *
 * @property integer $wrongSubjectId
 * @property integer $userId
 * @property integer $subjectId
 * @property integer $questionNum
 * @property integer $createTime
 * @property integer $updateTime
 */
class SeWrongQuestionBookSubject extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_wrongQuestionBookSubject';
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
            [['userId', 'subjectId', 'questionNum', 'createTime'], 'required'],
            [['userId', 'subjectId', 'questionNum', 'createTime', 'updateTime'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'wrongSubjectId' => '错题本科目主键',
            'userId' => '用户id',
            'subjectId' => '科目id',
            'questionNum' => '题目总数',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
        ];
    }

    /**
     * @inheritdoc
     * @return SeWrongQuestionBookSubjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeWrongQuestionBookSubjectQuery(get_called_class());
    }

    /**
     * 根据科目id查询对应的错题科目编号
     * @param integer $userId  用户id
     * @param integer $subjectId  科目id
     * @return array|SeWrongQuestionBookSubject|null
     */
    public function selectWrongSubjectId($userId, $subjectId){
        return self::find()->where(['userId'=>$userId,'subjectId'=>$subjectId])->select('wrongSubjectId')->limit(1)->one();
    }
}
