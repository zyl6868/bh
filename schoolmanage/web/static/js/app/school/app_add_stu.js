
require.config({
      //urlArgs: "v=" + (new Date()).getTime(),
    baseUrl: "/static/js",
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
        'school_add_stu':'app/school/school_add_stu',
        'sch_mag_teacher':'app/sch_mag/sch_mag_teacher'
    },
    waitSeconds: 0,
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
require(['popBox','jquery','domReady','base','school_add_stu','jqueryUI'],function(popBox,$){
    //初始化弹框
    $('.popBox').dialog({
        autoOpen: false,
        width: 640,
        modal: true,
        resizable: false,
        close: function() {
            $(this).dialog("close")
        }
    });

});

