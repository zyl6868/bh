<?php
/**
 * Created by PhpStorm.
 * User: yangjie
 * Date: 2017/12/20
 * Time: 下午3:55
 */

namespace common\clients\heEducation;


use common\clients\OrganizationService;
use common\clients\SchoolService;
use common\models\heEducation\ShHeClass;
use common\models\heEducation\ShHeClassMember;
use common\models\heEducation\ShHeSchoolInfo;
use common\models\heEducation\ShHeUserInfo;
use common\models\pos\SeUserinfo;
use frontend\components\User;
use Httpful\Mime;
use Httpful\Request;
use Yii;
use yii\db\Exception;
use yii\db\Transaction;
use yii\helpers\ArrayHelper;

class heEducationService
{

    protected $privatekey = 'COpJlbDWQgaMgxuo';

    const   HE_TEACHER_ROLE = 1;
    const  HE_STUDENT_ROLE = 2;


    public
    function __construct()
    {

    }


    protected
    function getData($result)
    {
        if (isset($result->ret)) {
            return $result->data;
        }
        return null;
    }


    protected
    function getUserinfo(int $he_userId)
    {
        $parameters = ['API_KEY' => 'b836dfd489371283c3cf39882e891908',
            'Operate' => 'ApUserData.getDataByUid',
            'Time' => gettimeofday(true),
            'Uid' => $he_userId,
            'From' => 'bhw',
            'Args' => 'uid,role,name,education',
        ];

        $parameters['Sign'] = $this->getSign($parameters, $this->privatekey);

        try {
            $result = Request::post('http://jl.jiaxiaoquan.com/apps/openapi/api.php')
                ->body(http_build_query($parameters))
                ->sendsType(Mime::FORM)
                ->expectsType('json')
                ->send();

            return $this->getData($result->body);

        } catch (Exception $e) {
            return null;
        }

    }


    /**
     *
     * @param integer $uid
     * @return User|null|\yii\web\IdentityInterface
     */
    public function getLoginUser(int $uid)
    {
        $modelSeHeModel = ShHeUserInfo::find()->where(['hUserId' => $uid])->one();
        if ($modelSeHeModel != null && $modelSeHeModel->isFinish == ShHeUserInfo::IS_FINISH) {
            return User::findIdentity($modelSeHeModel->userId);
        }
        return $this->createHeUser($modelSeHeModel,$uid);

    }

    /**
     * @param array $parameters
     * @return bool
     */
    public
    function verificationInput(array $parameters): bool
    {
        if (is_array($parameters) && array_key_exists('sign', $parameters)) {
            ArrayHelper::removeValue($parameters, null);
            $sign = ArrayHelper::remove($parameters, 'sign', '');
            $outSign = $this->getSign($parameters, $this->privatekey);
            return $sign == $outSign;
        }

        return false;
    }


    /**
     * 创建和教育用户和班海的对应关系
     * @param array|ShHeUserInfo|null $modelSeHeModel
     * @param integer $userId
     * @return User|null|\yii\web\IdentityInterface
     */
    protected
    function createHeUser($modelSeHeModel,int $userId)
    {
        /** @var Transaction $transaction */
        $transaction = Yii::$app->db_he_edu->beginTransaction();
        $userInfoModel = null;

        try {

            if($modelSeHeModel == null){
                $heUser = $this->getUserinfo($userId);

                if(!$heUser || !isset($heUser->education) || !isset($heUser->education->classes)){
                   throw new Exception('获取用和教育户信息失败');
                }

                //存入信息
                $schoolModel = ShHeSchoolInfo::addSchool($heUser);
                $modelSeHeModel = ShHeUserInfo::addHeUser($heUser, $schoolModel);
                $classModelArr = ShHeClass::addClass($heUser);
                ShHeClassMember::addClassMember($heUser);

            }else{
                $schoolModel = ShHeSchoolInfo::find()->where(['hSchoolId'=>$modelSeHeModel->hSchoolId])->one();
                $classIds = ShHeClassMember::find()->select('hClassId')->where(['hUserId'=>$userId])->asArray()->all();
                $classModelArr = ShHeClass::find()->where(['hClassId'=>$classIds])->andWhere('classNumber>0 and gradeId>0 and joinYear>0')->all();
            }

            $userInfoModel = $this->createBHInfo($modelSeHeModel,$schoolModel,$classModelArr);
            if($userInfoModel == null){
                throw new Exception('添加班海用户信息失败');
            }

            $transaction->commit();
        }catch (Exception $e) {

            Yii::error('添加信息失败:------' . $e->getMessage());
            $transaction->rollBack();
        }

        return $userInfoModel;

    }

