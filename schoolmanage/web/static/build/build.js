({
    appDir: '../',                  //相对build.js的当前路径的所属地址
    baseUrl: './js',                //定位到appDir后，找到js脚本相对页面地址的位置
    dir: '../../dist',             //生成的文件地址
    modules: [
        {
            name: 'app/classes/classes_answering_question',
            exclude: ['jquery'],
            exclude: ['jqueryUI']
        },
        {
            name: 'app/classes/classes_file',
            exclude: ['jquery'],
            exclude: ['jqueryUI']
        }
    ],
    fileExclusionRegExp: /^(r|build)$/,
    optimizeCss: 'standard', /* none|standard|standard.keepLines|standard.keepComments|standard.keepComments.keepLines */
    removeCombined: true,

    //路径配置,需要包含所有模块中用的资源，可以从common.js中取
    paths: {
        /*库依赖*/
        "jquery":"lib/jquery-1.7.1.min",
        "jqueryUI":"lib/jquery-ui.min",
        "jquery_sanhai":"lib/jquery.sanhai",
        "base":"module/base",
        "popBox":"module/popBox",
        "echarts":"lib/echarts",
        'userCard':"module/userCard",
        "sanhai_tools":"module/sanhai_tools",
        'classes_answering_question':'app/classes/classes_answering_question',
        'classes_file':'app/classes/classes_file'
        //text: "plugin/require.text",    //text!text_path/hello.tpl
        //css: "plugin/require.css",      //css!css_path/swiper.css
        //text_path: "templates",
        //css_path: "../css"
    }


    //map: {
    //    '*': {
    //        'text': 'plugin/require.text',
    //        'css': 'plugin/require.css'
    //    }
    //},

    //shim: {
    //
    //    jquery:{
    //        exports:'$'
    //    },
    //
    //    underscore: {
    //        exports: '_'
    //    },
    //    domReady: {
    //        exports: "domReady"
    //    },
    //
    //    template: {
    //        exports: "template"
    //    },
    //
    //    lazyload: ['jquery'],
    //
    //    bootstrap: ['jquery'],
    //
    //    swiper: {
    //        deps: ['jquery'],
    //            exports: "swiper"
    //    }
    //}
})