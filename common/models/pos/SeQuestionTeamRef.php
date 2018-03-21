<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_questionTeamRef".
 *
 * @property string $questionRefID
 * @property string $questionTeamID
 * @property string $questionID
 */
class SeQuestionTeamRef extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_questionTeamRef';
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
     * @return SeQuestionTeamRefQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeQuestionTeamRefQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['questionRefID'], 'required'],
            [['questionRefID', 'questionTeamID', 'questionID'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'questionRefID' => 'Question Ref ID',
            'questionTeamID' => 'Question Team ID',
            'questionID' => 'Question ID',
        ];
    }
}
