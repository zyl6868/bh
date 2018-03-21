<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_userControl".
 *
 * @property string $userID
 * @property string $phoneReg
 * @property string $email
 * @property string $activateMailCode
 * @property int $generateCodeTime
 * @property string $firstIP
 * @property string $firstTime
 * @property string $lastIP
 * @property string $lastTime
 * @property string $sessionToken
 * @property string $sessionTokenTime
 * @property string $terminal
 * @property string $os
 * @property string $terModel
 * @property integer $id
 * @property string $activateCount
 * @property string $firstFromSource
 * @property string $firstDevice
 *
 */
class SeUserControl extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_userControl';
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
     * @return SeUserControlQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeUserControlQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userID', 'firstIP', 'firstTime','lastIP', 'lastTime', 'sessionTokenTime', 'terminal', 'os', 'terModel'], 'string', 'max' => 30],
            [['phoneReg'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 200],
            [['activateMailCode', 'sessionToken'], 'string', 'max' => 128],
            [['activateCount'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userID' => '用户ID',
            'phoneReg' => 'Phone Reg',
            'email' => '邮箱',
            'activateMailCode' => '邮箱验证码',
            'generateCodeTime' => '邮箱验证码生成时间',
            'lastIP' => '最后一次登录ip',
            'lastTime' => '最后一次登录时间',
            'sessionToken' => 'sessionToken值',
            'sessionTokenTime' => 'sessionToken生成时间',
            'terminal' => '终端类型1：PC浏览器 2：移动APP',
            'os' => '终端系统',
            'terModel' => '终端型号',
            'id' => 'ID',
            'activateCount' => '今日申请手机验证次数',
        ];
    }
}
