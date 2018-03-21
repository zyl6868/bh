<?php

namespace tests\codeception\frontend\unit\models;

use common\models\pos\SeFavoriteMaterial;
use common\models\pos\SeHomeworkTeacher;
use common\models\pos\SeQuestionFavoriteFolderNew;
use common\models\pos\SeUserinfo;
use common\models\sanhai\SrMaterial;
use tests\codeception\frontend\unit\TestCase;
use Yii;

class TeacherHomeTest extends TestCase
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
     * 获取收藏的题目
     */
    public function testGetFavoriteQuestionNum(){
        $userId = 202534;
        $favoriteFolderModel = new SeQuestionFavoriteFolderNew();
        $favoriteFolderNum = $favoriteFolderModel-> getfavoriteQuestionNum($userId);
        $this->assertTrue(is_numeric($favoriteFolderNum));

    }




    /**
     * 测试收藏的文件数
     */
    public function testFavoriteFileNum(){
        $materialModel = new SeFavoriteMaterial();
        $userId = 202534;
        $favNum =  $materialModel->favoriteFileNum($userId);
        $this->assertTrue(is_numeric(count($favNum)));
    }

    /**
     * 测试创建的文件数
     */
    public function testCreateFileNum(){
        $materialModel = new SrMaterial();
        $userId = 202534;
        $favNum =  $materialModel->getCreateFileCount($userId);
        $this->assertTrue(is_numeric(count($favNum)));
    }

    /**
     * 测试班级信息
     */
    public function testGetClassInfo(){
        $userId = 202534;
        $userModel = SeUserinfo::find()->where(['userID'=>$userId])->one();
        $classModel = $userModel->getClassInfo();
        $this->assertInternalType('array',$classModel);

    }


    /**
     * 测试教研组信息
     */
    public function testGetGroupInfo(){
        $userId = 202534;
        $userModel = SeUserinfo::find()->where(['userID'=>$userId])->one();
        $groupModel = $userModel->getGroupInfo();
        $this->assertInternalType('array',$groupModel);
    }


    /**
     * 测试 教师 创建作业和收藏作业数
     */
    public function testHomeworkNum(){
        $userId = 202534;
        $homeworkTeacherModel = new SeHomeworkTeacher();
        //创建的作业数
        $createHomeworkNum = $homeworkTeacherModel->getCreateHomeworkNum($userId);
        $this->assertTrue(is_numeric($createHomeworkNum));

        //收藏的作业数
        $collectHomeworkNum = $homeworkTeacherModel->getCollectHomeworkNum($userId);
        $this->assertTrue(is_numeric($collectHomeworkNum));
    }
}
