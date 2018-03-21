<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace schoolmanage\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        "css/bootstrap.min.css",
        "css/font-awesome.min.css",
        "css/ionicons.min.css",
        "css/morris/morris.css",
        "css/jvectormap/jquery-jvectormap-1.2.2.css",
        "css/fullcalendar/fullcalendar.css",
        "css/daterangepicker/daterangepicker-bs3.css",
        "css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css",
        "css/AdminLTE.css"
    ];
    public $js = [

        //<!-- jQuery 2.0.2 -->
        "js/jquery.min.js",
        //<!-- jQuery UI 1.10.3 -->
        "js/jquery-ui-1.10.3.min.js",
        //<!-- Bootstrap -->
        "js/bootstrap.min.js",
        // <!-- Morris.js charts -->
        "js/raphael-min.js",
        "js/plugins/morris/morris.min.js",
        // <!-- Sparkline -->
        "js/plugins/sparkline/jquery.sparkline.min.js",
        // <!-- jvectormap -->
        "js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js",
        "js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js",
        //<!-- fullCalendar -->
        "js/plugins/fullcalendar/fullcalendar.min.js",
        // <!-- jQuery Knob Chart -->
        "js/plugins/jqueryKnob/jquery.knob.js",
        //<!-- daterangepicker -->
        "js/plugins/daterangepicker/daterangepicker.js",
        //<!-- Bootstrap WYSIHTML5 -->
        "js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js",
        //<!-- iCheck -->
        "js/plugins/iCheck/icheck.min.js",

        //<!-- AdminLTE App -->
        "js/AdminLTE/app.js",

        //   <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        "js/AdminLTE/dashboard.js"

    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
