<?php
/* @var $this yii\web\View */
/* @var $error array */

$this->title = 'Error';

$this->blocks['bodyclass'] = "wrongHint";
?>
<div class="wrong_bg_n">
    <div class="wrong clearfix">
        <div class="wrong_L fl">


        </div>

        <div class="wrong_R fr">

            <h1><?php echo isset($message) ? $message : "抱歉, 你穿越了 <span>...</span>" ?></h1>
            <div class="wrong_Btn">
                <a href="/" class="index">返回首页</a>
                <a href="javascript:history.back(-1);" class="pageup">上一页</a>
            </div>

        </div>
    </div>
</div>