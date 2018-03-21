<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: ysd
 * Date: 2016/1/19
 * Time: 11:25
 */

namespace frontend\modules\teacher\controllers;

use common\models\JsonMessage;
use common\models\pos\SeFavoriteMaterial;
use common\models\pos\SeFavoriteMaterialGroup;
use common\models\pos\SeShareMaterial;
use common\models\sanhai\SrMaterial;
use frontend\components\TeacherBaseController;
use Yii;
use yii\data\Pagination;

/**
 * Class FavoritematerialController
 * @package frontend\modules\teacher\controllers
 */
class FavoritematerialController extends TeacherBaseController
{
    /**
     *  学段——小学
     */
    const DEPARTMENT = 20201;

    /**
     * 学科——语文
     */
    const SUBJECT = 10010;

    /**
     *是否删除
     */
    const ISDELETE = 0;

    /**
     *是否禁用
     */
    const DESABLED = 0;

    /**
     *0:我的收藏 1：自定义分组  2：我的创建
     */
    const GROUPTYPE_DEFAULT = 0;

    /**
     *0:我的收藏 1：自定义分组  2：我的创建
     */
    const GROUPTYPE_FAVORITE = 1;

    /**
     *0:我的收藏 1：自定义分组  2：我的创建
     */
    const GROUPTYPE_CREATE = 2;

    /**
     *最多40自定义分组
     */
    const MAXGROUPNUM = 40;

    public $layout = 'lay_user_new';


    /**
     * 我的资源——我的收藏
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionIndex()
    {
        $pages = new Pagination();
        $pages->validatePage = false;
        $pages->pageSize = 10;
        $userId = user()->id;

        $department = (int)app()->request->get('department', self::DEPARTMENT);   //学部
        $subjectId = (int)app()->request->get('subjectId', self::SUBJECT);    //学科
        $matType = app()->request->get('matType', ''); //课件类型
        $groupType = 0;  //我的收藏0 我的创建2
        $groupId = app()->request->get('groupId', '');      //分组id
        $defaultGroupId = '';
        $groupDefaultArray = SeFavoriteMaterialGroup::favoriteGroup($userId, $subjectId, $department); //分组列表（我的收藏）
        $customGroupArray= SeFavoriteMaterialGroup::favoriteGroupList($userId, $subjectId, $department); //分组列表（自定义）
        if($groupDefaultArray){
            $defaultGroupId = $groupDefaultArray['groupId'];
            $favoriteMaterial = SeFavoriteMaterial::find()->where(['isDelete' => self::ISDELETE, 'disabled' => self::DESABLED, 'userId'=> $userId]);

            if(!empty($groupId)){
                $favoriteMaterial->andWhere(['groupId' => $groupId]);

            }else{
                $groupId = $defaultGroupId;
                $favoriteMaterial->andWhere(['groupId' => $defaultGroupId]);
            }
            //我的资源——我的创建
            if (!empty($matType)) {
                $favoriteMaterial->andWhere(['matType' => $matType]);
            }
            $favoriteMaterialList = $favoriteMaterial->orderBy('createTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->all();
            //当前分组的信息
            $nowGroupInfo = SeFavoriteMaterialGroup::getGroupInfo((int)$groupId, $userId);
            //当前分组的课件数量
            $nowGroupMaterialCount = SeFavoriteMaterial::getGroupMaterialCount((int)$groupId, $userId);
            $pages->totalCount = $nowGroupMaterialCount;
        }else{
            $favoriteMaterialList = [];
            $nowGroupInfo = [];
            $nowGroupMaterialCount = '';
        }
        $pages->params = ['department' => $department,
            'subjectId' => $subjectId,
            'matType' => $matType,
            'groupType' => $groupType,
            'groupId' => $groupId,
            'defaultGroupId'=>$defaultGroupId
        ];

        $arr = ['favoriteMaterialList' => $favoriteMaterialList,
            'customGroupArray' => $customGroupArray,
            'groupType' => $groupType,
            'matType' => $matType,
            'department' => $department,
            'subjectId' => $subjectId,
            'pages' => $pages,
            'groupId' => $groupId,
            'defaultGroupId'=>$defaultGroupId,
            'nowGroupInfo'=>$nowGroupInfo,
            'nowGroupMaterialCount'=>$nowGroupMaterialCount,
            'groupDefaultArray'=>$groupDefaultArray
        ];

        if (app()->request->isAjax) {
            return $this->renderPartial('_index_list_favorite', $arr);
        }

        return $this->render('index', $arr);
    }


    /**
     * 用于加载自定义分组的片段
     * @throws \yii\base\InvalidParamException
     */
    public function actionGroupList()
    {
        $department = (int)app()->request->get('department');
        $subjectId = (int)app()->request->get('subjectId');
        $groupId = app()->request->get('groupId');
        $groupType = app()->request->get('groupType');
        $defaultGroupId = app()->request->get('defaultGroupId');

        $userId = user()->id;
        $groupDefaultArray = SeFavoriteMaterialGroup::favoriteGroup($userId, $subjectId, $department); //分组列表（我的收藏）
        $customGroupArray = SeFavoriteMaterialGroup::favoriteGroupList($userId, $subjectId, $department);

        return $this->renderPartial('_group_list', [
            'department' => $department,
            'subjectId' => $subjectId,
            'groupType' => $groupType,
            'customGroupArray' => $customGroupArray,
            'groupId' => $groupId,
            'defaultGroupId'=>$defaultGroupId,
            'groupDefaultArray'=>$groupDefaultArray
        ]);
    }

