<?php
/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2016/4/27
 * Time: 19:23
 */
use yii\helpers\Url;

$this->title = "使用统计-激活统计";
$this->blocks['requireModule']='app/statistic/use_Statistics';
//$this->blocks['bodyclass'] = 'statistic';
?>

<div class="main col1200 clearfix useStatistic requireModule" id="requireModule" rel="app/statistic/use_Statistics">
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
                            <div class="TotalRegistration"><span><em><?php echo $studentNum;?></em>总注册量</span></div>
                            <div class="ActivationVolume"><span><em><?php echo $activateNum;?></em>激活量</span></div>
                            <div class="ActivationRatio"><span><em><?php echo $proportion;?>%</em>激活比例</span></div>
                        </div>

                        <div class="notActive">未激活：<span><?php echo $noActivate;?></span>位学生</div>

                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<script>


</script>

