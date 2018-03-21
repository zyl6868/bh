<?php
use frontend\components\helper\ViewHelper;
use yii\helpers\StringHelper;
use yii\web\View;

$this->title='学米兑换';
$this->registerCssFile(BH_CDN_RES.'/static' .'/css/teacher_treasure.css'. RESOURCES_VER,['position' => View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES.'/static' . '/js/lib/jquery.validationEngine.min.js' . RESOURCES_VER, ['position' => View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES.'/static' . '/js/lib/jquery.validationEngine_zh_CN.js' . RESOURCES_VER, ['position' => View::POS_HEAD]);
$this->blocks['requireModule']='app/teacher/teacher_treasure';
?>

<div id="main" class="clearfix main">
<!--主体-->
    <div id="main_left" class="main_left">
        <!-- 选项卡 -->

        <?php if($user->type==1){?>
            <div class="mag_title">
                <a href="javascript:;" onclick="window.history.go(-1)" class="btn btn30 icoBtn_back gobackBtn bg_gray"><i></i>返回</a>
                <h4>学米商城</h4>
            </div>
        <?php }else{?>
            <ul class="main_tab bg_fff">
                <li ><a href="<?=Url(['/student/mytreasure/my-treasure'])?>">我的学米</a></li>
                <li ><a href="<?=Url(['/student/mytreasure/treasure-details'])?>">学米明细</a></li>
                <li id="select" class="select_income"><a href="<?=Url(['/student/mytreasure/treasure-exchange'])?>">学米商城</a></li>
            </ul>
        <?php } ?>
        <!-- 学米商城 -->
        <div id="tab_3" class="tab_class bg_fff tab_3_fff">
            <ul>
                <li><span>
                        <?php if($user->type == 1){
                            if($accountType == 1){
                                echo '结转学米：';
                            }else{
                                echo +$month.'月学米：';
                            }
                        }else{
                           echo '我的学米：';
                        }
                        ?>
                    </span>
                    <a href="javascript:;" class="cursor_def" id='myXuemi' monthAccountId = "<?php echo $monthAccountId;?>" total="<?php if($user->type == 1){echo $total;}else{echo $myAccount;};?>" style="font-size: 24px;">
                        <?php if($user->type == 1){echo $total;}else{echo $myAccount;};?>
                    </a>
                </li>
            </ul>
            <ul class="table">
                <?php if(count($goods) !== 0){?>
                    <?php foreach($goods as $key=>$val){?>
                        <li class="rol_ fl" data-content="<?=$val->name?>" data-content-id="<?=$val->xueMi?>" data-id="<?=$val->goodId?>" isPrivilege="<?=$val->isPrivilege?>">
                            <div class="foodsList"><img src="<?= $val->image ?>" alt="" />
                                <?php if($val->isPrivilege==1){?>
                                     <img src="<?php echo BH_CDN_RES;?>/static/images/vipLogo.jpg" alt="" class="vipLogo">
                                <?php } ?>
                            </div>
                            <ul>
                                <li class="img_name" style="font-size: 18px;font-weight:inherit;" title="<?php echo $val->name;?>"><?=StringHelper::truncate($val->name, 8,'...','utf-8')?></li>
                                <li class="integral tc margin_">
                                    <a href="javascript:;" class="cursor_def">
                                        <span style="color:black">所需学米:</span><?=$val->xueMi?>
                                    </a>
                                    <?php if($val->isShowAmount == 1){?>
                                        <a href="javascript:;" class="cursor_def" style="color:black;font-size:14px;">
                                            <span>可兑换:</span><?=$val->amount?>
                                        </a>
                                    <?php } ?>
                                </li>
                                <li class="btn_ tc">

                                    <button class=" <?php if($val->amount <=0){ echo 'btngray btn_disable'; }else{echo "btn40 btn";} ?>" style="width:108px;height: 40px;">去兑换</button>

                                    <p style="margin-top:14px;">已有<?php echo $val->exchangeNum?>人兑换</p>
                                </li>
                            </ul>
                        </li>
                    <?php }?>
                <?php }else{
                    ViewHelper::emptyView('暂无商品');
                }?>
            </ul>
        </div>
    </div>

    <!-- 主题右侧 我的积分 -->
    <div id="main_right" class="main_right">
        <?php echo $this->render("_my_treasure",['user'=>$user,'myAccount'=>$myAccount,'todayAccount'=>$todayAccount]);?>
    </div>

</div>
<?php
$form =\yii\widgets\ActiveForm::begin( array(
    'id' => 'form_id'

)) ?>
<div id="confirm_integral" class="confirm_integral" style="display:none;">
    <div id="confirm_integral_header" class="confirm_integral_header">填写收货信息<i></i></div>
    <div class="integralAddress_main clearfix">
        <ul class="addressMessage left">
            <li>
                <label>
                    <span class="addressMessage">收货人 <span class="red essential"> * &nbsp;</span> </span>
                    <input type="text" class="contact" name="contact" data-prompt-position="topLeft" data-errormessage-value-missing="联系人不能为空！"
                           data-validation-engine="validate[required,custom[notnull],maxSize[20]]" >
                </label>
            </li>
            <li>
                <label>
                    <span class="addressMessage">详细地址 <span class="red essential"> * &nbsp;</span> </span>
                    <textarea cols="30" rows="10" class="address" name="address" data-prompt-position="topLeft" data-errormessage-value-missing="地址不能为空！"
                              data-validation-engine="validate[required,custom[notnull],maxSize[100]]"></textarea>
                </label>
            </li>
            <li>
                <label>
                    <span class="addressMessage">手机号码 <span class="red essential"> * &nbsp;</span> </span>
                    <input type="text" class="contactPhone" name="contactPhone"  data-prompt-position="topLeft" data-errormessage-value-missing="请输入正确手机号！"
                           data-validation-engine="validate[required,custom[phoneNumber]]">
                </label>
            </li>
            <input type="hidden" name="goodsId" id="goodsId">
        </ul>
        <ul class="addressMessage right">
            <li>1.话费等虚拟商品填写完毕后等待充值即可！</li>
            <li>2.邮寄费用由班海承担，邮寄范围仅限中国大陆地区。</li>
            <li>3.奖品以实物为准，将在兑换后1个月内寄出，请注意查收！</li>
            <li>4.请先验货确认无误再签收，由于个人登记错误的，一经签收，出现问题，概不负责!</li>
        </ul>
        <div class="addressMessage fl">
            <p class="warnMessage"><span style="" class="warn">!</span> 如果您兑换的商品为话费充值，将为您填写的号码充值</p>
            <div class="giftMessage">
                <div>
                    您选择兑换的物品为<span class="red" id="box_name"></span>,需要<span class="blue" id="num"></span>学米。<br>
                    点击下方"确定兑换"后,会有工作人员跟您联系,为您发放礼品
                </div>
                <div class="btn_class">
                    <a href="javascript:;" class="button_ confirm" id="confirm" >确认兑换</a>
                    <a href="javascript:;" class="button_ btn_cancel" id="cancel">取消</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php \yii\widgets\ActiveForm::end(); ?>
