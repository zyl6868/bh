<?php

namespace schoolmanage\widgets\ueditor;


class MiniUEditor extends UEditor
{
    protected $defaultPath = array(
        'imageUrl' => 'php/imageUp.php',
        'imagePath' => '/uploads/ue/',
        'fileUrl' => 'php/fileUp.php',
        'filePath' => 'php/',
        'catcherUrl' => 'php/getRemoteImage.php',
        'catcherPath' => 'php/',
        'imageManagerUrl' => 'php/imageManager.php',
        'imageManagerPath' => 'php/',
        'snapscreenHost' => '127.0.0.1',
        'snapscreenServerUrl' => 'php/imageUp.php',
        'snapscreenPath' => 'php/',
        'wordImageUrl' => 'php/imageUp.php',
        'wordImagePath' => 'php/',
        'getMovieUrl' => 'php/getMovie.php'
    );

    protected $defaultToolbars = array(
        array(
            'source', '|', 'fontsize', 'bold', 'italic', 'underline', 'strikethrough', 'forecolor', 'justifyleft', 'justifycenter',
            'justifyright', 'inserttable', 'insertimage', 'imagecenter', 'imageleft', 'imageright'
        ),
    );

    protected $defaultLabelMap = array(
//        'anchor' => '锚点', 'undo' => '撤销', 'redo' => '重做', 'bold' => '加粗', 'indent' => '首行缩进', 'snapscreen' => '截图',
//        'italic' => '斜体', 'underline' => '下划线', 'strikethrough' => '删除线', 'subscript' => '下标',
//        'superscript' => '上标', 'formatmatch' => '格式刷', 'source' => '源代码', 'blockquote' => '引用',
//        'pasteplain' => '纯文本粘贴模式', 'selectall' => '全选', 'print' => '打印', 'preview' => '预览',
//        'horizontal' => '分隔线', 'removeformat' => '清除格式', 'time' => '时间', 'date' => '日期',
//        'unlink' => '取消链接', 'insertrow' => '前插入行', 'insertcol' => '前插入列', 'mergeright' => '右合并单元格', 'mergedown' => '下合并单元格',
//        'deleterow' => '删除行', 'deletecol' => '删除列', 'splittorows' => '拆分成行', 'splittocols' => '拆分成列', 'splittocells' => '完全拆分单元格',
//        'mergecells' => '合并多个单元格', 'deletetable' => '删除表格', 'insertparagraphbeforetable' => '表格前插行', 'cleardoc' => '清空文档',
//        'fontfamily' => '字体', 'fontsize' => '字号', 'paragraph' => '段落格式', 'insertimage' => '图片', 'inserttable' => '表格', 'link' => '超链接',
    );

    protected $defaultiframeCss = 'themes/iframe.css';

}
