<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/3/21
 * Time: 10:26
 */
use yii\helpers\Url;

?>
<div class="popCont">
    <div class="sUI_formList">
        <div class="row">
            <div class="form_l">错误类型:</div>
            <div class="form_r">
                <label><input type="checkbox" class="checkbox" value="题目类型" name="errorType[]">题目类型</label>
                <label><input type="checkbox" class="checkbox" value="题目答案" name="errorType[]">题目答案</label>
                <label><input type="checkbox" class="checkbox" value="题目解析" name="errorType[]">题目解析</label>
                <label><input type="checkbox" class="checkbox" value="题目知识点" name="errorType[]">题目知识点</label>
                <label><input type="checkbox" class="checkbox" value="其他" name="errorType[]">其他</label>
            </div>
        </div>
        <div class="row">
            <div class="form_l">错误描述:</div>
            <div class="form_r">
                <div class="textareaBox">
                    <textarea class="textarea"></textarea>
                    <span class="placeholder" style="display: block;">发送私信内容</span>
                    <div class="btnArea"> <em class="txtCount">可以输入 <b class="num">300</b> 字</em>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="popBtnArea">
    <button type="button" class="okBtn">确定</button>
    <button type="button" class="cancelBtn">取消</button>
</div>
<script>
    $('.popBox .cancelBtn').click(function(){
        $(this).parents('.popBox').dialog("close");
    });
    $('#correctionBox .okBtn').click(function(){
        errorTypeArray=[];
        var errorTypeDom=$("[name='errorType[]']:checked");
        errorTypeDom.each(function(index,el){
            errorTypeArray.push($(el).val());
        });

        errorType=errorTypeArray.join(',');
        if(errorType==''){
            require(['popBox'],function(popBox){
                popBox.errorBox('请选择错误类型');
            });
            return false;
        }
        var isOvered=$('.num').attr('data-text-excess');
        var wordSize=$('.num').html();
        if(isOvered){
            require(['popBox'],function(popBox){
                popBox.errorBox('已超出'+wordSize+'个字');
            });
            return false;
        }
        var errorBrief=$('textarea').val();
        var questionID=$('#correctionBox').attr('questionID');
        $.post('<?=Url::to("/ajax-question/question-error")?>',{errorBrief:errorBrief,errorType:errorType,questionId:questionID},function(result){
            $('.popBox').dialog("close");
            require(['popBox'],function(popBox){
                popBox.successBox(result.message);
            });

        })
    });

</script>