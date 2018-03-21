<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/8/18
 * Time: 11:46
 */
use yii\web\View;

$this->title = "个人设置-加入班级";
$this->blocks['requireModule'] = 'app/site/register';

?>

<div class="gnn_container">
    <div class="content">
        <p class="congratulations">你还没有加入任何班级！</p>
        <p class="account">请输入<span class="account">班级加入码</span>加入到你的班级</p>
        <div class="accountcode">
            <label for="accountName" class="message">班级加入码（8位）</label>
            <input type="text" id="accountName" class="accountname">
        </div>
        <input type="button" name="" id="login" class="login join_class" value="加入班级">

        <?php if (loginUser()->isTeacher()) { ?>
            <div style="width: 30em;margin: 0 auto;line-height: 1.8">
                <p style="margin: 5em 0 1em;"><a
                            href="<?php echo \yii\helpers\Url::to(['teacher/searchschool/index']) ?>"
                            style="font-size: 1.4em;">点击手动查找班级<img style="vertical-align: middle;margin-left: 1em;"
                                                                   src="<?php BH_CDN_RES ?>/static/images/goSeek.jpg"
                                                                   alt=""></a></p>
                <p>找不到班级? 你可以：</p>
                <p>1.已经有学校没有班级的老师可以去创建班级。</p>
                <p>2.没有学校的可以选择去申请创建学校，申请后会有工作人员</p>
                <p>联系你创建学校和班级，请耐心等待。</p>
                <p>3.已有班级不可以创建。</p>
            </div>
        <?php } ?>
    </div>
</div>




