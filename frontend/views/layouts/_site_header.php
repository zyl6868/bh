<?php


/* @var $this yii\web\View */

$r = $this->context->getRoute();
$g = $this->context->getUniqueId();

$key = user()->id.'_' . $r.'_'. $g;
if ($this->beginCache($key, ['duration' => 600])) {



   if(!user()->isGuest){
       $userModel = loginUser();

       $classArr = $userModel->getClassInfo();
       $schoolid = $userModel->schoolID;

//手拉手班级

       $binderClass = [];


       if ($userModel->isStudent()) {
           $homeUrl = url('student/setting/my-center');
           $msgUrl = url('student/message/message-list?show=sendwin');
       }
       if ($userModel->isTeacher()) {
           $homeUrl = url('teacher/setting/personal-center');
           $msgUrl = url('teacher/message/message-list?show=sendwin');
       }
   }

    ?>
    <div class="head">
        <div class="cont24">
            <h1>班海网</h1>
            <?php if (!user()->isGuest) {


                if (loginUser()->isStudent()) {
                    $homeUrl = url('student/setting/my-center');
                    $msgUrl = url('student/message/message-list?show=sendwin');
                }
                if (loginUser()->isTeacher()) {
                    $homeUrl = url('teacher/setting/personal-center');
                    $msgUrl = url('teacher/message/message-list?show=sendwin');
                }

                ?>

                <ul class="head_nav">

                    <?php
                    if (loginUser()->isTeacher()) {
                        ?>
                        <li>
                            <a class="<?= $this->context->highLightUrl(['platform/question/keywords-choose', 'platform/question/chapter-choose', 'platform/question/knowledge-choose'], $r) ? 'ac' : '' ?>"
                               href="<?= url('platform/question/chapter-choose') ?>">试题库</a></li>
                        <li><a class="<?= $g == 'platform/file' ? 'ac' : '' ?>"
                               href="<?= url('/platform/file') ?>">课件库</a></li>
                        <li><a class="<?= $g == 'platform/managetask' ? 'ac' : '' ?>"
                               href="<?= url('/platform/managetask/index') ?>">作业库</a>
                        </li>
                    <?php } ?>
                    <li><a class="<?= $this->context->highLightUrl(['platform/answer/index'], $r) ? 'ac' : '' ?>"
                           href="<?= url('platform/answer/index') ?>">问题答疑</a>
                    </li>
                    <li><a class="<?= $g == 'school' ? 'ac' : '' ?>"
                           href="<?= url('school/index', array('schoolId' => $schoolid)); ?>">学校</a>
                    </li>
                    <li><a class="has_subMenu <?= $g == 'class' ? 'ac' : '' ?>">班级帮</a>
                        <ul class="subMenu hide">

                            <li>
                                <dl>
                                    <dt>我的班级</dt>
                                    <?php foreach ($classArr as $valClass) { ?>
                                        <dd><a href="<?= url('class/index', array('classId' => $valClass->classID)); ?>"
                                               title="<?= $valClass->className ?>"><?= $valClass->className ?></a></dd>
                                    <?php } ?>

                                </dl>
                            </li>

                        </ul>
                    </li>
                    <?php if (loginUser()->isTeacher()) { ?>
                        <li><a class="" href="http://zixun.banhai.com">班海资讯</a></li>
                    <?php } ?>
                </ul>


                <div class="userCenter">
                    <div class="userChannel">
                        <a class="userName" href="<?= $homeUrl ?>" title="<?= loginUser()->getTrueName() ?>"><i></i><?= loginUser()->getTrueName() ?></a>
                    </div>
                    <a href="<?= url('site/logout') ?>" class="logOff">退出</a>

                    <div class="msgAlert hasMsg">
                    </div>

                    <a class="help" href="http://www.banhai.com/pub/help/focus_map_video.html" title="帮助"></a>
                </div>
            <?php } ?>


        </div>
    </div>


    <?php $this->endCache();
} ?>
<script type="text/javascript">
    $(function(){
        $(document).ready(function(sumCnt,priMsg,notice,sysMsg){
            $.get("<?php echo url("/ajax/msg-num")?>",{},function(data){


                $("#messageSum").html("(" + data.sumCnt + ")");
                if (data.notice>99) {
                    $("#messageNotice").html("99+");
                } else {
                    $("#messageNotice").html(data.notice);
                }
                if (data.sysMsg>99) {
                    $("#messageSys").html("99+");
                } else {
                    $("#messageSys").html(data.sysMsg);
                }

                if(data.sumCnt>99){
                    $(".sysMsg").addClass("over99");
                }
            });
        });
    })
</script>