    /**
     * 移动课件到其他分组
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionMoveGroup()
    {
        $jsonResult = new JsonMessage();
        $collectArray = app()->request->getBodyParam('collectArray');
        $groupId = app()->request->getBodyParam('groupId');
        $result = SeFavoriteMaterial::moveGroup(user()->id, $collectArray, $groupId);
        if ($result == true) {
            $jsonResult->success = true;
            $jsonResult->message = '课件移动成功';
        } else {
            $jsonResult->message = '课件移动失败';
        }
        return $this->renderJSON($jsonResult);
    }

    /**
     * 删除课件
     * @return string
     * @throws \Exception
     */
    public function actionDeleteMaterial()
    {
        $jsonResult = new JsonMessage();
        $collectArray = app()->request->getBodyParam('collectArray');
        $groupType = app()->request->post('groupType');

        if ($groupType == self::GROUPTYPE_DEFAULT) {
            $result = SeFavoriteMaterial::delFavMaterial($collectArray, user()->id);
        } else {
            $result = SrMaterial::delMaterail($collectArray, user()->id);
        }

        if ($result == false) {
            $jsonResult->message = '课件删除失败';
            return $this->renderJSON($jsonResult);
        }

        $jsonResult->success = true;
        $jsonResult->message = '课件删除成功';

        return $this->renderJSON($jsonResult);
    }

