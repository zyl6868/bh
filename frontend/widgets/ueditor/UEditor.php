<?php
namespace frontend\widgets\ueditor;

/*
$this->widget('ext.ueditor.UEditor',
    array(
        'id'=>'editor',
        'model'=>$model,
        'attribute'=>'content',
        'UEDITOR_CONFIG'=>array(
            'UEDITOR_HOME_URL'=>Yii::$app->baseUrl.'/ueditor/',
            //All configuration items are annotated UEditor default values

            'isShow'=>true,
            'initialContent'=>'欢迎使用ueditor!',       //Initialize the contents of the editor (Welcome use ueditor!)
            'autoClearinitialContent'=>false,           //Whether to automatically remove the initial content of the editor, 
            //Note: If the focus property is set to true, this is true, then the editor up will not see the trigger lead to initialize the contents of the
            'iframeCssUrl'=>Yii::$app->baseUrl.'/ueditor/themes/default/iframe.css', //Within the editor to the introduction of a css file
            'focus'=>false,     //Initialization, and whether to allow the editor to obtain the focus true or false
            'minFrameHeight'=>320,
            'fullscreen'=>false,    //Whether to open the full-screen, off by default initialization
            'readonly'=>false,      //After the initialization of the editor, regional editor is read-only, default is false.
            'zIndex'=>900,          //the default is 900
            'imagePopup'=>true,     //Picture a floating layer switch, turned on by default
            'initialStyle'=>'body{font-size:18px}',     //Within the editor style, can be used to change the font
            'emotionLocalization'=>false,               //Open expression localized, off by default.To turn to make sure that the emotion folder contains a folder of images expression
            'enterTag'=>'p',            //Editor Enter labels. p or br
            'pasteplain'=>false,        //Whether pure text paste
            'wordCount'=>true,          //Whether or not to open the Word Count
            'maximumWords'=>10000,      //Maximum number of characters allowed
            'wordCountMsg'=>'当前已输入 {#count} 个字符，您还可以输入{#leave} 个字符',      //Word Count prompt {# count} represents the current number of words, {# leave} representatives also can enter the number of characters
            'wordOverFlowMsg'=>'<span style="color:red;">你输入的字符个数已经超出最大允许值，服务器可能会拒绝保存！</span>',        //Beyond the word limit prompt
            'tabSize'=>4,       //Click the tab the moving distance, tabSize, multiples, tabNode character as a unit
            'tabNode'=>'&nbsp;',
            'removeFormatTags'=>'b,big,code,del,dfn,em,font,i,ins,kbd,q,samp,small,span,strike,strong,sub,sup,tt,u,var',        //Clear tags and attributes can be deleted in the format
            'removeFormatAttributes'=>'class,style,lang,width,height,align,hspace,valign',
            'maxUndoCount'=>20,     //Can be rolled back up to the number of default 20
            'maxInputCount'=>20,    //When the number of characters entered exceeds the value, save an on-site
            'autoHeightEnabled'=>true,      //Whether to automatically default true
            'autoFloatEnabled'=>true,       //Whether to keep the location of the toolbar is fixed, default true
            'indentValue'=>'2em',           //The first line indent, default is 2em
            'pageBreakTag'=>'_baidu_page_break_tag_',           //Paging identifier, the default is _baidu_page_break_tag_
            'toolbars'=>array(
                array(
                    'fullscreen', 'source', '|', 'undo', 'redo', '|',
                    'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch','autotypeset', '|',
                    'blockquote', '|', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist','selectall', 'cleardoc', '|', 'customstyle',
                    'paragraph', '|','rowspacingtop', 'rowspacingbottom','lineheight', '|','fontfamily', 'fontsize', '|',
                    'directionalityltr', 'directionalityrtl', '|', '', 'indent', '|',
                    'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
                    'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright',
                    'imagecenter', '|', 'insertimage', 'emotion', 'insertvideo', 'attachment', 'map', 'gmap', 'insertframe','highlightcode','webapp','pagebreak', '|',
                    'horizontal', 'date', 'time', 'spechars','snapscreen', 'wordimage', '|',
                    'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', '|',
                    'print', 'preview', 'searchreplace','help'
                )
            ),              //All the function button on the toolbar and drop-down box
            'labelMap'=>array(
                'anchor'=>'锚点', 'undo'=>'撤销', 'redo'=>'重做', 'bold'=>'加粗', 'indent'=>'首行缩进','snapscreen'=> '截图',
                'italic'=>'斜体', 'underline'=>'下划线', 'strikethrough'=>'删除线', 'subscript'=>'下标',
                'superscript'=>'上标', 'formatmatch'=>'格式刷', 'source'=>'源代码', 'blockquote'=>'引用',
                'pasteplain'=>'纯文本粘贴模式', 'selectall'=>'全选', 'print'=>'打印', 'preview'=>'预览',
                'horizontal'=>'分隔线', 'removeformat'=>'清除格式', 'time'=>'时间', 'date'=>'日期',
                'unlink'=>'取消链接', 'insertrow'=>'前插入行', 'insertcol'=>'前插入列', 'mergeright'=>'右合并单元格', 'mergedown'=>'下合并单元格',
                'deleterow'=>'删除行', 'deletecol'=>'删除列', 'splittorows'=>'拆分成行', 'splittocols'=>'拆分成列', 'splittocells'=>'完全拆分单元格',
                'mergecells'=>'合并多个单元格', 'deletetable'=>'删除表格', 'insertparagraphbeforetable'=>'表格前插行', 'cleardoc'=>'清空文档',
                'fontfamily'=>'字体', 'fontsize'=>'字号', 'paragraph'=>'段落格式', 'insertimage'=>'图片', 'inserttable'=>'表格', 'link'=>'超链接',
                'emotion'=>'表情', 'spechars'=>'特殊字符', 'searchreplace'=>'查询替换', 'map'=>'Baidu地图', 'gmap'=>'Google地图',
                'insertvideo'=>'视频', 'help'=>'帮助', 'justifyleft'=>'居左对齐', 'justifyright'=>'居右对齐', 'justifycenter'=>'居中对齐',
                'justifyjustify'=>'两端对齐', 'forecolor'=>'字体颜色', 'backcolor'=>'背景色', 'insertorderedlist'=>'有序列表',
                'insertunorderedlist'=>'无序列表', 'fullscreen'=>'全屏', 'directionalityltr'=>'从左向右输入', 'directionalityrtl'=>'从右向左输入',
                'RowSpacingTop'=>'段前距', 'RowSpacingBottom'=>'段后距','highlightcode'=>'插入代码', 'pagebreak'=>'分页', 'insertframe'=>'插入Iframe', 'imagenone'=>'默认',
                'imageleft'=>'左浮动', 'imageright'=>'右浮动','attachment'=>'附件', 'imagecenter'=>'居中', 'wordimage'=>'图片转存',
                'lineheight'=>'行间距', 'customstyle'=>'自定义标题','autotypeset'=> '自动排版','webapp'=>'百度应用'
            ),              //Tooltip prompts displayed when the mouse on the toolbar


        ),

));
*/

