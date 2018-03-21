<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/19
 * Time: 17:23
 */
use common\helper\DateTimeHelper;
use frontend\components\helper\ImagePathHelper;
use frontend\components\helper\ViewHelper;
use common\components\WebDataCache;
use common\models\dicmodels\FileModel;
use yii\helpers\Html;
use yii\helpers\Url;

$arr = [
    'department' => $department,
    'subjectId' => $subjectId,
    'fileName' => $fileName,
    'edition' => $edition,
    'tome' => $tome,
];

$sortType= app()->request->get('sortType');
?>

<div class="container col910 omega currency_hg1">
    <div id="classes_sel_list" class="sUI_formList" style="margin-left: 20px">
        <div class="row  classes_file_list">
            <div class="form_l tl"><a class="<?php echo '' == $mattype ? 'sel_ac' : ''; ?> select_mattype" data-sel-item
                                      href="javascript:;"
                                      data-url="<?= Url::to(array_merge([''], $arr, array('sortType' => $sortType, 'mattype' => ''))) ?>">全部类型</a>
            </div>
            <div class="form_r">
                <ul>
                    <?php
                    $file = FileModel::model()->getList();
                    foreach ($file as $val) {
                        ?>
                        <li>
                            <a data-sel-item
                               class="<?php echo $mattype == $val->secondCode ? 'sel_ac' : ''; ?> select_mattype"
                               href="javascript:;"
                               data-url="<?= Url::to(array_merge([''], $arr, ['sortType' => $sortType, 'mattype' => $val->secondCode])) ?>"><?= $val->secondCodeValue ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>

        </div>
    </div>
</div>

<div class="container col910 omega classify no_bg">
    <div class="no_bg">
        <div class="sUI_pannel bg_blue_l classes_fList">
            <div class="pannel_l clsoption_list">
                <span class="sort_a"><i class="bq1"></i>排序</span>
                        <span>
                        <a class="read <?php if ($sortType == 'readNum') {
                            echo 'cur';
                        } ?> sort_search"
                           data-url="<?= Url::to(array_merge([''], $arr, ['sortType' => 'readNum', 'mattype' => $mattype])) ?>"
                           href="javascript:;"><i></i>阅读</a>
                    </span>
                    <span>
                        <a class="fav <?php if ($sortType == 'favoriteNum') {
                            echo 'cur';
                        } ?> sort_search"
                           data-url="<?= Url::to(array_merge([''], $arr, ['sortType' => 'favoriteNum', 'mattype' => $mattype])) ?>"
                           href="javascript:;"><i></i>收藏</a>
                    </span>
                    <span>
                        <a class="download <?php if ($sortType == 'downNum') {
                            echo 'cur';
                        } ?> sort_search"
                           data-url="<?= Url::to(array_merge([''], $arr, ['sortType' => 'downNum', 'mattype' => $mattype])) ?>"
                           href="javascript:;"><i></i>下载</a>
                    </span>
            </div>
        </div>

        <?php
        if (empty($materialList)) {
            echo ViewHelper::emptyView("无数据！");
        } else {
            ?>
            <ul class="sUI_dialog_list cls_rList clearfix">
                <?php foreach ($materialList as $material) { ?>
                    <li class="<?php
                    /** @var common\models\sanhai\SrMaterial $material */
                    if ($material->isNewFile()) {
                        echo 'news';
                    } ?>">
                        <div class="cls_lf_list">
                            <span class="file_cls <?php echo ImagePathHelper::getNewFilePic($material->url); ?>"></span>

                            <div class="sUI_pannel sUI_pannel_min">
                                <h5>

                                    <a class="addReadNum" id="previewMaterial" fileId="<?php echo $material->id;?>" href="javascript:;" target="_blank" title="<?= Html::encode($material->name) ?>">
                                        <?= \yii\helpers\Html::encode($material->name) ?>
                                    </a>

                                </h5>
                            </div>
                            <div class="sUI_pannel in_troduces">
                            <span><?php if (!empty($material->creator)) {
                                    echo WebDataCache::getTrueNameByuserId($material->creator);
                                } else {
                                    echo '系统';
                                } ?> <?php if (!empty($material->updateTime)) {
                                    echo date('Y-m-d H:i', DateTimeHelper::timestampDiv1000($material->updateTime));
                                } ?>更新</span>
                            </div>
                        </div>
                        <div class="cls_rg_list">
                            <a class="read addReadNum" id="previewMaterial"  fileId="<?php echo $material->id;?>" href="javascript:;"
                               target="_blank"><i></i><br>阅读(<span class="readNum"><?= $material->readNum ?></span>)</a>

                            <a class="fav" href="javascript:;" id="collectMaterial"
                               data-id="<?= $material->id ?>" data-type="<?= $material->matType ?>"
                               data-url="<?php echo Url::to('/ajax/collect-material'); ?>"
                               data-url-cancel="<?php echo Url::to('/ajax/cancel-collect-material') ?>"><i></i><br>
                                <span class="collection">收藏</span>
                                (<span class="collectionNum"><?= $material->favoriteNum; ?></span>)</a>

                            <a class="download" target="_blank" id="downloadMaterial" fileId="<?php echo $material->id;?>" price="<?php echo $material->price;?>"
                               href="javascript:;"><i></i><br>下载(<span class="downloadNum"><?= $material->downNum ?></span>)</a>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
        <?php
        echo \frontend\components\CLinkPagerNormalExt::widget(array(
                'firstPageLabel' => false,
                'lastPageLabel' => false,
                'pagination' => $pages,
                'updateId' => '#classFile',
                'maxButtonCount' => 8,
            )
        );
        ?>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        //页面加载判断课件是否已收藏
        var materialIdArray = [];
        $('.sUI_dialog_list .fav').each(function (index, el) {
            var materialId = $(el).attr('data-id');
            materialIdArray.push(materialId);
        });
        $.post("/ajax/file-is-collected", {materialIdArray: materialIdArray}, function (result) {
            var materialIdArray = result.data;

            $('.sUI_dialog_list .fav').each(function (index, el) {
                if ($.inArray($(el).attr('data-id'), materialIdArray) > -1) {
                    $(el).addClass('cur');
                    $(el).find('.collection').html('取消收藏');
                }
            });
        });
    })
</script>
