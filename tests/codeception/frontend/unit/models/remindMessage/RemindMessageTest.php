<?php
/**
 * Created by PhpStorm.
 * User: 邓奇文
 * Date: 2016/5/23
 * Time: 17:19
 */

namespace tests\codeception\frontend\unit\models;

use common\helper\DateTimeHelper;
use frontend\services\pos\pos_MessageSentService;
use tests\codeception\frontend\unit\TestCase;
use Yii;
use yii\data\Pagination;

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
     * 提醒消息的列表页
     * @return bool
     */
    public function testNotice()
    {
        $userId = 202534;       //测试用户id(田老师)
        $messageType = '' ;     //全部
        $pages = new Pagination();
        $pages->validatePage = false;
        $pages->pageSize = 10;
        $data = new pos_MessageSentService();
        $result = $data->readerQuerySentMessageInfo($userId , 508, $messageType, $pages->getPage() + 1, $pages->pageSize);
        $this->assertInternalType('object', $result);

    }



}
