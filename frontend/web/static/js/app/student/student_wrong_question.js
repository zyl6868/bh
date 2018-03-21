define(['jquery', "popBox", 'userCard', 'jquery_sanhai', 'echarts/echarts', 'validationEngine', 'validationEngine_zh_CN', 'jqueryUI', 'echarts/chart/pie'],

    function ($, popBox, userCard, jquery_sanhai, ec, validationEngine, validationEngine_zh_CN) {

        $(document).on('click', '#MyError button.icoBtn_open', function () {
            var $this = $(this);
            $this.toggleClass('icoBtn_close');
            $this.parent().next().fadeToggle(0);
            $this.html() == '查看答案解析 <i></i>' ? $this.html('收起答案解析 <i></i>') : $this.html('查看答案解析 <i></i>');
        });

    })
