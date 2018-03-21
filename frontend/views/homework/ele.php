<?php
/**
 * Created by liuxing.
 * User: Administrator
 * Date: 2015/9/18
 * Time: 10:10
 */

$this->registerCssFile(BH_CDN_RES.'/static/css/media_source.css'.RESOURCES_VER, ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile(BH_CDN_RES . '/static/css/classes.css' . RESOURCES_VER);
$this->registerJsFile(BH_CDN_RES.'/static/js/app/classes/media_source.js', ['position' => \yii\web\View::POS_HEAD]);


$this->title = '作业详情';

?>

<!--top_end-->
<!--主体-->
<body class="platform">
<div class="main col800 clearfix platform_hmwk_veiw_ele">
    <div class="container homework_title">
        <h4 title="<?php echo $homeworkData->name; ?>"><?php echo $homeworkData->name; ?></h4>
    </div>

    <div class="container no_bg">
        <div class="testPaper">
            <?php foreach ($homeworkResult as $item) { ?>
                <?php echo $this->render('//publicView/new_class_homework/_itemPreviewType', array('item' => $item, 'homeworkData' => $homeworkData)); ?>
            <?php } ?>
        </div>
    </div>


</div>
</body>
<!--主体end-->

<script>
    //查看解析答案按钮
    $('.show_aswerBtn').click(function(){
        var _this=$(this);
        var pa=_this.parents('.quest')
        pa.toggleClass('A_cont_show');
        _this.toggleClass('icoBtn_close');
        if(pa.hasClass('A_cont_show')) _this.html('收起答案解析 <i></i>');
        else _this.html('查看答案解析 <i></i>');
    });
</script>
