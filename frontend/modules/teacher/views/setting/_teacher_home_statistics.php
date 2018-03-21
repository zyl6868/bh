<?php
use yii\helpers\Url;

?>

<ul>
  <li class="home_hmwk">
    <a href="<?= url('teacher/resources/collect-work-manage');?>"><i></i>作业</a>
    <div><p>我收藏的：</p><span id="collectHomeworkNum">0</span></div>
    <div><p>我创建的：</p><span id="creatHomeworkNum">0</span></div>
  </li>
  <li class="home_quest">
    <a href="<?= url('teacher/question/index');?>"><i></i>题目</a>
    <div><p>我收藏的：</p><span id="favoriteTitleNum">0</span></div>
  </li>
  <li class="home_course">
    <a href="<?= url('teacher/favoritematerial/index');?>"><i></i>课件</a>
    <div><p>我收藏的：</p><span id="favoriteFileNum">0</span></div>
  </li>
  <li class="home_test noBorder">
    <a href="<?= url('teacher/managepaper/index');?>"><i></i>试卷</a>
    <div><p>我创建的：</p><span id="createTestNum">0</span></div>
  </li>
</ul>
<script>
    $.get('<?=Url::to("/teacher/setting/resources-statistics")?>',{},function(result){
        $("#collectHomeworkNum").html(result.collectHomeworkNum);
        $("#creatHomeworkNum").html(result.creatHomeworkNum);
        $("#favoriteTitleNum").html(result.favoriteTitleNum);
        $("#favoriteFileNum").html(result.favoriteFileNum);
        $("#createFileNum").html(result.createFileNum);
        $("#createTestNum").html(result.createTestNum);
    })
</script>