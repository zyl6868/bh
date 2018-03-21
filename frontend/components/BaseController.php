<?php

namespace frontend\components;

use common\components\WebDataKey;
use common\controller\YiiController;
use common\models\pos\SeClass;
use common\models\pos\SeClassMembers;
use common\models\pos\SeGroupMembers;
use common\models\pos\SeSchoolInfo;
use common\models\pos\SeTeachingGroup;
use Yii;
use yii\helpers\Url;


/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class BaseController extends YiiController
{
    /**
     * @var null
     */
    protected $classModel = null;
    protected $schoolModel = null;
    protected $teachingGroupModel = null;

    /**
     * 通过id获取班级信息
     * @param integer $classId 班级ID
     * @return null
     * @throws \yii\base\ExitException
     * @throws \yii\web\HttpException
     */
    public function getClassModel(int $classId)
    {
        $view = Yii::$app->view;

        if ($classId === null) {
            return $this->notFound();
        }

        if ($this->classModel !== null) {
            $view->params['classModel'] = $this->classModel;
            return $view->params['classModel'];

        }

        //判断当前用户是否有进入所访问页面的权限
        $cache = Yii::$app->cache;
        $key = WebDataKey::USER_IS_IN_CLASS_KEY . $classId . '||' . user()->id;
        $data = $cache->get($key);
        if ($data === false) {
            $data = SeClassMembers::find()->where(['classID' => $classId, 'userID' => user()->id])->limit(1)->one();
            $cache->set($key, $data, 3600);
        }
        if ($data === null) {
            return $this->notFound('你没有权限查看该班级', 403);
        }
        $model = SeClass::find()->where(['classID' => $classId])->limit(1)->one();

        if ($model !== null) {
            $view->params['classModel'] = $model;
            return $this->classModel = $model;
        } else {
            return $this->notFound();
        }

    }

    /**
     * 通过id获取学校信息
     * @param integer $schoolId
     * @return SeSchoolInfo|null
     * @throws \yii\base\ExitException
     * @throws \yii\web\HttpException
     */
    public function getSchoolModel(int $schoolId)
    {

        $view = Yii::$app->view;

        if ($schoolId === null) {
            return $this->notFound();
        }

        if ($this->schoolModel !== null) {
            $view->params['schoolModel'] = $this->schoolModel;
            return $this->schoolModel;
        }

        $model = SeSchoolInfo::find()->where(['schoolID' => $schoolId])->limit(1)->one();

        if ($model !== null) {

            $view->params['schoolModel'] = $model;
            return $this->schoolModel = $model;
        } else {
            return $this->notFound();
        }
    }

    /**
     * 通过id获取教研组信息
     * @param $groupId
     * @return SeTeachingGroup
     * @throws \yii\base\ExitException
     * @throws \yii\web\HttpException
     */
    public function getTeachingGroupModel($groupId)
    {

        $view = Yii::$app->view;
        if ($groupId == null) {
            return $this->notFound();
        }
        //判断当前用户是否有进入所访问页面的权限
        $cache = Yii::$app->cache;
        $key = WebDataKey::USER_IS_IN_GROUP_KEY . $groupId . '||' . user()->id;
        $data = $cache->get($key);
        if ($data === false) {
            $data = SeGroupMembers::find()->where(['groupID' => $groupId, 'teacherID' => user()->id])->limit(1)->one();
        }
        if ($data == null) {
            return $this->notFound('你没有权限查看该教研组', 403);
        }
        if ($this->teachingGroupModel != null) {
            $view->params['teachingGroup'] = $this->teachingGroupModel;
            return $this->teachingGroupModel;
        }

        $model = SeTeachingGroup::findOne($groupId);


        if ($model != null) {
            $view->params['teachingGroup'] = $model;
            return $this->teachingGroupModel = $model;
        } else {
            return $this->notFound();
        }
    }

    /**
     * 跑到个设置主页
     */
    public function redirectSetHome()
    {
        return $this->redirect($this->getSetHoneUrl());

    }

    /**
     * 返回个人设置主页url
     * @return string
     */
    public function getSetHoneUrl()
    {
        if ($this->isLogin()) {
            if (loginUser()->isStudent()) {
                return Url::to('/student/setting/index');
            }
            if (loginUser()->isTeacher()) {
                return Url::to('/teacher/setting/index');
            }
        }
        return "/";
    }

    /**
     * 跳转到找班级
     * @return \yii\web\Response
     */
    public function userRedirectFindClass()
    {

        $url = '';
        if ($this->isLogin()) {
            $userInfo = loginUser()->getModel();

            $classes = $userInfo->getClassInfo();
            switch ($userInfo->type) {
                case 0:
                case 1:
                    if (empty($classes)) {
                        if (app()->request->isAjax) {
                            $url = '/register/join-class';
                            break;
                        }
                        return $this->redirect(['/register/join-class']);
                    }
                    break;
            }

        }
        if (app()->request->isAjax) {
            return $url;
        }

    }

    /**
     * 跳到班级首页
     * @return \yii\web\Response
     */
    public function userRedirectClassHome()
    {
        $url = '';
        if ($this->isLogin()) {
            $classList = loginUser()->getModel(false)->getUserClassGroup();
            if (count($classList) > 0) {
                $classId = $classList[0]->classID;
                if (loginUser()->isTeacher()) {
                    $model = from($classList)->firstOrDefault(null, function ($v) {
                        return $v->identity == '20401';
                    });
                    if ($model !== null) {
                        $classId = $model->classID;
                    }
                }
                if (app()->request->isAjax){
                    $url = '/class/index?classId='.$classId;
                    return $url;
                }
                return $this->redirect(['/class/index', 'classId' => $classId]);
            }
        }

        if (app()->request->isAjax){
            return $url;
        }

    }

    /**
     * 用户缺省跳转页
     */
    public function userDefaultRedirectUrl()
    {
        $this->userRedirectFindClass();
        $this->userRedirectClassHome();
    }

    /**
     * 是否是班主任
     * 返回班主任的班级信息
     * @return mixed
     */
    public function MasterClass()
    {

        $classList = loginUser()->getModel(false)->getUserClassGroup();
        $model = from($classList)->firstOrDefault(null, function ($v) {
            return $v->identity == '20401';
        });
        return $model;
    }

    /**
     * 是否是班主任
     * 返回班主任的班级信息
     * @param integer $classID 班级ID
     * @return mixed
     */
    public function MasterClassByClass(int $classID)
    {

        $classList = loginUser()->getModel(false)->getUserClassGroup();
        $model = from($classList)->firstOrDefault(null, function ($v) use ($classID) {
            return $v->identity == '20401' && $v->classID == $classID;
        });
        return $model;
    }


}
