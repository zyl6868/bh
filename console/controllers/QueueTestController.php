<?php
namespace console\controllers;
use mithun\queue\controllers\WorkerController;
use mithun\queue\services\QueueInterface;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/14
 * Time: 11:53
 */
class QueueTestController extends  WorkerController{
    /**
     * 队列名称
     */
    const  QUEUE_TYPE = 'queue_push_home_work';
    /**
     *  根据条件生成推送记录
     */
    public function actionPush()
    {

        /** @var QueueInterface $queue */
        $queue = \yii::$app->queue;
        for($i=1;$i<10;$i++) {
            $queue->push($i, self::QUEUE_TYPE);

        }
    }
    public function actionListen()
    {

        $queue = \yii::$app->queue;
        /** @var QueueInterface $queue */
        while (true) {

            $value = $queue->pop(self::QUEUE_TYPE);

            //删除消息

            if ($value === false) {
                sleep(5);
                continue;
            }

            if($value){
                $queue->delete($value);
            }



            $id = $value['body'];
            echo $id.'\r\n';


        }
    }
    public function actionEachWhile(){
        while(true){
            sleep(4);
            echo '<br/>';
        }
    }


}