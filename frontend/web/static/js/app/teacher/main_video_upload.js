
define(['base','jqueryUI','sanhai_tools','popBox','jquery_sanhai'],function(base,jqueryUI,sanhai_tools,popBox,jquery_sanhai){
    function _init() {
        bskt_conf_hmwk_Box();
    }
    _init();
    function bskt_conf_hmwk_Box() {
        $("#pointTree").tree();
        //初始化弹框
        $('.popBox').dialog({
            autoOpen: true,
            width: 840,
            modal: true,
            resizable: false,
            close: function () {
                $(this).hide()
            }
        });
        //向右侧添加节点
        $('#add_custom_btn').click(function () {
            var sel_item = $('.pointTree .ac');
            if (sel_item.size() > 0) {
                var txt = sel_item.text();
                var id = sel_item.attr('data-value');
                if ($('#custom_sel_list #' + id).size() != 1) {
                    $('#custom_sel_list').append('<li id="' + id + '">' + txt + '</li>');
                }
                else {
                    popBox.errorBox('该章节已添加!');
                }
            } else {
                popBox.errorBox("请选择章节");
            }
        });
        //选择右侧"已选"项
        $('.cha_r').on('click', '#custom_sel_list li', function () {
            $(this).addClass('ac').siblings().removeClass('ac');
        });
        $('#del_custom_btn').click(function () {
            if ($('#custom_sel_list .ac').size() > 0) {
                var id = $('#custom_sel_list .ac').attr('id');
                $('#' + id).remove();
            }
            else {
                popBox.errorBox('请选择要删除项目!')
            }
        })
    }
    //单选条目
    $('.resultList').delegate('li','click',function(){
        $(this).addClass('ac').siblings().removeClass('ac');
    });

    $('#delBtnP').delegate('p .delBtn','click',function(){
        var self = $(this);
        self.parent().remove();
    });
    $(".inprad").delegate("input:radio","click",function(){
        var target=$(this).next('label');
        var name=$(this).attr('name');
        target.addClass('radioLabel_ac');
        if($(this).attr('disabled')!=true){
            $('input:radio[name='+name+']').not(this).each(function(index, element) {
                $(this).next('label').removeClass('radioLabel_ac');
            });
        }
    })
    //目录树
    $('.pointTree').tree();
});

