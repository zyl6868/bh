<?php
/**
 * Created by PhpStorm.
 * User: 邓奇文
 * Date: 2016/4/29
 * Time: 9:56
 */
use frontend\components\CLinkPagerExt;
use frontend\components\helper\ViewHelper;

?>
<script type="text/javascript">
    $(function () {
        $(".nub_of_peo_em").text(<?php echo $numberOfPeople; ?>);
    })
</script>
<?php
if (empty($userInfo)) {
    echo "<tr>" . ViewHelper::emptyView("无人员数据！") . "</tr>";
}else{
?>
<table class="sUI_table">
    <thead>
    <tr>
        <th>姓名</th>
        <th>性别</th>
        <th>学段</th>
        <th>学科</th>
        <th>手机号</th>
        <th>登录名</th>
        <th>激活状态</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($userInfo as $item) {
        ?>
        <tr class="u<?php echo $item["userID"]?>">
            <?php echo $this->render("_teacher_list_detail",["item"=>$item]);?>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php } ?>
<div class="page">
    <?php
    echo CLinkPagerExt::widget(
        array(
        'pagination' => $pages,
        'updateId' => '#personnel_list',
        'maxButtonCount' => 10,
        'showjump' => true
        )
    )
    ?>
</div>