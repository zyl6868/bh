<?php
/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2016/2/16
 * Time: 9:43
 */

/** @var $this yii\web\View */
$this->title='科目分数设置';
$this->blocks['requireModule']='app/sch_mag/sch_mag_set_up';
?>
<div class="main col1200 clearfix sch_mag_set_up" id="requireModule">
    <div class="container clearfix">
        <div class="sz_fraction" style=" padding: 15px 0; margin-bottom: 20px; border-bottom: 1px solid #dcdcdc">
            <a href="javascript:history.back(-1);" class="btn btn30 icoBtn_back fl"><i></i>返回</a>
            <h4><?=$SeExamSchool->examName?></h4>
        </div>
        <div class="pd25">
            <form  id="post">
            <div class="sUI_formList clas_formLIst">
                <input type="hidden" name="school" value="<?=$schoolExamId?>">
                <div class="row">
                    <div class="form_l"><b>*</b>考试班级:</div>
                    <div class="form_r moreContShow" style="width: 700px">
                        <?php if(!empty($class)){?>
                            <?php $i=0; foreach($class as $val){?>
                                <label><input type="checkbox" name="checkbox[]" class="checkbox" value="<?=$val->classID?>"
                                        <?php if(!empty($classModel)){foreach($classModel as $v){if($v->classId==$val->classID){echo 'checked=true';}}}?>
                                        ><?=$val->className?></label>
                                <?php if($i==5){?>
                                    <a class="showMoreBtn" href="javascript:;">更多<i></i></a>
                                <?php }?>
                            <?php $i++;}?>
                        <?php }?>
                    </div>
                </div>
                <div class="row">
                    <div class="form_l"><b>*</b>考试科目:</div>
                    <div  class="form_r moreContShow">
                        <?php if(!empty($subject)){?>
                            <a class="showMoreBtn" href="javascript:;">更多<i></i></a>
                        <?php }?>
                        <ul  id="subList_con" class="subList_con">
                            <?php if(!empty($subject)){?>
                                <?php foreach($subject as $val){?>
                                    <li data-sel-value="<?=$val->secondCode?>" data-sel-item
                                        <?php if(!empty($subjectModel)){foreach($subjectModel as $v){if($v->subjectId==$val->secondCode){echo 'class="sel_ac"';}}}?>
                                        ><a href="javascript:;"><?=$val->secondCodeValue?></a></li>
                                <?php }?>
                            <?php }?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="table_con sch_table_con">
                <table id="table_set_up" class="sUI_table table_set_up">
                    <thead>
                    <tr>
                        <th width="100px">
                            考试科目
                        </th>
                        <th width="140px">
                            卷面满分
                        </th>
                        <th width="150px">
                            分数线
                        </th>
                        <th width="200px">
                            <button id="show_sel_classesBar_btn" type="button" class="bg_white icoBtn_add_blue hide"><i></i>添加分数线</button>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr id="yuwen_subject">
                        <?php if(!empty($subjectModel)){?>
                            <?php foreach($subjectModel as $v){?>
                                <tr id="<?=$v->subjectId?>_subject">
                                <td><?php if(!empty($subject)){
                                        foreach($subject as $k){
                                            if($k->secondCode==$v->subjectId){
                                                echo $k->secondCodeValue;
                                            }
                                        }
                                    }?></td>
                                <td><input type="hidden" name="man[]" value="<?=$v->subjectId?>"> <input type="text" class="fraction score_p" name="<?=$v->subjectId?>_full" value="<?=$v->fullScore?>"></td>
                                <td><input type="text" class="fraction score_l" name="<?=$v->subjectId?>_cutLine" value="<?=$v->borderlineOne?>"></td>
                                <td></td>
                               </tr>
                            <?php }?>
                        <?php }?>
                    </tr>
                    </tbody>

                    <tfoot>
                    <tr style="background: #f5f5f5">
                        <td>总分</td>
                        <td id="total_paper"><?php if(!empty($score)){ echo $score['sum'];}else{echo 0;}?></td>
                        <td id="total_line"><?php if(!empty($score)){ echo $score['scoreLine'];}else{echo 0;}?></td>
                        <td></td>
                    </tr>
                    </tfoot>

                </table>
                <br>
                <div class="tc"><button type="button" style="width: 80px" class="bg_white">确定</button>&nbsp;&nbsp;&nbsp;<button type="button"  style="width: 80px" class="bg_white_gray">取消</button></div>
            </div>
        </form>
        </div>
    </div>
</div>

