define(['jquery',"popBox", 'jquery_sanhai', 'jqueryUI'], function($,popBox,ec) {
    window.loadImageFile = (function () {
        if (window.FileReader) {
            var oPreviewImg = null, oFReader = new window.FileReader(),
                rFilter = /^(?:image\/bmp|image\/cis\-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x\-cmu\-raster|image\/x\-cmx|image\/x\-icon|image\/x\-portable\-anymap|image\/x\-portable\-bitmap|image\/x\-portable\-graymap|image\/x\-portable\-pixmap|image\/x\-rgb|image\/x\-xbitmap|image\/x\-xpixmap|image\/x\-xwindowdump)$/i;
            oFReader.onload = function (oFREvent) {
                oPreviewImg = new Image();
                oPreviewImg.style.width = "500px";
                oPreviewImg.style.height = "98px";
                var img_ul = $('#addimage');
                oPreviewImg.src = oFREvent.target.result;
                img_ul.html(oPreviewImg);
            };
            return function () {
                var aFiles = document.getElementById("fileupload").files;
                if (aFiles.length === 0) {
                    return;
                }
                if (!rFilter.test(aFiles[0].type)) {
                    alert("You must select a valid image file!");
                    return;
                }
                oFReader.readAsDataURL(aFiles[0]);
            }
        }
    }());
    $("#contentImg").delegate("img", "click", function () {
        var self = $(this);
        var shade = $('.shade');
        var img_big = shade.find('div.img_big');
        var bigimg = img_big.find('img');
        bigimg.attr("src", self.url);
        shade.css({
            "width": $(document).width(),
            "height": $(document).height()
        }).show();
        img_big.css({
            "margin": 'auto',
            //"width": bigimg.width(),
            "position": "fixed",
            "left": ($(window).width() - img_big.width()) / 2,
            "top": ($(window).height() - img_big.height()) / 2
        }).show();
    });
    $('u.close').click(function () {
        var self = $(this);
        self.parent().hide();
        self.parent().parent().hide();
    });



});