    /**
     * 创建组
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionAddGroup()
    {
        $jsonResult = new JsonMessage();
        $department = (int)app()->request->post('department');
        $subjectId = (int)app()->request->post('subjectId');
        $groupName = app()->request->post('groupName');
        $userId = Yii::$app->getUser()->id;

        $groupNum = SeFavoriteMaterialGroup::getGroupNum($userId);
        if ($groupNum >= 40) {
            $jsonResult->message = '自定义分组限制40个';
            return $this->renderJSON($jsonResult);
        }

        $groupList = SeFavoriteMaterialGroup::favoriteGroupList($userId, $subjectId, $department);
        foreach ($groupList as $group) {
            if ($groupName == $group['groupName']) {
                $jsonResult->message = '已经有该名字';
                return $this->renderJSON($jsonResult);
            }
        }

        $result = SeFavoriteMaterialGroup::addGroup($userId, $department, $subjectId, (string)$groupName);
        if ($result) {
            $jsonResult->success = true;
            $jsonResult->message = '创建成功';
        } else {
            $jsonResult->message = '创建失败';
        }

        return $this->renderJSON($jsonResult);
    }

    /**
     * 修改组
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionUpdateGroupName()
    {
        $jsonResult = new JsonMessage();
        $department = (int)app()->request->post('department');
        $subjectId = (int)app()->request->post('subjectId');
        $groupId = (int)app()->request->post('groupId');
        $groupName = app()->request->post('groupName');
        $userId = user()->id;

        $groupInfo = SeFavoriteMaterialGroup::getGroupInfo($groupId, $userId);
        if (empty($groupInfo)) {
            $jsonResult->message = '修改失败';
            return $this->renderJSON($jsonResult);
        }
        if ($groupInfo->groupType != self::GROUPTYPE_FAVORITE) {
            $jsonResult->message = '不能修改系统默认分组';
            return $this->renderJSON($jsonResult);
        }

        $groupList = SeFavoriteMaterialGroup::favoriteGroupList($userId, $subjectId, $department);
        foreach ($groupList as $group) {
            if ($groupName == $group['groupName']) {
                $jsonResult->message = '已经有该名字';
                return $this->renderJSON($jsonResult);
            }
        }

        $result = $groupInfo->updateGroupName($groupName);
        if ($result) {
            $jsonResult->success = true;
            $jsonResult->message = '修改成功';
        } else {
            $jsonResult->message = '修改失败';
        }

        return $this->renderJSON($jsonResult);

    }

    /**
     * 删除组
     * @return string
     * @throws \Exception
     * @throws \yii\base\ExitException
     */
    public function actionDeleteGroup()
    {
        $jsonResult = new JsonMessage();
        $groupId = (int)app()->request->post('groupId');
        $userId = Yii::$app->getUser()->id;

        $groupInfo = SeFavoriteMaterialGroup::getGroupInfo($groupId, $userId);

        if (empty($groupInfo)) {
            $jsonResult->message = '删除失败';
            return $this->renderJSON($jsonResult);
        }

        if ($groupInfo->groupType != self::GROUPTYPE_FAVORITE) {
            $jsonResult->message = '不能删除系统默认分组';
            return $this->renderJSON($jsonResult);
        }

        $result = $groupInfo->deleteGroup();
        if ($result == false) {
            $jsonResult->message = '删除失败';
            return $this->renderJSON($jsonResult);
        }

        $jsonResult->success = true;
        $jsonResult->message = '删除成功';

        return $this->renderJSON($jsonResult);
    }

    /**
     *分享
     * @throws \yii\base\ExitException
     */
    public function actionSharedMaterial()
    {
        $jsonResult = new JsonMessage();
        $matId = (int)app()->request->getParam('shareId', 0);
        $classId = (string)app()->request->getParam('classId', '');
        $groupId =(string)app()->request->getParam('groupId', '');
        $userId = (int)user()->id;

        $shareToClass = SeShareMaterial::shareToClass($classId, $userId, $matId);
        if ($shareToClass == false) {
            $jsonResult->message = '共享失败';
            return $this->renderJSON($jsonResult);
        }
        $shareToGroup = SeShareMaterial::shareToGroup($groupId, $userId, $matId);
        if ($shareToGroup == false) {
            $jsonResult->message = '共享失败';
            return $this->renderJSON($jsonResult);
        }

        $jsonResult->success = true;
        $jsonResult->message = '共享成功';

        return $this->renderJSON($jsonResult);
    }


    /**
     *AJAX上传文件
     * @throws \yii\base\ExitException
     */
    public function actionAjaxUpload()
    {
        $jsonResult = new JsonMessage();

        $subjectID = app()->request->getParam('subjectID');

        $version = app()->request->getParam('version');

        $matType = app()->request->getParam('matType');

        $name = app()->request->getParam('name');

        $department = app()->request->getBodyParam('department');

        $url = app()->request->getParam('url');
        $access = app()->request->getParam('access');
        $chapKids = app()->request->getParam('chapKids');

        $model = new SrMaterial();
        $model->access = $access;
        $model->subjectid = $subjectID;
        $model->versionid = $version;
        $model->matType = $matType;
        $model->name = $name;
        $model->url = $url;
        $model->department = $department;
        $model->chapterId = $chapKids;
        $model->creator = user()->id;

        if ($model->save(false)) {
            $jsonResult->success = true;
        }

        return $this->renderJSON($jsonResult);
    }

    /**
     * 收藏分享
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionGetMaterialBox()
    {
        $id = app()->request->getParam('id', '');
        $result = SrMaterial::getMaterialInfo($id);
        return $this->renderPartial('_getShareBox_view', ['result' => $result, 'id' => $id]);
    }

}