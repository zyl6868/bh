<?php
use common\models\pos\SeClassSubject;
use common\models\pos\SeExamClassSubject;
use common\models\pos\SeUserinfo;
use common\models\dicmodels\SubjectModel;
?>
<div id="teacherLink" class="teacherLink">
    <!--任教老师-->
    <p class="teacher"><span class="tch">任教老师</span>请确认下列任课老师是否正确，不正确请更换</p>
    <form id="addteacherlink" action="/exam/scoreinput/teacherlink" method="post">
        <input class="btn_sav" id="btn_sav" type="submit" value="保存">
        <ul class="sel_subject clearfix">
            <?php foreach($subjectList as $subject):?>
                <li>
                    <input type="hidden" name="teacherlink[subjectId][]" value="<?php echo $subject['subjectId'];?>">
                    <label><?php echo SubjectModel::model()->getName((int)$subject['subjectId']) ?>：</label>
                    <select class="sel_sub" name="teacherlink[userID][]">
                        <option value="<?php echo SeExamClassSubject::getTeacherId($subject['subjectId'], $classId, $schoolExamId)?>"><?php echo \common\components\WebDataCache::getTrueNameByuserId(SeExamClassSubject::getTeacherId($subject['subjectId'], $classId, $schoolExamId))?></option>
                        <?php foreach(SeUserinfo::getSchoolTeacher($schoolId,$subject['subjectId']) as $teacher):?>
                            <?php if($teacher['userID'] != SeExamClassSubject::getTeacherId($subject['subjectId'], $classId, $schoolExamId)) {?>
                                <option value="<?php echo $teacher['userID'];?>"><?php echo \common\components\WebDataCache::getTrueNameByuserId($teacher['userID'])?></option>
                            <?php }?>
                        <?php endforeach;?>
                    </select>
                </li>
            <?php endforeach;?>
        </ul>
        <input type="hidden" name="teacherlink[classId]" value="<?php echo $classId;?>">
        <input type="hidden" name="teacherlink[schoolExamId]" value="<?php echo $schoolExamId;?>">
    </form>
</div>