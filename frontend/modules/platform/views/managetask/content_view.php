<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/1/21
 * Time: 16:59
 */
use common\helper\DateTimeHelper;
use frontend\components\helper\AreaHelper;
use frontend\components\helper\ViewHelper;
use common\components\WebDataCache;
use frontend\models\dicmodels\ChapterInfoModel;
use common\models\dicmodels\EditionModel;
use common\models\dicmodels\SubjectModel;
use yii\helpers\Url;

?>

<div class="container col910 omega currency_hg1">
    <div class="sUI_formList  classes_file_list" style="margin-left: 20px">
        <div id="hard_list" class="row">
            <div class="form_l tl"><a data-sel-item onclick="return getContent(this)"  class="<?php echo app()->request->getParam('difficulty', '') == null ? 'sel_ac' : ''; ?>" href="<?= Url::to(array_merge([''], $searchArr, ['difficulty' => null])); ?>">全部难度</a></div>
            <div class="form_r">
                <ul>
                    <li><a  onclick="return getContent(this)" class="<?php echo app()->request->getParam('difficulty', '')!=null&app()->request->getParam('difficulty', '') == 0 ? 'sel_ac' : ''; ?>"  href="<?= Url::to(array_merge([''], $searchArr, [ 'chapterId'=>$chapterId,'difficulty' => 0])); ?>">普通<i class="dif_state dif_easy"></i></a></li>
                    <li><a  onclick="return getContent(this)" class="<?php echo app()->request->getParam('difficulty', '') == 1 ? 'sel_ac' : ''; ?>"  href="<?= Url::to(array_merge([''], $searchArr, [ 'chapterId'=>$chapterId,'difficulty' => 1])); ?>">中等<i class="dif_state dif_mid"></i></a></li>
                    <li><a  onclick="return getContent(this)" class="<?php echo app()->request->getParam('difficulty', '') == 2 ? 'sel_ac' : ''; ?>"  href="<?= Url::to(array_merge([''], $searchArr, [ 'chapterId'=>$chapterId,'difficulty' => 2])); ?>">较难<i class="dif_state dif_hard"></i></a></li>
                </ul>
            </div>
        </div>
    </div>

</div>



<div class="container col910 omega no_bg" >
    <?php if(!empty($dataList)){?>
    <ul class="hmwk_list">
        <?php
            if($level==0){
                foreach($dataList as $data){
                    $schoolId=WebDataCache::getSchoolIdByUserId($data->creator);
                    $schoolName=WebDataCache::getSchoolNameBySchoolId($schoolId);
                    $subjectName=SubjectModel::model()->getName((int)$data->subjectId);
                    $departmentName=WebDataCache::getDictionaryName($data->department);
                    $gradeName= \common\models\dicmodels\GradeModel::model()->getGradeName($data->gradeId);
                    $editionName=EditionModel::model()->getName($data->version);
                    /** @var common\models\pos\SeHomeworkPlatform $data */
                    ?>
            <li class="<?php if($data->isNewHomework()){echo 'news';} ?>">
                <span class="hmwk_cls hmwk_word"></span>
                <h5><a href="<?=Url::to(['/teacher/managetask/pushed-library-details','homeworkID'=>$data->id])?>"><?php echo '<em>'.ChapterInfoModel::getNamebyId($data->chapterId).'('.$departmentName.$subjectName.$editionName.$gradeName.')</em>'.'&nbsp&nbsp'. AreaHelper::getAreaName($data->provience);?>·<?php echo AreaHelper::getAreaName($data->city);?>·<?=$schoolName?></a></h5>
                <h6 class="gray">原标题:<?php echo $data->name;?></h6>
                <p><img class="owner_img" src="<?=WebDataCache::getFaceIconUserId($data->creator)?>"><?php echo \common\components\WebDataCache::getTrueNameByuserId($data->creator);?> <?php if (!empty($data->uploadTime)) {
                        echo date('Y-m-d', DateTimeHelper::timestampDiv1000($data->uploadTime));
                    } ?> 贡献到平台</p>
                <p>难度:<?php if($data->difficulty==0) {
                        echo '<i class="dif_state dif_easy"></i>';
                    }elseif($data->difficulty==1)  {
                        echo '<i class="dif_state dif_mid"></i>';
                    }elseif($data->difficulty==2){
                        echo '<i class="dif_state dif_hard"></i>';
                    }
                    ?></p>
                <p>简介:<?php echo $data->homeworkDescribe;?></p>
            </li>
        <?php } }?>

        <?php  if($level==1){ foreach($dataList as $data){
            $schoolId=WebDataCache::getSchoolIdByUserId($data->creator);
            $schoolName=WebDataCache::getSchoolNameBySchoolId($schoolId);

            ?>
            <li class="<?php if($data->isNewHomework()){echo 'news';} ?>">
                <span class="hmwk_cls hmwk_word"></span>
                <h5><a href="<?=Url::to(['/teacher/managetask/pushed-library-details','homeworkID'=>$data->id])?>"><em><?php echo $data->name;?></em></a></h5>
               <p>系统 <?php echo date('Y-m-d',DateTimeHelper::timestampDiv1000($data->uploadTime))?> 发布</p>
                <p>难度:<?php if($data->difficulty==0) {
                        echo '<i class="dif_state dif_easy"></i>';
                    }elseif($data->difficulty==1)  {
                        echo '<i class="dif_state dif_mid"></i>';
                    }elseif($data->difficulty==2){
                        echo '<i class="dif_state dif_hard"></i>';
                    }
                        ?></p>
                <p>简介:<?php echo $data->homeworkDescribe;?></p>
            </li>
        <?php } }?>
    </ul>
    <?php }else{
        ViewHelper::emptyViewByPage($pages,$message='此处暂无内容，换个章节试试');
    }?>
    <div class="page">
        <?php
        echo \frontend\components\CLinkPagerNormalExt::widget(array(
                'firstPageLabel'=>false,
                'lastPageLabel'=>false,
                'pagination' => $pages,
                'updateId' => '#hmwk',
                'maxButtonCount' => 8,
            )
        );
        ?>
    </div>
</div>

