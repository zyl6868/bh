<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2015/12/10
 * Time: 13:46
 */
/** @var common\models\pos\SeClass $classModel */
use yii\helpers\Url;

$classID = $classModel->classID;
?>

<dl class="class_top">
    <dd class="class_book">
        <?php if ($isInClass) { ?>
            <a href="<?php echo Url::to(['class/homework', 'classId' => $classModel->classID]); ?>"><i></i>作业</a>
        <?php } else { ?>
            <a><i></i>作业</a>
        <?php } ?>
    </dd>

    <dt class="statistics">
    <div><p>作业统计</p>：<span id="homeworkMember">0</span>份</div>
    <div><p>　已截止</p>：<span id="deadlineTimeHomework">0</span>份</div>
    <div><p>　未截止</p>：<span id="unHomeworkMember">0</span>份</div>
    </dt>
</dl>
<dl class="class_top">
    <dd class="class_answer">
        <a href="<?php echo Url::to(['class/answer-questions', 'classId' => $classModel->classID]) ?>"><i></i>答疑</a>
    </dd>

    <dt class="statistics">
    <div><p>答疑总计</p>：<span id="answerAllCount">0</span>个</div>
    <div><p>　已解决</p>：<span id="resolvedAnswer">0</span>个</div>
    <div><p>　未解决</p>：<span id="unResolvedAnswer">0</span>个</div>
    　
    </dt>
</dl>
<dl class="class_top noBorder">
    <dd class="class_file">
        <a href="<?php echo Url::to(['class/class-file', 'classId' => $classModel->classID]) ?>"><i></i>文件</a>
    </dd>
    <dt class="statistics">
    <div><p>文件总计</p>：<span id="fileCount">0</span>份</div>
    <div><p>阅读总计</p>：<span id="readCount">0</span>次</div>
    </dt>
</dl>
<script>
    var classID = <?php echo $classID;?>;
    $.get('<?=Url::to("/class/class-statistics")?>',{classID:classID},function(result){
        $("#homeworkMember").html(result.homeworkMember);
        $("#deadlineTimeHomework").html(result.deadlineTimeHomework);
        $("#unHomeworkMember").html(result.homeworkMember-result.deadlineTimeHomework);
        $("#answerAllCount").html(result.answerAllCount);
        $("#resolvedAnswer").html(result.resolvedAnswer);
        $("#unResolvedAnswer").html(result.answerAllCount-result.resolvedAnswer);
        $("#fileCount").html(result.fileCount);
        $("#readCount").html(result.readCount);
    })
</script>
