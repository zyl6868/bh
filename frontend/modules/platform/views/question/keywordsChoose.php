<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/1/18
 * Time: 11:02
 */
use yii\helpers\Html;

$this->registerCssFile(BH_CDN_RES.'/static'.'/css/platform.css');
$this->title='搜索选题';
$searchArr= array(

    'department'=>app()->request->getParam('department',$department),
    'subjectId'=>app()->request->getParam('subjectId',$subjectid),
);
$this->blocks['requireModule']='app/platform/platform_question_search';
?>
<div class="main col1200 clearfix platform_question_search" id="requireModule" rel="app/platform/platform_question_search">
 <?php echo $this->render('top_nav',['searchArr'=>$searchArr,'department'=>$department,'subjectId'=>$subjectid])?>
    <div class="container" style="padding-top: 10px">
    <div class="tc seFile">
                    <span class="sUI_searchBar sUI_searchBar_max">
                       <?php
                             echo Html::beginForm(array_merge([''],$searchArr),'get') ?>
                        <input id="mainSearch" type="text" name="text" class="text" value="<?=$text?>"><button type="submit" class="searchBtn">搜索</button>
                        <?php echo Html::endForm() ?>
                </span>
    </div>
        </div>

    <div class="content">
        <?php echo $this->render('content_view',['searchArr'=>$searchArrMore,'dataList'=>$dataList,'pages'=>$pages,'result'=>$result])?>

    </div>
</div>

<div id="quest_basket" class="quest_basket" department=<?=$department?>  subject=<?=$subjectid?> >
    <i class="ico_basket" onclick="jumpUrl()" ></i>
    <em class="q_num"></em>
    <b>选题篮</b>
</div>