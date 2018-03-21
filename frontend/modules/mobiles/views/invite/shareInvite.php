<?php
/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 17-5-3
 * Time: 下午6:02
 */

use yii\web\View;

/* @var $this yii\web\View */
$this->registerCssFile(BH_CDN_RES . '/static/css/appShareInvite.css' . RESOURCES_VER, ['position' => View::POS_HEAD]);


?>
<div class="inviteContent">
    <img class="inviteBg" src="<?= BH_CDN_RES . '/static' ?>/images/inviteBgTopNew.png" alt="">
    <div class="inviteBgBtm">
        <img class="inviteBgBtm1" src="<?= BH_CDN_RES . '/static' ?>/images/inviteBgBtm1.png" alt="">
        <img class="inviteBgBtm2" src="<?= BH_CDN_RES . '/static' ?>/images/inviteBgBtm2.png" alt="">
    </div>
    <div class="teacherDiv">
        <table class="teacherList">
            <thead class="thead">
            <tr>
                <th>用户名</th>
                <th>用户班级</th>
                <th>奖励</th>
            </tr>
            </thead>
            <tbody>
            <?php /** @var \common\models\pos\SeInviteTeacher $inviteTeacherArray */
            if (count($inviteArray) > 0) {
                foreach ($inviteArray as $inviteTeacher) {
                    ?>
                    <tr>
                        <td><?php echo $inviteTeacher['phoneReg'] ?></td>
                        <td><?php echo $inviteTeacher['className'] ?></td>
                        <td><?php echo $inviteTeacher['isAward'] == 1 ? '已奖励' : '' ?></td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr class="noInvite">
                    <td colspan="3">暂无邀请记录~</td>
                </tr>

            <?php } ?>

            </tbody>
        </table>
    </div>
</div>
