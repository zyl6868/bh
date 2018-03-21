
require.config({
    urlArgs: "v=" + (new Date()).getTime(),
    baseUrl: "/static/js",
    waitSeconds: 0,
    paths: {
        "domReady":"domReady",
        "jquery":"jquery",
        "jqueryUI":"jquery-ui",
        "jquery_sanhai":"lib/jquery.sanhai",
        "base":"module/base",
        "popBox":"module/popBox",
        "echarts":"lib/echarts",
        "sanhai_tools":"module/sanhai_tools",
        'userCard':"module/userCard",
        'validationEngine':'lib/jquery.validationEngine.min',
        'validationEngine_zh_CN':'lib/jquery.validationEngine_zh_CN',
        'jquery.fileupload':'lib/jqueryfileupload/jquery.fileupload',
        'sch_mag_teacher':'app/sch_mag/sch_mag_teacher'
    },
    shim:{
        "validationEngine":{
            deps:["jquery"],
            exports:"validationEngine"
        },
        "validationEngine_zh_CN":{
            deps:["jquery"],
            exports:"validationEngine_zh_CN"
        }

    }
});


require(['domReady','sch_mag_teacher','base'], function(domReady){
    domReady(function(){
        var requireModule=document.getElementById('requireModule').getAttribute('rel');
        require([requireModule]);
    })

});



