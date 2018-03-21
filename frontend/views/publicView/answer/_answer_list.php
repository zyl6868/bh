<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2015/4/25
 * Time: 15:03
 */
use frontend\components\helper\ViewHelper;
use common\components\WebDataCache;

$this->registerCssFile(BH_CDN_RES.'/pub/js/fancyBox/jquery.fancybox.css' . RESOURCES_VER);
$this->registerJsFile(BH_CDN_RES.'/pub/js/fancyBox/jquery.fancybox.js' . RESOURCES_VER, ['position' => \yii\web\View::POS_HEAD]);
?>
<script>
    $(function () {

        $(".fancybox").die().fancybox();
        $("img.lazy").lazyload({
            effect: "fadeIn"
        });

        //回答
        $('.red_btn_js2').die().live('click', function () {
            var _this = $(this);
            var pa = _this.parents('.make_testpaperli');
            var aqid = _this.attr('val');
            var answer = $(".textarea_js" + aqid).val();
            var no = $("h4[data-id=" + aqid + "]").attr("nub");
            if (answer == '') {
                popBox.errorBox("内容不能为空!");
                return false;
            }
            if (answer.length > 1001) {
                popBox.alertBox('超过1000字数限制，请重新编辑！');
                return false;
            }
            else {
                _this.removeClass("red_btn_js2");
                $.post('<?php echo url('answer/result-question');?>', {answer: answer, aqid: aqid}, function (data) {
                    if (data.success) {
                        popBox.successBox('回答成功');
                        pa.toggleClass('open_answer');
                        pa.removeClass('open_ask').siblings('li').removeClass('open_answer open_ask');
                        answerNumber = $("a[aqid=" + aqid + "]").find("b").html();
                        answerNumber = parseInt(answerNumber) + 1;
                        $("a[aqid=" + aqid + "]").find("b").html(answerNumber);
                        $(".textarea_js" + aqid).val("");
                        //打开回答列表
                        $.post('<?php echo url('answer/reply-list'); ?>', {apid: aqid}, function (result) {
                            $('#reply_list' + aqid).html(result);
                        })
                    } else {
                        popBox.errorBox(data.message);
                    }
                });
                $(this).parent().parent('.pop_up_js').hide();
            }
        });

        /*增加同问的数字*/
        $('.q_add').die().live('click', function () {
            var aqid = $(this).attr('val');
            var no = $("h4[data-id=" + aqid + "]").attr("nub");
            var creatorid = $(this).attr('user');
            var userid = "<?php echo user()->id;?>";
            if (creatorid == userid) {
                popBox.errorBox("请勿同问自己问答！");
                return false;
            } else {
                var aqid = $(this).attr('val');
                //同问数+1
                var same_number = $(this).children('#same' + aqid).attr('val');
                same_number++;
                $.post('<?php echo url('answer/same-question');?>', {aqid: aqid}, function (data) {
                    if (data.success) {
	                    $('#come_from'+aqid ).children('ul').append('<li><div class="picture_listl" creatorID="<?=user()->id; ?>"><img data-type="header" onerror="userDefImg(this);"  width="30px" height="30px" src="<?php echo publicResources() . WebDataCache::getFaceIconUserId(user()->id);?>" alt="" title="<?php echo WebDataCache::getTrueNameByuserId(user()->id);?>"></div></li>');

	                    $("#same" + aqid).text(same_number);
                    } else {
                        popBox.errorBox(data.message);
                    }
                })
            }
        });

        /*点击采用变成已采用*/
        $('.adopt_btn').die().live('click', function () {

            $(this).removeClass('put');
            $(this).text('最佳答案');
            var creatorID = $(this).parents("li").find('em').attr('creatorID');
            var aqid = $(this).attr('u');
            var no = $("h4[data-id=" + aqid + "]").attr("nub");
            var resultid = $(this).attr('val');
            $.post('<?php echo url('answer/use-the-answer');?>', {
                resultid: resultid,
                creatorID: creatorID,
	            aqid:aqid
            }, function (data) {
                if (data.success) {
                    $.post('<?php echo url('answer/answer-detail');?>', {aqid: aqid}, function (datas) {

                        $("h4[data-id=" + aqid + "]").text("问题 " + no + "：");
                        $("h4[data-id=" + aqid + "]").attr("nub", no);
                        $('.answerBigBox' + aqid).children('.answerW').show();
                        //打开回答列表
                        $.post('<?php echo url('answer/reply-list'); ?>', {apid: aqid}, function (result) {
                            $('#reply_list' + aqid).html(result);
                        })
                    });
                }
                else
                {
	                popBox.errorBox(data.message);
                }
            })
        });

        $('.reply').click(function () {
            var pa = $(this).parents('.make_testpaperli');
            pa.toggleClass('open_ask');
            pa.removeClass('open_answer').siblings('li').removeClass('open_ask open_answer');
            pa.find(".rep_btn").addClass("red_btn_js2");
        });
         //查询答案列表
        $('.open_reply_list').click(function () {
            var rep_num = $(this).find("b").html();

            if (rep_num == 0) {
                popBox.errorBox('暂无答案！');
	            return false;
            } else {
                var pa = $(this).parents('.make_testpaperli');
                pa.toggleClass('open_answer');
                pa.removeClass('open_ask').siblings('li').removeClass('open_answer open_ask');
	            var apid = $(this).attr('aqid');
	            $.post('<?php echo url('answer/reply-list'); ?>', {apid: apid}, function (data) {
		            $('#reply_list' + apid).html(data);
	            })
            }
        });

        $('.cancel_btn').click(function () {
            $(this).parents('.editor').find('textarea').val("");
            var pa = $(this).parents('.make_testpaperli');
            pa.removeClass('open_ask').siblings('li').removeClass('open_answer open_ask');
        });

        $('.quiz').die().live('one', 'click', function () {
            var oText = $(this).children('em');
            var num = oText.text();
            num++;
            oText.text('').append(num);
        });

        var overTime,outTime;
        $('.answer_listL').live({
            mouseover:function(){
                clearTimeout(overTime);
                var _this=$(this);
                var card=_this.children('.business_card');
                if(card.size()<=0){
                    overTime=setTimeout(function(){
                    var userID = _this.attr('creatorID');
                    var source = _this.attr('source');
                    $.ajax({
                        url: "<?=url('answer/show-per-msg')?>",
                        data: {userID: userID, source: source},
                        type: 'post',
                        global: false,
                        success: function (result) {
                            _this.append(result);
                            _this.children('.business_card').show();
                        }
                    });
                    },200);
                }
                else{
                    overTime=setTimeout(function(){
                        card.show();
                    },200);
                    if(sanhai_tools.vertical_position(_this)){
                        card.addClass('business_card_under');
                    }else{
                        card.removeClass('business_card_under');
                    }
                }
            },
            mouseout:function(){
                clearTimeout(overTime);
                var _this=$(this);
                var card=_this.children('.business_card');

                function hideCard(){
                    clearTimeout(outTime);
                    outTime=setTimeout(function(){
                        card.hide();
                    },0);
                }
                hideCard();
                card.mouseover(function(){
                    clearTimeout(outTime);
                });
                card.mouseout(function(){
                    hideCard();
                });
            }
        });
        $('.picture_listl').live({
            mouseover:function(){
                clearTimeout(overTime);

                var _this=$(this);
                var card=_this.children('.business_card');
                if(card.size()<=0){
                    overTime=setTimeout(function(){


                        var userID = _this.attr('creatorID');
                        var source = _this.attr('source');
                        $.ajax({
                            url: "<?=url('answer/show-per-msg')?>",
                            data: {userID: userID, source: source},
                            type: 'post',
                            global: false,
                            success: function (result) {
                                _this.children('.business_card').remove();
                                _this.append(result);
                            }
                        });

                        _this.addClass('business_card_show');
                        if(sanhai_tools.vertical_position(_this)){
                            card.addClass('business_card_under');
                        }else{
                            card.removeClass('business_card_under');
                        }

                    },200);

                }
                else{
                    overTime=setTimeout(function(){
                        _this.addClass('business_card_show');
                    },200);
                    if(sanhai_tools.vertical_position(_this)){
                        card.addClass('business_card_under');
                    }else{
                        card.removeClass('business_card_under');
                    }
                }
            },
            mouseout:function(){
                var _this=$(this);
                clearTimeout(overTime);
                var card=_this.children('.business_card');

                function hideCard(){
                    clearTimeout(outTime);
                    outTime=setTimeout(function(){
                        _this.removeClass('business_card_show');
                    },0);
                }
                hideCard();
                card.mouseover(function(){
                    clearTimeout(outTime);
                });
                card.mouseout(function(){
                    hideCard();
                });
            }
        });


    })
</script>
<div id="answerPage" class="answerPage">
    <?php if (empty($modelList)): ?>
        <li class="make_testpaperli"><?php ViewHelper::emptyView(); ?></li>
    <?php endif ?>
    <ul class="make_testpaperList">

        <?php
        foreach ($modelList as $key => $val):
            echo $this->render('//publicView/answer/_answer_list_all', array('modelList' => $modelList, 'no' => $key + 1, 'val' => $val));
        endforeach;
        ?>
    </ul>
    <?php
    echo \frontend\components\CLinkPagerExt::widget(
        array(
            'pagination' => $pages,
            'updateId' => '#answerPage',
            'maxButtonCount' => 8
        )
    )
    ?>
</div>