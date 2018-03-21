<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/19
 * Time: 15:54
 */
namespace tests\codeception\schoolmanage\unit\models;

use tests\codeception\frontend\unit\TestCase;
use common\helper\DateTimeHelper;
use common\models\pos\SeUserinfo;
use common\models\pos\SeClassMembers;

class StudentManageTest extends TestCase
{
    use \Codeception\Specify;

    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
    }

    public function testUserInfo(){
        $seUserInfoModel = new SeUserinfo();

    }

}