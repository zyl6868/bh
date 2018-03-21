<?php
namespace common\behaviors;

use Yii;
use yii\base\Action;
use yii\base\ActionFilter;
use yii\base\Exception;


class BehaviorsTracking extends ActionFilter
{

    protected $url;
    protected $userID;
    protected $time;
    protected $ip;
    protected $actionMethod;




    /**
     * This method is invoked right after an action is executed.
     * You may override this method to do some postprocessing for the action.
     * @param Action $action the action just executed.
     * @param mixed $result the action execution result
     * @return mixed the processed action result.
     */
    public function afterAction($action,$result)
    {
        if (isset(Yii::$app->params['traceLogUrl'])){
            $array = Yii::$app->params['traceLogUrl'];
            if(!empty($array)){
                try {
                    if (!Yii::$app->user->isGuest) {
                        $this->url = $action->getUniqueId();
                        $this->userID = Yii::$app->user->id;
                        $this->time = time();
                        $this->ip = Yii::$app->request->getUserIP();
                        $this->actionMethod = $action->actionMethod;
                        $pName = $this->pubArray($array, $value = $this->url);
                        if ($pName) {
                             \Yii::info($this->ip . '--' . $this->userID . '--' . $this->url . '--' . $pName, 'traceweb');
                        }
                    }
                } catch (Exception $e) {}
            }
        };
        return $result;
    }


    /*
     *公共方法
     * $array 跟踪URL数组
     * $value 当前的URL
    */
    protected  function pubArray($array,$value){
        foreach($array as $val){
            if($val['name'] == $value){
                return $val['p'];
            }
        }
    }

}
