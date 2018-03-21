<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_questionDeliverStu".
 *
 * @property string $deliverID
 * @property string $notesID
 * @property string $studentID
 * @property string $questionTeamID
 */
class SeQuestionDeliverStu extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_questionDeliverStu';
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
     * @return SeQuestionDeliverStuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeQuestionDeliverStuQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deliverID'], 'required'],
            [['deliverID', 'notesID', 'studentID', 'questionTeamID'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'deliverID' => 'Deliver ID',
            'notesID' => 'Notes ID',
            'studentID' => 'Student ID',
            'questionTeamID' => 'Question Team ID',
        ];
    }
}
