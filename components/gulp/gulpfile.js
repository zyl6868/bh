const gulp = require('gulp'),
    plumber = require('gulp-plumber'),
    uglify = require('gulp-uglify-cli'),
    cssmin = require('gulp-minify-css'),
    changed = require('gulp-changed'),
    imagemin = require('gulp-tinypng'),
    debug = require('gulp-debug');
//班海路径
const BHPath = ["../../frontend/web/static/**/", "../../frontend/web/pub/**/"];
const BHOutPutPath = ["../../frontend/web/dist/static/", "../../frontend/web/dist/pub/"];
//管理班海路径
const GLBHPath = ["../../schoolmanage/web/static/**/", "../../schoolmanage/web/pub/**/"];
const GLBHOutPutPath = ["../../schoolmanage/web/dist/static/", "../../schoolmanage/web/dist/pub/"];
/***************************************
 *
 *              班海
 *
 * ************************************/
gulp.task("BH_*_0", function() {
    gulp.src(BHPath[0] + "*.{swf,json,map,woff,eot,html,min.js}")
        .pipe(changed(BHOutPutPath[0]))
        .pipe(debug({
            title: '编译*:'
        }))
        .pipe(gulp.dest(BHOutPutPath[0]));
});

gulp.task("BH_*_1", function() {
    gulp.src(BHPath[1] + "*.{swf,json,map,woff,eot,html,min.js}")
        .pipe(changed(BHOutPutPath[1]))
        .pipe(debug({
            title: '编译JS:'
        }))
        .pipe(gulp.dest(BHOutPutPath[1]));
});
gulp.task("BH_js_0", function() {
    console.log('****************************** 当前任务 : BH_js_0 ******************************');
    gulp.src([BHPath[0] + "*.js", "!" + BHPath[0] + "*.min.js"])
        .pipe(changed(BHOutPutPath[0]))
        .pipe(debug({
            title: '编译JS:'
        }))
        .pipe(uglify('--support-ie8 --mangle --compress'))
        // .pipe(uglify({
        //     mangle: false, //,    //类型：Boolean 默认：true 是否修改变量名
        //     compress: false,   //类型：Boolean 默认：true 是否完全压缩
        // preserveComments: 'all' //保留所有注释
        // }))
        .pipe(gulp.dest(BHOutPutPath[0]));
});
gulp.task("BH_js_1", function() {
    console.log('****************************** 当前任务 : BH_js_1 ******************************');
    gulp.src([BHPath[1] + "*.js", "!" + BHPath[1] + "*.min.js"])
        .pipe(changed(BHOutPutPath[1]))
        .pipe(debug({
            title: '编译JS:'
        }))
        .pipe(uglify('--support-ie8 --mangle --compress'))
        .pipe(gulp.dest(BHOutPutPath[1]));
});
gulp.task("BH_img_0", function() {
    console.log('****************************** 当前任务 : BH_img_0 ******************************');
    gulp.src(BHPath[0] + "*.{png,jpg,gif,svg}")
        .pipe(changed(BHOutPutPath[0]))
        .pipe(debug({
            title: "编译IMG:"
        }))
        .pipe(gulp.dest(BHOutPutPath[0]));
});
gulp.task("BH_img_1", function() {
    console.log('****************************** 当前任务 : BH_img_1 ******************************');
    gulp.src(BHPath[1] + "*.{png,jpg,gif,svg}")
        .pipe(changed(BHOutPutPath[1]))
        .pipe(debug({
            title: "编译IMG:"
        }))
        .pipe(gulp.dest(BHOutPutPath[1]));
});
gulp.task("BH_css_0", function() {
    console.log('****************************** 当前任务 : BH_css_0 ******************************');
    gulp.src(BHPath[0] + "*.css")
        .pipe(changed(BHOutPutPath[0]))
        .pipe(debug({
            title: '编译CSS:'
        }))
        .pipe(plumber())
        .pipe(cssmin({
            advanced: false, //类型：Boolean 默认：true [是否开启高级优化（合并选择器等）]
            compatibility: 'ie7', //保留ie7及以下兼容写法 类型：String 默认：''or'*' [启用兼容模式； 'ie7'：IE7兼容模式，'ie8'：IE8兼容模式，'*'：IE9+兼容模式]
            keepBreaks: false, //类型：Boolean 默认：false [是否保留换行]
            keepSpecialComments: '*' //保留所有特殊前缀 当你用autoprefixer生成的浏览器前缀，如果不加这个参数，有可能将会删除你的部分前缀
        }))
        .pipe(gulp.dest(BHOutPutPath[0]));
});
gulp.task("BH_css_1", function() {
    console.log('****************************** 当前任务 : BH_css_1 ******************************');
    gulp.src(BHPath[1] + "*.css")
        .pipe(changed(BHOutPutPath[1]))
        .pipe(debug({
            title: '编译CSS:'
        }))
        .pipe(plumber())
        .pipe(cssmin({
            advanced: false, //类型：Boolean 默认：true [是否开启高级优化（合并选择器等）]
            compatibility: 'ie7', //保留ie7及以下兼容写法 类型：String 默认：''or'*' [启用兼容模式； 'ie7'：IE7兼容模式，'ie8'：IE8兼容模式，'*'：IE9+兼容模式]
            keepBreaks: false, //类型：Boolean 默认：false [是否保留换行]
            keepSpecialComments: '*' //保留所有特殊前缀 当你用autoprefixer生成的浏览器前缀，如果不加这个参数，有可能将会删除你的部分前缀
        }))
        .pipe(gulp.dest(BHOutPutPath[1]));
});
gulp.task('BH', ['BH_js_0', 'BH_js_1', 'BH_img_0', 'BH_img_1', 'BH_css_0', 'BH_css_1', 'BH_*_0', 'BH_*_1']);

