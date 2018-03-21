<?php
/**
 *
 * @var MakepaperController $this
 */
use yii\web\View;

/* @var $this yii\web\View */  $this->title="试卷结构";
$backend_asset = BH_CDN_RES.'/pub';
;
$this->registerJsFile($backend_asset . '/js/json2.js' . RESOURCES_VER);
$this->registerCssFile($backend_asset . '/js/ztree/zTreeStyle/zTreeStyle.css'.RESOURCES_VER);
$this->registerJsFile($backend_asset . '/js/ztree/jquery.ztree.all-3.5.min.js'.RESOURCES_VER, ['position'=>View::POS_END]);

/**  @var MakePaperForm $model */

?>
<div class="grid_19 main_r">
    <div class="main_cont  make_testpaper">

        <div class=" title">
            <h4>试卷结构</h4>
        </div>
        <ul class="stepList clearfix">
            <li class="step_finish step_ac_before"><span>试卷标题</span><i></i></li>
            <li class="step_ac"><span>试卷结构</span><i></i></li>
            <li><span>筛选题目</span><i></i></li>
            <li class="step_end"><span>设定分值</span><i></i></li>
        </ul>


        <div class="form_list">

            <div class="makePaper">
                <div class="testpaperSetup clearBoth">
                    <h6>卷头</h6>
                    <hr>
                    <ul id="testPaperHeadTree" class="clearfix ztree">
                    </ul>
                    <h6>卷体</h6>
                    <hr>
                    <ul id="testPaperBodyTree" class="clearfix ztree">
                    </ul>
                </div>
                <div class="testPaperDemo clearfix">
                    <div class="testPaperHead">

                    </div>
                    <div id="0" class="testPaperBody"></div>
                </div>
                <hr>
            </div>


            <div class="tc bottomBtnBar">
                <button type="button" id="nextstep" class="bg_blue btn40 w120">下一步</button>
            </div>
        </div>
    </div>
</div>
<!--知识树-->
<script>
    $("#nextstep").click(
        function () {
            formarray = [];
            pageMain = JSON.stringify(testPaperCont);
            formarray.push({name: 'pageMain', value: pageMain});
            $.post($('#makePaper').attr('action'), $.param(formarray), function (result) {
                if (result.success) {
                    window.location.href = "<?php  echo url("/teacher/makepaper/paper-subject")  ?>?paperId=" + result.data;

                } else {
                    popBox.errorBox('保存失败');
                }

            });
        }
    );
