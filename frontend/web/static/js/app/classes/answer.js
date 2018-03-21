define(['sanhai_tools'], function (sanhai_tools) {
    var answerLeft = 240;
    var answerDOM = $('#answer');
    answerDOM.css({
        top: $(document).scrollTop() + 180 + 'px',
        left: ($('body').width() - answerDOM.width()) / 2 + answerLeft + 'px'
    });
    $(window).resize(function(){
        answerDOM.css({
            top: $(document).scrollTop() + 180 + 'px',
            left: ($('body').width() - answerDOM.width()) / 2 + answerLeft + 'px'
        });
    });
    $(window).scroll(function(){
        answerDOM.css({
            top: $(document).scrollTop() + 180 + 'px',
            left: ($('body').width() - answerDOM.width()) / 2 + answerLeft + 'px'
        });
    });
});