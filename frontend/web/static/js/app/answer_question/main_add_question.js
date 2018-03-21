require.config({
    baseUrl: '/static/js',
    paths: {
        'jquery': 'jquery',
        'jqueryUI':"jquery-ui",
        'add_question':'app/answer_question/add_question',
        'base':"module/base",
        'validationEngine':'lib/jquery.validationEngine.min',
        'validationEngine_zh_CN':'lib/jquery.validationEngine_zh_CN',
        'jquery.fileupload':'lib/jqueryfileupload/jquery.fileupload',
        "jquery_sanhai":"lib/jquery.sanhai",
        "sanhai_tools":"module/sanhai_tools",
        "popBox":"module/popBox",
        "ZeroClipboard": "lib/ueditor/third-party/zeroclipboard/ZeroClipboard"//主要是加这句话
    }
});
require(['jquery','jqueryUI','base','add_question', 'jquery.fileupload',"jquery_sanhai", "popBox"]);

