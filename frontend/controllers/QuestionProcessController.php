<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/5
 * Time: 18:14
 */

namespace frontend\controllers;

use common\controller\YiiController;
use common\models\search\Es_testQuestion;
use common\clients\MpsdAppService;


class QuestionProcessController extends YiiController
{

    /**
     * 单个题目的展示
     * @return string
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
    public function actionIndex(){

        $id = (int)app()->request->getParam('id',0);
        if($id <= 0){
            return $this->notFound('请输入题目编号');
        }

       if(!Es_testQuestion::questionRefreshElasticSearch($id)){
           return $this->notFound('暂无此题目');
       };

        //app端更新题目 清空题目缓存
        $questionProcessService = new MpsdAppService();
        $questionProcessService->questionProcess($id);

        Es_testQuestion::flush();
        $Es_testQuestion = Es_testQuestion::find()->where(['mainQusId' => 0])->andWhere(['id' => $id])->one();

        return $this->renderAjax('index',['testQuestion' => $Es_testQuestion]);
    }
}
