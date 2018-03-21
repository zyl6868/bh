/**
 * Created by wangshikui on 17-11-14.
 */
document.addEventListener("DOMContentLoaded", function () {
    function my$(ele) {
        return document.getElementById(ele);
    }

// // 点击我的错题
//     my$('myErrWork').onclick = function () {
//         // my$('weakP').className = 'noSelected';
//         // my$('weakImg').className = 'noShow';
//         // my$('myErrP').className = '';
//         // my$('myErrImg').className = '';
//         my$('shadeBox').style.display = 'none';
//         my$('options').style.display = 'none';
//     };
// 点击薄弱知识点
//     my$('weakSpot').onclick = function () {
//         // my$('weakP').className = '';
//         // my$('weakImg').className = '';
//         // my$('myErrP').className = 'noSelected';
//         // my$('myErrImg').className = 'noShow';
//         my$('shadeBox').style.display = 'none';
//         my$('options').style.display = 'none';
//     };

// 点击橘黄色导航
    $('#topOrange').tap(function () {
        $('#shadeBox').css('display', 'block');
        $('#options').css('display', 'block');
    })

//     var subjectList = my$('toggleSubject').getElementsByTagName('li');
// // 切换学科
//     for (var i = 0; i < subjectList.length; i++) {
//         subjectList[i].onclick = function () {
//             for (var j = 0; j < subjectList.length; j++) {
//                 subjectList[j].className = "";
//             }
//             this.className = "isSelected";
//             my$('shadeBox').style.display = 'none';
//             my$('options').style.display = 'none';
//         }
//     }

// 点击空白关闭导航
    $('#shadeBox').tap(function () {
        $('#shadeBox').css('display', 'none');
        $('#options').css('display', 'none');
    })

    var percent = $('.percent');
    var $workData=  $('#errWorkList');
    var kidsDate = $workData.attr('data-date');
    var subjectId = $workData.attr('data-subject-id');
    if (percent.length > 0) {
        var clientH = document.body.clientHeight;
        $workData.height(clientH - 115 - 30);

        var totalNum = $('.percent:first').attr('data-num');
        // 错题长度
        for (var i = 0; i < percent.length; i++) {
            percent[i].style.width = (percent[i].getAttribute('data-num') / totalNum) * 100 + 'px';
        }

        //加载更多
        var on_off = 0;
        var page_index = 2;

        // 最外层div id
        $workData.on('scroll', function () {

            if ($('.errWorkBox').length < 10) {
                on_off = 1000;
                return;
            }

            // 整个内容的高度
            var errWorkHeight = $('#errWorkHeight').offset().height;
            if ((errWorkHeight - this.scrollTop - this.offsetHeight + 30 + on_off) <= 0) {
                on_off = 1000;

                // 在最外层最下面 p 标签
                $('#loadMore').css('display', 'block');
                //获取参数
                setTimeout(function () {
                    $.get('/web/weakness/weakness-kids/kids-list', {
                        subjectId: subjectId,
                        date: kidsDate,
                        page: page_index++
                    }, function (data) {

                        var html = '';
                        $.each(data.data, function (key, item) {
                            html += '<div class="errWorkBox">'
                                + '<div class="errWorkTitle">' + item.kidName + '</div>'
                                + '<div class="errWorkCtn">'
                                + '<div class="errNum">'
                                + '<div class="percent" data-num="' + item.wrongNum + '"></div>'
                                + '<span>错' + item.wrongNum + '题</span>'
                                + '</div>'
                                + '<p>'
                                + '<a href="/web/weakness/weakness-kids/kid-question-list?kid=' + item.kid + '">查看错题</a> |'
                                + '<a href="javascript:;" onclick="BHWEB.toPlayVideo(' + String((item.videoInfo != null) ? (item.videoInfo.videoId) : 0) + ')" class="studySpot">学习知识点</a>'
                                + '</p>'
                                + '</div>'
                                + '</div>'
                        });
                        var kidList = data.data;
                        if (kidList.length == 0) {
                            on_off = 1000;
                            $('#loadMore').html('已经到底了');
                        } else {
                            // 添加包裹所有片段的div  errWorkHeight
                            $('#errWorkHeight').append(html);
                            var percent = $('.percent');
                            var totalNum = $('.percent:first').attr('data-num');

                            // 错题长度
                            for (var i = 0; i < percent.length; i++) {
                                percent[i].style.width = (percent[i].getAttribute('data-num') / totalNum) * 100 + 'px';
                            }
                            $('#loadMore').css('display', 'none');
                            on_off = 0;
                        }

                    });
                }, 1000);


            }
        })
    }

    // 点击返回
    $('#back').tap(function () {
        BHWEB.pop();
    });


});
