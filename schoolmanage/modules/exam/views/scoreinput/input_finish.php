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
$this->blocks['requireModule']='app/sch_mag/sch_mag_input_finish';
?>
    <div class="main col1200 clearfix sch_mag_input" id="requireModule" rel="app/sch_mag/sch_mag_input_finish">
        <div class="container testTitle">
            <?php echo $this->render('_public_title',['examName'=>$examName,'department'=>$department]);?>
        </div>
        <div class="container input_banner"><img src="<?=BH_CDN_RES;?>/static/images/school_banner.jpg"></div>
        <div class="container">
            <div class="pd25">
                <ul id="classes_list" class="classes_list">
                    <?php foreach($examClass as $v):
                        $class = 'undo';
                        $ac = '';
                        if($v[2] == $classId){$ac = 'ac';}
                        if($v[1] == 0){$class = 'undo';}elseif($v[1] == 1){$class = 'half';}elseif($v[1] == 2){$class = 'finish';}
                        ?>
                        <li><a class="<?php echo $class,' ',$ac;?>" href="<?php echo Url::to(['check-class','classId'=> $v[2],'examId'=>$schoolExamId])?>" ><?php echo $v[0]?><i></i></a></li>
                    <?php endforeach;?>
                </ul>
                <?php echo  $this->render('_public_score')?>
                <hr>
                <div id="editCont" class="edit_show editCont">
                    <?php echo  $this->render('_teacher_link',['schoolExamId'=>$schoolExamId,'classId'=>$classId,'subjectList'=>$subjectList,'schoolId'=>$schoolId])?>
                    <div class="sUI_pannel editBtnBar hide">
                        <div class="pannel_r"><span><button id="editBtn" type="button" class="bg_blue">编辑</button></span> </div>
                    </div>
                    <br>

                    <!-- 表格区-->
                    <div id="input_table_bar" class="input_table_bar">
                    </div>
                    <br>
                    <div class="tc" style="padding:20px 0 10px">
                        <span class="tab_text gray_l"><i></i>横向切换键：tab或enter键</span> <i class="ico_excel"></i> 下载Excel成绩导入模板 <a href="<?=url('template/template.xlsx')?>" >点此下载</a>
                    </div>
                </div>

            </div>


        </div>
    </div>

<script>
    data = <?php echo json_encode($data);?>;
</script>