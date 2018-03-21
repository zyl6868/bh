<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/1/19
 * Time: 14:55
 */
use frontend\components\helper\TreeHelper;
use yii\helpers\Url;

$this->title='知识点选题';
$searchArr= array(
    'department'=>$department,
    'subjectId'=>$subjectid
);
$this->blocks['requireModule']='app/platform/platform_question_point';
?>
<div class="main col1200 clearfix platform_question_point" id="requireModule" rel="app/platform/platform_question_point">
<?php echo $this->render('top_nav',['searchArr'=>$searchArr,'department'=>$department,'subjectId'=>$subjectid])?>


<div class="aside col260 alpha no_bg">
<div class="asideItem ">
    <div class="border">
        <div class="treeWrap" url="<?=url::to(array_merge([''],$searchArr))?>">
            <div class="pd15">
                <?php  echo TreeHelper::streefun($knowtree,['onclick'=>"return getSearchList(this,'kid');"],'tree pointTree')?>
            </div>
        </div>
    </div>
</div>
</div>

    <div class="content container col910 omega no_bg">
<?php echo $this->render('content_view',['kid'=>$kid,'searchArr'=>$searchArr,'dataList'=>$dataList,'pages'=>$pages,'result'=>$result])?>
</div>

</div>
<div id="quest_basket" class="quest_basket" department=<?=$department?>  subject=<?=$subjectid?> >
    <i class="ico_basket" onclick="jumpUrl()" ></i>
    <em class="q_num"></em>
    <b>选题篮</b>
</div>
<script>
    var getSearchList= function(obj,state){
        kid = $(obj).attr('data-value');
        url=$(obj).parents('.treeWrap').attr('url');
        $.get(url, { kid: kid}, function (data) {
            $(".content").html(data);
        })
    };
    var getContent=function(obj){
        var url=$(obj).attr('href');
        $.get(url,function(data){
            $(".content").html(data);
        });
        return false;
    }

</script>