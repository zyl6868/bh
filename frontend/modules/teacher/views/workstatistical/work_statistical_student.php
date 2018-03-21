<script type="text/javascript">
    $(function() {

        imgArr = ["../../images/testPaper.jpg", "../../images/testPaper.jpg", "../../images/testPaper.jpg", "../../images/testPaper.jpg", "../../images/testPaper.jpg", "../../images/testPaper.jpg"];
        $('.correctPaperSlide').testpaperSlider({
            ClipArr: imgArr
        });

        $('.test_class_this .c_Btn').click(function() {
            $('.imgFile').show().imgFileUpload();
            $(this).parent('.test_class_this').hide();
        });

        $('.finishBtn').click(function() {
            //$(this).hide();
            $('.item_title, .imgFile h6').show();
        });

        $('.cancelBtn').click(function() {
            $('.test_class_this').show();
            $('.imgFile').hide();
        });
        //上下翻页js
        $(".u_list .btn_g").each(function() {
            var list = $(this).prev(),
                firstHeight = list.find("a:eq(0)").height() + 22,
                maxRow = Math.ceil(list.height() / firstHeight),
                prevBtn = $(this).find(".prev"),
                nextBtn = $(this).find(".next"),
                btn_g = $(this);

            function scroll(index, list) {
                list.animate({
                    "top": index * firstHeight * -1 + 'px'
                }, 500);
            }
            if (maxRow < 2) {
                btn_g.hide();
            }
            //上按钮点击
            prevBtn.click(function() {
                var index = parseInt(btn_g.data("index") || 0);
                if (index >= 1) {
                    index--;
                    scroll(index, list);
                    nextBtn.removeClass("stop");
                }
                if (index <= 1) {
                    $(this).addClass("stop");
                }
                btn_g.data("index", index);
            });
            //下按钮点击
            nextBtn.click(function() {
                var index = parseInt(btn_g.data("index") || 0);
                if (index < maxRow - 1) {
                    index++;
                    scroll(index, list);
                    prevBtn.removeClass("stop");
                }
                if (index >= maxRow - 1) {
                    $(this).addClass("stop");
                }
                btn_g.data("index", index);
            });
        });

        //题目弹出层
        $(".u_list .u_right_list a").live('click',function() {
            var questionId = $(this).attr('questionId');
            var answerOption = $(this).attr('answerOption');
            var _this=$(this);
            $.post("<?php echo \yii\helpers\Url::to('question-info')?>",{questionId:questionId,answerOption:answerOption,'relId':<?php echo $relId;?>,student:'student'},function(data){
                //拼接html
                var layerTopic = $('#layerTopic');
                if (layerTopic.size() > 0) layerTopic.remove();

                var elm_pos = sanhai_tools.horizontal_position(_this);
                var offset = _this.offset(),
                    left = offset.left - 100,
                    top = offset.top + 55;
                var layerHtml = [
                    '<div id="layerTopic" class="original_num" style="top:' + top + 'px; left:' + left + 'px">' +
                    '   <div class="exhibition">' +
                    '       <b class="close_box">×</b>' +
                    '       <i class="v_r_arrow"></i>' +
                    '       <div class="content">' +data +
                    '       </div>' +
                    '   </div>' +
                    '</div>'
                ];
                $("body").append(layerHtml.join(""));

                if (!elm_pos) {
                    $('#layerTopic').addClass("layer_right").css({
                        'left': left - 300
                    });
                } else {
                    $('#layerTopic').removeClass("layer_right");
                }

            });
        });
        // 弹层关闭按钮
        $(".close_box").live('click',function(){
            $("#layerTopic").remove();
        });

    })


</script>

                <!--按人批改-->
<div class="tabItem clearfix">
    <div class="statistics_item clearfix">
        <h6 class="tjqk">作业正确率排名</h6>
        <div class="con">
            <?php $i=0; foreach($orderStudent as $k=>$v):
                $i++;
                if($i<10){$i = '0'.$i;}

                $homeworkAnswer = \common\models\pos\SeHomeworkAnswerInfo::find()->select('homeworkAnswerID')->where(['studentID'=>$k,'relId'=>$relId])->one();

                ?>
                <div class="u_list">
                    <div class="u_left"> <span class="num"><?php echo $i;?></span>
                        <div class="u_info"> <span class="headimg"><img src="<?php echo \common\components\WebDataCache::getFaceIconUserId($k)?>" alt="" data-type="header" onerror="userDefImg(this);"></span>
                            <div class="u_name_per">
                                <p class="name"><?php echo \common\components\WebDataCache::getTrueNameByuserId($k);?></p>
                                <p class="per"><?php echo floor($v*100)?>%</p>
                            </div>
                        </div>
                    </div>
                    <div class="u_right">
                        <div class="clearfix u_right_list">
                            <?php foreach($questionArray as $k1 =>$v1):
                            $answerAllResult = \common\models\pos\SeHomeworkAnswerQuestionAll::find()->where(['homeworkAnswerID' => $homeworkAnswer['homeworkAnswerID'], 'questionID' => $v1['questionID']])->one();
                                if ($answerAllResult != null) {
                                    $correctResult = $answerAllResult->correctResult;
                                } else {
                                    $correctResult = 0;
                                }
                                switch ($correctResult) {
                                    case 0:
                                        $pic = 'state3';
                                        break;
                                    case 1:
                                        $pic = 'state3';
                                        break;
                                    case 2:
                                        $pic = 'state2';
                                        break;
                                    case 3:
                                        $pic = 'state1';
                                        break;
                                    default:
                                        $pic='state3';
                                }
                                ?>
                                <a  title="点击查看原题"  class="<?php echo $pic;?>" answerOption="<?php echo $answerAllResult->answerOption;?>" questionId = "<?php echo $v1['questionID'];?>">
                                    <?php echo $homeworkResult->getQuestionNo($v1['questionID']);?>
                                      <i></i>
                                      <div class="content">
                                          <h4>题目1：【2014年  高考  选择题】</h4>
                                          <h4>答案与解析</h4>
                                      </div>
                                </a>
                            <?php endforeach;?>
                        </div>
                        <div class="btn_g">
                            <a class="prev stop"></a>
                            <a class="next"></a>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</div>