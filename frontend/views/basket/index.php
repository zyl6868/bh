<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/2/23
 * Time: 14:04
 */
use common\components\WebDataCache;
use common\models\dicmodels\SubjectModel;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title='选题篮';
$this->registerCssFile(BH_CDN_RES.'/static/css/test_basket.css'.RESOURCES_VER);
$this->blocks['requireModule']='app/test_basket/test_basket_view';
?>
<div class="main col1200 clearfix test_basket_view" id="requireModule" rel="app/test_basket/test_basket_view">
    <div class="container">
        <div class="sUI_pannel top_panner">
            <a id="return_btn" onclick="history.go(-1)" class="btn bg_gray icoBtn_back return_btn"><i></i>返回</a>
            <div class="pannel_r">
                <span><a id="saveBtn" href="javascript:;" class="btn btn40 bg_blue">保存选题篮</a></span>
                <span><a id="conformBtn" href="javascript:;" class="btn btn40 bg_blue">确认出题</a></span>
                <ul id="conformList" class="conformList pop">
                    <span class="arrow"></span>
                    <li><a data-popBox="hmwk" href="javascript:;" cartId="<?=$cartId?>">作业</a></li>
                </ul>
            </div>

        </div>

    </div>
    <div class="container count_question"  style="height:60px; line-height: 60px; text-indent: 25px; font-size: 16px">
        共选择<span><?php echo count($questionCartQuestion)?></span>道题
    </div>
    <div class="container no_bg">
        <div class="testPaper">
            <?php echo $this->render("_question_list", ["questionCartQuestion"=>$questionCartQuestion]);?>
        </div>
    </div>
</div>
<div id="bskt_conf_hmwk_Box" class="popBox bskt_conf_hmwk_Box hide" title="确认出题" >
    <?php $form =\yii\widgets\ActiveForm::begin( array(
        'enableClientScript' => false,
        'id' => "homework_form",
        'method'=>'post'
    )) ?>
    <div class="popCont">
        <div class="subTitleBar">
            <h5>完善作业信息</h5>
        </div>
        <div class="sUI_formList">
            <div class="row">
                <?php $departmentName=WebDataCache::getDictionaryName($department);
                    $subjectName=SubjectModel::model()->getName((int)$subject);
                    $finalDepartmentName=substr($departmentName,0,6);
                ?>
                名称：<input type="text" class="text homeworkName" value="<?=date('Y-m-d',time()).$finalDepartmentName.$subjectName.'作业'?>" data-validation-engine="validate[required,maxSize[30]]" style="width: 402px">
            </div>
            <div class="row">
                <label>学段：<input type="text" value="<?=$departmentName?>" readonly="true" class="text"  style="width:80px">
                    <input type="hidden" id="department" value="<?=$department?>">
                    <input type="hidden" id="cartId" value="<?=$cartId?>">
                </label>
                <label>学科：<input type="text" value="<?=$subjectName?>" readonly="true" class="text"  style="width:80px">
                    <input type="hidden" id="subject" value="<?=$subject?>">
                </label>
                <label>版本：
                    <?php echo Html::dropDownList('','',$versionList,   array(
                        "id" => "version",
                        'data-validation-engine' => 'validate[required]',
                        'data-prompt-target' => "grade_prompt",
                        'data-prompt-position' => "inline",
                        'data-errormessage-value-missing' => "年级不能为空",
                    ))?>
                </label>
                <label class="tomeData">分册：<?php echo Html::dropDownList('','',$chapterArray,array(
                        "id" => "tome",
                        'data-validation-engine' => 'validate[required]'
                    ) )?>
                </label>
                <label>难度：<?php echo Html::dropDownList('','',[0=>'普通','1'=>'中等','2'=>'较难'],array(
                        "id" => "difficulty",
                        'data-validation-engine' => 'validate[required]'
                    ) )?>
                </label>
            </div>
            <div class="row">
                章节：
                <div class="chapter_sel clearfix">
                    <div class="cha_box cha_l leftTree">
                        <ul id="pointTree" class="tree pointTree">
                        </ul>
                    </div>
                    <div class="cha_box cha_c">
                        <br><br><button id="add_custom_btn" type="button" class="bg_blue">添加</button><br><br>
                        <button id="del_custom_btn" type="button" class="">删除</button>
                    </div>
                    <div class="cha_box cha_r"><ul id="custom_sel_list" class="custom_sel_list"></ul></div>
                </div>
            </div>
        </div>
    </div>
    <div class="popBtnArea">
        <button type="button" class="okBtn create">确定</button>
        <button type="button" class="cancelBtn">取消</button>
    </div>
    <?php \yii\widgets\ActiveForm::end(); ?>
</div>
<script>
    $(function(){

        //选择 学段 学科……
        $('#version').change(function(){
            subject=$('#subject').val();
            department=$('#department').val();
            version=$(this).val();
            $.post('<?=Url::to("/basket/get-tome-list")?>',{
                subject:subject,
                department:department,
                version:version
            },function(result){
                $('.tomeData').html(result);
            });
            $('#custom_sel_list').empty();
            $('.leftTree').empty();
        });
//        改变分册章节树变化
        $(document).on('change','#tome',function(){
            var tome=$(this).val();
            var subject=$('#subject').val();
            var  department=$('#department').val();
            var  version=$('#version').val();
            $.post('<?=Url::to("/basket/get-chapter-list")?>',{
                tome:tome,
                subject:subject,
                department:department,
                version:version
            },function(result){
                $('.leftTree').html(result);
            });
            $('#custom_sel_list').empty();
        });
//        创建作业
        $('.create').click(function(){
            if ($('#homework_form').validationEngine('validate')) {
                var homeworkName=$('.homeworkName').val();
                var subject=$('#subject').val();
                var  department=$('#department').val();
                var  version=$('#version').val();
                var chapterList=$('#custom_sel_list').find('li');
                var cartId=$('#cartId').val();
                var difficulty=$('#difficulty').val();
                if(chapterList.size()>0) {
                    chapterList.each(function (index, el) {
                        if (index == 0) {
                            chapterId = $(el).attr('id');
                        }
                    });
                }else{
                    require(['popBox'],function(popBox){
                        popBox.errorBox('请选择章节');
                    });
                    return false;
                }

                $.post('<?=Url::to(["/basket/create-homework"])?>',{
                    homeworkName:homeworkName,
                    subject:subject,
                    department:department,
                    version:version,
                    chapterId:chapterId,
                    cartId:cartId,
                    difficulty:difficulty
                },function(result){
                    if(result.success){
                        window.location.href='<?=Url::to("/teacher/resources/my-create-work-manage")?>'
                    }else{
                        require(['popBox'],function(popBox){
                            popBox.errorBox(result.message);
                        });
                    }
                })
            }
        });
        $("#saveBtn").click(function(){
             var questList =$('.quest');
            var dataArray=[];
            questList.each(function(index,el){
                var orderNumber=$(el).find('.del_question').attr('orderNumber');
                var cartQuestionId=$(el).find('.pd25').attr('cartQuestionId');
                var data={'cartQuestionId':cartQuestionId,'orderNumber':orderNumber};
                dataArray.push(data);
            });
            $.post('<?=Url::to("/basket/save-basket-order")?>',{dataArray:dataArray},function(result){
                require(['popBox'],function(popBox){
                    popBox.successBox('保存成功');
                })
            })
        });

    })
</script>