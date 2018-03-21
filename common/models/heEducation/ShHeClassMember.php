<?php

namespace common\models\heEducation;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "sh_he_classMember".
 *
 * @property integer $hUserId
 * @property integer $hClassId
 * @property string $createTime
 * @property string $updateTime
 *
 * @property ShHeUserInfo $hUser
 * @property ShHeClass $hClass
 */
class ShHeClassMember extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sh_he_classMember';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_he_edu');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hUserId'], 'required'],
            [['id', 'hUserId', 'hClassId'], 'integer'],
            [['createTime', 'updateTime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'H ID',
            'hUserId' => 'H User ID',
            'hClassId' => 'H Class ID',
            'subject' => 'Subject',
            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHUser()
    {
        return $this->hasOne(ShHeUserInfo::className(), ['hUserId' => 'hUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHClass()
    {
        return $this->hasOne(ShHeClass::className(), ['hClassId' => 'hClassId']);
    }

    /**
     * @inheritdoc
     * @return ShHeClassMemberQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShHeClassMemberQuery(get_called_class());
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\AttributeBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['createTime','updateTime'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updateTime'],
                ],
                'value' => date('Y-m-d H:i:s',time()),
            ],
        ];

    }

    public static function addClassMember($heUser){
        $heUserId = $heUser->uid;
        $classes = [];
        if($heUser->education){
            $classes = $heUser->education->classes;
        }

        foreach ($classes as $item){
            $classModel = self::find()->where(['hClassId'=>$item->classid,'hUserId'=>$heUserId])->one();

            if($classModel == null){
                $hClassModel = new self();
                self::getDb()->useMaster(function () use ($heUserId,$item,$hClassModel){
                    $hClassModel->hUserId = $heUserId;
                    $hClassModel->hClassId = $item->classid;
                    $hClassModel->save(false);
                });

            }

        }
    }

}
