<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_classEvent".
 *
 * @property integer $eventID
 * @property string $classID
 * @property string $eventName
 * @property string $time
 * @property string $briefOfEvent
 * @property string $url
 * @property string $timesOfView
 * @property string $createTime
 * @property string $creatorID
 * @property string $isDelete
 * @property mixed eventPic
 */
class SeClassEvent extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_classEvent';
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
     * @return SeClassEventQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeClassEventQuery(get_called_class());
    }

    /**
     * 获取大事记图片
     * @return \yii\db\ActiveQuery
     */
    public function getEventPic(){
        return $this->hasMany(SeClassEventPic::className(),['eventID'=>'eventID']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['briefOfEvent'], 'string'],
            [['eventName'], 'string', 'max' => 200],
            [['url'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'eventID' => '大事记ID',
            'classID' => '班级ID',
            'eventName' => '事件名称',
            'time' => '时间',
            'briefOfEvent' => '事件描述',
            'url' => '照片url',
            'timesOfView' => '阅读次数',
            'createTime' => '信息创建时间',
            'creatorID' => '信息创建人',
            'isDelete' => '是否删除',
        ];
    }


    /**
     * 查询班级大事记列表
     * @param integer $classId 班级ID
     * @return array|SeClassEvent[]
     */
    public function selectClassEventList(int $classId)
    {
        if($classId > 0){
            return self::find()->where(['classID' => $classId])->active()->orderBy('time desc')->limit(10)->all();
        }
        return null;
    }

    /**
     * 随机一条班级大事记
     * @param integer $classId 班级ID
     * @return array|SeClassEvent|null
     */
    public static function randClassEvent(int $classId)
    {
        if($classId > 0){
            return self::find()->where(['classID' => $classId])->active()->orderBy("rand()")->limit(1)->one();
        }
        return null;
    }

    /**
     * 根据大事记id 查询大事记详情
     * wgl
     * @param integer $eventID 大事记id
     * @return array|SeClassEvent|null
     */
    public static function getOneEventDetails(int $eventID)
    {
        if($eventID > 0){
            return self::find()->where(['eventID' => $eventID])->active()->limit(1)->one();
        }
        return null;
    }


    /**
     * 逻辑删除班级大事记
     * wgl
     * @param integer $eventID 大事记id
     * @return int
     */
    public static function deleteEvent(int $eventID)
    {
        return self::updateAll(['isDelete' => 1], ['eventID' => $eventID]);
    }
}