    /**
     * @param array|ShHeUserInfo|null $modelSeHeModel
     * @param array|ShHeSchoolInfo|null $schoolModel
     * @param array $classModelArr
     * @return User|null|\yii\web\IdentityInterface
     */
    public function createBHInfo($modelSeHeModel,$schoolModel,array $classModelArr){

        $userInfoModel = null;

        //创建班海学校
        if ($schoolModel) {
            $schoolModel = self::createSchool($schoolModel);

            if ($schoolModel->schoolId) {
                //创建班海用户
                if ($modelSeHeModel && empty($modelSeHeModel->userId)) {

                    $userInfoModel = new SeUserinfo();
                    SeUserinfo::getDb()->useMaster(function () use ($modelSeHeModel,$schoolModel,$userInfoModel){
                        $userInfoModel->phoneReg = 'he_' . time();
                        $userInfoModel->passWd = strtoupper(md5(123456));
                        $userInfoModel->trueName = $modelSeHeModel->name;
                        $userInfoModel->subjectID = $modelSeHeModel->subjectId;
                        $userInfoModel->schoolID = $schoolModel->schoolId;
                        $userInfoModel->status1 = SeUserinfo::REGISTER_STATUS_UNFINISHED;
                        $userInfoModel->sex = 0;

                        if ($modelSeHeModel->role == self::HE_TEACHER_ROLE) {
                            $userInfoModel->type = SeUserinfo::TYPE_TEACHER;
                        } else {
                            $userInfoModel->type = SeUserinfo::TYPE_STUDENT;
                        }

                        if ($userInfoModel->save(false)) {
                            ShHeUserInfo::getDb()->useMaster(function ()use($modelSeHeModel,$userInfoModel){
                                $modelSeHeModel->userId = $userInfoModel->userID;
                                $modelSeHeModel->save(false);
                            });
                        }
                    });
                }

                //创建加入班级
                if($modelSeHeModel->userId && !empty($classModelArr)){
                    self::createJoinClass($schoolModel, $classModelArr, (int)$modelSeHeModel->userId);
                    $modelSeHeModel->isFinish = ShHeUserInfo::IS_FINISH;
                    if($modelSeHeModel->save(false)){
                        $userInfoModel = User::findIdentity($modelSeHeModel->userId);
                    }
                }

            }
        }
        return $userInfoModel;
    }

    /**
     * 创建学校
     * @param  ShHeSchoolInfo $schoolModel
     * @return mixed
     * @throws Exception
     */
    public static function createSchool(ShHeSchoolInfo $schoolModel)
    {

        $schoolService = new SchoolService();
        $schoolArr = [
            'schoolName' => $schoolModel->schoolName,
            'nickName' => '',
            'department' => $schoolModel->schoolType,
            'lengthOfSchooling' => '20501',
            'schoolAddress' => '',
            'brief' => '',
            'provience' => $schoolModel->provinceCode,
            'city' => $schoolModel->cityCode,
            'country' => $schoolModel->countryCode,
            'ispass' => 2,
            'creatorID' => 300,
            'disabled' => 1,
            'trainingSchool' => 0,
            'schoolType' => 0
        ];

        if (empty($schoolModel->schoolId)) {

            try{
                $schoolResult = $schoolService->CreateSchool(json_encode($schoolArr));
                if ($schoolResult->success) {
                    $schoolInfo = $schoolResult->data;
                    $schoolModel->schoolId = $schoolInfo->schoolID;
                    $schoolModel->save(false);
                }else{
                    throw new Exception('和教育调用服务创建学校失败:' .$schoolResult->message);
                }

            }catch (Exception $e){
                throw new Exception('和教育调用服务创建学校失败:' .$e->getMessage());
            }
        }

        return $schoolModel;
    }

    /**
     * 创建班级
     * @param ShHeSchoolInfo $schoolModel
     * @param array $classModelArr
     * @param integer $userId
     * @return bool
     * @throws \Exception
     */
    public static function createJoinClass(ShHeSchoolInfo $schoolModel,array $classModelArr,int $userId)
    {
        $schoolID = $schoolModel->schoolId;
        $department = $schoolModel->schoolType;

        foreach ($classModelArr as $v) {
            $gradeId = $v->gradeId;
            $classNumber = $v->classNumber;
            $joinYear = $v->joinYear;

            try{
                $organizationModel = new OrganizationService();
                $classResult = $organizationModel->ClassAddTeacher($userId,(int) $classNumber,(int) $department,(int) $gradeId,(int) $joinYear,(int)$schoolID);
                if ($classResult->success == true) {
                    $classInfo = $classResult->data;
                    $v->classId = $classInfo->classID;
                    $v->save(false);
                }
            }catch (\Exception $e){
                throw new Exception('和教育创建班海加入班级信息失败:'.$classResult.'-'.$schoolID.'-'. $gradeId.'-'.$department.'-'.$classNumber. '-'.$joinYear.'-'. $userId);
            }
        }
    }


    /**
     *
     * 签名生成
     * @param array $data
     * @param string $privateKey
     * @return string
     */
    private
    function getSign(array $data, string $privateKey): string
    {

        ksort($data);
        reset($data);

        $s = '';
        foreach ($data as $key => $value) {
            $s .= $key . '=' . $value . '&';
        }
        return md5($s . $privateKey);
    }

    public function ToSign(array $data): string
    {

        return $this->getSign($data, $this->privatekey);


    }


}