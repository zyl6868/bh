<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/11
 * Time: 17:47
 */
use yii\helpers\Html;

?>
<div class="tab">

    <ul class="tabList clearfix" style="margin-left: -35px;">
        <li><a href="javascript:;" class="sysMsg <?php if(isset($msgResult->sysMsg) && $msgResult->sysMsg>99){echo 'over99';}?>"><i></i><b><?= $msgResult->sysMsg; ?></b>系统消息</a> </li>
    </ul>
    <div class="tabCont">
        <div class="tabItem "> <i class="arrow" style="left:25px ;"></i>
            <ul class="myMsg_notice">
                <?php foreach($sysResult as $sys){?>
                    <li>
                        <div class="title">
                            <h4><?= Html::encode($sys->messageContent)?></h4>
                            <div class="title_r"> <?= $sys->sentTime;?></div>
                        </div>
                        <div class="title ">
                            <h4 class="font14 notice_h4">发件人：<?= $sys->sentName?></h4>
                            <div class="title_r notice_r"> <a href="<?php echo url('teacher/message/is-read',array('messageID'=>$sys->messageID,'messageType'=>$sys->messageType,'objectID'=>$sys->objectID))?>" class="btn bg_blue btn30 w120">
                                    <?php
                                    if($sys->messageType == 507003){?>
                                        前去批改
                                    <?php }elseif($sys->messageType == 507004){?>
                                        前去批改
                                    <?php }elseif($sys->messageType == 507403){?>
                                        查看答题情况
                                    <?php }elseif($sys->messageType == 507404){?>
                                        去完善
                                    <?php }elseif($sys->messageType == 507005){?>
                                        点击查看
                                    <?php }?>
                                </a> </div>
                        </div>
                    </li>
                <?php }?>
            </ul>
        </div>
        <div class="tabItem hide myMsg_letter clearfix"> <i class="arrow" style="left: 200px;"></i>
            <i class="arrow" style="left: 200px;"></i>
            <div id="letter_div" class="msg_mine"></div>
        </div>
    </div>
</div>