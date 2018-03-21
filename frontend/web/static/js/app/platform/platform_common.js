/**
 * Created by Administrator on 2016/3/29.
 */
define(function(){
    //查看解析答案按钮
    function answerShowAndHide(){

        //查看解析答案按钮
        $('.show_aswerBtn').click(function(){
            var _this=$(this);
            var pa=_this.parents('.quest');
            pa.toggleClass('A_cont_show');
            _this.toggleClass('icoBtn_close');
            if(pa.hasClass('A_cont_show')){_this.html('收起答案解析 <i></i>');}
            else{_this.html('查看答案解析 <i></i>');}
        })
    }
    return {
        answerShowAndHide:answerShowAndHide
    }
}
);