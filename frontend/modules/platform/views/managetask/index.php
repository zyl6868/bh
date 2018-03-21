    <?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/3/24
 * Time: 17:55
 */
    use frontend\components\helper\TreeHelper;
    use common\components\WebDataCache;
    use common\models\dicmodels\ChapterInfoModel;
    use common\models\dicmodels\EditionModel;
    use common\models\dicmodels\SubjectModel;
    use yii\helpers\Url;

    $this->title='作业库';
$this->blocks['requireModule']='app/platform/platform_hmwk_list';
$searchArr= array(
    'department'=>$department,
    'subjectId'=>$subjectId,
    'level'=>$level
);
?>
<div class="main col1200 clearfix platform_hmwk_list" id="requireModule" rel="app/platform/platform_hmwk_list">
<div class="aside col260 alpha">
    <div id="sel_classes" class="currency_hg sel_classes">
        <div class="pd15">
            <h5><?=WebDataCache::getDictionaryName($department).SubjectModel::model()->getName((int)$subjectId)?></h5>
            <button id="show_sel_classesBar_btn" type="button" class="bg_white  icoBtn_change"><i></i>更换学科</button>
            <div id="sel_classesBar" class="sel_classesBar pop">
                <?php foreach($departAndSubArray as $k=>$v){?>
                    <dl>
                        <dt><?=WebDataCache::getDictionaryName($k)?></dt>
                        <?php foreach($v as $key=>$item){?>
                            <dd data-sel-item class="sel_ac"><a href="<?=Url::to(array_merge([''],$searchArr,['subjectId'=>$key,'department'=>$k]))?>"><?=$item?> </a></dd>
                        <?php }?>
                    </dl>
                <?php }?>
            </div>
        </div>
    </div>
</div>

<div class="container col910 omega currency_hg">
    <div class="sUI_pannel tab_pannel">
        <div class="pannel_l">
            <div class="sUI_tab">
                <ul class="tabList clearfix">
                    <li><a href="<?=url::to(['/platform/managetask/index','department'=>$department,'subjectId'=>$subjectId,'level'=>1])?>" class="<?=$level?'ac':''?>">精品作业</a></li>
                    <li><a href="<?=url::to(['/platform/managetask/index','department'=>$department,'subjectId'=>$subjectId,'level'=>0])?>" class="<?=$level==0?'ac':''?>">教师贡献作业</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>


<div class="aside col260 alpha no_bg">
<div class="asideItem">
    <div class="border  currency_hg1">
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

<div  id="hmwk">
    <?php echo  $this->render('content_view',[ 'chapterId'=>$chapterId,'dataList'=>$dataList,'searchArr'=>$searchArr,'pages'=>$pages,'level'=>$level,'difficulty'=>$difficulty])?>
</div>
</div>

<script>
    var getSearchList= function(obj,kid){
        chapterId = $(obj).attr('data-value');
        url=$(obj).parents('.treeWrap').attr('url');
        $.get(url, { chapterId: chapterId}, function (data) {
            $("#hmwk").html(data);
        });
        return false;
    };
    var getContent=function(obj){
        var url=$(obj).attr('href');
        $.get(url,function(data){
            $("#hmwk").html(data);
        });
        return false;
    }

</script>
