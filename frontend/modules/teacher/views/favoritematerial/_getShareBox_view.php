<?php
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 15-4-27
 * Time: 下午12:01
 */
?>

<div class="popCont share">
    <div class="form_list no_padding_form_list clearfix">
        <div class="row clearfix">
            <div class="formL">
                <label>分享资料：</label>
            </div>
            <div class="formR d_my02">
                <input type="hidden" value="<?php echo $id; ?>" id="share">
                <em style="margin-right:20px; color: #10ADE4; line-height: 37px;">
                    <?php
                    echo $result->name . '&nbsp;&nbsp;';
                    echo count($result) > 1 ? '等' : '';
                    ?>
                </em>至:
            </div>
        </div>
        <div class="row clearfix">
            <div class="formL">
                <label>我的班级：</label>
            </div>
            <div class="formR">
                <ul class="multi_resultList  clearfix testClsList class">
                    <?php foreach (loginUser()->getClassInfo() as $val) { ?>
                        <li data_classId="<?php echo $val->classID; ?>" class="">
                            <a href="javascript:;">
                                <?php echo $val->className; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="popBtnArea">
    <button type="button" class="okBtn">确定</button>
    <button type="button" class="cancelBtn">取消</button>
</div>