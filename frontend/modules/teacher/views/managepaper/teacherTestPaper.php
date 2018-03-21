<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/30
 * Time: 11:16
 */

use frontend\components\helper\DepartAndSubHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = '教师--试卷管理-列表';
$this->blocks['bodyclass'] = "platform";
$this->blocks['requireModule'] = 'app/teacher/teacher_home_paper';
$this->registerCssFile(BH_CDN_RES.'/static/css/teacher_manage_testpaper.css');

$searchArr = array(
    'department' => app()->request->getParam('department', $department),
    'subjectId' => app()->request->getParam('subjectId', $subjectId),
    'getType' => app()->request->getParam('getType'),
    'orderType' => app()->request->getParam('orderType')
);
?>



<!--主体-->
<div class="main platform col1200 clearfix platform_question_bank" id="requireModule" rel="app/teacher/teacher_home_courseware">
    <div class="aside col260 alpha">
        <div id="sel_classes" class=" currency_hg sel_classes" data-department="<?php echo $department ?>"
             data-subjectId="<?php echo $subjectId ?>">
            <div class="pd15">
                <?php
                $departAndSubArray = DepartAndSubHelper::getTopicSubArray();
                echo $this->render('_depart_and_sub_menu',
                    ['departAndSubArray' => $departAndSubArray, 'department' => $department, 'subjectId' => $subjectId]);
                ?>
            </div>
        </div>
    </div>
    <div class="tch_resource container col910 omega currency_hg">
        <div class="sUI_pannel tab_pannel">
            <div class="pannel_l">
                <div class="tab sUI_tab clearfix">
                    <ul class="tabList clearfix">
                        <li><a href="<?php echo Url::to(["/teacher/resources/collect-work-manage"]) ?>" class="tch_hmwk_ic"><i></i>作业</a></li>
                        <li><a href="<?php echo Url::to(["/teacher/question/index"]) ?>" class="tch_question_ic"><i></i>题目</a></li>
                        <li><a href="<?php echo Url::to(["/teacher/favoritematerial/index"]) ?>" class="tch_courseware_ic"><i></i>课件</a></li>
                        <li><a href="<?php echo Url::to(["/teacher/managepaper/index"]) ?>" class="tch_exam_ic ac"><i></i>试卷</a></li>
                    </ul>
                </div>
            </div>
            <div id="problem_r_list" class="problem_r_list">
                <h5>创建试卷</h5>
                <ul class="hot pop clearfix" style="display: none;">
                    <li class="list"><a class="" href="<?php echo url('teacher/managepaper/upload-paper') ?>">上传试卷</a></li>

                </ul>
                <u class="u_show clearfix" style="display: none"></u>
            </div>
        </div>
    </div>
    <div class="aside col260 alpha no_bg">
        <ul class="custom_groups">
            <li class="addGroup establish"><a href="<?php echo Url::to(['/teacher/managepaper/index', 'department' => $department, 'subjectId' => $subjectId]) ?>" class="ac"><i></i>我的创建</a></li>
        </ul>
    </div>

    <div class="tch_question container col910 omega no_bg">
        <div class="container" style="margin-top:0">
            <div class="sUI_pannel collections">
                <div class="pannel_l"><a href="<?php echo Url::to(['/teacher/managepaper/index', 'department' => $department, 'subjectId' => $subjectId]) ?>" class="sel_ac" data-sel-item>我的创建</a></div>
            </div>
            <div class="pd25">
                <div class="sUI_formList sUI_formList_min classes_file_list">
                    <div id="classes_sel_list" class="row">
                        <div class="form_l tl ">
                            <a href="<?= Url::to(array_merge([''], $searchArr, ['getType' => ''])) ?>" class="<?php echo app()->request->getParam('getType') == '' ? 'sel_ac' : '' ?>" data-sel-item>全部类型</a>
                        </div>
                        <div class="form_r">
                            <ul>
                                <li>
                                    <a class="<?php echo app()->request->getParam('getType') == '0' ? 'sel_ac' : '' ?>"  href="<?= Url::to(array_merge([''], $searchArr, ['getType' => '0'])) ?>">纸质试卷</a>
                                </li>
                                <li>
                                    <a class="<?php echo app()->request->getParam('getType') == '1' ? 'sel_ac' : '' ?>"  href="<?= Url::to(array_merge([''], $searchArr, ['getType' => '1'])) ?>">电子试卷</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--试卷列表-->
        <div id="paper_list">
            <?php
            echo $this->render('_test_paper_list', array('data' => $data, 'pages' => $pages));
            ?>
        </div>
    </div>
</div>

<!--删除试卷-->
<div id="delPaper" class="popBox hide delPaper" title="删除试卷">
    <div class="popCont clearfix">
        <div class="ico fl"><i></i></div>
        <div class="span fl"><span>确认删除所选试卷吗？</span></div>
    </div>
    <div class="popBtnArea">
        <div class="btn_work">
            <button type="button" class="okBtn">确定</button>
            <button type="button" class="cancelBtn">取消</button>
        </div>
    </div>
</div>
