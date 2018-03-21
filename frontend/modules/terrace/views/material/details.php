<?php
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-11-18
 * Time: 下午4:38
 */
use frontend\components\helper\AreaHelper;
use common\models\dicmodels\ChapterInfoModel;
use common\models\dicmodels\KnowledgePointModel;

/* @var $this yii\web\View */  $this->title="教学库-资料详情";
?>
<script type="text/javascript">
    $(function () {
        $('.uploadNewtestpaperBtn').bind('click', function () {
            var $_this = $(this);
            var id = $_this.attr('collectID');
            var type =$_this.attr('typeId');
            var action =$_this.attr('action');
            $.post("<?php echo url('ku/material/add-material')?>", {id: id,type:type,action:action}, function (data) {
                if (data.success) {
                    if(action==1){
                        $_this.attr('action',0).text('取消收藏');
                    }else{
                        $_this.attr('action',1).text('收藏');
                    }
                } else {
                    popBox.alertBox(data.message);

                }
            });
        });
        $('.del').bind('click',function(){
            var $_this = $(this);
            var id = $_this.attr('collectID');
            $.post("<?php echo url('ku/material/del-material')?>",{id:id},function(data){
                if (data.success) {
                    location.reload();
                } else {
                    popBox.alertBox(data.message);

                }
            });
        });

        $('#downNum').click(function(){
            var id= '<?php echo $model->id;?>';
            $.post("<?php echo url('ku/material/get-down-num')?>",{id:id},function(data){
                if(data.success){
                    $("#downNum i").html(data.data);
                }else{
                    popBox.alertBox(data.message);
                }
            })
        })

    })

</script>

    <script type="text/javascript">
        $(function(){
//搜索按钮切换
            $('.terrace_btn_js span').bind('click',function(){
                $(this).addClass('s_btn').siblings('span').removeClass('s_btn');

            })
        })
    </script>
<!--主体内容开始-->
<div class="replace">
        <div class="deta_de">
            <a href="<?php echo url('ku/questions/index')?>">首页</a>&gt;&gt;<a href="#" class="this">教学库</a>
        </div>
        <div class="class_c clearfix tch">
            <div class="currentLeft grid_5 grid_16 stu_Detail_div c_data">
                <div class="noticeH  clearfix">
                    <h3 class="h3L">资料详情</h3>

                    <div class="new_not fr">
                        <?php
                        if($model->isCollected ==0){ ?>
                            <a href="javascript:" class="B_btn120 btn uploadNewtestpaperBtn" action="1" collectID="<?php echo $model->id;?>" typeId="<?php echo $model->matType;?>">收 藏</a>

                      <?php  }else{?>

                            <a href="javascript:" class="B_btn120 btn uploadNewtestpaperBtn" action="0" collectID="<?php echo $model->id;?>" typeId="<?php echo $model->matType;?>">取消收藏</a>

                     <?php   } ?>
                    </div>
</div>


                <hr>
                <div class="wd_details">
                    <h4><?php echo $model->name;?></h4>
                    <ul class="wd_keywords_list clearfix">
                        <li>
                            <p><?php echo $model->subjectname;?></p>
                        </li>
                        <li>
                            <p><?php echo $model->gradename;?></p>
                        </li>
                        <li>
                            <p><?php echo $model->versionname;?></p>
                        </li>
                        <li class="wd_source">
                            <p class="sou_btn"><a style="color: #0000ff;" href="<?php echo url('school/index',array('schoolId'=>$model->school));?>"><?php echo $model->schoolName;?></a></p>
                        </li>
                    </ul>
                    <ul class="wd_introduce_list ">
                        <li><em>适用于:</em><?php echo AreaHelper::getAreaName($model->provience);?> &nbsp;<?php echo AreaHelper::getAreaName($model->city);?>&nbsp;<?php echo AreaHelper::getAreaName($model->country);?></li>
                        <li><?php if($model->contentType==2){?>
                                <em>章节讲解：</em>
                                <?php
                                if(isset($model->chapKids)){
                                    echo ChapterInfoModel::findChapterStr($model->chapKids) ;
                                } }else{?>
                                <em>知识点讲解：</em>
                                <?php
                                if(isset($model->chapKids)){
                                    foreach(KnowledgePointModel::findKnowledge($model->chapKids) as $key=>$item){
                                        echo $item->name;
                                    }  }  } ?></li>
                        <li><em>资料介绍：</em><p><?php echo $model->matDescribe;?></p></li>
                    </ul>
                    <button class="dataBtn" type="button"  id="downNum">下载教案<span>(<i><?php echo $model->downNum;?></i>)</span></button>
                </div>

            </div>
            <div class="centRight">
                <div class="centRightT">
                    <a href="classHandsin.html" class=" outAdd_btn B_btn120">设置手拉手班级</a> </div>
                <div class="centRightT clearfix">
                    <p class="title titleLeft"> <span>手拉手班级</span><i></i> </p>
                    <hr>
                    <dl class="list_dl clearfix">
                        <dt><img src="../images/pic.png" alt="" width="90" height="90"></dt>
                        <dd>
                            <h3>177班</h3>
                        </dd>
                        <dd><span>学校：</span>北京人大附中</dd>

                        <dd><span>成员：</span>30名学生</dd>
                    </dl>
                </div>
                <div class="centRightT">

                    <ul class="class_list clearfix">
                        <li><a href="#"><img src="../images/user_s.jpg" alt="" title="北京"></a></li>
                        <li><a href="#"><img src="../images/user_s.jpg" alt="" title="北京"></a></li>
                        <li><a href="#"><img src="../images/user_s.jpg" alt="" title="北京"></a></li>
                    </ul>
                </div>
                <div class="centRightT">
                    <h3 class="clearfix">推荐视频</h3>
                    <hr>
                    <h4>资料名称资料名称资料名称资料名称......</h4>
                    <dl class="y_list">
                        <dt><a href="#"><img src="../images/teacher_m.jpg"></a></dt>
                        <dd>
                            <span>简介：</span>简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介
                        </dd>

                    </dl>
                    <ul class="info_list">
                        <li><a href="#">资料名称资料名称料名称资料名称料名称资料名称资料名称资料名称</a></li>
                        <li><a href="#">资料名称资料名称料名称资料名称料名称资料名称资料名称资料名称</a></li>
                        <li><a href="#">资料名称资料名称料名称资料名称料名称资料名称资料名称资料名称</a></li>
                        <li><a href="#">资料名称资料名称料名称资料名称料名称资料名称资料名称资料名称</a></li>
                    </ul>
                </div>
            </div>
        </div>
</div>
<!--主体内容结束-->
