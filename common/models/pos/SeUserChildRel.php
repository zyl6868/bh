<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_userChildRel".
 *
 * @property integer $userChildRelID
 * @property integer $parentUserID
 * @property integer $userID
 * @property integer $createTime
 */
class SeUserChildRel extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_userChildRel';
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
            [['parentUserID', 'userID'], 'required'],
            [['parentUserID', 'userID', 'createTime'], 'integer'],
            [['parentUserID', 'userID'], 'unique', 'targetAttribute' => ['parentUserID', 'userID'], 'message' => 'The combination of Parent User ID and User ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userChildRelID' => 'ID',
            'parentUserID' => '父用户ID',
            'userID' => '孩子用户ID',
            'createTime' => '创建时间',
        ];
    }

    /**
     * @inheritdoc
     * @return SeUserChildRelQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeUserChildRelQuery(get_called_class());
    }

}
