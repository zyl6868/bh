<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2015/12/10
 * Time: 17:23
 */
use frontend\components\helper\ImagePathHelper;
use common\components\WebDataCache;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var common\models\pos\SeClass $classModel */
$classTea = $classModel->getClassTeacherList();
//首页最多显示学生13位成员
$limit = 13;
$classStu = $classModel->getClassStudentList($limit);
$stuMem = $classModel->getClassStudentCount();
?>
<script>
    $(function () {
        //截取右侧班级成员10个显示
        $('.ta_student_list').children('li:gt(9)').hide();
        //点击展开
        $(".interlink .all").toggle(
            function () {
                $(".student_list").css("height", "auto");
                $(this).text("收起");
            },
            function () {
                $(".student_list").css("height", 100);
                $(this).text("查看全部<?php echo $stuMem; ?>位成员");
            }
        );
    });
</script>
<div class="sUI_formList sUI_formList6 sUI_formList_min head_portrait">
    <div class="row">
        <h5>教师</h5>
        <ul class="sUI_user_list sUI_user_list_big clearfix">
            <?php foreach ($classTea as $teaVal) { ?>

                <li>
                    <a href="<?php echo Url::to(['student/default/index', 'studentId' => $teaVal->userID]) ?>"
                       title="<?php echo Html::encode(WebDataCache::getTrueNameByuserId($teaVal->userID)); ?>">
                        <img data-type='header' onerror="userDefImg(this);"
                             src="<?php echo ImagePathHelper::imgThumbnail(WebDataCache::getFaceIconUserId($teaVal->userID),70,70)?>" height="50" width="50">
                        <?php echo Html::encode(WebDataCache::getTrueNameByuserId($teaVal->userID)); ?>
                    </a>
                </li>

            <?php } ?>
        </ul>
    </div>
    <div class="row noBorder clearfix">
        <h5>学生</h5>
        <ul class="sUI_user_list sUI_user_list_big clearfix fl">
            <?php foreach ($classStu as $tuVal) { ?>

                <li>
                    <a href="<?php echo Url::to(['student/default/index', 'studentId' => $tuVal->userID]) ?>"
                       title="<?php echo Html::encode(WebDataCache::getTrueNameByuserId($tuVal->userID)); ?>">
                        <img data-type='header' onerror="userDefImg(this);"
                             src="<?php echo ImagePathHelper::imgThumbnail(publicResources() . WebDataCache::getFaceIconUserId($tuVal->userID),70,70)?>" height="50" width="50">
                        <?php echo Html::encode(WebDataCache::getTrueNameByuserId($tuVal->userID)); ?>
                    </a>
                </li>

            <?php } ?>
        </ul>
        <?php if ($stuMem >= $limit) { ?>
            <a href="<?php echo Url::to(['class/member-manage', 'classId' => $classModel->classID]) ?>" class="morestudent f1">更多&gt;&gt;</a>
        <?php } ?>
    </div>
</div>