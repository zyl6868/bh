<?php
declare(strict_types=1);
namespace frontend\modules\platform\controllers;
use common\models\sanhai\ShQuestionPaper;
use common\models\sanhai\ShQuestionVideo;
use common\models\sanhai\ShResource;
use common\models\sanhai\ShTestquestion;
use frontend\components\BaseAuthController;
use yii\data\Pagination;

/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2016/1/19
 * Time: 13:29
 */
class VideoController extends BaseAuthController{
    public $layout = "lay_platform";
    /*
     * 视频列表页
     */
    public function actionIndex(){

        $proFirstime = microtime(true);
        //接受参数
        $department =app()->request->get('department', '20202');
        $subjectId =app()->request->get('subjectId', '10011');
        $province=app()->request->get('province','');
        $year=app()->request->get('year','');
        $text=app()->request->get('text','');
        //视频数据
        $video=ShQuestionPaper::find()->active();
        if(!empty($subjectId)){$video->andWhere(['subjectId'=>$subjectId]);}
        if($department!=''){$video->andWhere(['department'=>$department]);}
        if($province!=''){$video->andWhere(['like','testArea',$province]);}
        if($year!=''){$video->andWhere(['year'=>$year]);}
        if($text!=''){$video->andWhere(['like','paperName',$text]);}
        //分页
        $page=new Pagination();
        $page->validatePage = false;
        $page->pageSize = 10;
        $page->totalCount=$video->count();
        $videos=$video->offset($page->getOffset())->limit($page->getLimit())->all();

        $page->params = ['department' => $department,'subjectId' => $subjectId,'province' => $province,'year' => $year];
        \Yii::info('视频库 '.(microtime(true)-$proFirstime),'service');
        if(app()->request->isAjax){
            return $this->renderPartial('_videoList',['year'=>$year,'videos'=>$videos,'department'=>$department,
                   'subjectId'=>$subjectId,'department'=>$department,'province' => $province,'page'=>$page]);
        }
        return $this->render('index',['year'=>$year,'videos'=>$videos,'department'=>$department,'department'=>$department,
                              'province' => $province,'page'=>$page,'subjectId'=>$subjectId,'text'=>$text]);
    }
    /*
     * 视频题列表
     * 不要分页
     */
    public function actionList($paperId){
        $videoModel=ShQuestionPaper::find()->where(['paperId'=>$paperId])->one();
        if($videoModel){
            //以后恢复过来把这个数据（Es_testQuestion）
//            $listModel = Es_testQuestion::find();
            $listModel = ShTestquestion::find();
            $questionModel =$listModel ->where(['paperId' => $paperId])->all();
            return $this->render('list',['questionModel'=>$questionModel,'videoModel'=>$videoModel]);
        }else{
            return $this->notFound('视频不存在',403);
        }

    }
    /*
     * 视频详情
     */
    public function actionDetail(){
        $id=app()->request->get('id');
            $questionVideo=ShQuestionVideo::find()->where(['questionId'=>$id])->orderBy('resourceId')->all();
            $question=ShTestquestion::find()->where(['id'=>$id])->one();
            $videoArray=[];
            if(!empty($questionVideo) && !empty($question) ){
                foreach($questionVideo as $val){
                    $videoResource = ShResource::find()->where(['id' => $val->resourceId])->one();
                    $videoArray[]=$videoResource;
                }
                 return $this->render('detail',['question'=>$question,'videoArray'=>$videoArray]);
            }
            return $this->notFound('视频不存在',403);
    }
}
