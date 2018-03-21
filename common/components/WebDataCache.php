<?php

namespace common\components;

use common\models\dicmodels\DicModelBase;
use common\models\pos\SeClassMembers;
use common\models\pos\SeSchoolInfo;
use common\models\pos\SeUserinfo;
use common\models\sanhai\SeDateDictionary;
use common\models\sanhai\SeSchoolGrade;
use common\models\sanhai\ShTestquestion;
use frontend\components\helper\ImagePathHelper;
use common\models\dicmodels\SubjectModel;
use frontend\models\ScanLoginModel;
use Yii;

/**
 * Created by PhpStorm.
 * User: yang
 * Date: 15-7-13
 * Time: 上午11:46
 */
class WebDataCache
{


    /**
     * 用户名称
     * @param $useId
     * @return string
     */
    public static function getTrueNameByuserId($useId)
    {

        $model = self::getUserModel((int)$useId);

        if ($model) {
            return $model->trueName;
        }
        return '';
    }

    /**
     * 用户名
     * @param $useId
     * @return string
     */
    public static function getUserNameByUserId($useId)
    {

        $model = self::getUserModel((int)$useId);

        if ($model) {
            return $model->phoneReg;
        }
        return '';
    }

    /**
     * 获取用户的真实姓名
     * @param int $userId 用户id
     * @return string
     */
    public static function getUserTrueNameByUserId(int $userId)
    {

        $model = self::getUserModel($userId);

        if ($model) {
            return $model->trueName;
        }
        return '';
    }


    /**
     * 根据邀请码获取用户id
     * @param string $inviteCode
     * @return int
     */
    public static function getUserIdByInviteCode(string $inviteCode): int
    {
        $model = self::getUserModelByInviteCode($inviteCode);

        if ($model != null) {
            return $model->userID;
        }
        return 0;
    }

    /**
     * 根据用户邀请码获取用户
     * @param string $inviteCode 邀请码
     * @return array|SeUserinfo|mixed|null
     */
    public static function getUserModelByInviteCode(string $inviteCode)
    {
        if ($inviteCode == '') {
            return null;
        }
        $cache = Yii::$app->cache;
        $key = WebDataKey::GET_USER_MODEL_BY_INVITE_CODE_CACHE_KEY . $inviteCode;
        $data = $cache->get($key);
        if ($data === false) {
            $data = SeUserinfo::find()->where(['inviteCode' => $inviteCode])->active()->limit(1)->one();
            if ($data != null) {
                $cache->set($key, $data, 600);
            }
        }
        return $data;
    }

    /**
     * 用户科目
     * @param $useId
     * @return string
     */
    public static function getSubjectNameByUserId($useId)
    {

        $model = self::getUserModel((int)$useId);

        if ($model) {
            return SubjectModel::model()->getName((int)$model->subjectID);
        }
        return '';
    }

    /**
     * 根据科目查询学科
     * @param $subjectId
     * @return string
     */
    public static function getSubjectNameById($subjectId)
    {
        return SubjectModel::model()->getName((int)$subjectId);
    }


    /**
     * @param $userId
     * @return array|\common\models\pos\SeUserinfo|mixed|null
     */
    private static function getUserModel(int $userId)
    {

        if ($userId <= 0) {
            return null;
        }
        $cache = Yii::$app->cache;
        $key = WebDataKey::USER_CACHE_KEY . $userId;
        $data = $cache->get($key);
        if ($data === false) {
            $data = \common\models\pos\SeUserinfo::find()->where(['userID' => $userId])->limit(1)->one();
            if ($data != null) {
                $cache->set($key, $data, 600);
            }
        }
        return $data;
    }

    public static function clearUserCache($userId)
    {
        $cache = Yii::$app->cache;
        $key = WebDataKey::USER_CACHE_KEY . $userId;
        $cache->delete($key);

    }


