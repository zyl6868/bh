<?php
/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title="试题";
/**
 * Created by PhpStorm.
 * User: mahongru
 * Date: 15-8-19
 * Time: 下午6:01
 */
?>
    <!--主体-->
    <div class="cont24">
        <div class="grid24 main">
            <div class="video_topics">
                <div class="title">
                    <a href="<?= Url::to(array_merge(['/terrace/videopaper/index'])) ?>" class="txtBtn backBtn larrow"></a>
                    <h4>试卷选视频</h4>
                 </div>
                <div class="video_topics_con" id="questionsVideo">
                    <?php echo $this->render('_questions_video',array('pages' => $pages,'questions'=>$questions,'paperId'=>$paperId,'paperName' => $paperName,'offset'=>$offset))?>
                </div>
            </div>
        </div>
    </div>
    <!--主体end-->
    <script>
        $(function() {
            $('.tree').tree({
                openSubMenu: true,
                operate: false
            });
            $('.orderBar span').click(function() {
                $(this).addClass('ac').siblings().removeClass('ac');
            })
        })
    </script>
