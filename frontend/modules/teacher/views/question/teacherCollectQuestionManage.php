<?php
/**
 * Created by PhpStorm.
 * User: 邓奇文
 * Date: 2016/5/30
 * Time: 11:12
 */

use common\components\WebDataCache;
use common\models\dicmodels\SubjectModel;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var common\models\pos\SeQuestionGroup $groupIds */
/** @var common\models\pos\SePaperQuesTypeRlts $result */
/** @var common\models\search\Es_testQuestion $dataList */
/** @var integer $subjectId */
/** @var integer $groupId */
/** @var integer $collectGroupId */
/** @var string $groupName */
/** @var integer $type */
/** @var integer $complexity */

$this->title = "题目管理-我的收藏";
$this->blocks['bodyclass'] = "teacher platform";
$this->blocks['requireModule']='app/teacher/teacher_home_question';
?>

<div class="main col1200 clearfix platform_question_search" id="requireModule" rel="app/teacher/teacher_home_question">
    <div class="aside col260 alpha">
        <div id="sel_classes" class=" currency_hg sel_classes" data-department="<?=$department ?>" data-subjectId="<?=$subjectId ?>" data-groupId="<?=$groupId?>">
            <div class="pd15">
                <h5><?=WebDataCache::getDictionaryName($department).SubjectModel::model()->getName((int)$subjectId)?></h5>
                <button id="show_sel_classesBar_btn" type="button" class="bg_white icoBtn_add_blue"><i></i>更换学科</button>
                <div id="sel_classesBar" class="sel_classesBar pop">
                    <?php foreach($departAndSubArray as $k=>$v){?>
                        <dl>
                            <dt><?=WebDataCache::getDictionaryName($k)?></dt>
                            <?php foreach($v as $key=>$item){?>
                                <dd data-sel-item class="sel_ac"><a href="<?=Url::to(array_merge([''],$searchArr,['subjectId'=>$key,'department'=>$k]))?>"><?=$item?> </a></dd>
                            <?php }?>
                        </dl>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>

    <div class="tch_resource container col910 omega currency_hg">
        <?php
        //右部导航 公告页面
        echo $this->render("//publicView/resources/_my_resources_right_top_nav");
        ?>
    </div>
    <div class="aside col260 alpha">

        <ul class="custom_groups groups_bot">
            <li class="custom">
                <span><i></i>自定义分组</span>
                <a class="addGroup" href="javascript:;"><i></i>新建组</a>
            </li>
            <li class="collection">
                <a class=" <?php echo $groupId == $collectGroupId ? 'ac' : ''; ?>" href="<?= Url::to(['index', 'department'=>$department,'subjectId'=>$subjectId,'groupId' => $collectGroupId]); ?>"><i></i>我的收藏</a><span><em><?=$defaultGroupNum?></em>份</span>
            </li>
            <div id="groupRefresh">
                <?php
                //题目收藏组展示
                echo $this->render('_defineGroup',['department'=>$department,'subjectId'=>$subjectId,'groupIds'=>$groupIds,'groupId' => $groupId]);
                ?>
            </div>
        </ul>
    </div>
    <div class="tch_question container col910 omega no_bg">
        <div class="container" style="margin-top:0">
            <div class="sUI_pannel collections">
                <div class="pannel_l"><a id="gName" href="<?= Url::to(array_merge([''], ['subjectId'=>$subjectId,'department'=>$department,'groupId' => $groupId])); ?>" data-sel-item><?=$groupName?></a><span><em id="QuestionNum"><?=$nowGroupNum;?></em>份</span></div>
                <?php if($groupId != $collectGroupId){ ?>
                    <div class="pannel_r"><a href="javascript:;" class="modify" gId = <?php echo app()->request->get("groupId");?> data-sel-item>修改组名</a><span>|</span><a href="javascript:;" class="delGroup" data-sel-item>删除该组</a></div>
                <?php } ?>
            </div>
            <div class="pd25">
                <div class="sUI_formList sUI_formList_min classes_file_list">
                    <div id="classes_sel_list" class="row" >
                        <?php
                        //题目类型列表
                        echo $this->render('topic_type_view',['groupId'=>$groupId,'result'=>$result,'searchArr'=>$searchArr,'type'=>$type]);
                        ?>
                    </div>
                    <div id="hard_list" class="row">
                        <?php
                        //题目难度列表
                        echo $this->render('topic_dif_list_view',['groupId'=>$groupId,'searchArr'=>$searchArr,'complexity'=>$complexity,]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="container manipulate" style="margin-bottom:-18px">
            <div class="gray_bg">
                <input class="allCheck" type="checkbox"/>
                <span>已选中<em id="questionNum"></em>道题目</span>
                <div class="btn_box">
                    <a href="javascript:" class="move"><i></i>移动到<b></b></a>
                    <div class="move_to pop" style="display:none">
                        <div></div>
                        <?php
                        //中间导航  移动和删除题目
                        echo $this->render('_moveGroup',['collectGroupId'=>$collectGroupId,'groupId'=>$groupId,'subjectId'=>$subjectId,'department'=>$department,'groupIds'=>$groupIds]);
                        ?>
                    </div>
                    <a  class="remove" href="<?= Url::to(array_merge([''], ['subjectId'=>$subjectId,'department'=>$department,'groupId' => $groupId])); ?>"><i></i>删除</a>
                </div>
            </div>
        </div>
        <div class="content container no_bg">
            <?php
            //收藏题目展示列表
            echo $this->render('topic_list',['groupId'=>$groupId,'dataList'=>$dataList,'pages'=>$pages,'searchArr'=>$searchArr]);
            ?>
        </div>
    </div>


</div>

<!--选题篮-->
<div id="quest_basket" class="quest_basket" department=<?=$department?>  subject=<?=$subjectId?> >
    <i class="ico_basket" onclick="jumpUrl()" ></i>
    <em class="q_num"></em>
    <b>选题篮</b>
</div>
<!--修改组名-->
<div id="modify" class="popBox hide modify" title="修改组名">
    <div class="popCont">
        <div class="input"><input id="groupNameNew" placeholder="请输入组的名称" type="text" maxlength="15"/></div>
        <div class="span"><span>限制15个字，多于15个字不允许输入</span></div>
    </div>
    <div class="popBtnArea">
        <div class="btn_work">
            <button type="button" class="okBtn" >确定</button>
            <button type="button" class="cancelBtn">取消</button>
        </div>
    </div>
</div>
<!--添加组-->
<div id="addGroup" class="popBox hide addGroup" title="添加组">
    <div class="popCont">
        <div class="input"><input id="groupName" placeholder="请输入组的名称" type="text" maxlength="15"/></div>
        <div class="span"><span>限制15个字，多于15个字不允许输入</span></div>
    </div>
    <div class="popBtnArea">
        <div class="btn_work">
            <button type="button" class="okBtn">确定</button>
            <button type="button" class="cancelBtn">取消</button>
        </div>
    </div>
</div>
<!--删除组-->
<div id="delGroup" class="popBox hide delGroup" title="删除组">
    <div class="popCont clearfix">
        <div class="ico"><i></i></div>
        <div class="span"><span>确认删除该组吗？删除后该组下的题目也将删除!</span></div>
    </div>
    <div class="popBtnArea">
        <div class="btn_work">
            <button type="button" class="okBtn"  data-collectGroupId="<?=$collectGroupId?>">确定</button>
            <button type="button" class="cancelBtn">取消</button>
        </div>
    </div>
</div>
<!--删除题目-->
<div id="delQuestion" class="popBox hide delQuestion" title="删除题目">
    <div class="popCont clearfix">
        <div class="ico"><i></i></div>
        <div class="span"><span>确认删除所选题目吗？</span></div>
    </div>
    <div class="popBtnArea">
        <div class="btn_work">
            <button type="button" class="okBtn"  data-typeId="<?=$type?>" data-complexity="<?=$complexity?>">确定</button>
            <button type="button" class="cancelBtn">取消</button>
        </div>
    </div>
</div>



