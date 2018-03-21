<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/1
 * Time: 14:27
 */
use common\models\pos\SeFavoriteMaterialGroup;
use frontend\components\helper\DepartAndSubHelper;
use yii\helpers\Url;

/** @var $this  yii\web\View */
$this->title = '我的资源-课件';
$this->blocks['bodyclass'] = "platform";
$this->blocks['requireModule'] = 'app/teacher/teacher_home_courseware';
$arr = ['favoriteMaterialList' => $favoriteMaterialList,
    'groupType' => $groupType,
    'pages' => $pages,
    'matType' => $matType,
    "department" => $department,
    "subjectId" => $subjectId,
    'groupId' => $groupId
];

?>
<div class="main col1200 clearfix platform_question_bank" id="requireModule" rel="app/teacher/teacher_home_courseware">
    <div class="aside col260 alpha">
        <div id="sel_classes" class=" currency_hg sel_classes" data-department="<?php echo $department ?>"
             data-subjectId="<?php echo $subjectId ?>" data-type="<?php echo $groupType ?>">
            <div class="pd15">
                <?php
                $departAndSubArray = DepartAndSubHelper::getTopicSubArray();
                echo $this->render('_depart_and_sub_menu',
                    ['departAndSubArray' => $departAndSubArray, 'department' => $department, 'subjectId' => $subjectId]);
                ?>
            </div>
        </div>
    </div>
    <div class="tch_resource container col910 omega currency_hg">
        <div class="sUI_pannel tab_pannel">
            <div class="pannel_l">
                <div class="sUI_tab">
                    <ul class="tabList clearfix">
                        <li>
                            <a href="<?php echo Url::to(["/teacher/resources/collect-work-manage"]) ?>" class="tch_hmwk_ic">
                                <i></i>作业
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo Url::to(["/teacher/question/index"]) ?>" class="tch_question_ic">
                                <i></i>题目
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo Url::to(["/teacher/favoritematerial/index"]) ?>" class="tch_courseware_ic ac">
                                <i></i>课件
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo Url::to(["/teacher/managepaper/index"]) ?>" class="tch_exam_ic">
                                <i></i>试卷
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="aside col260 alpha no_bg">
        <ul class="custom_toggle">
            <li class="collection">
                <a href="<?php echo Url::to(['/teacher/favoritematerial/index', 'department' => $department, 'subjectId' => $subjectId]) ?>" class="<?php echo $groupType == 0 ? 'ac' : '' ?>">
                    我的收藏
                </a>
            </li>
            <li class="establish">
                <a href="<?php echo Url::to(['/teacher/favoritematerial/index-create', 'department' => $department, 'subjectId' => $subjectId]) ?>" class="<?php echo $groupType == 2 ? 'ac' : '' ?>">
                    我的上传
                </a>
            </li>
        </ul>
        <div id="groupList">
            <?php echo $this->render('_group_list', ["department" => $department, "subjectId" => $subjectId, 'groupType' => $groupType, 'groupId' => $groupId])?>
        </div>
    </div>

    <div id="material_list">
        <?php
        echo $this->render('_index_list_create', $arr);
        ?>
    </div>

</div>

<!--修改组名-->
<div id="modify" class="popBox hide" title="修改组名">
    <div class="popCont">
        <div class="input"><input placeholder="请输入组的名称" type="text" maxlength="15" value="<?php
            if (!empty($groupId) && $groupInfo = SeFavoriteMaterialGroup::getGroupInfo((int)$groupId, user()->id)) {
                echo $groupInfo->groupName;
            } else {
                echo '我的收藏';
            }?>"/></div>
        <div class="span"><span>限制15个字，多于15个字不允许输入</span></div>
    </div>
    <div class="popBtnArea">
        <div class="btn_work">
            <button type="button" class="okBtn" id="updateGroupName" data-groupId="<?php echo $groupId ?>">确定</button>
            <button type="button" class="cancelBtn">取消</button>
        </div>
    </div>
</div>
<!--添加组-->
<div id="addGroup" class="popBox hide" title="添加组">
    <div class="popCont">
        <div class="input"><input id="add-group-name" placeholder="请输入组的名称" type="text" maxlength="15"/></div>
        <div class="span"><span style="color:red;">限制15个字，多于15个字不允许输入</span></div>
    </div>
    <div class="popBtnArea">
        <div class="btn_work">
            <button type="button" class="okBtn" id="sureAddCroup">确定</button>
            <button type="button" class="cancelBtn">取消</button>
        </div>
    </div>
</div>
<!--删除组-->
<div id="delGroup" class="popBox hide" title="删除组">
    <div class="popCont clearfix">
        <div class="ico"><i></i></div>
        <div class="span"><span>确认删除该组吗？删除后该组下的课件也将删除!</span></div>
    </div>
    <div class="popBtnArea">
        <div class="btn_work">
            <button type="button" class="okBtn" id="deleteGroup" data-groupId="<?php echo $groupId ?>">确定</button>
            <button type="button" class="cancelBtn">取消</button>
        </div>
    </div>
</div>
<!--删除课件-->
<div id="delCourse" class="popBox hide" title="删除组">
    <div class="popCont clearfix">
        <div class="ico"><i></i></div>
        <div class="span"><span>确认删除所选课件吗？</span></div>
    </div>
    <div class="popBtnArea">
        <div class="btn_work">
            <button type="button" class="okBtn">确定</button>
            <button type="button" class="cancelBtn">取消</button>
        </div>
    </div>
</div>
<!--分享我的收藏-->
<div id="popBox4" class="popBox mshare hide" title="分享资料">
    <div id="collectShare"></div>
</div>