</script>
<!--试卷结构-->
<script type="text/javascript">
    var testPaperCont =<?php echo json_encode($this->context->toZtreeData($treejson)); ?>;

    var num = ["一", "二", "三", "四", "五", "六", "七", "八", "九", "十", "十一", "十二", "十三", "十四", "十五", "十六", "十七", "十八", "十九", "二十", "二十一", "二十二", "二十三", "二十四", "二十五", "二十六", "二十七", "二十八", "二十九", "三十"];
    var setting2 = {
        check: {
            enable: true,
            chkboxType: {"Y": "", "N": ""}
        },
        data: {
            simpleData: {
                enable: true
            }
        },
        callback: {
            onCheck: testPaperSetupCheck
        },
        view: {
            showIcon: false,
            showLine: false
        }
    };

    //排序方法
    function sequence() {
        var sp_num = $('.testPaperBody .subPart:visible').size();
        $('.subPart:visible').each(function (sp_num) {
            $(this).children('h6').children('i').text(num[sp_num] + '.')
        });
    }

    function editZnodes(id, obj, val) {
        var zHead = testPaperCont.paperHead;
        var zBody = testPaperCont.paperBody;
        for (var i = 0; i < zHead.length; i++) {
            if (zHead[i].id == id) zHead[i][obj] = val;
        }
        for (var i = 0; i < zBody.length; i++) {
            if (zBody[i].id == id) zBody[i][obj] = val;
        }
    }

    //树的check行为
    function testPaperSetupCheck(event, treeId, treeNode) {
        if (treeNode.checked == false) {
            $('#' + treeNode.id).hide();
            editZnodes(treeNode.id, "checked", false);
            sequence();
        }
        else {
            $('#' + treeNode.id).show();
            editZnodes(treeNode.id, "checked", true);
            sequence()
        }
    }


    function fixTxt(txt) {
        var new1 = txt.replace(/\s/g, "")//清除所有空格
        var new2 = new1.replace(/<br>/g, "\n")//用回车替换<br>
        return new2
    };;
    function addBr(txt) {
        var new1 = txt.replace(/\n|\r/g, "<br>");
        return new1
    }


    $(function () {

//试卷结构树
        $.fn.zTree.init($("#testPaperHeadTree"), setting2, testPaperCont.paperHead);
        $.fn.zTree.init($("#testPaperBodyTree"), setting2, testPaperCont.paperBody);


//试卷头部
        var headIndex = testPaperCont.paperHead.length;
        $('.testPaperBody').attr("id", "testPaperHead");
        for (var i = 0; i < headIndex; i++) {
            var id = testPaperCont.paperHead[i].id;
            if (id == "line") {//插入装订线
                $('#testPaperHead').append('<div id="line"  class="paper_bindLine"><span class="hide">装订线</span></div>');
            }
            if (id == "secret_sign" || id == "main_title" || id == "sub_title" || id == "info" || id == "student_input") {
                var headPart = '<div id="' + testPaperCont.paperHead[i].id + '" class="setup"><div class="setupBar hide"><span class="setupBtn">编辑</span></div><p>' + testPaperCont.paperHead[i].name + '</p><div class="editBar  hide"><input type="text" class="text txt"><input class="btn okBtn" type="button" value="确定"><input class="btn cancelBtn" type="button" value="取消"></div></div>';
                if (testPaperCont.paperHead[i].pId == "testPaperHead") {
                    $('#testPaperHead').append(headPart)
                }
            }
            if (id == "pay_attention") {//插入表格和注意事项
                $('#testPaperHead').append('<div class="part7"><table class="topTotalTable"><thead><tr><th>题号</th><th>一</th><th>二</th><th>三</th><th>四</th><th>五</th><th>六</th><th>七</th><th>八</th><th>九</th><th>总分</th></tr><tr><td>得分</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></thead></table></div><div id="pay_attention" class="setup"><div class="setupBar hide"><span class="setupBtn">编辑</span></div><h6>' + testPaperCont.paperHead[i].name + ':</h6><p>' + testPaperCont.paperHead[i].text + '</p><div class="editBar hide "><textarea class="txt"></textarea><br><input class="btn okBtn" type="button" value="确定"><input class="btn cancelBtn" type="button" value="取消"></div>');
            }

            if (testPaperCont.paperHead[i].checked != true) {
                $('#testPaperHead').children('#' + testPaperCont.paperHead[i].id).hide();
            }
        }


//试卷插入项目
        var subject = testPaperCont.paperBody.length;
        $('.testPaperBody').attr("id", "testPaperBody");
        for (var i = 0; i < subject; i++) {
            var paperPart = '<div id="' + testPaperCont.paperBody[i].id + '" class="paperPart"><div class="testPaperTitle setup"><p>' + testPaperCont.paperBody[i].name + '</p><div class="editBar  hide"><input type="text" class="text txt"> <input class="btn okBtn" type="button" value="确定"> <input class="btn cancelBtn" type="button" value="取消"></div><span class="setupBar hide"><span class="setupBtn">编辑</span></span></div><div class="testPaperCom setup"><h6>说明:</h6><p>' + testPaperCont.paperBody[i].text + '</p><div class="editBar  hide"><input type="text" class="text txt"> <input class="btn okBtn" type="button" value="确定"> <input class="btn cancelBtn" type="button" value="取消"></div><span class="setupBar hide"><span class="setupBtn">编辑"注释"</span></span></div><div class="editBar  hide"><input type="text" class="text txt"> <input class="btn okBtn" type="button" value="确定"> <input class="btn cancelBtn" type="button" value="取消"></div><span class="setupBar hide"><span class="setupBtn">编辑"注释"</span></span></div>';
            var subPart = '<div id="' + testPaperCont.paperBody[i].id + '" class="subPart setup"><table><thead><tr><th>评卷人</th><th>得分</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr></thead></table><h6><i>一.</i><em>' + testPaperCont.paperBody[i].name + '</em></h6><p>(' + testPaperCont.paperBody[i].text + ')</p><div class="editBar  hide"><input type="text" class="text txt"> <input class="btn okBtn" type="button" value="确定"> <input class="btn cancelBtn" type="button" value="取消"></div><span class="setupBar hide"><span class="setupBtn">编辑"注释"</span><span class="upBtn">上移</span><span class="downBtn">下移</span></span></div>';

            if (testPaperCont.paperBody[i].pId == "testPaperBody") {
                $('#testPaperBody').append(paperPart)
            }
            if (testPaperCont.paperBody[i].pId == "win_paper_typeone") {
                $('#win_paper_typeone').append(subPart)
            }
            if (testPaperCont.paperBody[i].pId == "win_paper_typetwo") {
                $('#win_paper_typetwo').append(subPart)
            }
            if (testPaperCont.paperBody[i].checked != true) {
                $('#testPaperBody').children('#' + testPaperCont.paperBody[i].id).hide();
            }
        }

//插入dom后排序,必须放在这里!!!!!
        sequence();


//下移
        $('.setup .downBtn').live('click', function () {
            var arr = testPaperCont.paperBody;
            var next = $(this).parents('.subPart').next('.subPart');
            $(next).after($(this).parents('.subPart'));
            sequence()


        });
//上移
        $('.setup .upBtn').live('click', function () {
            var arr = testPaperCont.paperBody;
            var prev = $(this).parents('.subPart').prev('.subPart');
            $(prev).before($(this).parents('.subPart'));
            sequence()

        });


//显示编辑按钮
        $('.testPaperDemo .setup').hover(
            function () {
                $(this).addClass('hover');
                if ($(this).attr("edit") != "on") {
                    $(this).children('.setupBar').show();
                }
            },
            function () {
                $(this).removeClass('hover').children('.setupBar').hide();
            }
        );

        $('.setupBtn').click(function () {
            $(this).parent('.setupBar').hide();
            $(this).parents('.setup').attr("edit", "on");
            var oldText = $(this).parent().siblings('p').html();
            $(this).parent().siblings('.editBar').show().children('.txt').val(fixTxt(oldText));
            $(this).parent().siblings('p').hide();
        });


//编辑
        $('.testPaperDemo .setup').find('.okBtn').click(function () {
            var _this = $(this).parents('.setup');
            var oldText = $(_this).children('p').text();
            var newText = $(_this).find('.txt').val();
            if (newText == "") {
                newText = oldText
            }
            $(_this).children('p').html(addBr(newText)).show();
            $(_this).children('.editBar').hide();
            $(_this).attr("edit", "no");
            $(_this).children('.setupBar').show();

            //修改"树"数据
            var id = $(_this).attr("id");
            editZnodes(id, "text", newText);
        });

        $('.testPaperDemo .testPaperTitle').find('.okBtn').click(function () {
            var _this = $(this).parents('.testPaperTitle');
            var id = $(this).parents('.paperPart').attr("id");
            var oldText = $(_this).children('p').text();
            var newText = $(_this).find('.txt').val();

            if (newText == "") {
                newText = oldText
            }
            for (var i = 0; i < headIndex; i++) {
                if (testPaperCont.paperHead[i].id == id) {
                    testPaperCont.paperHead[i].name = newText;
                }
                if (testPaperCont.paperBody[i].id == id) {
                    testPaperCont.paperBody[i].name = newText;
                }
            }
        });

        $('.testPaperDemo .testPaperCom').find('.okBtn').click(function () {
            var _this = $(this).parents('.testPaperCom');
            var id = $(this).parents('.paperPart').attr("id");
            var oldText = $(_this).children('p').text();
            var newText = $(_this).find('.txt').val();

            if (newText == "") {
                newText = oldText
            }
            for (var i = 0; i < headIndex; i++) {
                if (testPaperCont.paperHead[i].id == id) {
                    testPaperCont.paperHead[i].text = newText;
                }
                if (testPaperCont.paperBody[i].id == id) {
                    testPaperCont.paperBody[i].text = newText;
                }

            }

        });

        $('.testPaperDemo .setup').find('.cancelBtn').click(function () {
            var _this = $(this).parents('.setup');
            var oldText = $(_this).children('p').html();
            $(_this).children('p').html(oldText).show();
            $(_this).children('.editBar').hide();
            $(_this).attr("edit", "no");
            $(_this).children('.setupBar').show();
        })


    })


</script>

