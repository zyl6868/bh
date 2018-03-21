<?php
/**
 * Created by unizk.
 * User: ysd
 * Date: 2015/5/1
 * Time: 14:45
 */
/* @var $this yii\web\View */
$this->title='班级文件详情';
use frontend\components\helper\ImagePathHelper;
use yii\helpers\Url;


$arr= ImagePathHelper::resImage($model->url);
?>
<script>
    $(function(){
        $('.correctPaper').testpaperSlider();
    });
</script>
<div class="main_cont">
    <div class="title">
        <a class="txtBtn backBtn" href="<?=Url::to(['class/class-file','classId'=>app()->request->getQueryParam('classId')])?>"></a>
        <h4>班级文件详情</h4>

    </div>
    <div class="title item_title noBorder">
        <h5><?php if(!empty($model->name)){echo $model->name;} ?></h5>
    </div>
    <p class="synopsis"><span>简介：</span><?php if(!empty($model->matDescribe)){echo $model->matDescribe;}?></p>
    <div class="check_div">
        <a href="<?php echo url('/ajax/download-file',array('id'=>$id));?>" class="btn white btn40 w140 bg_blue">下载</a>&nbsp;
        <?php if (count($arr) == 0) { ?>
            <a target="_blank" href="http://officeweb365.com/o/?i=5362&furl=<?=urlencode(ImagePathHelper::resUrl1($model->url)); ?>"
               class="btn white btn40 w140 bg_blue">预 览</a>
        <?php } ?>
        <?php if(loginUser()->isTeacher()){?>
        <a href="javascript:;" class="btn white btn40 w140 bg_blue collectionbtn">
            <?php
            if($model->isCollected ==1){
                echo '已收藏';
            }elseif($model->isCollected ==0){
                echo '收藏';
            }
            ?>
        </a>
        <?php }?>
    </div>

    <br>
    <?php if(!empty($arr)): ?>
        <div class=" font16 tr pageCount" style="padding-right:10px"></div>
        <div class="correctPaper" style="border:1px solid #ddd; padding:30px">
            <div class="testPaperWrap mc pr" style="width:650px">
                <ul class="testPaperSlideList slid" style="width:auto">
                    <?php   foreach($arr  as  $i): ?>
                    <li><img src="<?=$i ?>"  /></li>
                    <?php endforeach ?>

                </ul>
                <a href="javascript:;" id="prevBtn" class="correctPaperPrev">上一页</a>
                <a href="javascript:;" id="nextBtn" class="correctPaperNext">下一页</a>
            </div>
        </div>
    <?php endif ?>
</div>

<script type="text/javascript">
	$(function(){
		$('.collectionbtn').click(function(){
			var _this = $(this);
			var id ="<?=$model->id?>";
			var type = "<?= $model->matType;?>";
			$.post("<?=url('/class/collect');?>",{id:id,type:type},function(data){
				_this.text('已收藏');
			});
		});
	})
</script>