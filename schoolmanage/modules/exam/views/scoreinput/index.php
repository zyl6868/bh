<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/16
 * Time: 10:17
 */
use yii\helpers\Url;

/** @var $this yii\web\View */
$this->title = '考务管理-成绩录入';
?>
<div class="main col1200 clearfix sch_mag_input" id="requireModule" rel="">
    <div class="container testTitle">
        <?php echo $this->render('_public_title',['examName'=>$examName,'department'=>$department]);?>
    </div>
    <div class="container input_banner"><img src="<?=BH_CDN_RES;?>/static/images/school_banner.jpg"></div>
    <div class="container">
        <div class="pd25">
            <ul id="classes_list" class="classes_list">
                <?php foreach($examClass as $v):
                    $class = 'undo';
                    if($v[1] == 0){$class = 'undo';}elseif($v[1] == 1){$class = 'half';}elseif($v[1] == 2){$class = 'finish';}
                    ?>
                    <li><a class="<?php echo $class;?>" href="<?php echo Url::to(['check-class','classId'=> $v[2],'examId'=>$schoolExamId])?>" ><?php echo $v[0]?><i></i></a></li>
                <?php endforeach;?>
<!--                <li><a class="half" href="javascript:;">高二2班<i></i></a></li>-->
<!--                <li><a class="undo" href="javascript:;">高三3班<i></i></a></li>-->
            </ul>
            <?php echo  $this->render('_public_score')?>
            <hr>

                <div class="tc" style="padding:20px 0 10px">
                    <i class="ico_excel"></i> 下载Excel成绩导入模板 <a href="<?=url('template/template.xlsx')?>" >点此下载</a>
                </div>

        </div>


    </div>
</div>
