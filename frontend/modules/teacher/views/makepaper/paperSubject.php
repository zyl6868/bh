<?php
/**
 *
 * @var MakepaperController $this
 */
use frontend\components\helper\TreeHelper;
use common\models\dicmodels\DegreeModel;

/* @var $this yii\web\View */  $this->title="教师-组卷-筛选题目";
$backend_asset = BH_CDN_RES.'/pub';
;
$this->registerJsFile($backend_asset . '/js/ztree/jquery.ztree.all-3.5.min.js'.RESOURCES_VER);
$this->registerCssFile($backend_asset . '/js/ztree/zTreeStyle/zTreeStyle.css'.RESOURCES_VER);
?>
<div class="grid_24 main_r filterSubject">
    <div class="main_cont tezhagnhaioast_problem">
        <div class="title">
            <h4>题目筛选</h4>
        </div>

        <ul class="stepList clearfix">
            <li class="step_finish"><span>试卷标题</span><i></i></li>
            <li class="step_finish"><span>试卷结构</span><i></i></li>
            <li class="step_ac"><span>筛选题目</span><i></i></li>
            <li class="step_end"><span>设定分值</span><i></i></li>
        </ul>
        <br/>

        <div class="paperStructure clearfix">
            <h5>试卷中的题目(点击题目编号预览):</h5>
            <span class="moveBtn prevItem hide"></span>
            <span class="moveBtn nextItem hide"></span>
            <div class="paperItemListWrap">
            <ul class="paperItemList">
                <?php foreach ($queryType as $key => $item) { ?>
                    <li tab="Q_<?php echo $item->typeId ?>" class="<?php echo $key == 0 ? 'ac' : ''; ?>"
                        typeId="<?php echo $item->typeId ?>"><?php echo $item->typeName ?></li>
                <?php } ?>
            </ul>
                </div>
            <div class="paperItemConts">
                <?php foreach ($queryType as $key1 => $item1) {
                    ?>
                    <ul id="Q_<?php echo $item1->typeId ?>"
                        class="clearfix <?php echo $key1 == 0 ? '' : 'hide'; ?>">
                        <?php foreach ($item1->questions as $itemqu) { ?>
                            <li val="<?php echo $itemqu->id; ?>"><span><?php echo $itemqu->id; ?><?php echo $itemqu->name; ?></span><b>×</b></li>
                        <?php } ?>
                    </ul>
                <?php
                } ?>
                <div class="demoBar hide">
                    <span class="close">关闭预览</span>

                    <div id="showqe">
                    </div>
                </div>
            </div>

        </div>

        <div class="form_list type">
            <div class="row ">

                <div class="formR">
                    <ul class="resultList testClsList" id="queTypes">
                        <li class="ac"><a onclick="return getSearchList(this,'type')">全部题型</a></li>
                        <?php foreach ($queryType as $key => $item) { ?>
                            <li><a data-value="<?php echo $item->typeId ?>"
                                   onclick="return getSearchList(this,'type')"><?php echo $item->typeName ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="row">

                <div class="formR">
                    <ul class="resultList testClsList" id="degreeTypes">
                        <li class="ac"><a onclick="return getSearchList(this,'com')">全部难度</a></li>
                        <?php $degreeList = DegreeModel::model()->getListData();
                        foreach ($degreeList as $key => $item) { ?>
                            <li><a data-value="<?= $key ?>" onclick="return getSearchList(this,'com')"><?= $item ?></a>
                            </li>
                            <?php ?>
                        <?php } ?>

                    </ul>
                </div>
            </div>
        </div>


        <div class="problem_box clearfix">
            <div class="grid_5 alpha knowledge" style=" width: 230px">
                <div class="problem_tree_cont">
                    <h4>基本知识</h4>
                    <a href="javascript:" onclick="$('#problem_tree .ac').removeClass();return getSearchList(this,'');" class="resetting">重置知识点</a>

	                <div id="problem_tree"  class="problemTreeWrap">
                        <?php echo TreeHelper::streefun($knowTRee, ['onclick' => "return getSearchList(this,'kid');"], 'tree pointTree'); ?>
                    </div>
                </div>
            </div>
	        <div class="problem_r grid_18 omega alpha" >

	            <div class="tab fl">
		            <ul class="tabList clearfix">
			            <li class="select_n"><a href="javascript:;" n="0" class="ac">平台题库</a></li>
			            <li class="select_n"><a href="javascript:;" n="1">我的题库</a></li>
			            <li class="select_n"><a href="javascript:;" n="2">我收藏的题目</a></li>
		            </ul>
		            <div class="grid_18 alpha omega knowledgeR tabCont">
			            <div class="tabItem">
			                <div class="schResult">

			                    <div id="uploadId">
			                        <?php echo $this->render("_pageSubjectView", array('list' => $list, 'pages' => $pages)); ?>
			                    </div>
			                </div>
			            </div>
		            </div>
	            </div>
			</div>
        </div>

        <div class="tc submitBtnBar">
            <button type="button" onclick="history.go(-1);" class="btn40 bg_blue w120 preStepBtn">上一步</button>
            <button type="button" class="bg_blue btn40 w120 nextStepBtn">下一步</button>
        </div>
    </div>
</div>

<script>
	$(function(){
		// 0 平台题库  1我的题库 2收藏的题库
		$('.select_n').click(function(){
			var n = $(this).find('.ac').attr('n');
            var type = $('#queTypes .ac a').data("value");
            var com = $('#degreeTypes .ac a').data("value");
            var kid = $('#problem_tree .ac').data("value");
			$.get("<?php echo url('teacher/makepaper/paper-subject',['paperId'=>app()->request->getParam('paperId')])?>",{n:n,type:type,kid:kid,complexity:com},function(data){
				$("#uploadId").html(data);
			})
		})
	});
    var getSearchList = function (obj, t) {
        var type = $('#queTypes .ac a').data("value");
        var com = $('#degreeTypes .ac a').data("value");
        var kid = $('#problem_tree .ac').data("value");
        var n=$(".tabList").find(".ac").attr("n");
        $value = $(obj).data('value');
        switch (t) {
            case  "type":
                type = $value;
                break;
            case  "com":
                com = $value;
                break;
            case  "kid":
                kid = $value
        }

        $.get("<?php  echo app()->request->url?>", {type: type, complexity: com, kid: kid,n:n}, function (data) {
            $("#uploadId").html(data);
        });
        return false;
    };


    $('.nextStepBtn').click(function () {
        if ($("li[val]").size() == 0) {
            popBox.errorBox('请组题');
            return false;
        }

        $qus = [];
        $('.paperItemList li[tab]').each(function (index) {
            pid = $(this).attr('tab');
            tabid = $(this).attr('typeId');
            value = [];
            $("#" + pid + " li[val]").each(function () {
                value.push($(this).attr('val'));
            });
            $qus.push({"name": 'items[' + tabid + ']', "value": value.join(',')});
        });

        $.post('<?php echo \yii\helpers\Url::to(['save-paper-subject','paperId'=>app()->request->getParam('paperId')]) ?>', $.param($qus), function (result) {
            if (result.success) {
                window.location.href = "<?php  echo \yii\helpers\Url::to(["paper-set-score",'paperId'=>app()->request->getParam('paperId')])  ?>";
            } else {
                popBox.errorBox('保存失败');
            }

        });
    });

    $(function () {
//已选题目 选项卡
        $('.paperItemList li').click(function () {
            var index = $(this).index();
            $(this).addClass('ac').siblings().removeClass('ac');
            $('.paperItemConts ul').eq(index).show().siblings().hide();
            $('.paperItemConts li').removeClass('ac');
        });
        $('.openAnswerBtn').toggle(function () {

            $(this).parents('.btnArea').siblings('.answerArea').show();
        }, function () {

            $(this).parents('.btnArea').siblings('.answerArea').hide();

        });

//组卷按钮
        $('.paper .addBtn').live('click', function () {
            var id = $(this).attr('id');
            var pid = $(this).attr('pid');
            var index = $('#' + pid).index();
            var tab = "";
            $('.paperItemList li').each(function () {//判断是否有此题型
                if ($(this).attr('tab') == pid) tab = true;
            });
            if (tab == true) {
                $(this).removeClass('addBtn').addClass('del_btn').text('删除');
                $('.paperItemList li').eq(index).addClass('ac').siblings().removeClass('ac');
                $('#' + pid).show().siblings().hide();
                $('#'+pid).append('<li val="' + id + '"><span>'+id+'</span><b>×</b></li>');
            } else {
                popBox.errorBox('本试卷没有该题型!!')
            }
        });

        $('.paper .del_btn').live('click', function () {
            var id = $(this).attr('id');
            $(this).removeClass('del_btn').addClass('addBtn').text('组卷');
            var pid = $(this).attr('pid');
            var index = $('#' + pid).index();
            $('.paperItemList li').eq(index).addClass('ac').siblings().removeClass('ac');
            $('#' + pid).show().siblings().hide();
            $('#' + pid + ' li').each(function (index, element) {
                //if ($(this).text() == id) $(this).remove();
                if($(this).children('span').text()==id) $(this).remove();
            });
        });
        //删除选定的题
        $('.paperItemConts ul li b').live('click',function(){
            var pa=$(this).parents('.paperItemConts');
            $(this).parent().remove();
            var id=$(this).prev().text();
            pa.find('.demoBar').hide();
            $('#'+id).removeClass('del_btn').addClass('addBtn').text('组卷');
            return false;
        });

//点击题目id,显示题型
        $('.paperItemConts li').live('click', function () {
            $.get('<?php echo \yii\helpers\Url::to(['view-pager-by-id']) ?>', {qid: $(this).attr('val')}, function (html) {
                $('#showqe').html(html);
                $('.paperItemConts .demoBar').show();
            });


        });
        $('.demoBar .close').click(function () {
            $(this).parent().hide();
        });

//知识点 fixed
//试卷中的题目 fixed

        $('.tree').tree({expandAll:true,operate:false});
        $('.paperStructure').itemFixed({fixTop:51,fixWidth:1080,scroll_top:51,fix_zIndex:100});

        (function(){
            var li_size=$('.paperItemList li').size();
            if(li_size>8){
                $('.paperStructure .nextItem').show();
            }
            var itemWidth=$('.paperItemList li').width();
            var num=0;
            $('.paperItemList').width(li_size*itemWidth);
            $('.paperStructure .nextItem').click(function(){
                if(num<li_size-8){
                    num++;
                    $('.paperItemList').animate({left:-(num*itemWidth)});
                    $('.paperItemList li:eq('+num+')').trigger('click');
                    $('.paperStructure .prevItem').show();
                }
                else{
                    $(this).hide();
                    popBox.errorBox("没有了！！")
                }
            });
            $('.paperStructure .prevItem').click(function(){
                if(num>0){
                    num--;
                    $('.paperItemList').animate({left:-(num*itemWidth)});
                    $('.paperItemList li:eq('+num+')').trigger('click');
                    $('.paperStructure .nextItem').show();
                }
                else{
                    $(this).hide();
                    popBox.errorBox("已是第1个！！")
                }

            });

            $('.paperItemConts li').live('click',function(){
                $(this).addClass('ac').siblings().removeClass('ac');
            })


        })()

    })

</script>

