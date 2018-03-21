<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2015/4/21
 * Time: 15:23
 */
use common\models\dicmodels\SubjectModel;
use yii\web\View;

/* @var $this yii\web\View */

$this->title="单科错题列表";
$this->blocks['requireModule'] = 'app/student/student_wrong_question';
$this->registerCssFile(BH_CDN_RES.'/static/css/media_source.css'.RESOURCES_VER, ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES.'/static/js/app/classes/media_source.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile(BH_CDN_RES.'/static/css/classes.min.css' . RESOURCES_VER, ['position' => View::POS_HEAD]);
$this->registerCssFile(BH_CDN_RES.'/static/css/stu_error_question.css' . RESOURCES_VER);
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/echarts/echarts.js' . RESOURCES_VER, ['position' => View::POS_HEAD]);
$subject=new SubjectModel();
/** @var common\models\pos\SeWrongQuestionBookInfo[] $wrongQuestion */
?>

<div id="main" class="clearfix main classes_answering_question">
    <h4 id="main_head" class="bg_fff main_head">
        <a href="<?php echo url('/student/wrongtopic/manage')?>" class="btn icoBtn_back"><i></i>返回</a>
        <?php if(!empty($wrongSubject)){ echo $subject->getName((int)$wrongSubject->subjectId);}?>错题集
    </h4>
    <div id="MyError" class="main_cont mistake_detail MyError">
        <div class="testPaper clearfix">
            <?php  echo $this->render('//publicView/wrong/_new_wrong_question_list',['wrongQuestion'=>$wrongQuestion,'pages' => $pages])?>
        </div>
    </div>
</div>
