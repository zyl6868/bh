/**
 * Created by wangshikui on 17-11-14.
 */



/*// 点击我的错题
my$('myErrWork').onclick = function () {
    my$('weakP').className = 'noSelected';
    my$('weakImg').className = 'noShow';
    my$('myErrP').className = '';
    my$('myErrImg').className = '';
    my$('shadeBox').style.display = 'none';
    my$('options').style.display = 'none';
}
// 点击薄弱知识点
my$('weakSpot').onclick = function () {
    my$('weakP').className = '';
    my$('weakImg').className = '';
    my$('myErrP').className = 'noSelected';
    my$('myErrImg').className = 'noShow';
    my$('shadeBox').style.display = 'none';
    my$('options').style.display = 'none';
}*/

// 点击橘黄色导航
$('#topOrange').tap(function () {
    $('#shadeBox').css('display', 'block');
    $('#options').css('display', 'block');
})

// var subjectList = my$('toggleSubject').getElementsByTagName('li');
// var difficultyList = my$('toggleDifficulty').getElementsByTagName('li');
// // 切换学科
// for (var i = 0; i < subjectList.length; i++) {
//     subjectList[i].onclick = function () {
//         for (var j = 0; j < subjectList.length; j++) {
//             subjectList[j].className = "";
//         }
//         this.className = "isSelected";
//         $('#shadeBox').css('display', 'none');
//         $('#options').css('display', 'none');
//     }
// }
// // 切换难度
// for (var i = 0; i < difficultyList.length; i++) {
//     difficultyList[i].onclick = function () {
//         for (var j = 0; j < difficultyList.length; j++) {
//             difficultyList[j].className = "";
//         }
//         this.className = "isSelected";
//         my$('shadeBox').style.display = 'none';
//         my$('options').style.display = 'none';
//     }
// }
// 点击空白关闭导航
$('#shadeBox').tap(function () {
    $('#shadeBox').css('display', 'none');
    $('#options').css('display', 'none');
})

// 点击返回
$('#back').tap(function () {
    BHWEB.pop();
})

//获取Url参数值
function UrlSearch(param) {
    var str = location.href;         //取得整个地址栏
    var index = str.indexOf("?");
    str = str.substr(index + 1);//取得所有参数   stringvar.substr(start [, length ]
    var arr = str.split("&");        //各个参数放到数组里
    for (var i = 0; i < arr.length; i++) {
        index = arr[i].indexOf("=");
        if (index > 0) {
            var name = arr[i].substring(0, index);
            if (name == param) {
                return arr[i].substr(index + 1)
            }
        } else {
            return '';
        }
    }
}

