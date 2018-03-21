<?php
/**
 * Created by zyl.
 * User: zyl
 * Date: 17-03-30
 * Time: 下午6:59
 */
use common\models\pos\SeHomeworkTeacher;

/**
 *@var array $gradeInfoArr
 *@var integer $homeworkType
 *@var integer $gradeId
 *@var $this yii\web\View
 */

$this->title="教师-精品作业";

$this->registerCssFile(BH_CDN_RES.'/static/css/teacher_MyMessage.css'.RESOURCES_VER);
$this->registerCssFile(BH_CDN_RES.'/static/css/teacher_remind_message.css'.RESOURCES_VER);
$this->blocks['requireModule'] = 'app/teacher/teacher_remind_message';

?>

<div id="main" class="clearfix main" style="min-height:700px;"  >
    <!-- 主体左侧 -->
    <div id="main_left" class="main_left">
        <?php echo $this->render('_message_nav')?>
    </div>
    <div id="main_right" class="main_right">
        <ul id="tab" class="tab_sub">
            <?php echo $this->render("_quality_work_sel",['homeworkType'=>$homeworkType]);?>
        </ul>
        <ul id="gradeName">
            <?php
            foreach ($gradeInfoArr as $k=>$v){
                $class = '';
                if ($gradeId == $k){
                    $class = 'ac';
                }
                ?>
                <li class="<?php echo $class;?>" value="<?php echo $k;?>"><?php echo $v;?></li>
            <?php } ?>
        </ul>
        <div class="tab_1 notice main_h4" id="qualityWork">
            <?php echo $this->render('_homework_list',array('model'=>$model,'pages' => $pages));?>
        </div>

    </div>
</div>


<script>
    $('#gradeName').find('li').click(function () {
        var homeworkType = <?php echo is_array($homeworkType) ? SeHomeworkTeacher::LISTEN_HOMEWORK : $homeworkType;?>;
        $('#gradeName').find('li').removeClass('ac');
        $(this).addClass('ac');
        var gradeId = $(this).val();
        $.get('/teacher/message/quality-work',{gradeId: gradeId,homeworkType:homeworkType},function(data){
            $("#qualityWork").html(data);
        })
    })
</script>