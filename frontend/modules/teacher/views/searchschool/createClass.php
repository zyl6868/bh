<?php
/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 17-6-30
 * Time: 下午6:53
 */
use yii\helpers\Url;

/** @var yii\web\View $this */
$this->title = '创建班级';
$this->registerCssFile(BH_CDN_RES . "/static/css/createClass.css" . RESOURCES_VER);
$this->blocks['requireModule'] = 'app/teacher/search_class';
?>
<h4 id="main_head" class="bgWhite main_head"><a
            href="<?php echo Url::to(['class-list', 'schoolId' => $schoolInfo->schoolID]) ?>"
            class="btn icoBtn_back"><i></i>返回</a>创建班级</h4>
<div class="main page bgWhite">
    <ul class="createClass">
        <li>
            <span class="des">学校名称 :</span>
            <span class="schoolName"><?php echo $schoolInfo->schoolName ?></span>
        </li>
        <li>
            <span class="des">
                <span class="mandatory" id='createClass_dep' schoolId="<?php echo $schoolInfo->schoolID; ?>">*</span>选择学段 :
            </span>
            <?php
            $departmentArray = explode(',', $schoolInfo->department);
            foreach ($departmentArray as $v) {
                $departmentName = '';
                if ($v == 20201) {
                    $departmentName = '小学';
                } else if ($v == 20202) {
                    $departmentName = '初中';
                } else if ($v == 20203) {
                    $departmentName = '高中';
                }
                ?>
                <span class="create_class grade <?php echo $v == $departmentId ? 'ac' : '' ?>"
                      departmentId="<?php echo $v ?>"><?php echo $departmentName; ?></span>
            <?php } ?>
        </li>
        <li>
            <span class="des">
                <span class="mandatory">*</span>年级 :
            </span>
            <select class="bgWhite" id="gradeId">
                <?php foreach ($gradeDataList as $k => $v) { ?>
                    <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                <?php } ?>
            </select>
        </li>
        <li>
            <span class="des">
                <span class="mandatory">*</span>班级 :
            </span>
            <select class="bgWhite" id="classId">
                <?php for ($i = 1; $i <= 30; ++$i) { ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?>班</option>
                <?php } ?>
            </select>
        </li>
        <li>
            <span class="des">
              <span class="mandatory">*</span>入学年份 :
            </span>
            <select class="bgWhite" id="joinYear">
                <?php foreach ($joinYear as $k=>$v) {
                        if($k == 11){
                            break;
                        }
                    ?>
                    <option value="<?php echo $v; ?>"><?php echo $v; ?>年</option>
                <?php } ?>
            </select>
        </li>
        <li class="tc">
            <button class="affirm">确认创建</button>
        </li>
    </ul>
</div>
