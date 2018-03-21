<?php
declare(strict_types=1);
namespace common\models\pos;

use Yii;


/**
 * This is the model class for table "se_invite_teacher".
 *
 * @property integer $inviteId
 * @property integer $userId
 * @property string $inviteCode
 * @property integer $inviteeId
 * @property string $inviteeName
 * @property string $inviteePhone
 * @property string $IP
 * @property integer $classId
 * @property integer $operatorId
 * @property integer $isReach
 * @property integer $isAward
 * @property integer $isShow
 * @property string $createTime
 * @property string $updateTime
 */
class SeInviteTeacher extends PosActiveRecord
{
    /**
     *显示记录
     */
    const IS_SHOW = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_invite_teacher';
    }

    /**
     * @return object
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
            [['inviteId', 'userId', 'inviteeId', 'classId', 'operatorId', 'isReach', 'isAward', 'isShow'], 'integer'],
            [['inviteId', 'userId', 'inviteCode', 'inviteeName', 'inviteePhone', 'createTime', 'updateTime'], 'safe'],
            [['inviteCode'], 'string', 'max' => 36],
            [['inviteeName'], 'string', 'max' => 50],
            [['inviteePhone'], 'string', 'max' => 20],
            [['IP'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'inviteId' => '邀请表ID',
            'userId' => '邀请人ID',
            'inviteCode' => '邀请码',
            'inviteeId' => '被邀请人ID',
            'inviteeName' => '被邀请人姓名',
            'inviteePhone' => '被邀请人电话',
            'IP' => '被邀请人IP地址',
            'classId' => '班级ID',
            'operatorId' => '操作人ID',
            'isReach' => '是否达标 0否，1是 ',
            'isAward' => '是否奖励 0否，1是 ',
            'isShow' => '是否显示 0否，1是 ',
            'createTime' => '创建时间',
            'updateTime' => '修改时间',
        ];
    }

    /**
     * @inheritdoc
     * @return SeInviteTeacherQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeInviteTeacherQuery(get_called_class());
    }


    /**
     * 获取邀请的老师列表
     * @param int $userId 邀请人id
     * @return array|SeInviteTeacher[]
     */
    public static function getInviteeByInviterId(int $userId)
    {
        return self::find()->where(['userId'=>$userId])->andWhere(['isShow'=>self::IS_SHOW])->all();
    }


}
