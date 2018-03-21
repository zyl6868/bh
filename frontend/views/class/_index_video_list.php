<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2014/12/23
 * Time: 11:26
 */
?>
<?php foreach($courseList as $courseVal){ ?>
    <dl class="once clearfix">
        <dt><a href="<?php echo url('class/video-view', array('id' => $courseVal->courseID, 'classId' =>  $this->classModel->classID)) ?>"><img src="<?php echo publicResources()?>/images/user_m.jpg" alt="" width="110" height="110"></a></dt>
        <dd>
            <h5><a href="<?php echo url('class/video-view', array('id' => $courseVal->courseID, 'classId' =>  $this->classModel->classID)) ?>">[<?php echo $courseVal->subjectName; ?>]<?php echo $courseVal->courseName; ?></a></h5>
        </dd>
        <dd><i>介绍:</i><a href="<?php echo url('class/video-view', array('id' => $courseVal->courseID, 'classId' =>  $this->classModel->classID)) ?>" class="j_link"><?php  echo mb_substr(strip_tags($courseVal->courseBrief), 0, 14, 'utf-8'); ?>......</a></dd>
        <dd><a href="<?php echo url('class/video-view', array('id' => $courseVal->courseID, 'classId' =>  $this->classModel->classID)) ?>" class="btn once_aBtn ">观看</a></dd>
    </dl>
<?php } ?>