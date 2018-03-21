$('u.close').click(function () {
    var self = $(this);
    self.parent().hide();
    self.parent().parent().hide();
});
$("#weChatIcon").click(function () {
    $("#weChatBigIcon").show();
    return false;
});
$(document).bind("mouseup", function (e) {
    var target = $(e.target);
    if (target.closest(".pop").length == 0)$(".pop").hide()
});