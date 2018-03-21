<?php

namespace common\models\pos;

use common\helper\DateTimeHelper;
use Exception;
use Yii;

/**
 * This is the model class for table "se_homework_platform_suggest".
 *
 * @property integer $suggestId
 * @property integer $id
 * @property string $comment
 * @property string $createTime
 * @property string $userID
 */
class SeHomeworkPlatformSuggest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_homework_platform_suggest';
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
            [['id', 'createTime', 'userID'], 'integer'],
            [['comment'], 'string', 'max' => 600]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'suggestId' => 'Suggest ID',
            'id' => 'ID',
            'comment' => 'Comment',
            'createTime' => 'Create Time',
            'userID' => 'User ID',
        ];
    }

    /**
     * @inheritdoc
     * @return SeHomeworkPlatformSuggestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeHomeworkPlatformSuggestQuery(get_called_class());
    }

    /**
     * 添加意见反馈
     * wgl
     * @param integer $homeworkID 作业id
     * @param string $suggestion 内容
     * @param integer $userId 用户id
     * @return bool
     * @throws \yii\db\Exception
     */
    public static function addSuggest(int $homeworkID,string $suggestion,int $userId)
    {
        $tran = self::getDb()->beginTransaction();
        try {
            $model = new SeHomeworkPlatformSuggest();
            $model->id = $homeworkID;
            $model->comment = $suggestion;
            $model->userID = $userId;
            $model->createTime = DateTimeHelper::timestampX1000();
            if ($model->save()) {
                $tran->commit();
                return true;
            }
        }catch (Exception $e) {
            $tran->rollBack();
            return false;
        }
    }
}
