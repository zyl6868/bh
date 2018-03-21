<?php
/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2016/1/19
 * Time: 13:58
 */
/** @var ShTestquestion[] $questionModel */
use common\models\sanhai\ShTestquestion;
use frontend\components\helper\ViewHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title="视频库-题列表";
$this->blocks['requireModule']='app/classes/tch_hmwk_veiw_ele';
?>
<div class="main col1200 clearfix platform_video_list" id="requireModule" rel="app/classes/tch_hmwk_veiw_ele">
    <div class="container homework_title">
        <a href="javascript:history.back(-1);" class="btn bg_gray icoBtn_back return_btn"><i></i>返回</a>
        <h4><?=$videoModel->paperName;?></h4>
    </div>
    <?php
    if(!empty($questionModel)){ $i=1;?>
        <?php foreach($questionModel as $key=>$val){?>
            <div class="container video_topics_con">
                <div class="pd25 clearfix">
                    <dl class="form_list">
                        <dt class="formL">
                            <a href="<?= Url::to(array_merge(['video/detail'],['id'=>$val->id])) ?>"><img src="<?=BH_CDN_RES.'/static/images/cat_big.jpg'?>" alt=""></a>
                        </dt>
                        <dd class="formR">
                            <h6><?=$i.".";?><?=$val->processContent()?></h6>
                        </dd>
                        <dd class="qr_code">
                            <img src="<?= url('qrcode/video/'.$val->id) ?>" alt="">
                            <span>扫一扫</span>
                        </dd>
                    </dl>
                </div>
            </div>
        <?php $i++;}?>
    <?php }else{?>
        <?php ViewHelper::emptyView(); ?>
    <?php }?>
</div>