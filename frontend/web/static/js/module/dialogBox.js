/**
 * Created by zyl on 17-5-11.
 */
define(function(){

    /**
     * 弹窗
     * @param options.title 标题名字
     * @param options.content 内容
     * @param options.TrueBtn.name 确定按钮名字
     * @param options.TrueBtn.fn 确定按钮回调
     * @param options.FalseBtn.name 取消按钮名字
     * @param options.FalseBtn.fn 取消按钮回调
     */
    $(document).on('mouseover', '#TrueBtn',function () {
        $(this).css({'background': '#10ade5', 'color': '#fff'})
    })
    $(document).on('mouseout', '#TrueBtn',function () {
        $(this).css({'background': '#fff', 'color': '#10ade5'})
    })
    $(document).on('mouseover', '#FalseBtn',function () {
        $(this).css({'background': '#999', 'color': '#fff'})
    })
    $(document).on('mouseout', '#FalseBtn',function () {
        $(this).css({'background': '#fff', 'color': '#999'})
    })
    $(document).on('mouseover', '#dialogClose',function () {
        $(this).css({'background': '#0f9dd0'})
    })
    $(document).on('mouseout', '#dialogClose',function () {
        $(this).css({'background': '#10ade5'})
    })

    var _style = '<style>#TrueBtn {background: #10ade5;color: white;}</style>'
    function dialogBox(options) {

        var btnBox = '';

        if(options.TrueBtn) {
            btnBox = '<div id="btnBox" style="border-top: 1px solid #eee;text-align: center;padding: 5px 0;"><a href="javascript:;" id="TrueBtn" style="display:inline-block;text-align:center;margin: 5px;border: 1px solid #10ade5;border-radius: 3px;background: #fff;color: #10ade5;width: 100px;line-height: 25px;">' + options.TrueBtn.name + '</a>';
        }

        if (options.FalseBtn) {
            btnBox += '<a href="javascript:;" id="FalseBtn" style="display:inline-block;text-align:center;margin: 5px;border: 1px solid #999;border-radius: 3px;background: #fff;color: #000;width: 100px;line-height: 25px;">' + options.FalseBtn.name + '</a>'
        }

        var rmHtml = '';

        if(!options.noRemove) {
            rmHtml = '<a href="javascript:;" style="width: 40px;height: 40px;display: inline-block;float: right" id="dialogClose"><span style="background: url(/static/images/remove.png);width: 12px;height: 12px;margin: 14px;float: left;"></span></a>'
        }

        btnBox += '</div>'

        var popHtml = '<div id="mask" style="position: fixed;top: 0;left: 0;height: 100%;width: 100%;z-index: 999">' +
            '<div style="position: absolute;top: 0;left: 0;background: #666;opacity: .5;filter: Alpha(Opacity=50);height: 100%;width: 100%;z-index: -1"></div>' +
            '<div id="dialogBox" style="width: 420px;margin: 300px auto 0;background:white;opacity: 1;filter: Alpha(Opacity=100);">' +
            '<div id="boxHead" style="line-height: 40px;background: #10ade5;text-indent: 20px;font-size: 1.1em;color: white;">' + options.title +
            rmHtml +
            '</div>' +
            '<div id="boxContent" style="padding: 15px 25px;">' + options.content + '</div>' +
            btnBox +
            '</div>' +
            '</div>';
        $("body").append(popHtml);
        $('#TrueBtn').click(options.TrueBtn ? options.TrueBtn.fn : '');
        $('#FalseBtn').click(options.FalseBtn ? options.FalseBtn.fn : '');
        $('#btnBox a, #dialogClose').click(function () {
            $('#mask').remove();
        })
    }

    return dialogBox;
});