    /**
     * 判断用户身份，0-学生，1-老师
     * @param $userId
     * @return int|string
     */
    public static function getUserType($userId)
    {
        $model = self::getUserModel((int)$userId);
        if ($model) {
            return $model->type;

        }
        return 0;
    }


    /**
     * 获取用户所在的学校id
     */
    public static function getSchoolIdByUserId($userId)
    {
        $model = self::getUserModel((int)$userId);

        if ($model) {
            return $model->schoolID;
        }

        return '';
    }

    /**
     * 获取头像
     */
    public static function getFaceIconUserId($useId, $wh = 0)
    {
        $faceIcon = "/pub/images/tx.jpg";
        $model = self::getUserModel((int)$useId);

        if ($model) {
            if ($model->headImgUrl != null && trim($model->headImgUrl) != '') {
                $faceIcon = $model->headImgUrl;
            }
        }

        if ($wh > 0) {
            return ImagePathHelper::imgThumbnail($faceIcon, $wh, $wh);
        }


        return $faceIcon;
    }

    /**
     * 获取班级头像
     * @param $classId
     * @param int $wh
     * @return string
     */
    public static function getClassFaceIcon($classId, $wh = 0)
    {
        $classFaceIcon = "/static/images/cla.png";

        return $classFaceIcon;
    }

    /**
     * 获取学校头像
     * @param $schoolId
     * @param int $wh
     * @return string
     */
    public static function getSchoolFaceIcon($schoolId, $wh = 0)
    {
        $schoolFaceIcon = "/static/images/sch.png";

        return $schoolFaceIcon;
    }

    /**
     * 获取教研组头像
     * @param $groupId
     * @param int $wh
     * @return string
     */
    public static function getTeaGroupFaceIcon($groupId, $wh = 0)
    {
        $groupFaceIcon = "/static/images/tea.png";

        return $groupFaceIcon;
    }

    /**
     * 班级名称
     * @param $classId
     * @return string
     */
    public static function getClassesNameByClassId($classId)
    {
        if (empty($classId)) {
            return '';
        }

        $model = self::getClassModel((int)$classId);

        if ($model) {
            return $model->className;
        }

        return '';

    }

    /**
     * @param $classId
     * @return array|\common\models\pos\SeClass|mixed|null
     */
    private static function getClassModel(int $classId)
    {
        if (intval($classId) <= 0) {
            return null;
        }

        $cache = Yii::$app->cache;
        $key = WebDataKey::CLASS_CACHE_KEY . $classId;
        $data = $cache->get($key);
        if ($data === false) {
            $data = \common\models\pos\SeClass::find()->where(['classID' => $classId])->limit(1)->one();
            if ($data != null) {
                $cache->set($key, $data, 6000);
            }
        }
        return $data;
    }


    /**
     * 查询班级学生人数
     * wgl
     * @param $classId
     * @return int|mixed|null|string
     */
    public static function getClassStudentMember($classId)
    {
        if (intval($classId) <= 0) {
            return null;
        }

        $cache = Yii::$app->cache;
        $key = WebDataKey::CLASS_STUDENT_MEMBER_CACHE_KEY . $classId;
        $data = $cache->get($key);
        if ($data === false) {
            $data = SeClassMembers::find()->where(['classID' => $classId, 'identity' => '20403'])->andWhere(['>', 'userID', 0])->count();
            if ($data != null) {
                $cache->set($key, $data, 600);
            }
        }
        return $data;
    }

    /**
     * 学校名称
     * @param $schoolId
     * @return string
     */
    public static function getSchoolNameBySchoolId($schoolId)
    {

        $model = self::getSchoolModel($schoolId);

        if ($model) {
            return $model->schoolName;
        }

        return '';

    }

    /**
     * @param $schoolId
     * @return array|\common\models\pos\SeSchoolInfo|mixed|null
     */
    private static function getSchoolModel($schoolId)
    {
        return SeSchoolInfo::getOneCache($schoolId);
    }

    /**
     * 教研组名称
     * @param $groupId
     * @return string
     */
    public static function getTeachingGroupNameByGroupId($groupId)
    {

        $model = self::getGroupModel($groupId);

        if ($model) {
            return $model->groupName;
        }

        return '';

    }

