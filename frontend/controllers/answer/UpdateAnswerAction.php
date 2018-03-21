<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2015/8/5
 * Time: 10:02
 */
namespace frontend\controllers\answer;
use common\models\pos\SeAnswerQuestion;
use common\clients\KeyWordsService;
use frontend\modules\teacher\models\teaQuestionPackForm;
use yii\base\Action;
use yii\web\HttpException;

class UpdateAnswerAction extends Action{
    public function run(){
        $aqId = app()->request->getParam('aqId', 0);
        $result=SeAnswerQuestion::find()->active()->where(["aqID"=>$aqId,"creatorID"=>user()->id])->one();
        if(!$result){
            throw new HttpException(404, 'The requested page does not exist.');
        }
        $questionForm = new teaQuestionPackForm();
        if(isset($_POST['imgurls']) && !empty($_POST['imgurls'])){
            $picurls = implode(',',$_POST['imgurls']);
        }else{
            $picurls = "";
        }
        if (isset($_POST['teaQuestionPackForm'])) {
            $questionForm->attributes = $_POST['teaQuestionPackForm'];
            $questionForm->title = $result->aqName;
            if  ($questionForm->validate())
            {
                $result->imgUri=$picurls;
                $result->aqDetail=KeyWordsService::ReplaceKeyWord($questionForm->detail);
                $result->aqName=KeyWordsService::ReplaceKeyWord($questionForm->title);

                if ($result->save()) {
                    return $this->controller->redirect(['my-questions']);
                }
            }
        }
        return $this->controller->render('@app/views/publicView/answer/updateQuestion', array('model' => $questionForm,'result' => $result));
    }
}