<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<a href="<?php echo Url::to(['/exam','schoolLevel'=>$department])?>" class="btn btn30 icoBtn_back gobackBtn"><i></i>返回</a>
<h4><?php echo Html::encode($examName);?></h4>