    /**
     * @param $groupId
     * @return array|\common\models\pos\SeTeachingGroup|mixed|null
     */
    private static function getGroupModel($groupId)
    {

        if (intval($groupId) <= 0) {
            return null;
        }

        $cache = Yii::$app->cache;
        $key = WebDataKey::TEACHER_GROUP_CACHE_KEY . $groupId;
        $data = $cache->get($key);
        if ($data === false) {
            $data = \common\models\pos\SeTeachingGroup::find()->where(['ID' => $groupId])->limit(1)->one();
            if ($data != null) {
                $cache->set($key, $data, 6000);
            }
        }
        return $data;
    }

    /**
     * @param $gradeId
     * gradeModel
     */
    public static function getGradeModel($gradeId)
    {

        if (intval($gradeId) <= 0) {
            return null;
        }

        $cache = Yii::$app->cache;
        $key = WebDataKey::GRADE_CACHE_KEY . $gradeId;
        $data = $cache->get($key);
        if ($data === false) {
            $data = SeSchoolGrade::find()->where(['gradeId' => $gradeId])->limit(1)->one();
            if ($data != null) {
                $cache->set($key, $data, 6000);
            }
        }

        return $data;

    }


    /**
     * 根据题型获取showTypeID
     * @param $tqtid
     * @return string
     */
    public static function getShowTypeID($tqtid)
    {
        $result = 0;
        $data = DicModelBase::getDictionaryModel((int)$tqtid);
        if ($data) {
            $result = $data->reserve1;
        }
        return $result;
    }

    /**
     * 根据tqtid判断是否是主观题
     * @param $tqtid
     * @return bool
     */
    public static function isMajorQuestion($tqtid)
    {
        $showTypeID = self::getShowTypeID($tqtid);
        $isMajor = true;
        if ($showTypeID == ShTestQuestion::QUESTION_DAN_XUAN_TI || $showTypeID == ShTestquestion::QUESTION_DUO_XUAN_TI) {
            $isMajor = false;
        }
        return $isMajor;
    }

    /**
     * 获取数据字典名称
     * @param string $secondCode 二级代码
     * @return string
     */
    public static function getDictionaryName($secondCode)
    {
        $data = DicModelBase::getDictionaryModel((int)$secondCode);
        if ($data) {
            return $data->secondCodeValue;
        }
        return '';

    }


    /**
     * 年级名称
     * @param integer $groupId 年級ID
     * @return string
     */
    public static function getGradeName(int $gradeId)
    {

        $model = self::getGradeModel($gradeId);

        if ($model) {
            return $model->gradeName;
        }

        return '';

    }


    /**
     * 获取题目类型名字
     * @param integer $id 题目id
     * @return array|string
     */
    public static function getQuestionTypename(int $id)
    {
        $data = self::getDictionaryName($id);
        return $data;
    }

    /**
     * 获取用户的邀请码
     * @param int $userId
     * @return mixed|string
     */
    public static function getUserInviteCode(int $userId)
    {
        if (intval($userId) <= 0) {
            return '';
        }

        $cache = Yii::$app->cache;
        $key = WebDataKey::GET_USER_INVITE_CODE_CACHE_KEY . $userId;
        $inviteCode = $cache->get($key);

        if ($inviteCode == false) {
            //查询数据库，是否设置了邀请码
            $userInfoModel = SeUserinfo::getUserDetails($userId);
            if (!$userInfoModel->isTeacher()) {
                return '';
            }
            if (!$userInfoModel->inviteCode) {
                $userInfoModel->inviteCode = SeUserinfo::getUserInviteCode($userId);
                $result = $userInfoModel->save(false);

                if ($result == false) {
                    return '';
                }
            }

            $inviteCode = $userInfoModel->inviteCode;
            $cache->set($key, $inviteCode, 6000);
        }
        return $inviteCode;
    }

}