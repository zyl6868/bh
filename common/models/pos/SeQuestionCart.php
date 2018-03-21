<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_questionCart".
 *
 * @property integer $cartId
 * @property integer $userId
 * @property integer $subjectId
 * @property integer $departmentId
 * @property integer $statusSign
 * @property integer $createTime
 * @property integer $updateTime
 */
class SeQuestionCart extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_questionCart';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_school');
    }
    /**
     *查询选题篮里面的题目
     * @return $this
     */
    public function getQuestionCartQuestion(){
        return $this->hasMany(SeQuestionCartQeustions::className(),['cartId'=>'cartId'])->orderBy('orderNumber');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'subjectId', 'departmentId', 'createTime'], 'required'],
            [['userId', 'subjectId', 'departmentId', 'statusSign', 'createTime', 'updateTime'], 'integer']
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cartId' => '选题篮id',
            'userId' => '用户id',
            'subjectId' => '科目id',
            'departmentId' => '学段id',
            'statusSign' => '状态',
            'createTime' => '添加时间',
            'updateTime' => '修改时间',
        ];
    }

    /**
     * @inheritdoc
     * @return SeQuestionCartQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeQuestionCartQuery(get_called_class());
    }

    /**
     *根据cartID和userID查询记录
     * @param integer $userID
     * @param integer $cartId
     */
    public  static  function  findByUserAndCardId(int $userID,int $cartId)
    {
       return  self::find()->where(['cartId' => $cartId,'userId'=>$userID])->limit(1)->one();
    }
}
