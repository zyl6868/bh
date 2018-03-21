<?php
/**
 * Created by PhpStorm.
 * User: 邓奇文
 * Date: 2016/5/23
 * Time: 17:19
 */

namespace tests\codeception\frontend\unit\models;

use common\helper\DateTimeHelper;
use common\models\pos\SeQuestionFavoriteFolderNew;
use common\models\pos\SeQuestionGroup;
use tests\codeception\frontend\unit\TestCase;
use Yii;

class QuestionTest extends TestCase
{

    use \Codeception\Specify;

    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
    }


    /**
     * 新建组单元测试
     * @return bool
     */
    public function testAddGroup()
    {
        $seQuestionGroupModel = new SeQuestionGroup();
        $subjectid = 10010;     //语文
        $departments = 20201;   //小学
        $userId = 202534;       //测试用户id(田老师)
        $groupName = "单元测试分组";
        $groupType = 1;
        $createTime = DateTimeHelper::timestampX1000();

        $collectGroup = $seQuestionGroupModel->collectGroup($userId,$subjectid,$departments);
        $this->assertInternalType('object', $collectGroup);
        $this->assertTrue(is_numeric(count($collectGroup)));
        $this->assertEquals(1, count($collectGroup));


        $defineGroup = $seQuestionGroupModel->defineGroup($userId,$subjectid,$departments);
        $this->assertTrue(is_array($defineGroup));

        $groupId = 218;           //默认‘我的收藏’测试分组id
        $groupModel = $seQuestionGroupModel->groupName($groupId);
        $this->assertInternalType('object', $groupModel);
        $this->assertEquals('我的收藏', $groupModel['groupName']);

        $defineGroupNum = $seQuestionGroupModel->defineGroupNum($userId);
        $this->assertTrue(is_numeric($defineGroupNum));

        $groupOne = $seQuestionGroupModel->groupOne($userId,$groupId);
        $this->assertInternalType('object', $groupOne);

        $addGroupNewId = $seQuestionGroupModel->addGroupNew($userId,$departments,$subjectid,$groupName,$groupType,$createTime);
        $this->assertTrue(is_numeric($addGroupNewId));
        return $addGroupNewId;
    }


    /**
     * 修改组单元测试
     * @param $addGroupNewId
     * @depends testAddGroup
     */
    public function testModifyGroup($addGroupNewId)
    {
        $userId = 202534;
        $groupId = $addGroupNewId;
        $groupName = '单元测试修改组名222';
        $updateTime = DateTimeHelper::timestampX1000();
        $seQuestionGroupModel = new SeQuestionGroup();
        $modifyGroupName = $seQuestionGroupModel->modifyGroupName($userId,$groupId,$groupName,$updateTime);
        $this->assertTrue(is_bool($modifyGroupName));
        $groupModel = $seQuestionGroupModel->groupName($groupId);
        $this->assertInternalType('object', $groupModel);
        $this->assertEquals('单元测试修改组名222', $groupModel['groupName']);
    }


    /**
     * 移动题目单元测试
     * @param $addGroupNewId
     * @depends testAddGroup
     * @return array|\common\models\pos\SeQuestionFavoriteFolderNew[]
     */
    /*public function testMoveQuestion($addGroupNewId)
    {
        $questionFmodle = new SeQuestionFavoriteFolderNew();
        $userId = 202534;
        $groupId = 218;
        $questionIdList = $questionFmodle->questionIdList($userId,$groupId);
        $this->assertTrue(is_array($questionIdList));

        $questionsIds = $questionIdList;
        $selectQuestion = $questionFmodle->selectQuestion($userId,$groupId,$questionsIds);
        $this->assertTrue(is_array($selectQuestion));

        $groupId = $addGroupNewId;
        $moveQuestionGroup = $questionFmodle->moveQuestionGroup($userId,$questionsIds,$groupId);
        $this->assertTrue(is_bool($moveQuestionGroup));
        $this->assertTrue($moveQuestionGroup);
        return $questionsIds;
    }*/


    /**
     * 删除题目单元测试
     * @depends testAddGroup
     * @depends testMoveQuestion
     * @param $addGroupNewId
     * @param $questionsIds
     */
   /* public function testDelQuestion($addGroupNewId, $questionsIds)
    {
        $questionFmodle = new SeQuestionFavoriteFolderNew();
        $userId = 202534;
        $groupId = $addGroupNewId;
        $delQuestion = $questionFmodle->delQuestion($userId,$questionsIds,$groupId);
        $this->assertTrue(is_bool($delQuestion));
        $this->assertTrue($delQuestion);
    }*/


    /**
     * 删除组单元测试
     * @depends testAddGroup
     * @param $addGroupNewId
     */
   /* public function testDelGroup($addGroupNewId)
    {
        $seQuestionGroupModel = new SeQuestionGroup();
        $userId = 202534;
        $groupId = $addGroupNewId;
        $groupInfoModel = $seQuestionGroupModel->groupOne($userId,$groupId);
        $deleteGroup = $groupInfoModel->deleteGroup($userId,$groupId);
        $this->assertTrue(is_bool($deleteGroup));
        $this->assertTrue($deleteGroup);
        $this->assertEquals('1', $deleteGroup);
    }*/

}
