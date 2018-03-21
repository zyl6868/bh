<?php
use frontend\components\helper\ViewHelper;
use yii\helpers\Html;

if(empty($sysResult)){
    ViewHelper::emptyView('暂无消息！');
}?>

<?php foreach($sysResult as $sysVal){?>
     <li>
         <i></i>
         <?php
             $url = 'javascript:void(0)';
             if(isset($sysVal->messageType) && $sysVal->messageType != 507009){
                 $url = url('teacher/message/is-read',array('messageID'=>$sysVal->messageID,'messageType'=>$sysVal->messageType,'objectID'=>$sysVal->objectID));
             }
         ?>
         <a class="title ellipsis" href="<?php echo  $url; ?>">
             <?php echo Html::encode($sysVal->messageTiltle) ?>
         </a>
         <a class="ellipsis" title="<?php echo Html::encode($sysVal->messageContent)?>" href="<?php echo $url;?>">
             <?php echo Html::encode($sysVal->messageContent)?>
         </a>
         <span>
             <?php echo $sysVal->sentTime?>
         </span>
     </li>
<?php } ?>
