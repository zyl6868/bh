<?php

namespace tests\codeception\frontend\unit\models;

//use yii\codeception\TestCase;
use common\helper\DateTimeHelper;
use common\models\pos\SeFavoriteMaterial;
use common\models\pos\SeFavoriteMaterialGroup;
use common\models\pos\SeShareMaterial;
use common\models\sanhai\SrMaterial;
use tests\codeception\frontend\unit\TestCase;


/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/14
 * Time: 16:59
 */
class FavoriteMaterialTest extends TestCase
{

    //添加组-修改组-删除组
    //收藏课件-取消收藏课件
    //移动课件-删除课件
    //共享

    /**
     * 新建组
     */
    public function testAddGroup()
    {
        $seQuestionGroupModel = new SeFavoriteMaterialGroup();
        $subjectid = 10010;     //语文
        $departments = 20201;   //小学
        $userId = 202534;       //测试用户id(田老师)
        $groupName = "单元测试分组11";

        $getGroupNum = $seQuestionGroupModel::getGroupNum($userId);
        $this->assertTrue(is_numeric($getGroupNum));

        $addGroupId = $seQuestionGroupModel::addGroup($userId, $departments, $subjectid, $groupName);
        $this->assertTrue(is_numeric(count($addGroupId)));
        return $addGroupId;

    }

    /**
     * 更新组
     * @param $addGroupId
     * @depends testAddGroup
     */
    public function testUpdateGroup($addGroupId)
    {
        $userId = 202534;
        $groupId = $addGroupId;
        $groupName = '单元测试修改组名222';
        $updateTime = DateTimeHelper::timestampX1000();
        $seFavoriteMaterialGroupModel = new SeFavoriteMaterialGroup();
        $updateGroupInfo = $seFavoriteMaterialGroupModel->getGroupInfo($groupId, $userId);
        $this->assertInternalType('object', $updateGroupInfo);

        $updateGroup = $updateGroupInfo->updateGroupName($groupName);
        $this->assertTrue(is_bool($updateGroup));

    }

    /**
     * 删除组测试
     * @param $addGroupId
     * @depends testAddGroup
     */
    public function testDeleteGroup()
    {
        $userId = 202534;
        $groupId = 39;
        $seFavoriteMaterialGroup = new SeFavoriteMaterialGroup();
        $deleteGroupInfo = $seFavoriteMaterialGroup->getGroupInfo($groupId, $userId);
        $this->assertInternalType('object', $deleteGroupInfo);
        $deleteGroup = $deleteGroupInfo->deleteGroup();
        $this->assertTrue(is_bool($deleteGroup));
    }

    /**
     *收藏课件的测试
     */
    public function testCollect()
    {
        $id = 80300337660;  //课件id
        $matType = 1;          //1教案,2讲义 ,4 资料,5 ppt,6 素材
        $userId = 202534;
        $srMaterial = new SrMaterial();
        $materialInfo = $srMaterial->getMaterialInfo($id);
        $this->assertInternalType('object', $materialInfo);

        $seFavoriteMaterial = new SeFavoriteMaterial();
        $totalMaterialNum = $seFavoriteMaterial->getTotalMaterialNum($userId);
        $this->assertTrue(is_numeric(count($totalMaterialNum)));

        $materialCollect = $seFavoriteMaterial->materialCollect($materialInfo, $id, $userId, $matType);

        $this->assertTrue(is_bool($materialCollect));

    }

    /**
     *取消收藏测试
     */
    public function testCancelCollect()
    {
        $id = 80300337660;  //课件id
        $userId = 202534;
        $seFavoriteMaterial = new SeFavoriteMaterial();
        $result = $seFavoriteMaterial::materialCancelCollect($id, $userId);
        $this->assertInternalType('bool', $result);
    }

    /**
     *课件移动到其他组
     */
    public function testMoveGroup()
    {
        $SeFavoriteMaterialModel = new SeFavoriteMaterial();
        $userId = 202534;       //测试用户id(田老师)
        $groupId = 262;
        $collectArray = ['1566'];

        $result = $SeFavoriteMaterialModel->moveGroup($userId, $collectArray, $groupId);
        $this->assertInternalType('bool', $result);
        $this->assertTrue(is_numeric(count($result)));
        $this->assertEquals(1, count($result));
    }

    /**
     * 删除课件
     */
    public function testDeleteMaterial()
    {
        $groupType = 2;
        $userId = 202534;       //测试用户id(田老师)
        $collectArray = ['2002365'];

        if ($groupType == 1) {
            //删除收藏的课件
            $seFavoriteMaterialModel = new SeFavoriteMaterial();
            $result = $seFavoriteMaterialModel::delFavMaterial($collectArray, $userId);
            $this->assertInternalType('bool', $result);

        } else {
            //删除创建的课件
            $srMaterialModel = new SrMaterial();
            $result = $srMaterialModel::delMaterail($collectArray, $userId);
            $this->assertInternalType('bool', $result);
        }

    }

    /**
     * 分享课件到班级或者教研组
     */
    public function testSharedMaterial()
    {
        $id = 2011191;   //课件id
        $userId = 202534;
        $classId = 202192;  //班级id  高一一班
        $groupId = 202145;         //教研组id  数离子教研组
        $shareToClass = SeShareMaterial::shareToClass($classId, $userId, $id);
        $this->assertInternalType('bool', $shareToClass);

        $shareToGroup = SeShareMaterial::shareToGroup($groupId, $userId, $id);
        $this->assertInternalType('bool', $shareToGroup);

    }

}