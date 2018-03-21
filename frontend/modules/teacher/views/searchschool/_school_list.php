<?php
/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 17-6-30
 * Time: 下午6:41
 */
use frontend\components\CLinkPagerExt;
use frontend\components\helper\AreaHelper;
use frontend\components\helper\ViewHelper;
use yii\helpers\Url;

?>
<?php
if(empty($schoolInfos)){
    echo ViewHelper::emptyView('未搜索到您的学校！');
}
?>
<ul class="classList"><!--
--><?php
        foreach($schoolInfos as $v) {
    ?><!--
--><li class="bgWhite">
            <span class="caption VAM"><?php echo $v->schoolName ?><br>
                <span style="font-size:12px;color: #999">
                    <?php echo !empty($v->provience)?AreaHelper::getAreaName($v->provience).AreaHelper::getAreaName($v->city).AreaHelper::getAreaName($v->country):'&nbsp;'; ?>
                </span>
            </span>
            <a href="<?php echo Url::to(['class-list','schoolId'=>$v->schoolID]);?>"><span class="joinBtn">选择</span></a>
    </li><!--
--><?php }?><!--
--></ul>


