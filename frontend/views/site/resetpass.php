<?php
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-12-19
 * Time: 上午10:41
 */
/** @var Controller $this */
/* @var $this yii\web\View */  $this->title="重置密码";
$backend_asset = BH_CDN_RES.'/pub';
$this->registerJsFile($backend_asset . "/js/jquery.validationEngine-zh_CN.js");
$this->registerJsFile($backend_asset . "/js/jquery.validationEngine.min.js");
$this->registerJsFile($backend_asset . "/js/register.js".RESOURCES_VER);
?>

<!--中间内容开始-->
<div class="reg_content cont24">
    <div class="reg_c_content reg_password">
        <h3 class="pass">重置密码</h3>

        <?php echo Html::form(); ?>
        <div class="passWordBox">
            <ul class="form_list">
                <?php if (!empty($email)) { ?>
                    <li>
                        <div class="formL">新&nbsp;&nbsp;密&nbsp;&nbsp;码:</div>
                        <div class="formR">
                            <input id="password" name="password" type="password" class="text"
                                   data-validation-engine="validate[required,minSize[6],maxSize[20],custom[onlyLetterNumber]]"
                                   data-errormessage-value-missing="密码不能为空"
                                   data-errormessage-custom-error="无效的密码"/>  <?php if (isset($message)) {
                                echo $message;
                            } ?>
                        </div>
                    </li>
                    <li>
                        <div class="formL">确定新密码:</div>
                        <div class="formR">
                            <input name="password2" type="password" class="text"
                                   data-validation-engine="validate[required,equals[password]]"
                                   data-errormessage-value-missing="确认密码不能为空"
                                   data-errormessage-pattern-mismatch="密码不一致，请重新输入！"/>

                        </div>
                    </li>

                    <li>
                        <div class="formL"></div>
                        <div class="formR">
                            <button type="submit" class="btn submitBtn">确定</button>

                        </div>
                    </li>
                <?php } else { ?>
                    <li>
                        <div class="formL">重置密码key已过期</div>
                    </li>
                <?php } ?>

            </ul>

            <?php echo Html::endForm(); ?>
        </div>

    </div>
    <!--中间内容结束-->
