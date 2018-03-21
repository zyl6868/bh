<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/1/19
 * Time: 13:40
 */
use frontend\components\helper\ViewHelper;
use yii\helpers\Url;

?>

    <div class="testPaper">

        <?php  if(!empty($dataList)){ foreach($dataList as $item){
            echo    $this->render('//publicView/topic_preview/_itemPreviewType',['item'=>$item]) ;
        } }else{
            ViewHelper::emptyViewByPage($pages);
          }?>
    </div>

    <div class="page">
        <?php
        echo \frontend\components\CLinkPagerNormalExt::widget(array(
                'firstPageLabel'=>false,
                'lastPageLabel'=>false,
                'pagination' => $pages,
                'updateId' => '.content',
                'maxButtonCount' => 8,
            )

        );
        ?>
    </div>
<!--弹窗-->
<div id="correctionBox" class="popBox correctionBox hide" title="题目纠错" >

</div>
<script>
    require(['app/platform/platform_common'],function(platform_question_point){
        platform_question_point.answerShowAndHide();
    });

    $(function(){

        var questionIDArray=[];
        $('.quest').each(function(index,el){
            var questionID=$(el).attr('data-content-id');
            questionIDArray.push(questionID);
        });
        $.post("<?=url::to(['/ajax-question/if-collected'])?>",{questionIDArray:questionIDArray},function(result){
            var questionIDArray=result.data;

            $('.quest').each(function(index,el){
                if($.inArray($(el).attr('data-content-id'),questionIDArray)>-1){
                    $(el).find('.fav').addClass('cur');
                    $(el).find('.fav').html('<i></i>取消收藏');
                }
            });
            //        收藏
            $('.fav').click(function(){

                _this=$(this);
                var questionID=$(this).parents('.quest').attr('data-content-id');
                var department=<?php echo $searchArr['department'];?>;
                var subjectId=<?php echo $searchArr['subjectId'];?>;
                if(_this.hasClass('cur')){

                    $.post("<?=url::to(['/ajax-question/cancel-collect'])?>",{questionID:questionID},function(result){

                        if(result.success){

                            _this.removeClass('cur');
                            _this.html('<i></i>收藏');
                        }
                })
                }else {
                    $.post("<?=url::to(['/ajax-question/collect'])?>",{questionID:questionID,department:department,subjectId:subjectId},function(result){
                        require(['popBox'],function(popBox) {
                            if (result.success) {
                                _this.addClass('cur');
                                _this.html('<i></i>取消收藏');
                            } else {
                                popBox.errorBox(result.message);
                            }
                        })
                    })
                }
            })
        });
        //添加选题篮
        $('.join_basket_btn').click(function(){
            var _this=$(this);
            var pa=_this.parents('.quest');
            var cartId = $('.ico_basket').attr('cartId');
            var questionID = $(this).parents('.quest').attr('data-content-id');
            if(!pa.hasClass('join_basket')) {

                if($('.ico_basket').next('.q_num').html()<50) {
                    $.post('<?=Url::to(['/basket/add-cart-questions'])?>', {
                        cartId: cartId,
                        questionID: questionID
                    }, function (result) {
                        var numDom = $('.q_num');
                        var num = parseInt(numDom.html()) + 1;
                        numDom.html(num);
                        pa.addClass('join_basket');
                    })
                }else{
                    require(['popBox'],function(popBox){
                        popBox.errorBox('选题篮中最多放50道题');
                    });
                }
            }else{
                $.post('<?=Url::to(["/basket/del-question"])?>',{
                    cartId:cartId,
                    questionID:questionID
                },function(result){
                    var numDom = $('.q_num');
                    var num = parseInt(numDom.html()) -1;
                    numDom.html(num);
                    pa.removeClass('join_basket');
                })
            }

        });

   var      department=$('#quest_basket').attr('department');
      var  subject=$('#quest_basket').attr('subject');
//        判断选题篮是否存在，不存在生成选题篮
        $.post("<?=Url::to(['/basket/get-question-cart'])?>", {
            department: department,
            subject: subject
        },function(result){
            $('#quest_basket').find('i').attr('cartId',result.data.cartId);
            $('#quest_basket').find('em').html(result.data.num);
        });
//        加载整个页面判断题目是否已经加入选题篮
        $.post("<?=Url::to(['/basket/if-in-cart'])?>",{
            department:department,
            subject:subject,
            questionIDArray:questionIDArray
        },function(result){
            var questionIDArray=result.data;
            $('.quest').each(function(index,el){
                if($.inArray($(el).attr('data-content-id'),questionIDArray)>-1){
                    $(el).addClass('join_basket');
                }
            });
        });


    });

    jumpUrl=function(){
        var cartId = $('.ico_basket').attr('cartId');
        if($('.ico_basket').next('.q_num').html()>0) {
            window.location.href = "<?=Url::to(['/basket/index'])?>" + "?cartId=" + cartId
        }else{
            require(['popBox'],function(popBox){
                popBox.errorBox('当前选题篮是空的');
            });
        }
    };

    //纠错弹框
    $('.correction').click(function(){
       var questionID= $(this).parents('.quest').attr('data-content-id');
        $('#correctionBox').attr('questionID',questionID);
        $.post('<?=Url::to("/ajax-question/get-error-box")?>',function(result){
            $('#correctionBox').html(result);
            $('.popBox').dialog({
                    autoOpen: false,
                    width: 640,
                    modal: true,
                    resizable: false,
                    close: function () {
                        $(this).dialog("close")
                    }
                }
            );


            $('.textareaBox').speak('发送纠错内容',300);
            $('#correctionBox').dialog('open');
        });

    });

</script>