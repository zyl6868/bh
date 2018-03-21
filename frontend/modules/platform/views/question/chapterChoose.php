<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/1/19
 * Time: 14:51
 */
use frontend\components\helper\TreeHelper;
use common\models\dicmodels\ChapterInfoModel;
use common\models\dicmodels\EditionModel;
use yii\helpers\Url;

$this->title='章节选题';
$searchArr= array(
    'department'=>$department,
    'subjectId'=>$subjectId,
);
$this->blocks['requireModule']='app/platform/platform_question_chapter';
?>
<div class="main col1200 clearfix platform_question_chapter" id="requireModule" rel="app/platform/platform_question_chapter">
<?php echo $this->render('top_nav',['searchArr'=>$searchArr,'department'=>$department,'subjectId'=>$subjectId])?>
<div class="aside col260 alpha no_bg">
<div class="asideItem">
    <div class="border">
        <div id="sel_course" class="sUI_select" style="border-bottom: 1px solid #f5f5f5">
            <em class="sUI_select_t"><?=EditionModel::model()->getName($version)?></em>
            <ul class="sUI_selectList pop">
            <?php foreach($versionList as $k=>$v){
                ?>
                <li><a href="<?=url::to(array_merge([''],$searchArr,['version'=>$k]))?>"><?=$v?></a></li>
            <?php } ?>
            </ul>
            <i class="sUI_select_open_btn"></i>
        </div>
        <?php if(!empty($chapterTomeResult)){?>
        <div id="sel_grade" class="sUI_select">
            <em class="sUI_select_t"><?=ChapterInfoModel::tomeName((int)$chapterId)?></em>
            <ul class="sUI_selectList pop">
                <?php foreach($chapterTomeResult as $v){ ?>
                <li><a href="<?=url::to(array_merge([''],$searchArr,['version'=>$version,'chapterId'=>$v->id]))?>"><?=$v->name?></a></li>
                <?php }?>
            </ul>
            <i class="sUI_select_open_btn"></i>
        </div>
        <?php }?>
    </div>
</div>
<div class="asideItem ">
    <div class="border">
        <div class="treeWrap" url="<?=url::to(array_merge([''],$searchArr,['version'=>$version]))?>">
            <div class="pd15" >
                <?php  echo TreeHelper::streefun($chapterTree,['onclick'=>"return getSearchList(this,'chapId');"],'tree pointTree')?>
            </div>
        </div>
    </div>
</div>
</div>


    <div class="content container col910 omega no_bg">
        <?php echo $this->render('content_view',['searchArr'=>$searchArrMore,'dataList'=>$dataList,'pages'=>$pages,'result'=>$result])?>
    </div>

</div>
<div id="quest_basket" class="quest_basket" department=<?=$department?>  subject=<?=$subjectId?> >
    <i class="ico_basket" onclick="jumpUrl()" ></i>
    <em class="q_num"></em>
    <b>选题篮</b>
</div>
<script>
    var getSearchList= function(obj,kid){
        chapterId = $(obj).attr('data-value');
        url=$(obj).parents('.treeWrap').attr('url');
        $.get(url, { chapterId: chapterId}, function (data) {
            $(".content").html(data);
        });
        return false;
    };
    var getContent=function(obj){
        var url=$(obj).attr('href');
        $.get(url,function(data){
            $(".content").html(data);
        });
        return false;
    }
</script>
