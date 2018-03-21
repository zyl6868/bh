<?php

namespace common\models\heEducation;

use common\clients\heEducation\heEducationService;
use common\models\dicmodels\SubjectModel;
use yii\db\Exception;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "sh_he_userInfo".
 *
 * @property integer $hUserId
 * @property string $name
 * @property string $eduName
 * @property integer $role
 * @property integer $subjectId
 * @property integer $hSchoolId
 * @property integer $userId
 * @property integer $isFinish
 * @property string $createTime
 * @property string $updateTime
 *
 * @property ShHeClassMember $shHeClassMember
 */
class ShHeUserInfo extends \yii\db\ActiveRecord
{
    /**
     * 创建完成
     */
    const IS_FINISH = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sh_he_userInfo';
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
            [['hUserId', 'role', 'userId', 'isFinish','subjectId','hSchoolId'], 'integer'],
            [['createTime', 'updateTime'], 'safe'],
            [['name', 'eduName'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'hUserId' => 'H User ID',
            'name' => 'Name',
            'eduName' => 'Edu Name',
            'role' => 'Role',
            'subjectId' => 'Subject ID',
            'hSchoolId' => 'hSchoolId',
            'userId' => 'User ID',
            'isFinish' => 'Is Finish',
            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShHeClassMember()
    {
        return $this->hasOne(ShHeClassMember::className(), ['hUserId' => 'hUserId']);
    }

    /**
     * @inheritdoc
     * @return ShHeUserInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShHeUserInfoQuery(get_called_class());
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

    /**
     * 添加用户
     * @param $heUser
     * @param ShHeSchoolInfo $schoolModel
     * @return array|ShHeUserInfo|null
     * @throws Exception
     */
    public static function addHeUser($heUser,$schoolModel){

        $modelSeHeModel = self::find()->where(['hUserId' => $heUser->uid])->one();
        if ($modelSeHeModel == null) {
            $modelSeHeModel = new self();
            self::getDb()->useMaster(function() use ($heUser,$schoolModel,$modelSeHeModel){

                $modelSeHeModel->hUserId = $heUser->uid;
                $modelSeHeModel->role = $heUser->role;

                if ($heUser->role == heEducationService::HE_TEACHER_ROLE) {
                    if(isset($heUser->education)){
                        $classes = $heUser->education->classes;
                        $subjectName = SubjectModel::model()->getIdBySubjectName((string)$classes[0]->subject) ?: 10010 ;
                        if($subjectName){
                            $modelSeHeModel->subjectId = $subjectName;
                        }else{
                            throw new Exception('没有查到对应的科目,subjectName='.$classes[0]->subject);
                        }
                    }
                }
                $modelSeHeModel->hSchoolId = $schoolModel->hSchoolId;
                $modelSeHeModel->name = $heUser->name;
                $modelSeHeModel->eduName = $heUser->education ? $heUser->education->name : '';
                $modelSeHeModel->save(false);
            });

        }
        return $modelSeHeModel;
    }

}
