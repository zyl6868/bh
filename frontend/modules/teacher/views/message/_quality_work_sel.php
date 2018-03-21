<?php
/**
 * Created by zyl.
 * User: zyl
 * Date: 17-03-30
 * Time: 下午6:59
 */
use common\models\dicmodels\GradeModel;
use common\models\pos\SeHomeworkPlatformPushRecord;
use common\models\pos\SeHomeworkTeacher;

/** @var integer|array $homeworkType */
?>
<?php if(loginUser()->subjectID == GradeModel::CHINESE_SUBJECT && loginUser()->department == GradeModel::PRIMARY_SCHOOL){?>
    <li class="<?php if($homeworkType == SeHomeworkTeacher::READ_HOMEWORK){echo 'select';}?>">
        <a href="<?php echo \yii\helpers\Url::to(['quality-work',"homeworkType"=>SeHomeworkTeacher::READ_HOMEWORK])?>">朗读作业</a>
    </li>
<?php }
if(loginUser()->subjectID == GradeModel::ENGLISH_SUBJECT && loginUser()->department == GradeModel::PRIMARY_SCHOOL){?>
    <li class="<?php if(is_array($homeworkType)){echo 'select';}?>">
        <a href="<?php echo \yii\helpers\Url::to(['quality-work',"homeworkType"=>SeHomeworkTeacher::LISTEN_HOMEWORK])?>">语音作业</a>
    </li>
<?php } ?>

<li class="<?php if($homeworkType == SeHomeworkPlatformPushRecord::BASIC_HOMEWORK){echo 'select';}?>">
    <a href="<?php echo \yii\helpers\Url::to(['quality-work',"homeworkType"=>SeHomeworkPlatformPushRecord::BASIC_HOMEWORK])?>">基础作业</a>
</li>
<li class="<?php if($homeworkType == SeHomeworkPlatformPushRecord::ADVANCE_HOMEWORK){echo 'select';}?>">
    <a href="<?php echo \yii\helpers\Url::to(['quality-work',"homeworkType"=>SeHomeworkPlatformPushRecord::ADVANCE_HOMEWORK])?>">提升作业</a>
</li>
<li class="<?php if($homeworkType == SeHomeworkPlatformPushRecord::UNIT_TEST){echo 'select';}?>">
    <a href="<?php echo \yii\helpers\Url::to(['quality-work',"homeworkType"=>SeHomeworkPlatformPushRecord::UNIT_TEST])?>">单元测试</a>
</li>
