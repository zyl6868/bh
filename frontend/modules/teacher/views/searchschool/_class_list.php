<?php
/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 17-6-30
 * Time: 下午6:41
 */
use frontend\components\helper\ViewHelper;

?>
<?php
if (empty($classList)) {
    echo ViewHelper::emptyView('未搜索到班级！');
}
?>
<ul class="classList"><!--
--><?php
        foreach($classList as $v) {
    ?><!--
--><li class="bgWhite">
            <span class="caption VAM"><?php echo $v->className;?></span>
            <span class="joinBtn joinClass" classId="<?php echo $v->classID;?>" style="margin-top: 0">加入</span>
    </li><!--
--><?php }?><!--
--></ul>

