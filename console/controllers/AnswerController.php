<?php
/**
 * Created by wangchunlei
 * User: Administrator
 * Date: 2015/8/6
 * Time: 11:17
 */
namespace console\controllers;

use common\models\pos\SeAnswerQuestion;
use common\models\pos\SeClassMembers;
use common\models\pos\SeSchoolInfo;
use common\components\WebDataCache;
use yii\console\Controller;

class AnswerController extends Controller
{

    /**
     *给学校ID是空的数据添加schoolID
     */
    public function actionAddSchool()
    {
        $answerList = SeAnswerQuestion::find()->where("schoolID is null")->all();
        $result = true;
        foreach ($answerList as $v) {
            $schoolID = WebDataCache::getSchoolIdByUserId($v->creatorID);
            $v->schoolID = $schoolID;
            if (!$v->save()) {
                $result = false;
            }
        }
        if ($result) {
            echo "schoolID success";
        }
    }

    /**
     *给classID是空的数据添加classID
     */
    public function actionAddClass()
    {
        $answerList = SeAnswerQuestion::find()->where("classID is null")->orWhere(["classID" => ""])->all();
        $result = true;
        foreach ($answerList as $v) {
            $userModel = SeClassMembers::find()->where(["userID" => $v->creatorID])->limit(1)->one();
            if ($userModel) {
                $classID = $userModel->classID;
            } else {
                $classID = "";
            }

            $v->classID = $classID;
            if (!$v->save()) {
                $result = false;
            }
        }
        if ($result) {
            echo "classID success";
        }
    }

    /**
     *给答疑表country为空的字段赋值
     */
    public function actionAddCountry()
    {
        $answerList = SeAnswerQuestion::find()->where("country is null")->orWhere(["country" => ""])->all();
        $result = true;
        foreach ($answerList as $v) {
            $schoolInfo = SeSchoolInfo::find()->where(["schoolID" => $v->schoolID])->limit(1)->one();
            if (!empty($schoolInfo)) {
                $country = $schoolInfo->country;
                $v->country = $country;
                if (!$v->save()) {
                    $result = false;
                }
            }
        }
        if ($result) {
            echo "add country success";
        } else {
            echo "add fail";
        }
    }


}