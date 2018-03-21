<?php
/* @var $this yii\web\View */
/* @var $error array */

$this->title = \Yii::$app->name . ' - Error';

$this->blocks['bodyclass'] = "wrongHint";
?>
<div class="wrong_bg_n">
    <div class="wrong wrong_L403 clearfix">
        <div class="wrong_L  fl">


        </div>

        <div class="wrong_R fr">
            <h1><?php echo empty($message)? '很抱歉，您没有访问权限' : $message; ?> <span>...</span></h1>

            <div class="wrong_Btn">
                <a href="javascript:history.back(-1);" class="pageup">返回上一页</a>
            </div>
        </div>
    </div>
</div>