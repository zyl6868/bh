<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_classEventPic".
 *
 * @property integer $id
 * @property integer $eventID
 * @property string $picUrl
 * @property integer $picId
 * @property integer $createTime
 */
class SeClassEventPic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_classEventPic';
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
            [['eventID', 'picId', 'createTime'], 'integer'],
            [['picUrl'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'eventID' => 'Event ID',
            'picUrl' => 'Pic Url',
            'picId' => 'Pic ID',
            'createTime' => 'Create Time',
        ];
    }

    /**
     * @inheritdoc
     * @return SeClassEventPicQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeClassEventPicQuery(get_called_class());
    }

    /**
     * @param $eventID
     * @return array|SeClassEventPic[]
     * 首页，根据id查询事件
     */
    public static function  eventPic($eventID){
        return seClassEventPic::find()->where(['eventID'=>$eventID])->all();
    }
}