use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\InputWidget;

class UEditor extends InputWidget
{
    protected $defaultPath = array(
        'imageUrl' => 'php/imageUp.php',
        'imagePath' => 'php/',
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
            'fullscreen', 'source', '|', 'undo', 'redo', '|',
            'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', '|',
            'blockquote', '|', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|', 'customstyle',
            'paragraph', '|', 'rowspacingtop', 'rowspacingbottom', 'lineheight', '|', 'fontfamily', 'fontsize', '|',
            'directionalityltr', 'directionalityrtl', '|', '', 'indent', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
            'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright',
            'imagecenter', '|', 'insertimage', 'emotion', 'insertvideo', 'attachment', 'map', 'gmap', 'insertframe', 'highlightcode', 'webapp', 'pagebreak', '|',
            'horizontal', 'date', 'time', 'spechars', 'snapscreen', 'wordimage', '|',
            'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', '|',
            'print', 'preview', 'searchreplace', 'help'
        ),
    );

    protected $defaultLabelMap = array(
//            'anchor'=>'锚点', 'undo'=>'撤销', 'redo'=>'重做', 'bold'=>'加粗', 'indent'=>'首行缩进','snapscreen'=> '截图',
//            'italic'=>'斜体', 'underline'=>'下划线', 'strikethrough'=>'删除线', 'subscript'=>'下标',
//            'superscript'=>'上标', 'formatmatch'=>'格式刷', 'source'=>'源代码', 'blockquote'=>'引用',
//            'pasteplain'=>'纯文本粘贴模式', 'selectall'=>'全选', 'print'=>'打印', 'preview'=>'预览',
//            'horizontal'=>'分隔线', 'removeformat'=>'清除格式', 'time'=>'时间', 'date'=>'日期',
//            'unlink'=>'取消链接', 'insertrow'=>'前插入行', 'insertcol'=>'前插入列', 'mergeright'=>'右合并单元格', 'mergedown'=>'下合并单元格',
//            'deleterow'=>'删除行', 'deletecol'=>'删除列', 'splittorows'=>'拆分成行', 'splittocols'=>'拆分成列', 'splittocells'=>'完全拆分单元格',
//            'mergecells'=>'合并多个单元格', 'deletetable'=>'删除表格', 'insertparagraphbeforetable'=>'表格前插行', 'cleardoc'=>'清空文档',
//            'fontfamily'=>'字体', 'fontsize'=>'字号', 'paragraph'=>'段落格式', 'insertimage'=>'图片', 'inserttable'=>'表格', 'link'=>'超链接',
//            'emotion'=>'表情', 'spechars'=>'特殊字符', 'searchreplace'=>'查询替换', 'map'=>'Baidu地图', 'gmap'=>'Google地图',
//            'insertvideo'=>'视频', 'help'=>'帮助', 'justifyleft'=>'居左对齐', 'justifyright'=>'居右对齐', 'justifycenter'=>'居中对齐',
//            'justifyjustify'=>'两端对齐', 'forecolor'=>'字体颜色', 'backcolor'=>'背景色', 'insertorderedlist'=>'有序列表',
//            'insertunorderedlist'=>'无序列表', 'fullscreen'=>'全屏', 'directionalityltr'=>'从左向右输入', 'directionalityrtl'=>'从右向左输入',
//            'RowSpacingTop'=>'段前距', 'RowSpacingBottom'=>'段后距','highlightcode'=>'插入代码', 'pagebreak'=>'分页', 'insertframe'=>'插入Iframe', 'imagenone'=>'默认',
//            'imageleft'=>'左浮动', 'imageright'=>'右浮动','attachment'=>'附件', 'imagecenter'=>'居中', 'wordimage'=>'图片转存',
//            'lineheight'=>'行间距', 'customstyle'=>'自定义标题','autotypeset'=> '自动排版','webapp'=>'百度应用'
    );

    protected $defaultiframeCss = 'themes/iframe.css';

    public $JsFile = 'ueditor.all.js';

    public $CssFile = 'themes/default/css/ueditor.min.css';

    public $UEDITOR_CONFIG = ['wordCount' => false, 'initialContent' => ''];


    public function init()
    {
        $this->UEDITOR_CONFIG['UEDITOR_HOME_URL'] = '/ueditor/';
        if (empty($this->UEDITOR_CONFIG['UEDITOR_HOME_URL']))
            throw new InvalidConfigException("UEDITOR_CONFIG['UEDITOR_HOME_URL'] must be set.");
        $this->generateDefaultConfig();
        $this->registerClientScripts();
        parent::init();
    }

    public function registerClientScripts()
    {
        //Register the main script files

        $cs = $this->view;;

        $ueditorJsFile = $this->UEDITOR_CONFIG['UEDITOR_HOME_URL'] . $this->JsFile;
        $cs->registerJsFile($ueditorJsFile,  ['position'=>View::POS_HEAD]);

        // add the css

        $ueditorCssFile = $this->UEDITOR_CONFIG['UEDITOR_HOME_URL'] . $this->CssFile;
        $cs->registerCssFile($ueditorCssFile);

        //Register the widget-specific script on ready
        $js = $this->generateJs();
        $cs->registerJs($js, View::POS_END, 'ueditor-' . $this->getId());

    }

    protected function generateDefaultConfig()
    {
        $configKeys = array_keys($this->UEDITOR_CONFIG);
        foreach ($this->defaultPath as $key => $value) {
            if (!in_array($key, $configKeys)) {
                $this->UEDITOR_CONFIG[$key] = $this->UEDITOR_CONFIG['UEDITOR_HOME_URL'] . $value;
            }
        }

        $this->UEDITOR_CONFIG['elementPathEnabled'] = false;
        $this->UEDITOR_CONFIG['imagePath'] = '/uploads/ue';
//        $this->UEDITOR_CONFIG['zIndex'] = 900;

        if (!in_array('toolbars', $configKeys)) {
            $this->UEDITOR_CONFIG['toolbars'] = $this->defaultToolbars;
        }

        if (!in_array('labelMap', $configKeys)) {
            $this->UEDITOR_CONFIG['labelMap'] = $this->defaultLabelMap;
        }
        if (!in_array('iframeCssUrl', $configKeys)) {
            $this->UEDITOR_CONFIG['iframeCssUrl'] = $this->UEDITOR_CONFIG['UEDITOR_HOME_URL'] . $this->defaultiframeCss;
        }

    }

    protected function generateJs()
    {
        $config = $this->UEDITOR_CONFIG;
        $jsValue = "editor";
        if (isset($config['jsValue'])) {
            $jsValue = $config['jsValue'];
            unset($config['jsValue']);
        };
        $js = "var $jsValue = new baidu.editor.ui.Editor(";
        if ($config) {
            $js .= \yii\helpers\Json::encode($config);
        }
        $js .= ");";
        $js .= "$jsValue.render('" . $this->id . "');";

        return $js;
    }


    public function run()
    {


        $nameID = $this->resolveNameID();
        $htmlOptions = $this->options;
        $htmlOptions['name'] = $nameID[0];
        $htmlOptions['id'] = $nameID[1];
        $htmlOptions['type'] = 'text/plain';
        if (!isset($htmlOptions['value'])) {
            $content = Html::getAttributeValue($this->model, $this->attribute);
        } else {
            $content = $htmlOptions['value'];
        }
        echo Html::tag('script', $content, $htmlOptions);
    }

    protected function resolveNameID()
    {
        if ($this->name !== null)
            $name = $this->name;
        elseif (isset($this->options['name']))
            $name = $this->options['name'];
        elseif ($this->hasModel())
            $name = Html::getInputName($this->model, $this->attribute);
        else
            throw new InvalidConfigException('{class} must specify "model" and "attribute" or "name" property values.');
        if (($id = $this->getId(false)) === null) {
            if (isset($this->options['id']))
                $id = $this->options['id'];
            else
                $id = self::getIdByName($name);
        }

        return array($name, $id);
    }
    private static function getIdByName($name)
    {
        return str_replace(['[]', '][', '[', ']', ' '], ['', '_', '_', '', '_'], $name);
    }
}
