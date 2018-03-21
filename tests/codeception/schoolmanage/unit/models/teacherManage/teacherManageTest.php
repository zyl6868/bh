<?php
namespace tests\codeception\schoolmanage\models;

use Codeception\Specify;
use common\models\pos\SeUserinfo;
use tests\codeception\frontend\unit\DbTestCase;
use Yii;

class teacherManageTest extends DbTestCase
{
    use Specify;

    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

}
?>