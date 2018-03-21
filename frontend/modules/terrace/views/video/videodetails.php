<?php
/**
 * Created by unizk.
 * User: ysd
 * Date: 2015/5/3
 * Time: 16:15
 */
/* @var $this yii\web\View */  $this->title='视频详情';
?>
<div class="grid_24 main_r">
    <div class="main_cont video_detail">
        <div class="title"><a href="<?= url('terrace/video'); ?>" class="txtBtn backBtn"></a>
            <h4 title="<?= $model->title; ?>"><?= $model->title; ?></h4>
        </div>

        <div class="video_detail_cont">
            <div class="video">视频简介：<?= $model->introduce ?></div>
        </div>
        <div class="video_detail_cont">
            <div class="video">
                <video style="width: 800px" controls="controls">
                    <source src="/res<?= $model->resFileUri ?>">
                </video>
            </div>

        </div>
    </div>
</div>
