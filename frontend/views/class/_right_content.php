<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2014/12/25
 * Time: 10:26
 */
use frontend\components\helper\ImagePathHelper;
use common\components\WebDataCache;

?>
<div class="centRightT">
	<?php if (loginUser()->isTeacher()) { ?>
            <div class="centRightT"> 
				<?php if(!empty($shoulashouList)){ echo "<p class='title'>本班还可以设置手拉手班级，快来设置吧</p>";}else{echo "<p class='title'>本班还没有设置手拉手班级，快来设置吧</p>";}	?>
                <a href="<?php echo url('class/shoulashou-list', array('classId' => $this->classModel->classID)) ?>"
                   class=" outAdd_btn B_btn120" style="font-size:14px; display:inline-block; color:#FFF;"
                   id="addThinkBtn">设置手拉手班级</a>
            </div>
        <?php } ?>


        <?php if (!empty($shoulashouList)) { ?>
            <p class="title titleLeft">
                <span>手拉手班级</span>
            </p>
            <?php foreach ($shoulashouList as $shoulashou_info) {
                ?>
                <div class="centRightT clearfix">
                    <hr>
                    <dl class="list_dl clearfix">
                        <dt><img src="<?php echo publicResources() ?>/images/pic.png" alt="" width="90" height="90">
                        </dt>
                        <dd>
                            <a href="<?php echo url("class/index", array("classId" => $shoulashou_info->classID)) ?>">
                                <h3><?php echo $shoulashou_info->className ?></h3></a></dd>
                        <dd><span>学校：</span><?php echo $shoulashou_info->schoolName ?></dd>
						<dd><span>班主任:</span><em><?php echo $shoulashou_info->classChargeName ?></em></dd>
                        <dd><span>成员：</span><?php echo $shoulashou_info->classStuMember ?>
                            名学生&nbsp;&nbsp;<?php echo $shoulashou_info->classTeachMember ?>名教师
                        </dd>
                    </dl>
                </div>
            <?php
            }
        } ?>
    <h3 class="clearfix"><span>班级成员</span> <a
            href="<?php echo url('class/member-manage', array('classId' => $this->classModel->classID)) ?>">所有成员</a>
    </h3>
    <hr>
    <ul class="class_list clearfix">
        <?php
        foreach ($memberData as $val) {
            ?>
            <li><a href="<?php echo url('student/default/index',array('studentId'=>$val->userID)) ?>"><img  data-type="header" onerror="userDefImg(this);"  src="<?php echo publicResources() . WebDataCache::getFaceIconUserId($val->userID) ?>"
                                                                                                            alt="" title="<?php echo $val->memName; ?>"></a></li>
        <?php
        }
        ?>
    </ul>
</div>
<div class="centRightT">
    <h3 class="clearfix"><span>今日课程安排</span></h3>
    <hr>
    <?php if(!empty($todayCourseList)){ foreach ($todayCourseList as $todayVal) { ?>
        <dl>
            <dt>
				<?php if(empty($todayVal->url)){ ?>
					<img src="<?php echo publicResources();?>/images/video.png" alt="">
				<?php }else{ ?>
					<img src="<?php echo ImagePathHelper::getPicUrl($todayVal->url); ?>" alt="">
				<?php } ?>
			</dt>
            <?php if($todayVal->teacherID == user()->id){ ?>
                <dd>
                    <h3><a href="<?php echo url('teacher/coursemanage/course-details',array('courseId'=>$todayVal->courseID)) ;?>"><?php echo $todayVal->subjectName; ?></a></h3>
                </dd>
                <dd><a href="<?php echo url('teacher/coursemanage/course-details',array('courseId'=>$todayVal->courseID)) ;?>"><?php echo $todayVal->teacherName; ?></a></dd>
                <dd><a href="<?php echo url('teacher/coursemanage/course-details',array('courseId'=>$todayVal->courseID)) ;?>"><?php echo $todayVal->courseName; ?></a></dd>
            <?php }else{ ?>
                <dd>
                    <h3><a href="<?php echo url('student/course-stu/course-details',array('courseId'=>$todayVal->courseID)) ;?>"><?php echo $todayVal->subjectName; ?></a></h3>
                </dd>
                <dd><a href="<?php echo url('student/course-stu/course-details',array('courseId'=>$todayVal->courseID)) ;?>"><?php echo $todayVal->teacherName; ?></a></dd>
                <dd><a href="<?php echo url('student/course-stu/course-details',array('courseId'=>$todayVal->courseID)) ;?>"><?php echo $todayVal->courseName; ?></a></dd>
            <?php } ?>
        </dl>
    <?php } } ?>

</div>
<div class="centRightT">
    <h3 class="clearfix"><span>今日作业安排</span></h3>
    <hr>
    <?php foreach ($homeworkResult->list as $k => $v) {
        if ($k < 4) {
            ?>
            <dl>
                <dt><img src="<?php echo publicResources() ?>/images/teacher_m.jpg"></dt>
                <dd>
                    <h3><a href="#"><?php echo $v->subjectname ?></a></h3>
                </dd>
                <dd><a href="#"><?php echo loginUser()->getUserInfo($v->creator)->getTrueName() ?>老师</a></dd>
                <dd><a href="#"><?php echo $v->name ?></a></dd>
            </dl>
        <?php
        }
    } ?>
</div>
<div class="centRightT">
    <h3 class="clearfix"><span>大事记</span> <a
            href="<?php echo url('class/memorabilia', array('classId' => $classId)) ?>">更多</a></h3>
    <hr>

    <?php echo $this->render('_event_view', array('history' => $history)) ?>
</div>
<!--日历-->
<!--<div class="centRightT">-->
<!--    <h3 class="clearfix"><span>课表</span></h3>-->
<!--    <hr>-->
<!--    <div id="calendar" class="itemCont"></div>-->
<!--</div>-->
</div>