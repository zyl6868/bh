<?php
/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2016/1/19
 * Time: 13:31
 */
use frontend\components\helper\AreaHelper;
use frontend\components\helper\DepartAndSubHelper;
use frontend\components\helper\listHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title='真题列表';
//公共
$searchArr = array(
    'department' => app()->request->getParam('department',$department),
    'subjectId' => app()->request->getParam('subjectId',$subjectId),
    'province' => app()->request->getParam('province'),
    'year' => app()->request->getParam('year'),
    'text'=>app()->request->getParam('text')
);
//左上角学部
$searchArray = array(
    'department' => app()->request->getParam('department',$department),
    'subjectId' => app()->request->getParam('subjectId',$subjectId),
);
//年份
$listYear=listHelper::listArray();
//省份
$listProvince=AreaHelper::getProvinceList();
//学段,年级
$departAndSubArray=DepartAndSubHelper::getvideoSubArray();
$this->blocks['requireModule']='app/platform/platform_video_topic_list';
?>
<div class="main col1200 clearfix platform_video_topic_list" id="requireModule" rel="app/platform/platform_video_topic_list">
    <div class="aside col260 alpha">
        <div class="currency_hg sel_classes">
            <div class="pd15">
                 <?php echo $this->render('@app/modules/platform/views/publicView/depart_and_sub_menu',
                    ['departAndSubArray'=>$departAndSubArray,'searchArr'=>$searchArray,'department'=>$department,'subjectId'=>$subjectId]);
                 ?>
            </div>
        </div>
    </div>
    <div class="container col910 omega currency_hg">
        <div class="sUI_pannel tab_pannel">
            <div class="pannel_l">
                <div class="sUI_tab">
                    <ul class="tabList clearfix">
                        <li><a href="javascript:;" class="ac">真题视频</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container classify">
        <div class="pd25">
            <div class="tc seFile" style="padding-top: 12px">
                    <span class="sUI_searchBar sUI_searchBar_max">
                         <?php echo Html::beginForm(array_merge([''],$searchArray),'get') ?>
                            <input id="mainSearch" type="text" class="text" name="text" value="<?=$text?>">
                            <button type="submit" class="searchBtn">搜索</button>
                        <?php echo Html::endForm() ?>
                    </span>
            </div>
            <div class="sUI_formList sUI_formList_min classes_file_list">
                <div id="class_sel_list" class="row  classes_sel_list">
                    <div class="form_l tl"><a data-sel-item class="<?=app()->request->getParam('year')==''?'sel_ac':''?>" href="<?=Url::to(array_merge(['video/index'],$searchArr,['year'=>'']))?>">全部年份</a> </div>
                    <div class="form_r moreContShow">
                        <ul>
                            <?php foreach($listYear as $key=>$val){?>
                                <li><a class="<?=app()->request->getParam('year')==$key?'sel_ac':''?>" data-sel-item href="<?=Url::to(array_merge(['video/index'],$searchArr,['year'=>$key]))?>"><?=$val;?></a></li>
                            <?php }?>
                        </ul>
                    </div>
                </div>
                <div id="class_sel_list" class="row  classes_sel_list">
                    <div class="form_l tl"><a data-sel-item class="<?=app()->request->getParam('province')==''?'sel_ac':''?>" href="<?=Url::to(array_merge(['video/index'],$searchArr,['province'=>'']))?>">全部地区</a> </div>
                    <div class="form_r moreContShow">
                        <ul>
                            <?php foreach($listProvince as $key=>$val){?>
                                <?php if($key<31){?>
                                    <li><a data-sel-item class="<?=app()->request->getParam('province')==$val['AreaID']?'sel_ac':''?>" href="<?=Url::to(array_merge(['video/index'],$searchArr,['province'=>$val['AreaID']]))?>"><?=$val['AreaName'];?></a></li>
                                <?php }?>
                            <?php }?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container classify test_questions no_bg">
        <div id="video">
            <?php echo $this->render('_videoList',array('videos'=>$videos,'page'=>$page))?>
        </div>

    </div>
</div>
