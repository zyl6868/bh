<?php

namespace frontend\components;

use common\models\pos\SeUserinfo;
use stdClass;


/**
 *
 * Class WebUser
 */
class WebUser
{


    /**
     * @var  SeUserinfo
     */
    private $_model;


    /**
     *  是老师
     * @return bool|int
     */
    function isTeacher()
    {
        $user = $this->getModel();
        if ($user == null) {
            return false;
        } else {
            return $user->type == 1;
        }
    }


    /**
     * 是学生
     * @return bool|int
     */
    function isStudent()
    {
        $user = $this->getModel();
        if ($user == null)
            return false;
        else
            return $user->type == 0;


    }


    function  getEmail()
    {
        $user = $this->getModel();
        if ($user == null)
            return "";
        return $user->email;
    }

    /**
     *  获取学校ID
     * @return string
     */
    function  getSchoolId()
    {
        $user = $this->getModel();
        if ($user == null)
            return '';
        return $user->schoolID;
    }

    /**
     * Login Function
     *
     * @param WebUserIdentity $identity
     * @param int $duration
     */
    public function login($identity, $duration = 0)
    {
        \Yii::$app->getSession()->remove('current_user');
        \Yii::$app->getSession()->add('current_user', $identity->getModel());
        return parent::login($identity, $duration);
    }


    /**
     * Get the Model from the session of Current User
     * @return SeUserinfo
     */
    public function getModel($cache = true)
    {
        if ($cache && $this->_model != null) {
            return $this->_model;
        }

        if ($cache) {
            $info = \Yii::$app->getSession()->get('current_user');
        }

        /** @var UserInfo $info */
        if (!isset($info)) {
            $info = \common\models\pos\SeUserinfo::findOne($this->getId());
            \Yii::$app->getSession()->remove('current_user');
            \Yii::$app->getSession()->add('current_user', $info);
            $this->_model = $info;
        }
        return $info;
    }

    /**
     * Logout Function
     * @param boolean $destroySession destroy the session or not
     */
    public function logout($destroySession = true)
    {
        // I always remove the session variable model.
        \Yii::$app->getSession()->remove('current_user');
        \Yii::$app->session->clear();
        \Yii::$app->session->destroy();

        parent::logout();
    }

    /** 获取指定用户信息
     * @param $id
     * @return common\models\pos\SeUserinfo
     */
    public function getUserModel($id)
    {
        return $this->getUserInfo($id);
    }


    /**
     * 获取头像
     */
    function  getFaceIcon()
    {
        $faceIcon = "";
        $user = $this->getModel();
        if ($user != null) {
            return $user->headImgUrl;
        }
        return $faceIcon;
    }

    /**
     *  获取学校
     * @return array
     */
    function   getSchoolInfo()
    {

        $user = $this->getModel();
        if ($user != null) {
            $result = new stdClass();
            $result->schoolID = $user->schoolID;
            $result->schoolName = $user->getSchoolName();
            return $result;
        }
        return null;
    }

    function  getSchoolName()
    {
        $user = $this->getModel();
        if ($user != null) {
            return $user->getSchoolName();
        }
        return '';
    }

    /**
     * 用户是否该学校中
     * @param $schoolId
     * @return null|UserClass
     */
    function  getIsSchool($schoolId)
    {
        $id = $this->getSchoolId();
        if (empty($id)) {
            return false;
        };
        return $id == $schoolId;
    }

    /**
     * 教师是否是该学校
     * @param $schoolId
     * @return bool
     */
    function  getTeacherInSchool($schoolId)
    {
        return $this->isTeacher() && $this->getIsSchool($schoolId);
    }

    /**
     * 学生是否该学校
     * @param $schoolId
     * @return bool
     */
    function  getStudentInSchool($schoolId)
    {
        return $this->isStudent() && $this->getIsSchool($schoolId);
    }

    /**
     * 获取组信息
     * @return array
     */
    function  getGroupInfo()
    {
        $result = array();
        $user = $this->getModel();
        if ($user != null) {
            return $user->getGroupInfo();
        }
        return $result;
    }

    /**
     * 获取班级信息
     * @return array
     */
    function  getClassInfo()
    {
        $result = array();
        $user = $this->getModel();
        if ($user != null) {
            return $user->getClassInfo();
        }
        return $result;
    }


    /**
     *  用户是否该班中
     * @param $classId
     * @return null|UserClass
     */
    function  getInClassInfo($classId)
    {
        $user = $this->getModel();
        if ($user != null) {
            return $user->getInClassInfo($classId);
        }
        return false;

    }

    /**
     *  用户是否该组中
     * @param $classId
     * @return null|UserClass
     */
    function  getInGroupInfo($groupId)
    {
        $user = $this->getModel();
        if ($user != null) {
            return $user->getInGroupInfo($groupId);
        }
        return null;

    }

    /**
     * @return mixed
     * 获取真实姓名
     */
    function getTrueName()
    {
        $user = $this->getModel();
        if ($user != null) {
            return $user->trueName;
        }
        return "";
    }


    /**
     *  获取用户的
     * @return int
     */
    public function  getMessageCount()
    {
        $data = new pos_MessageSentService();
        return $data->unReadNum(user()->id);
    }

    /** 获取用户信息
     * @param $userId
     * @return common\models\pos\SeUserinfo
     */
    public function  getUserInfo($userId)
    {
        return \common\models\pos\SeUserinfo::findOne($userId);
    }

    /**
     * 获取用户信息 cache
     * @param $userId
     * @return common\models\pos\SeUserinfo
     */
    public function  getUserInfoCache($userId)
    {
        return $this->getUserInfo($userId);
    }


    public function  getPhoneReg()
    {
        $user = $this->getModel();
        if ($user != null) {
            return $user->phoneReg;
        }
        return '';
    }


}

?>