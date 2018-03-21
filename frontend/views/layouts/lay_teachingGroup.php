<?php
/* @var $this yii\web\View */
$this->beginContent('//layouts/lay_user');
$this->registerCssFile(BH_CDN_RES.'/pub/css/tch_group.css'.RESOURCES_VER);
$groupId = $this->teachingGroupModel->groupID;

?>
    <div class="mainBody cont24">
        <div class="main_head">
            <h2 class="class_t">
                <span class="classFocus"><?php echo $this->teachingGroupModel->groupName; ?></span>
            </h2>

            <h3 class="Signature fot_z">
                <span><?php echo $this->teachingGroupModel->schoolName; ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->teachingGroupModel->departmentName; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                <span><?php echo $this->teachingGroupModel->subjectName; ?></span>

            </h3>

        </div>
        <div class="main_cent">
            <div class="mainNav clearfix">
                <ul class="mainNav_L">

                    <li class="<?php echo $this->context->highLightUrl(['teachinggroup/index']) ? 'ac' : '' ?>"><a
                            href="<?php echo url('teachinggroup/index', array('groupId' => $groupId)) ?>">首页</a></li>
                    <li class="<?php echo $this->context->highLightUrl(['teachinggroup/teaching-plan', 'teachinggroup/details']) ? 'ac' : '' ?>">
                        <a href="<?php echo url('teachinggroup/teaching-plan', array('groupId' => $groupId)) ?>">教学计划</a>
                    </li>
                    <li class="<?php echo $this->context->highLightUrl(['teachinggroup/course', 'teachinggroup/coursedetails']) ? 'ac' : '' ?>">
                        <a href="<?php echo url('teachinggroup/course', array('groupId' => $groupId)) ?>">教研课题</a></li>
                    <li class="<?php echo $this->context->highLightUrl(['teachinggroup/listen-lessons', 'teachinggroup/listendetail']) ? 'ac' : '' ?>">
                        <a
                            href="<?php echo url('teachinggroup/listen-lessons', array('groupId' => $groupId)) ?>">听课评课</a>
                    </li>
                    <li class="<?php echo $this->context->highLightUrl(['teachinggroup/teach-data', 'teachinggroup/uploadLessonData', 'teachinggroup/uploadVideo', 'teachinggroup/viewLessonData', 'teachinggroup/viewVideo']) ? 'ac' : '' ?>">
                        <a href="<?php echo url('teachinggroup/teach-data', array('groupId' => $groupId)) ?>">教研资料</a>
                    </li>
                </ul>
                <ul class="mainNav_R">
                    <li>
                        <i class="set"></i><span class="bColor setJs">
                           <span class="bColor setJs">
                       <a href="<?php echo $this->getSetHoneUrl() ?>">个人设置</a>
                    </span>
                        </span>
                        <ul class="tab hide">
                            <li>零食</li>
                            <li>零食</li>
                            <li>零食</li>
                            <li>零食</li>
                        </ul>
                    </li>
                    <li><i class="dressUp"></i><span class="dress_k">装扮空间</span></li>
                    <li><i class="management"></i><span><a href="<?php echo $this->getManageHoneUrl() ?>">个人管理中心</a></span></li>
                </ul>
            </div>
            <?php echo $content ?>
        </div>

    </div>
<?php $this->endContent(); ?>