/***************************************
 *
 *
 *              管理班海
 *
 *
 * ************************************/
gulp.task("GLBH_*_0", function() {
    gulp.src(GLBHPath[0] + "*.{swf,json,map,woff,eot,html,min.js}")
        .pipe(changed(GLBHOutPutPath[0]))
        .pipe(debug({
            title: '编译*:'
        }))
        .pipe(gulp.dest(GLBHOutPutPath[0]));
});
gulp.task("GLBH_*_1", function() {
    gulp.src(GLBHPath[1] + "*.{swf,json,map,woff,eot,html,min.js}")
        .pipe(changed(GLBHOutPutPath[1]))
        .pipe(debug({
            title: '编译*:'
        }))
        .pipe(gulp.dest(GLBHOutPutPath[1]));
});
gulp.task("GLBH_js_0", function() {
    console.log('****************************** 当前任务 : GLBH_js_0 ******************************');
    gulp.src([GLBHPath[0] + "*.js", "!" + GLBHPath[0] + "*.min.js"])
        .pipe(changed(GLBHOutPutPath[0]))
        .pipe(debug({
            title: '编译JS:'
        }))
        .pipe(uglify('--support-ie8 --mangle --compress'))
        .pipe(gulp.dest(GLBHOutPutPath[0]));
});
gulp.task("GLBH_js_1", function() {
    console.log('****************************** 当前任务 : GLBH_js_1 ******************************');
    gulp.src([GLBHPath[1] + "*.js", "!" + GLBHPath[1] + "*.min.js"])
        .pipe(changed(GLBHOutPutPath[1]))
        .pipe(debug({
            title: '编译JS:'
        }))
        .pipe(uglify('--support-ie8 --mangle --compress'))
        .pipe(gulp.dest(GLBHOutPutPath[1]));
});
gulp.task("GLBH_img_0", function() {
    console.log('****************************** 当前任务 : GLBH_img_0 ******************************');
    gulp.src(GLBHPath[0] + "*.{png,jpg,gif,svg}")
        .pipe(changed(GLBHOutPutPath[0]))
        .pipe(debug({
            title: "编译IMG:"
        }))
        .pipe(gulp.dest(GLBHOutPutPath[0]));
});
gulp.task("GLBH_img_1", function() {
    console.log('****************************** 当前任务 : GLBH_img_1 ******************************');
    gulp.src(GLBHPath[1] + "*.{png,jpg,gif,svg}")
        .pipe(changed(GLBHOutPutPath[1]))
        .pipe(debug({
            title: "编译IMG:"
        }))
        .pipe(gulp.dest(GLBHOutPutPath[1]));
});
gulp.task("GLBH_css_0", function() {
    console.log('****************************** 当前任务 : GLBH_css_0 ******************************');
    gulp.src(GLBHPath[0] + "*.css")
        .pipe(changed(GLBHOutPutPath[0]))
        .pipe(debug({
            title: '编译CSS:'
        }))
        .pipe(plumber())
        .pipe(cssmin({
            advanced: false, //类型：Boolean 默认：true [是否开启高级优化（合并选择器等）]
            compatibility: 'ie7', //保留ie7及以下兼容写法 类型：String 默认：''or'*' [启用兼容模式； 'ie7'：IE7兼容模式，'ie8'：IE8兼容模式，'*'：IE9+兼容模式]
            keepBreaks: false, //类型：Boolean 默认：false [是否保留换行]
            keepSpecialComments: '*' //保留所有特殊前缀 当你用autoprefixer生成的浏览器前缀，如果不加这个参数，有可能将会删除你的部分前缀
        }))
        .pipe(gulp.dest(GLBHOutPutPath[0]));
});
gulp.task("GLBH_css_1", function() {
    console.log('****************************** 当前任务 : GLBH_css_1 ******************************');
    gulp.src(GLBHPath[1] + "*.css")
        .pipe(changed(GLBHOutPutPath[1]))
        .pipe(debug({
            title: '编译CSS:'
        }))
        .pipe(plumber())
        .pipe(cssmin({
            advanced: false, //类型：Boolean 默认：true [是否开启高级优化（合并选择器等）]
            compatibility: 'ie7', //保留ie7及以下兼容写法 类型：String 默认：''or'*' [启用兼容模式； 'ie7'：IE7兼容模式，'ie8'：IE8兼容模式，'*'：IE9+兼容模式]
            keepBreaks: false, //类型：Boolean 默认：false [是否保留换行]
            keepSpecialComments: '*' //保留所有特殊前缀 当你用autoprefixer生成的浏览器前缀，如果不加这个参数，有可能将会删除你的部分前缀
        }))
        .pipe(gulp.dest("../../frontend/web/dist/static/"));
});

gulp.task('GLBH', ['GLBH_js_0', 'GLBH_js_1', 'GLBH_img_0', 'GLBH_img_1', 'GLBH_css_0', 'GLBH_css_1', 'GLBH_*_0']);