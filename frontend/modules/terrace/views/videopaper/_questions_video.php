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
 * Date: 15-8-27
 * Time: 下午14:10
 */

?>
<h5><?= $paperName ?></h5>
<?php if(!empty($questions)) : ?>
    <?php foreach($questions as $key => $question) : ?>
        <dl class="form_list">
            <dt class="formL">
                <a href="<?= Url::to(array_merge(['/terrace/videopaper/video-details'],['paperId'=>$paperId,'id'=>$question->id])) ?>"><img src="<?= BH_CDN_RES.'/pub/images/cat_big.jpg'?>" alt=""></a>
            </dt>
            <dd class="formR">
                <h6><?= $offset+$key+1 ?> : <?= $question->content ?></h6>
            </dd>
            <dd class="qr_code">
                <span>扫一扫</span>
                <img src="<?= url('qrcode/video/'.$question->id) ?>" alt="" width="100" height="100">
            </dd>
        </dl>
    <?php endforeach; ?>
<?php else : ?>
    <?php ViewHelper::emptyView('该试卷暂无题目！') ?>
<?php endif; ?>


    <?php
     echo CLinkPagerExt::widget( array(
           'pagination'=>$pages,
            'updateId' => '#questionsVideo',
            'maxButtonCount' => 10
        )
    );
    ?>
