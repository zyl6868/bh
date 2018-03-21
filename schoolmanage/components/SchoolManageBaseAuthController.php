<?php

namespace schoolmanage\components;

use common\models\pos\SeClass;
use common\models\pos\SeExamSchool;
use common\models\pos\SeSchoolInfo;
use common\models\pos\SeUserinfo;
use schoolmanage\components\behaviors\ControllerAttributeBehavior;
use yii\helpers\ArrayHelper;

/**
 *  学校权限基类 is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class SchoolManageBaseAuthController extends BaseAuthController
{
    /**
     * @var
     */
    public $schoolId;
    /**
     * @var
     */
    public $schoolModel;

    /**
     * @return array
     */
    public function behaviors()
    {

        $parentConfig = parent::behaviors();
        $config = [
            'schoolLoad' => [
                'class' => ControllerAttributeBehavior::className(),
                'attribute' => 'schoolModel',
                'value' => function () {
                    return SeSchoolInfo::find()->where(['schoolID' => loginUser()->schoolID])->one();
                }
            ],
            'schoolIdLoad' => [
                'class' => ControllerAttributeBehavior::className(),
                'attribute' => 'schoolId',
                'value' => function () {
                    return loginUser()->schoolID;
                }
            ],


        ];
        $config = ArrayHelper::merge($parentConfig,$config);
        return $config;

    }


    /**
     * @param integer $schoolExamId 学校考试id
     * @return array|SeExamSchool|null
     * @throws \yii\web\HttpException
     */
    public function getSeExamSchoolModel(int $schoolExamId)
    {
        $seExamSchoolModel = SeExamSchool::find()->where('schoolExamId=:schoolExamId and  schoolId=:schoolId ', [':schoolExamId' => $schoolExamId, ':schoolId' => $this->schoolId])->one();
        if (!$seExamSchoolModel) {
            $this->notFound('不存在考试');
        }
        return $seExamSchoolModel;
    }

    /**
     * 查找班级
     * @param integer $classId 班级ID
     * @return array|SeClass|null
     * @throws \yii\web\HttpException
     */
    public function getSchoolClassModel(int $classId)
    {

        $seClassModel = SeClass::find()->where('classID=:classID ', [':classID' => $classId ])->one();
        if (!$seClassModel) {
        return    $this->notFound('不存在该班级');
        }

        if ($seClassModel->schoolID!=$this->schoolId) {
        return     $this->notFound('不存在该班级');
        }

        return $seClassModel;
    }

    /**
     * 判断用户是否存在和是否在当前学校中
     * @param int $userID 用户ID
     * @return array|SeUserinfo|null|string
     * @throws \yii\web\HttpException
     */
    public function getSchoolUserModel(int $userID){

        $userModel = SeUserinfo::find()->where('userID=:userID',[':userID'=>$userID])->one();

        if(!$userModel){

            return $this->notFound('不存在该用户');
        }
        if($userModel->schoolID!=$this->schoolId){

            return $this->notFound('该用户不在当前学校中');

        }

        return $userModel;
    }

    /**
     * 学校下面的班级  多个
     * @param $classIdArr
     * @return array|\common\models\pos\SeClass[]
     * @throws \yii\web\HttpException
     */
    public function  getSchoolClassModels(array $classIdArr): array{
        $seClassModelList = SeClass::find()->where( ['classID' => $classIdArr ,'schoolId'=>$this->schoolId ])->all();
        return $seClassModelList;
    }

    /**
     * 查找学校人员
     * @param integer $userId 用户ID
     * @return array|SeUserinfo|null
     * @throws \yii\web\HttpException
     */
    public function  getSchoolUser(int $userId){

        $seUserModel = SeUserinfo::find()->where('userID=:userID ', [':userID' => $userId])->one();
        if (!$seUserModel) {
            $this->notFound('不存在该人员');
        }
        if ($seUserModel->schoolID!=$this->schoolId) {
            $this->notFound('不存在该人员');
        }

        return $seUserModel;


    }

    /**
     * 封班判断班级是否在本学校
     * @param $classId
     * @throws \yii\web\HttpException
     */

    public function isClassInSchool($classId){
        $seClassData = SeClass::find()->where(['classID' => $classId])->all();
        if(count($seClassData) != count($classId)){
            $this->notFound('不存在该班级');
        }
        foreach($seClassData as $val){
            if ($val->schoolID != $this->schoolId) {
                $this->notFound('不存在该班级');
            }
        }
    }






}