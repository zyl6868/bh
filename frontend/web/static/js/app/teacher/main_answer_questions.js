require.config({
    baseUrl: '/static/js',
    paths: {
        'jquery': 'jquery',
        'jqueryUI':"jquery-ui",
        'base':"module/base",
        'answer_questions':'app/teacher/answer_questions',
        'jquery_sanhai':"lib/jquery.sanhai",
        "echarts":"lib/echarts",
    }
});
require(['jquery', 'jqueryUI', 'base', 'answer_questions', 'jquery_sanhai', "echarts"]);

