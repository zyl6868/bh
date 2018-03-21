require.config({
    urlArgs: "bust=" + (new Date()).getTime(),
    baseUrl: "/static/js",
    paths: {
        "domReady":"domReady",
        "jquery":"jquery",
        "jqueryUI":"lib/jquery-ui.min",
        "jquery_sanhai":"lib/jquery.sanhai",
        "base":"module/base",
        "popBox":"module/popBox",
        "sanhai_tools":"module/sanhai_tools",
        'userCard':"module/userCard",
        'validationEngine':'lib/jquery.validationEngine.min',
        'validationEngine_zh_CN':'lib/jquery.validationEngine_zh_CN',
        "echarts":"lib/echarts",
       // 'pubjs':'module/pubjs',
        'register':'module/register',
        'uplodeImg_check_btn':'module/uplodeImg_check_btn',
        'jquery_ui_widget':'lib/jquery.ui.widget',
        'jquery.fileupload':'lib/jqueryfileupload/jquery.fileupload',
        'fancybox':'lib/fancyBox/jquery.fancybox',
        'jqueryztree':'lib/ztree/jquery.ztree.all-3.5.min'
        //'lazyload':'lib/lazyload/jquery.lazyload.min'
        //'jquery.iframe-transport':'lib/jqueryfileupload/jquery.iframe-transport',
        //'jquery.fileupload-process':'lib/jqueryfileupload/jquery.fileupload-process'
    },
    shim:{
        "validationEngine":{
            deps:["jquery"],
            exports:"validationEngine"
        },

        //"jquery.fancybox":{
        //    deps:["jquery"],
        //    exports:"jquery.fancybox"
        //},

        "validationEngine_zh_CN":{
            deps:["jquery"],
            exports:"validationEngine_zh_CN"
        },
		
		 "jQuery_cycle":["jquery"]
		 
        //"jquery.fileupload":{
        //    deps:["jquery"],
        //    exports:"jquery.fileupload"
        //}


    }
});

require(['domReady','base'], function(domReady){
    domReady(function(){

        var requireModule=document.getElementById('requireModule').getAttribute('rel');
        require([requireModule]);
    })

});