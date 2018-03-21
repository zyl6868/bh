<div class="footWrap">
    <div class="foot">
        <dl>
            <dt>关于我们</dt>
            <dd><a href="#">关于班海</a></dd>
            <dd><a href="#">招聘启事</a></dd>
            <dd><a href="#">法律声明</a></dd>
            <dd><a href="#">网站地图</a></dd>
        </dl>
        <dl>
            <dt>商务合作</dt>
            <dd><a href="#">商务合作</a></dd>
            <dd><a href="#">友情链接</a></dd>
            <dd><a href="#">资源合作</a></dd>
            <dd><a href="#">视频合作</a></dd>
        </dl>
        <dl>
            <dt>联系我们</dt>
            <dd><a href="#">在线客服</a></dd>
            <dd><a href="#">官方微博</a></dd>
            <dd><a href="#">意见反馈</a></dd>
            <dd><a href="#">关注微信</a></dd>
        </dl>
        <dl>
            <dt>问题帮助</dt>
            <dd><a href="#">常见问题</a></dd>
            <dd><a href="#">用户答疑</a></dd>
        </dl>
        <p>@ 2014 班海 http://www.banhai.com 北京三海教育科技有限公司 版权所有<br>
            京ICP证080367号 京ICP备08103829号 北京市公安局海淀分局备案号1101081714 </p>
    </div>
</div>

<script src="<?php echo publicResources() ?>/js/jquery.cookie.js"></script>
<script src="<?php echo publicResources() ?>/js/strophe.min.js"></script>
<script type="text/javascript">




    var connt = null;
    var startTime = null;

    function onMessage(msg) {
        to = msg.getAttribute('from');
        var from = msg.getAttribute('from');
        var type = msg.getAttribute('type');
        var elems = msg.getElementsByTagName('body');

        if (type == "chat" && elems.length > 0) {
            var body = elems[0];
            $('.notenum').text(parseInt($('.notenum').text()) + 1);
        }

        // we must return true to keep the handler alive.
        // returning false would remove it after it finishes.
        return true;
    }


    $.ajax({
        url:"<?php echo  url('xmpp/xmpp-bind' )?>?jsoncallback=?",
        dataType:'jsonp',
        crossDomain:true,
        jsonp:'jsoncallback',
        success:function(data) {
                if (data.success) {
                    try {
                        var cookieJid = $.cookie("jid");
                        var cookieSid = $.cookie("sid");
                        var cookieRid = $.cookie("rid");
                        connt = new Strophe.Connection("/http-bind");
                        connt.attach(cookieJid, cookieSid, parseInt(cookieRid), function (status) {

                            if (status == Strophe.Status.DISCONNECTED)
                            {

                            }

                            if (status === Strophe.Status.CONNECTED || status === Strophe.Status.ATTACHED) {
                                connt.send($pres());
                            }
                        });
                        connt.addHandler(onMessage, null, 'message', null, null, null);

                    } catch
                        (e) {

                    }
                }
        },
        timeout:3000
    });


</script>
<script src="<?php echo publicResources() ?>/js/jquery.blockUI.js"  type="text/javascript"></script>
<script type="text/javascript">
    $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
</script>





