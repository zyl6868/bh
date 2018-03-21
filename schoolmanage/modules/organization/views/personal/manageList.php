<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/7/13
 * Time: 13:56
 */
use common\components\WebDataCache;
use common\models\dicmodels\SubjectModel;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = "组织管理-人员管理";
$this->registerJsFile(BH_CDN_RES . '/static/js/require.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES . '/static/js/app/school/app_mag.js', ['position' => \yii\web\View::POS_HEAD]);
/** @var common\models\pos\SeClassMembers $studentList */
/** @var common\models\pos\SeClassMembers $teacherList */
?>
<link href="<?= BH_CDN_RES . '/static' ?>/css/school_testMag.css" rel="stylesheet" type="text/css">
<div class="main col1200 clearfix sch_mag_person sch_mag_teacher">
    <div class="mag_title">
        <a href="<?= Url::to(['/organization/default/index']) ?>" class="btn btn30 icoBtn_back gobackBtn"><i></i>返回</a>
        <h4><?= WebDataCache::getClassesNameByClassId($classID) ?></h4>
    </div>
    <div class="container">
        <ul class="content_tab">
            <li class="ac" id="classID" data-value="<?= $classID ?>">班级人员</li>
        </ul>
        <div class="table_con">
            <div class="num">本班加入码为：<em class="nub_of_peo_em inviteCode"><?php echo $inviteCode; ?></em></div>
        </div>
        <div class="class_classification clearfix">
            <p>班级教师管理</p>
            <dl id="addTh">
                <dt></dt>
                <dd><a href="javascript:;">添加老师</a></dd>
            </dl>
        </div>
        <div class="table_con">
            <div class="num">共计：<em class="nub_of_peo_em"><?php echo $teacherCount; ?></em>&nbsp;位老师</div>

            <div id="personnel1">

                <?php if ($teacherList) { ?>
                    <table class="sUI_table">
                        <thead>
                        <tr>
                            <th width="100px">姓名</th>
                            <th width="80px">性别</th>
                            <th width="100px">手机号</th>
                            <th width="80px">登录名</th>
                            <th width="130px">身份</th>
                            <th width="150px">任教学科</th>
                            <th width="160px">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($teacherList as $v) {

                            ?>
                            <tr class="tea">
                                <td width="100px" class="name"><?php echo cut_str($v['trueName'],10) ?></td>
                                <td width="40px">
                                    <?php if ($v['sex'] == 1) {
                                        echo '男';
                                    } elseif ($v['sex']== 2) {
                                        echo '女';
                                    } else {
                                        echo '*';
                                    } ?></td>
                                <td width="50px"><?php echo $v['bindphone'] ?></td>
                                <td width="50px"><?php echo $v['phoneReg'] ?></td>
                                <td width="130px"><?php echo $v['identity'] == '20401' ? '班主任' : '任课老师' ?></td>
                                <td><?php echo SubjectModel::model()->getName((int)$v['subjectID']) ?></td>
                                <td width="160px" class="oper fathers_td" uid="10363255630">
                                    <div class="operate clearfix" userID="<?php echo $v['userID'] ?>">
                                        <a href="javascript:;" class="see_b view_info  editIdentity">修改身份</a>
                                        <span class="blue fl">|</span>
                                        <a href="javascript:;" class="edit_b edit_stu_info  th_remove_class">移出本班</a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>

                        <script type="text/javascript">
                            $(function () {
                                $('.other_operation').click(function () {
                                    var _this = $(this);
                                    var title = _this.children('em');
                                    var sel_list = _this.find('.sUI_selectList');
                                    var sel_item = _this.find('a');
                                    sel_list.show();
                                    sel_item.click(function () {
                                        if (typeof(_this.attr("data-noChange")) == "undefined") {
                                            title.text($(this).text())
                                        }
                                        sel_list.hide();
                                        return false;
                                    });
                                    return false;
                                });

                            })
                        </script>

                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
        <div class="class_classification clearfix">
            <p>班级学生管理</p>
            <dl class="add_atudent">
                <a href="<?= Url::to(['/organization/personal/add-student', 'classID' => $classID]) ?>">
                    <dt></dt>
                    <dd>单个添加学生</dd>
                </a>
            </dl>
        </div>
        <div class="table_con">
            <div class="num">共计：<em class="nub_of_peo_em"><?php echo $studentCount; ?></em>&nbsp;位学生</div>

            <div id="personnel_list">

                <table class="sUI_table">
                    <thead>
                    <tr>
                        <th width="100px">学号</th>
                        <th width="80px">姓名</th>
                        <th width="100px">性别</th>
                        <th width="80px">手机号</th>
                        <th width="130px">身份</th>
                        <th width="160px">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($studentList as $v) {
                        if ($v) { ?>
                            <tr class="stu">
                                <td width="100px"><?php echo $v['stuID'] == null ? '--' : $v['stuID'] ?></td>
                                <td width="40px" class="name"><?php echo cut_str($v['memName'],10) ?></td>
                                <td width="50px">   <?php if ($v['sex'] == 1) {
                                        echo '男';
                                    } elseif ($v['sex'] == 2) {
                                        echo '女';
                                    } else {
                                        echo '*';
                                    } ?></td>
                                <td width="50px"><?php echo $v['bindphone']?></td>
                                <td width="130px">
                                    <?php
                                    if(empty($v['job'])){
                                        echo '<span style="color: #ff0000">未设置</span>';
                                    }else{
                                        echo WebDataCache::getDictionaryName($v['job']);
                                    }

                                    ?>
                                </td>
                                <td width="160px" class="oper fathers_td" uid="10363255630">
                                    <div class="clearfix operate_stu">
                                        <a href="javascript:;" class="see_b view_info viewInfo">查看</a>
                                        <span class="blue fl">|</span>
                                        <a href="javascript:;" class="edit_b edit_stu_info editInfo">编辑</a>
                                        <span class="blue fl">|</span>

                                        <div data-nochange="" class="sUI_select sUI_select_min fl other_operation">
                                            <em class="sUI_select_t">其它操作</em>
                                            <ul class="sUI_selectList pop" style="display: none;" userID="<?= $v['userID'] ?>">
                                                <li>
                                                    <a href="javascript:;" class="reset_passwd_bt student_remove_class">移出本班</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;"  class="reset_passwd_bt student_remove_school">移出本校</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class="reset_passwd_bt reset_pwd">重置密码</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class="reset_passwd_bt editStu updateIden">修改身份</a>
                                                </li>
                                            </ul>
                                            <i class="sUI_select_open_btn"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php }
                    } ?>

                    <script type="text/javascript">
                        $(function () {
                            $('.other_operation').click(function () {
                                var _this = $(this);
                                var title = _this.children('em');
                                var sel_list = _this.find('.sUI_selectList');
                                var sel_item = _this.find('a.sUI_select_t');
                                sel_list.show();
                                sel_item.click(function () {
                                    if (typeof(_this.attr("data-noChange")) == "undefined") {
                                        title.text($(this).text())
                                    }
                                    sel_list.hide();
                                    return false;
                                });
                                return false;
                            });
                            $(".reset_pwd").click(function () {
                                var userId = $(this).parents(".pop").attr("userID");
                                $.get("/personnel/student/alert-password", {userId: userId}, function (data) {
                                    $("#reset_passwordBox").html(data);
                                    $('#reset_passwordBox').dialog("open");
                                })
                            });
                            $('#glass').find('span').live('click', function () {
                                getTeacher();
                            });
                            $(window).keyup(function () {
                                var e = event || window.event || arguments.callee.caller.arguments[0];
                                if (e && e.keyCode == 13) { // 按 Esc
                                    getTeacher();
                                }
                            });
                            if (!$('#glass').html()) {

                            }
                            function getTeacher() {
                                var keywords = $('#find_teacher').val();

                                $.post('<?=Url::to(["get-teachers"])?>', {'keywords': keywords}, function (result) {
                                    if (result.success) {
                                        $('#find_name').html(result.data);
                                        $('#no_find_name').html('');
                                        $('#btn_c').show();
                                    } else {
                                        $('#no_find_name').html('对不起,没有找到<span>该老师</span>');
                                        $('#find_name').html('');
                                        $('#btn_c').hide();
                                    }
                                })
                            }
                        })
                    </script>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--弹框-->
    <!--弹框重置密码-->
    <div id="reset_passwordBox" class="popBox reset_passwordBox hide" title="重置密码">

    </div>

    <!--教师个人信息-->
    <div id="infoBox" class="popBox infoBox hide" title="教师个人信息">

    </div>
    <!--学生个人信息-->
    <div id="stuInfoBox" class="popBox infoBox hide view_student_info" title="学生个人信息">

    </div>

    <!--编辑教师个人信息-->
    <div id="editInfoBox" class="popBox editInfoBox hide" title="编辑学生个人信息">

    </div>

</div>