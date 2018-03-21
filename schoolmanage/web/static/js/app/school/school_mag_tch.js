define(["popBox", 'jquery_sanhai', 'jqueryUI'], function(popBox) {
    $('#mainSearch').placeholder({
        value: "请输入关键字……",
        left: 15,
        top: 4
    })

    //初始化弹框
    $('.popBox').dialog({
        autoOpen: false,
        width: 840,
        modal: true,
        resizable: false,
        close: function() {
            $(this).dialog("close")
        }
    });

    $(".addmemor_btn").click(function() {
        $("#confirmBox").dialog("open");

    });
    //其他操作
    $('.other_operation').sUI_select();




})
