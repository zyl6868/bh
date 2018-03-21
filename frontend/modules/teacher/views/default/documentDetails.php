<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2015/4/29
 * Time: 17:02
 */
use common\models\pos\SeFavoriteMaterial;
use frontend\components\helper\ImagePathHelper;

/* @var $this yii\web\View */  $this->title='文档详情页';
?>
<script>
    $(function () {
        $('.collectionbtn').bind('click', function () {
            var $_this = $(this);
            var id = $_this.attr('collectID');
            var type = $_this.attr('typeId');
            var action = $_this.attr('action');

            $.post("<?php echo url('teacher/default/add-material')?>", {
                id: id,
                type: type,
                action: action
            }, function (data) {
                if (data.success) {
                    if (action == 1) {
                        $_this.attr('action', 0).text('取消收藏');
	                    popBox.successBox('收藏成功！');
                    }
                    else {
                        $_this.attr('action', 1).text('收藏');
	                    popBox.successBox('取消成功！');
                    }
                } else {
                    popBox.alertBox(data.message);
                }
            });
        });
        $('.correctPaper').testpaperSlider();
    })
</script>

<!--主体-->

    <div class="grid_16 alpha omega main_l">
        <div class="main_cont docDetail">
            <div class="tab">
                <?php echo $this->render('_teacher_file_url', array('teacherId' => $teacherId)) ?>
                <div class="tabCont">
                    <?php foreach ($result as $val) {
                        //是否收藏过
                        $isCollect = SeFavoriteMaterial::find()->where(['userId'=>user()->id,'favoriteId'=>$val->id])->exists();
                        $arr = ImagePathHelper::resImage($val->url);
                        ?>
                        <div class="tabItem">
                            <div class="title item_title noBorder">
                                <h4><?php echo $val->name; ?></h4>
                            </div>
                            <p>简介：<span><?php echo strip_tags($val->matDescribe); ?></span></p>

                            <div class="check_div">
                                <a href="<?php echo url('ajax/download-file',array('id'=>$val->id));?>" class="btn white w100 bg_blue">下载</a>&nbsp;
                                <?php if (count($arr) == 0) { ?>
                                    <a target="_blank"
                                       href="http://officeweb365.com/o/?i=5362&furl=<?= urlencode(ImagePathHelper::resUrl1($val->url)); ?>"
                                       class="btn white w100 bg_blue">预 览</a>
                                <?php } ?>
                                <?php if($listType == 2) { ?>
                                    <?php if (empty($isCollect)) { ?>
                                        <button action="1" collectID="<?php echo $val->id; ?>"
                                                typeId="<?php echo $val->matType; ?>" type="button"
                                                class="btn w100 bg_blue_l collectionbtn" style="margin-left:10px;">收 藏
                                        </button>
                                    <?php } else { ?>
                                        <button action="0" collectID="<?php echo $val->id; ?>"
                                                typeId="<?php echo $val->matType; ?>" type="button"
                                                class="btn w100 bg_blue_l collectionbtn" style="margin-left:10px;">取消收藏
                                        </button>
                                <?php
                                        }
                                    }
                                ?>
                            </div>
                            <?php if (!empty($arr)): ?>
                                <div class=" font16 tr pageCount" style="padding-right:10px"></div>
                                <div class="correctPaper" style="border:1px solid #ddd; padding:30px">
                                    <div class="testPaperWrap mc pr">
                                        <ul class="testPaperSlideList slid">
                                            <?php foreach ($arr as $i): ?>
                                                <li><img src="<?= $i ?>" style="width: 685px"/></li>
                                            <?php endforeach ?>

                                        </ul>
                                        <a href="javascript:;" id="prevBtn" class="correctPaperPrev">上一页</a> <a
                                            href="javascript:;" id="nextBtn" class="correctPaperNext"
                                            style="right: 160px">下一页</a>
                                    </div>
                                </div>
                            <?php endif ?>
                            <div class="vidao">
                                <!--								文件阅读器-->
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

    </div>
    <?php echo $this->render('_teacher_file_right', array('answerResult' => $answerResult, 'teacherId' => $teacherId)); ?>

