define(['popBox','dialogBox','jquery_sanhai','jqueryUI'],function(popBox,dialogBox){
    //选择课程 年级
    $('#sel_course').sUI_select();
    $('#sel_grade').sUI_select();

   //打开课程列表
    $('#show_sel_classesBar_btn').click(function(){
        $(".sel_classesBar").slideDown();
        return false;
    });
    //选择学科
    $("#sel_classesBar").sel_list('single');
    $("#sel_classesBar dd").click(function(){
        $('#sel_classes h5').text($(this).text());
        $("#sel_classesBar").hide();
    });

    //目录树
    $('.pointTree').tree();



    //搜索框提示
    $('#mainSearch').placeholder({
        value: "请输入资料名称关键字……",
        left: 15,
        top: 4
    });

    //选择课程
    $(".classes_sel_list").sel_list('single', function () {
    });



    //章节树
    $("#problem_tree").find("a").click(function () {
        var _this = $(this);
        var tome = _this.attr("data-value");
        var url = $("#problem_tree").attr('data-url');
        $.get(url, {tome: tome}, function (result) {
            $('#classFile').html(result);
        })
    });


    //类型搜索
    $(document).on('click','.select_mattype',function(){
        var _this = $(this);
        var url = _this.attr('data-url');
        $.get(url,{},function(data){
            $("#classFile").html(data);
        })
    });

    //排序
    $(document).on('click','.sort_search',function(){
        var _this = $(this);
        var url = _this.attr('data-url');
        $.get(url,{},function(data){
            $("#classFile").html(data);
        })
    });

    //下载课件
    $(document).on('click',"#downloadMaterial",function () {
        var _this = $(this);

        var fileId = _this.attr("fileId");
        var price = _this.attr("price");

        $.post('/ajax/is-privilege-to-download',{fileId:fileId},function (data) {
            if(data.success == false){
                dialogBox({
                    title:'下载课件',
                    content:'<p class="tc">抱歉,此资源为高级会员专属,普通用户不能下载.</p><p class="tc">请到手机app端申请成为高级会员.</p>',
                    TrueBtn:{
                        name:'知道了'
                    }
                });
            }else{

                dialogBox({
                    title: '下载课件',
                    content: '<p class="tc">普通会员'+price+'学米</p><p class="tc">高级会员'+Math.ceil(price/2)+'学米</p>',
                    TrueBtn: {
                        name: '确定',
                        fn: function () {
                            $('#mask').remove();

                            $.post('/ajax/download-material',{fileId:fileId},function (result) {
                                if(result.success == false){

                                    if(result.code == 401 ){
                                        defaultMessage='请到手机app端申请成为高级会员.';
                                        if(result.message.indexOf("学米") > 0){
                                            defaultMessage = '';
                                        }
                                        dialogBox({
                                            title:'下载课件',
                                            content:'<p class="tc">'+result.message+'</p><p class="tc">'+defaultMessage+'</p>',
                                            TrueBtn:{
                                                name:'知道了'
                                            }
                                        });
                                    }else{
                                        popBox.errorBox(result.message);
                                    }

                                }else{
                                    var downloadNum = _this.children('.downloadNum').text();
                                    _this.children('.downloadNum').text(++downloadNum);
                                    window.open(result.data);
                                }

                            });
                        }
                    },
                    FalseBtn: {
                        name: '取消'
                    }
                });

            }
        });
    });


    //预览课件
    $(document).on('click',"#previewMaterial",function () {
        var _this = $(this);
        var fileId = _this.attr("fileId");

        $.get('/ajax/preview-material',{fileId:fileId},function (result) {

            if(result.success == false){

                if(result.code == 401 ){
                    dialogBox({
                        title:'预览课件',
                        content:'<p class="tc">'+result.message+'</p><p class="tc">请到手机app端申请成为高级会员.</p>',
                        TrueBtn:{
                            name:'知道了'
                        }
                    });
                }else{
                    popBox.errorBox(result.message);
                }

            }else{
                var readNum = _this.children('.readNum').text();
                _this.children('.readNum').text(++readNum);
                window.open(result.data);
            }

        });

    });

    //收藏，取消收藏
    $(document).on('click','#collectMaterial',function() {
        var _this=$(this);
        var id = _this.attr('data-id');
        var url = _this.attr('data-url');
        var cancelUrl = _this.attr('data-url-cancel');
        if(_this.hasClass('cur')){
            $.post(cancelUrl,{fileId:id},function(data){
                if(data.success){
                    _this.children('.collection').text('收藏');
                    var collectNum = _this.children('.collectionNum').text();
                    _this.children('.collectionNum').text(collectNum-1);
                    _this.removeClass('cur');
                }else{
                    popBox.errorBox(data.message);
                }
            });
        }else{
            $.post(url,{fileId:id},function(result){
                if(result.success){
                    _this.children('.collection').text('取消收藏');
                    var collectNum = _this.children('.collectionNum').text();
                    _this.children('.collectionNum').text(++collectNum);
                    _this.addClass('cur');
                }else{
                    if(result.code == 401 ){
                        dialogBox({
                            title:'收藏课件',
                            content:'<p class="tc">'+result.message+'</p><p class="tc">请到手机app端申请成为高级会员.</p>',
                            TrueBtn:{
                                name:'知道了'
                            }
                        });
                    }else{
                        popBox.errorBox(result.message);
                    }
                }
            });
        }
    });



});


