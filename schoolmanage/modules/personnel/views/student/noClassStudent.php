<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/22
 * Time: 14:28
 */

use yii\helpers\Url;

$this->title = "人员管理-学生管理";
$this->blocks['requireModule']='app/sch_mag/sch_mag_student';
?>

<div class="main col1200 clearfix sch_mag_person sch_mag_student" id="requireModule" rel="app/sch_mag/sch_mag_student">
    <div class="aside col260 alpha clearfix">
        <div class="sel_classes">
            <div class="pd15">
                <h5>人员管理</h5>
            </div>
        </div>
    </div>
    <div class="container col910 omega currency_hg">
        <div class="sUI_pannel tab_pannel">
            <div class="pannel_l">
                <ul id="tab_" class="tab_">
                    <li><a href="<?=Url::to(['index'])?>" id="hasclass" class="beCome hasclass">有班级</a></li>
                    <li class="select"><a href="<?=Url::to(['no-class-students'])?>" class="beCome">无班级</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="aside col260 alpha no_bg clearfix">
        <?php echo $this->render("/publicView/_personnel_left") ?>

    </div>
    <div class="container col910 omega">
        <div class="pd25 clearfix">
            <div class="right_con">
                <div class="sUI_pannel">
                    <div class="pannel_l">

                    </div>
                    <div class="pannel_r sch_content">
                        <span class="sUI_searchBar sUI_searchBar_max ">
                        <input id="mainSearch" type="text" class="text" value="">
                        <button type="button" class="searchBtn" id="no_class_search_word">搜索</button>
                        </span>
                    </div>
                </div>
                <div class="table_con">
                    <div class="num">共计：<em class="nub_of_peo_em"><?php echo $numberOfPeople; ?></em>&nbsp;位学生</div>
                    <div id="personnel_list">
                        <?php echo $this->render("_student_list", ["userInfo" => $userInfo, "pages" => $pages, "numberOfPeople" => $numberOfPeople]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--弹框-->
<!--弹框重置密码-->
<div id="reset_passwordBox" class="popBox reset_passwordBox reset_pass_view" title="重置密码">

</div>
<!--学生个人信息-->
<div id="infoBox" class="popBox infoBox hide view_student_info" title="学生个人信息">

</div>

<!--编辑学生个人信息-->
<div id="editInfoBox" class="popBox editInfoBox hide edit_stu_info_view" title="编辑学生个人信息">

</div>
