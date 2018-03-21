<?php
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 15-4-16
 * Time: 下午2:46
 */
use common\models\dicmodels\SchoolLevelModel;
use common\models\dicmodels\SubjectModel;

?>
<div class="form_list no_padding_form_list">
    <div class="row" style=" margin-top:5px;">
        <div class="formL">
            <label>选题方式：</label>
        </div>
        <div class="formR">
            <ul class="resultList clearfix">
                <li class="<?php echo $this->context->highLightUrl(['teacher/searchquestions/keyword-questions', 'teacher/searchquestions/keyword-questions']) ? 'ac' : '' ?>">
                    <a href="<?php echo url('teacher/searchquestions/keyword-questions'); ?>">搜索选题</a>
                </li>
	            <li class="<?php echo $this->context->highLightUrl(['teacher/searchquestions/chapter-questions', 'teacher/searchquestions/chapter-questions']) ? 'ac' : '' ?>">
		            <a href="<?php echo url('teacher/searchquestions/chapter-questions'); ?>">同步章节选题</a>
	            </li>
                <li class="<?php echo $this->context->highLightUrl(['teacher/searchquestions/knowledge-point-questions', 'teacher/searchquestions/knowledge-point-questions']) ? 'ac' : '' ?>" >
                    <a href="<?php echo url('teacher/searchquestions/knowledge-point-questions'); ?>">知识点选题</a>
                </li>

            </ul>
        </div>
    </div>
    <div class="course">
        <a href="javascript:;"
           class="cour_btn hotWord"><?php echo SchoolLevelModel::model()->getName($department); ?><?php echo SubjectModel::model()->getName((int)$subjectid); ?>
            <i></i></a>

        <div class="course_box hotWordList hide depart_sub">
            <i class="arrow course_box_arrow"></i>
            <dl class="clearfix">
                <?php echo $this->render('//publicView/search/_subject_view',array('department'=>'20201','departments'=>$department,'subjectid'=>$subjectid, ));?>
            </dl>
            <dl class="clearfix">
                <?php echo $this->render('//publicView/search/_subject_view',array('department'=>'20202','departments'=>$department,'subjectid'=>$subjectid,  ));?>
            </dl>
            <dl class="clearfix">
                <?php echo $this->render('//publicView/search/_subject_view',array('department'=>'20203','departments'=>$department,'subjectid'=>$subjectid,  ));?>
            </dl>
        </div>
    </div>
</div>