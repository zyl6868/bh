<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/1/19
 * Time: 11:51
 */
use frontend\components\helper\DepartAndSubHelper;
use yii\helpers\Url;

?>
<div class="aside col260 alpha">
    <div id="sel_classes" class=" currency_hg sel_classes">
        <div class="pd15">
          <?php   echo $this->render('@app/modules/platform/views/publicView/depart_and_sub_menu',[ 'departAndSubArray'=>DepartAndSubHelper::getTopicSubArray(),'searchArr'=>$searchArr,'department'=>$department,'subjectId'=>$subjectId]);?>
        </div>
    </div>
</div>
<div class="container col910 omega currency_hg">
    <div class="sUI_pannel tab_pannel">
        <div class="pannel_l">
            <div class="sUI_tab">
                <ul class="tabList clearfix">
                    <li><a href="<?=url::to(['/platform/question/chapter-choose','department'=>$department,'subjectId'=>$subjectId])?>" class="<?=$this->context->getRoute()=='platform/question/chapter-choose'?'ac':''?>">教材章节选题</a></li>
                    <li><a href="<?=url::to(['/platform/question/knowledge-choose','department'=>$department,'subjectId'=>$subjectId])?>" class="<?=$this->context->getRoute()=='platform/question/knowledge-choose'?'ac':''?>">知识点选题</a></li>
                    <li><a href="<?=url::to(['/platform/question/keywords-choose','department'=>$department,'subjectId'=>$subjectId])?>" class="<?=$this->context->getRoute()=='platform/question/keywords-choose'?'ac':''?>">搜索选题</a></li>
                </ul>
            </div>
        </div>
<!--        <div class="pannel_r favbar">-->
<!--            <span><a class="myFavBtn" href="javascript:;">我的收藏</a></span>&nbsp;&nbsp;&nbsp;|-->
<!--            <span><a class="creFavBtn" href="javascript:;">创建收藏</a></span>-->
<!--            <span><a id="addmemor_btn" class="btn bg_white icoBtn_add_blue addmemor_btn"><i></i>创建资源</a></span>-->
<!--        </div>-->
    </div>
</div>