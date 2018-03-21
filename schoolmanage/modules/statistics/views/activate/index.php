<?php
/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2016/4/27
 * Time: 19:23
 */
use common\models\dicmodels\SubjectModel;
use frontend\components\CHtmlExt;
use common\models\dicmodels\SchoolLevelModel;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "使用统计-激活统计";
$this->blocks['requireModule']='app/statistic/use_Statistics';
//$this->blocks['bodyclass'] = 'statistic';
?>

<div class="main col1200 clearfix useStatistic" id="requireModule" rel="app/statistic/use_Statistics">
    <div class="aside col260 no_bg  alpha">
        <div class="asideItem">
            <div class="sel_classes">
                <div class="pd15">
                    <h5>使用统计</h5>
                </div>
            </div>
        </div>
        <div class="left_menu">
            <?php echo $this->render("/publicView/_personnel_left") ?>
        </div>
    </div>
    <div class="container col910  omega use_statistics">
        <div class="sUI_tab">
            <ul class="tabList clearfix">
                <li>
                    <a class="<?php echo $this->context->highLightUrl(['statistics/activate/index']) ? 'ac' : ''?>" href="<?php echo Url::to("/statistics/activate/index")?>">教师</a>
                </li>
                <li>
                    <a class="<?php echo $this->context->highLightUrl(['statistics/activate/student']) ? 'ac' : ''?>" href="<?php echo Url::to("/statistics/activate/student")?>">学生</a>
                </li>
                <!--<li>
                    <a class="<?php /*echo $this->context->highLightUrl(['statistics/activate/home']) ? 'ac' : ''*/?>" href="<?php /*echo Url::to("/statistics/activate/home")*/?>">家长</a>
                </li>-->
            </ul>
            <div class="tabCont">
                <div class="tabItem">
                    <div class="Batch_statistics pd25">
                        <div class="activation clearfix">
                            <div class="TotalRegistration"><span><em><?php echo $teacherNum;?></em>总注册量</span></div>
                            <div class="ActivationVolume"><span><em><?php echo $activateNum;?></em>激活量</span></div>
                            <div class="ActivationRatio"><span><em><?php echo $proportion;?>%</em>激活比例</span></div>
                        </div>
                        <div class="selector">
                            <?php echo CHtmlExt::dropDownListAjax(Html::getAttributeName('departmentId'), "", SchoolLevelModel::model()->getListInData($departmentArray), array(
                                'prompt' => '学段(全部)',
                                'data-validation-engine' => 'validate[required]',
                                'data-prompt-target' => "department_prompt",
                                'data-prompt-position' => "inline",
                                'id' => 'departmentId',
                                'ajax' => [
                                    'url' => Yii::$app->urlManager->createUrl('statistics/activate/get-subject'),
                                    'data' => ['department' => new \yii\web\JsExpression('this.value')],
                                    'success' => 'function(html){jQuery("#' . 'subjectId' . '").html(html).change();}'
                                ],
                            )) ?>

                            <?php echo CHtmlExt::dropDownListAjax(Html::getAttributeName('subjectId'), "", SubjectModel::model()->getListData(), array(
                                'prompt' => '学科(全部)',
                                'data-validation-engine' => 'validate[required]',
                                'data-prompt-target' => "grade_prompt",
                                'data-prompt-position' => "inline",
                                'id' => 'subjectId',
                            )) ?>
                        </div>
                        <!--<div class="notActive">未激活：<span><?php /*echo $noActivate;*/?></span>位老师</div>-->
                        <div class="notActive">未激活：<em class="nub_of_peo_em"><?php echo $numberOfPeople?></em>&nbsp;位教师</div>
                        <div id="personnel_list">
                            <?php echo $this->render("_teacher_list", ["userInfo" => $userInfo, "pages" => $pages, "numberOfPeople" => $numberOfPeople]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

