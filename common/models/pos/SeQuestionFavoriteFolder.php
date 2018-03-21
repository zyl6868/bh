<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_questionFavoriteFolder".
 *
 * @property integer $collectID
 * @property string $questionID
 * @property string $userID
 * @property string $createTime
 * @property string $isDelete
 */
class SeQuestionFavoriteFolder extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_questionFavoriteFolder';
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

            [['questionID', 'userID', 'createTime'], 'string', 'max' => 20],
            [['isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'collectID' => 'id',
            'questionID' => '题目id',
            'userID' => '用户id',
            'createTime' => '创建时间',
            'isDelete' => '是否已删除',
        ];
    }

    /**
     * @inheritdoc
     * @return SeQuestionFavoriteFolderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeQuestionFavoriteFolderQuery(get_called_class());
    }
}
