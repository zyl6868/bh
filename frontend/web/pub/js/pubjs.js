// JavaScript Document

function formValidationIni(jqselect) {
    $(jqselect).validationEngine({
        validateNonVisibleFields: true,
        promptPosition: "centerRight",
        maxErrorsPerField: 1,
        showOneMessage: true,
        addSuccessCssClassToField: 'ok'
    });
}

function setUserDefHead() {
    $("img[data-type='header']").each(function () {
        this.removeAttribute('data-type');
        if (!this.complete || typeof this.naturalWidth == "undefined" || this.naturalWidth == 0) {
            $(this).attr('onerror', function () {
                this.src = '/pub/images/tx.jpg';
                this.onerror = null;
            });
        }
    });
}

function userDefImg(image) {
    image.src = '/pub/images/tx.jpg';
    image.onerror = null;
}



uploadDone = function (e, data) {
    $.each(data.result, function (index, file) {
        if (file.error) {
            popBox.errorBox(file.error);
            return;
        }
        $('<li><img src="' + file.url + '" alt=""><span class="delBtn"></span></li>').insertBefore($(e.target).parent());
    });

};

/**
 * @param colIdx
 * @returns {*}
 * 使用方法
 * $(function(){
 *      $('.tb tbody tr').each(function(row) {
 *      $('.tb').colspan(row);
 * });
 */

//jquery 合并数列单元格 rowspan
jQuery.fn.rowspan = function(colIdx) {
    return this.each(function(){
        var that;
        $('tr', this).each(function(row) {
            $('td:eq('+colIdx+')', this).each(function(col) {
                if ($(this).html() == $(that).html()) {
                    rowspan = $(that).attr("rowSpan");
                    if (rowspan == undefined) {
                        $(that).attr("rowSpan",1);
                        rowspan = $(that).attr("rowSpan");
                    }
                    rowspan = Number(rowspan)+1;
                    $(that).attr("rowSpan",rowspan); // do your action for the colspan cell here
                    $(this).hide(); // .remove(); // do your action for the old cell here
                } else {
                    that = this;
                }
                that = (that == null) ? this : that; // set the that if not already set
            });
        });
    });
};

/**
 * @param rowIdx
 * @returns {*}
 * 使用方法
 * $(function(){
 *      $('.tb tbody tr').each(function(col) {
 *      $('.tb').rowspan(col);
 *   });
 * })
 */
//jquery 合并纵向单元格 colspan
jQuery.fn.colspan = function(rowIdx) {
    return this.each(function(){
        var that;
        $('tr', this).filter(":eq("+rowIdx+")").each(function(row) {
            $(this).find('td').each(function(col) {
                /*  alert($(this).text()!=""); */
                if ($(this).html() == $(that).html()) {
                    colspan = $(that).attr("colSpan");
                    if (colspan == undefined) {
                        $(that).attr("colSpan",1);
                        colspan = $(that).attr("colSpan");
                    }
                    colspan = Number(colspan)+1;
                    $(that).attr("colSpan",colspan);
                    $(this).hide(); // .remove();
                } else {
                    that = this;
                }
                that = (that == null) ? this : that; // set the that if not already set
            });
        });
    });
};



