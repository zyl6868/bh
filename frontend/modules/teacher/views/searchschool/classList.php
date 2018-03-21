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

/** @var yii\web\View $this */
$this->title = '搜索学校';
$this->registerCssFile(BH_CDN_RES . "/static/css/selectClass.css" . RESOURCES_VER);
$this->blocks['requireModule'] = 'app/teacher/search_class';
?>
<div id="selectClass">
    <div class="title bgWhite">
        <?php echo $this->render('_search_schoolName'); ?>
        <p>
            <span class="attr">所选学校</span>
            <span class="school"><?php echo $schoolInfo->schoolName; ?></span>
            <a href="<?php echo Url::to(['index']); ?>"><span class="resetBtn">重新选择</span></a>
        </p>
        <p>
            <span class="attr" id="selectDepartment" schoolId="<?php echo $schoolInfo->schoolID; ?>">选择学段</span>
            <?php
            $departmentArray = explode(',', $departmentIds);
            foreach ($departmentArray as $v) {
                $departmentName = '';
                if ($v == 20201) {
                    $departmentName = '小学';
                } else if ($v == 20202) {
                    $departmentName = '初中';
                } else if ($v == 20203) {
                    $departmentName = '高中';
                }
                ?>
                <span class="schoolClass grade <?php echo $v == $departmentId ? 'ac' : '' ?>"
                      departmentId="<?php echo $v ?>"><?php echo $departmentName; ?></span>
            <?php } ?>
        </p>

    </div>

    <div class="content">

        <div class="allClass bgWhite">
            <p class="caption">全部班级</p>
            <div><img class="VAM" src="<?php echo BH_CDN_RES ?>/static/images/warn.jpg" alt=""><span class="VAM">没有找到自己的班级 ? </span><a
                        href="javascript:void();" id="createClass">去创建班级</a></div>
        </div>

        <div id="classList">
            <?php
            echo $this->render('_class_list', ['classList' => $classList, 'pages' => $pages]);
            ?>
        </div>
    </div>
</div>