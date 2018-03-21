<?php
/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 17-6-30
 * Time: 下午6:41
 */
use frontend\components\CHtmlExt;
use frontend\components\helper\AreaHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\View;

/** @var yii\web\View $this */
$this->title = '搜索学校';
$this->registerCssFile(BH_CDN_RES . "/static/css/applySchool.css" . RESOURCES_VER);
$this->blocks['requireModule'] = 'app/teacher/search_class';
?>
<h4 id="main_head" class="bgWhite main_head"><a href="<?php echo Url::to(['index']) ?>" class="btn icoBtn_back"><i></i>返回</a>申请学校
</h4>
<div class="main page tc bgWhite">
    <p class="lh2" style="font-size: 30px;"><span style="font-size: 40px;">找不到自己所在的学校?</span><br>您可以输入 <strong style="color: #10ade5!important;">自己的学校</strong> 去申请 , 会有工作人员联系您创建学校和班级</p>
    <?php if ($provinceId) {
        $cityArea = AreaHelper::getAreaName($cityId);
        if($cityArea == '市辖区' || $cityArea =='县'){
            $cityArea='';
        }
        ?>
        <p class="lh2">所在地区
            : <strong class="blue"><?php echo AreaHelper::getAreaName($provinceId) .$cityArea . AreaHelper::getAreaName($countryId); ?></strong></p>
    <?php } ?>
    <p class="applySchool"><input type="text" placeholder="请输入您所在学校的学校名称" id="applySchoolName"></p>
    <div class="applyBtn" provinceId="<?php echo $provinceId; ?>" cityId="<?php echo $cityId; ?>" countryId="<?php echo $countryId; ?>">申请学校</div>
</div>