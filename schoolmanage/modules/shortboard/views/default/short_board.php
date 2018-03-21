<div class="knowledge">
    <?php if(empty($monthShortBoard)){
        echo \frontend\components\helper\ViewHelper::emptyView('暂无数据');
    }?>

</div>

<script>
    var data = <?php echo json_encode($monthShortBoard);?>;

    var ary = data;
    if(ary.length != 0){
        var str = "",MaxAry = parseInt(ary[0].num);
        for (var i = 0; i < ary.length; i++) {
            var cur=parseInt(ary[i].num),item=ary[i].name;
            cur > MaxAry ? MaxAry = cur  : null;
            var num = Number((cur / MaxAry) * 100).toFixed(0);
            str += "<div class='knowledgeBar'><span class='knowledgeNum' title="+item+" kid="+ary[i].kid+">"+ item + "</span><div class='knowledgeError'><span class='width' style=width:" + (num) + '%' + "><em class='errorNum'>错误次数：" + cur + " 次</em></span></div></div>";
        }
        $(".knowledge").html(str);

        $('.knowledge').each(function(){
            $(this).find(".knowledgeError:last").css({"border-bottom":"2px solid #008acd"});

        });
    }

</script>
