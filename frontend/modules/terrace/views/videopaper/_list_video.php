<?php
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-11-18
 * Time: 上午11:01
 */
use frontend\components\CLinkPagerExt;
use frontend\components\helper\ViewHelper;
use yii\helpers\Url;

/**
 * Created by PhpStorm.
 * User: mahongru
 * Date: 15-8-19
 * Time: 下午6:01
 */

?>
<script type="text/javascript">
    $(function(){
        $('.showVideo').click(function(){
            var id = $(this).attr('datatype');
            location.href="<?= Url::to(['/terrace/video/video-details']);?>"+"?id="+id;
        });
    })

</script>
<ul class="videoList clearfix">
    <?php if($papers) : ?>
    <?php foreach($papers as $paper) :?>
        <li class="cur">
            <h4><a href="<?= Url::to(array_merge(['/terrace/videopaper/video'],['paperId'=>$paper->paperId])) ?>" title="<?= $paper->paperName ?>"><?= \frontend\components\helper\StringHelper::cutStr($paper->paperName,33) ?></a></h4>
            <dl class="exam">
                <?php if(!empty($paper->department)) : ?>
                <dt><?php echo $paper->department == '20202' ? '中考真题' : '高考真题' ?>&nbsp;&nbsp;|</dt>
                <?php endif; ?>
                <?php if(!empty($paper->year)) : ?>
                <dt><?= $paper->year ?>年</dt>
                <?php endif; ?>
            </dl>
            <dl class="exam examc">
                <dt>总题数:&nbsp;&nbsp;<?= $paper->allquestionCount ?></dt>
            </dl>
            <dl class="exam examc">
                <?php if(!empty($paper->updateTime)) : ?>
                <dt>更新时间:<?= date("Y-m-d H:i",$paper->updateTime/1000) ?></dt>
                <?php endif; ?>
            </dl>
        </li>
        <?php endforeach; ?>
    <?php else : ?>
    <?php ViewHelper::emptyView(); ?>
    <?php endif; ?>
</ul>
<br>


    <?php
     echo CLinkPagerExt::widget( array(
           'pagination'=>$pages,
            'updateId' => '#video',
            'maxButtonCount' => 10
        )
    );
    ?>
