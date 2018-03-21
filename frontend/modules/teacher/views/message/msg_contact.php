<?php
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 15-4-23
 * Time: 下午2:52
 */
use frontend\components\helper\ViewHelper;
use yii\helpers\Url;
use yii\helpers\Html;

?>
<div class="tab_1 tab main_h4">
    <ul>
        <?php if (empty($modelList)) {
            ViewHelper::emptyViewByPage($pages);
        } else {
            foreach ($modelList as $key => $val) {
                if ($category == 1) {

                    if ($val->isSend == 1) {
                        ?>
                        <li>
                            <h4>
                                <span class="sendsave" title="<?php echo Html::encode($val->title); ?>" infoid="<?php echo $val->id; ?>">
                                    <?php echo Html::encode(cut_str($val->title, 30)); ?>
                                </span>
                                <i class="cut remove_cut" delid="<?php echo $val->id; ?>"></i>
                            </h4>

                            <p><span><?php echo $val->creatTime; ?></span><span
                                    class="f_l"><i></i><span>
                                        <?php $arr = [];
                                        foreach ($val->receivers as $receiverOne) {
                                            if ($receiverOne->isRead == 1) {
                                                $arr[] = $receiverOne;
                                            }
                                        }
                                        echo sizeof($arr); ?>
                                    </span>/<span><?php echo sizeof($val->receivers); ?></span><b
                                        class="become" data-type="true"></b></span></p>

                            <div class="hide_">
                                <?php if (strstr($val->receiverType, "1")) { ?>
                                    <ul>
                                        <li class="hide_first">学生</li>
                                        <?php foreach ($val->receivers as $receiver) {
                                            if ($receiver->type == 0) {
                                                ?>
                                                <li class="poR <?= $receiver->isRead == 0 ? 'font_bold_color' : '' ?>">
                                                    <?php echo $receiver->receiverName; ?>
                                                </li>
                                            <?php }
                                        } ?>
                                    </ul>
                                <?php } ?>
                                <?php if (strstr($val->receiverType, "2")) { ?>
                                    <ul>
                                        <li class="hide_first">家长</li>
                                        <?php foreach ($val->receivers as $receiver) {
                                            if ($receiver->type == 3) {
                                                ?>
                                                <li class="poR <?= $receiver->isRead == 0 ? 'font_bold_color' : '' ?>">
                                                    <?php echo $receiver->receiverName; ?>
                                                </li>
                                            <?php }
                                        } ?>
                                    </ul>
                                <?php } ?>
                            </div>
                        </li>
                    <?php } else {
                        ViewHelper::emptyView('暂无数据');
                    } ?>
                <?php }

                if ($category == 0) {
                    if ($val->isSend == 0) {
                        ?>
                        <li>
                            <h4><span class="sendsave" title="<?php echo Html::encode($val->title); ?>"
                                      infoid="<?php echo $val->id; ?>"><?php echo cut_str($val->title, 30); ?></span><i
                                    class="cut remove_cut" delid="<?php echo $val->id; ?>"></i><a
                                    href="<?= url::to(['/teacher/message/edit-contact', 'id' => ""]) ?><?php echo $val->id; ?>"
                                    class="cut" modifymsgId="<?php echo $val->id; ?>" id="modifymsg"></a></h4>

                            <p><span><?php echo $val->creatTime; ?></span><span class="f_l">
                                    <button sendId="<?php echo $val->id; ?>" class="sendmsg">发布通知</button>
                                    <b class="become" data-type="true"></b></span>
                            </p>

                            <div class="hide_">
                                <?php if (strstr($val->receiverType, "1")) { ?>
                                    <ul>
                                        <li class="hide_first">学生</li>
                                        <?php foreach ($val->receivers as $receiver) {
                                            if ($receiver->type == 0) {
                                                ?>
                                                <li>
                                                    <?php echo $receiver->receiverName; ?>
                                                </li>
                                            <?php }
                                        } ?>
                                    </ul>
                                <?php } ?>
                                <?php if (strstr($val->receiverType, "2")) { ?>
                                    <ul>
                                        <li class="hide_first">家长</li>
                                        <?php foreach ($val->receivers as $receiver) {
                                            if ($receiver->type == 3) {
                                                ?>
                                                <li>
                                                    <?php echo $receiver->receiverName; ?>
                                                </li>
                                            <?php }
                                        } ?>
                                    </ul>
                                <?php } ?>
                            </div>
                        </li>
                    <?php }
                } ?>
            <?php }
        } ?>
    </ul>
    <script type="text/javascript">
        var msg_ele = '<div class="memor_nameformError parentFormevent_form formError" style="opacity: 0.87; position: absolute; top: 1px; left: 0; margin-top: 20px;"><div class="formErrorArrow"><div class="line1"></div><div class="line2"></div><div class="line3"></div><div class="line4"></div><div class="line5"></div><div class="line6"></div><div class="line7"></div><div class="line8"></div><div class="line9"></div><div class="line10"></div></div><div class="formErrorContent">*此人未读信息<br></div></div>';
        $('.font_bold_color').append(msg_ele);
    </script>
</div>
<div class="page ">
    <?php
    echo \frontend\components\CLinkPagerExt::widget(array(
            'pagination' => $pages,
            'updateId' => '#conDate',
            'maxButtonCount' => 5,
            'showjump' => true
        )
    );
    ?>
</div>

<div id="alert" class="alert" style="display:none;">
    <div id="alert_head" class="alert_head">通知详情<i id="alert_remove" class="alert_remove"></i></div>
    <div id="alert_main" class="alert_main">

    </div>
</div>
<div id="caution" class="caution">
    <div id="caution_header" class="tl caution_header">删除通知<i></i></div>
    <div id="caution_main" class="tc caution_main"><i></i>确定删除所选通知吗?</div>
    <div class="btn_c">
        <button class="okBtn">确定</button>
        <button class="cancelBtn btn">取消</button>
    </div>
</div>