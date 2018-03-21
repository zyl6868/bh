<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_joinPersonInfo".
 *
 * @property integer $ID
 * @property string $lectureID
 * @property string $userID
 * @property string $userName
 * @property string $isDelete
 */
class SeJoinPersonInfo extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_joinPersonInfo';
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
     * @return SeJoinPersonInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeJoinPersonInfoQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'required'],
            [['ID'], 'integer'],
            [['lectureID', 'userID'], 'string', 'max' => 20],
            [['userName'], 'string', 'max' => 50],
            [['isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'id',
            'lectureID' => '听课计划id',
            'userID' => '用户id',
            'userName' => '听课人姓名',
            'isDelete' => '是否删除',
        ];
    }
}
