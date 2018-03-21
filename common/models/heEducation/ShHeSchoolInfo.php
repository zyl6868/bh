<?php

namespace common\models\heEducation;

use yii\db\Exception;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "sh_he_schoolInfo".
 *
 * @property integer $hSchoolId
 * @property string $schoolName
 * @property string $city
 * @property integer $cityCode
 * @property string $province
 * @property integer $provinceCode
 * @property string $country
 * @property integer $countryCode
 * @property string $schoolType
 * @property integer $schoolId
 * @property string $createTime
 * @property string $updateTime
 *
 * @property ShHeClass[] $shHeClasses
 */
class ShHeSchoolInfo extends \yii\db\ActiveRecord
{
    const XIAO_XUE = 20201;
    const CHU_ZHONG = 20202;
    const GAO_ZHONG = 20203;
    const OTHER_TYPE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sh_he_schoolInfo';
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
            [['hSchoolId'], 'required'],
            [['hSchoolId', 'schoolId','cityCode','provinceCode','countryCode'], 'integer'],
            [['createTime', 'updateTime'], 'safe'],
            [['schoolName', 'city','province','country'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'hSchoolId' => 'H School ID',
            'schoolName' => 'School Name',
            'city' => 'City',
            'cityCode' => 'City Code',
            'province' => 'Province ',
            'provinceCode' => 'Province Code',
            'country' => 'Country',
            'countryCode' => 'Country Code',
            'schoolType' => 'School Type',
            'schoolId' => 'School ID',
            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShHeClasses()
    {
        return $this->hasMany(ShHeClass::className(), ['hSchoolId' => 'hSchoolId']);
    }

    /**
     * @inheritdoc
     * @return ShHeSchoolInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShHeSchoolInfoQuery(get_called_class());
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
     * 添加学校
     * @param $heUser
     * @return array|ShHeSchoolInfo|null
     * @throws Exception
     */
    public static function addSchool($heUser){

        $classes = $heUser->education->classes;
        $schoolId = 0;
        $schoolName = '';
        $schoolTypeArr = [];
        foreach ($classes as $key => $item){
            if($key == 0){
                $schoolId = $item->schoolid;
                $schoolName = $item->schoolname;
            }
            $schoolTypeArr[] = self::getSchoolCodeByType($item->schooltype);
        }

        $schoolModel = null;
        $schoolTypeArr = array_filter($schoolTypeArr);
        if($schoolId && !empty($schoolTypeArr)){
            $schoolModel = self::find()->where(['hSchoolId'=>$schoolId])->one();

            if($schoolModel == null){
                $schoolModel = new self();
                self::getDb()->useMaster(function() use ($schoolId,$schoolName,$heUser,$schoolTypeArr,$schoolModel){
                    $schoolModel->hSchoolId = $schoolId;
                    $schoolModel->schoolName = $schoolName;
                    $schoolModel->city = $heUser->education->city;
                    $schoolModel->cityCode = $heUser->education->citycode;
                    $schoolModel->province = $heUser->education->province;
                    $schoolModel->provinceCode = $heUser->education->provincecode;
                    $schoolModel->country = $heUser->education->county;
                    $schoolModel->countryCode = $heUser->education->countycode;
                    $schoolModel->schoolType = implode(',',array_unique($schoolTypeArr));
                    $schoolModel->save(false);
                });
            }
        }else{
            throw new Exception('和教育创建学校schoolId或departmentID为空');
        }
        return $schoolModel;
    }


    /**
     * 根据学校类型返回学校code码
     * @param $schoolType
     * @return int
     */
    public static function getSchoolCodeByType($schoolType){
        $type = '';
        if($schoolType == '小学'){
            $type = self::XIAO_XUE;
        }else if($schoolType == '初中'){
            $type = self::CHU_ZHONG;
        }else if($schoolType == '高中'){
            $type = self::GAO_ZHONG;
        }
        return $type;
    }

}
