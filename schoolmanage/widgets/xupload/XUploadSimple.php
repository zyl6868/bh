<?php

namespace schoolmanage\widgets\xupload;

use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\InputWidget;


/**
 * XUpload extension for Yii.
 *
 * jQuery file upload extension for Yii, allows your users to easily upload files to your server using jquery
 * Its a wrapper of  http://blueimp.github.com/jQuery-File-Upload/
 *
 * @author AsgarothBelem <asgaroth.belem@gmail.com>
 * @link http://blueimp.github.com/jQuery-File-Upload/
 * @link https://github.com/Asgaroth/xupload
 * @version 0.2
 *
 */
class XUploadSimple extends InputWidget
{

    /**
     * the url to the upload handler
     * @var string
     */
    public $url;

    /**
     * set to true to use multiple file upload
     * @var boolean
     */
    public $multiple = false;

    /**
     * The upload template id to display files available for upload
     * defaults to null, meaning using the built-in template
     */
    public $uploadTemplate;

    /**
     * The template id to display files available for download
     * defaults to null, meaning using the built-in template
     */
    public $downloadTemplate;

    /**
     * Wheter or not to preview image files before upload
     */
    public $previewImages = true;

    /**
     * Wheter or not to add the image processing pluing
     */
    public $imageProcessing = true;

    /**
     * set to true to auto Uploading Files
     * @var boolean
     */
    public $autoUpload = false;

    /**
     * @var string name of the form view to be rendered
     */
    public $formView = 'formsimle';

    /**
     * @var string name of the upload view to be rendered
     */
    public $uploadView = 'upload';

    /**
     * @var string name of the download view to be rendered
     */
    public $downloadView = 'download';

    /**
     * @var bool whether form tag should be used at widget
     */
    public $showForm = false;

    public $htmlOptions = [];

    /**
     * Publishes the required assets
     */
    public function init()
    {
        parent::init();
        $this->publishAssets();
    }

    /**
     * Publises and registers the required CSS and Javascript
     * @throws CHttpException if the assets folder was not found
     */
    public function publishAssets()
    {
        $baseUrl = '/static';
        // $this->registerJsFile($baseUrl . '/js/jquery.ui.widget.js', [ 'position'=>\yii\web\View::POS_HEAD] );
        \Yii::$app->view->registerCssFile($baseUrl . '/js/jqueryfileupload/jquery.fileupload.css');

        // The basic File Upload plugin
        \Yii::$app->view->registerJsFile($baseUrl . '/js/jqueryfileupload/jquery.fileupload.js', ['position' => View::POS_END]);

        //The Iframe Transport is required for browsers without support for XHR file uploads
        \Yii::$app->view->registerJsFile($baseUrl . '/js/jqueryfileupload/jquery.iframe-transport.js', ['position' => View::POS_END]);

        // The File Upload image processing plugin
        if ($this->imageProcessing) {
            //       Yii::$app->clientScript->registerScriptFile($baseUrl . '/js/jqueryfileupload/jquery.fileupload-ip.js', CClientScript::POS_END);
        }

        //The localization script
        $messages = Json::encode(array(
            'fileupload' => array(
                'errors' => array(
                    "maxFileSize" => ('文件太大'),
                    "minFileSize" => ('文件太小'),
                    "acceptFileTypes" => ('文件类型不允许'),
                    "maxNumberOfFiles" => ('Max number of files exceeded'),
                    "uploadedBytes" => ('Uploaded bytes exceed file size'),
                    "emptyResult" => ('Empty file upload result'),
                ),
                'error' => '错误',
                'start' => '开始',
                'cancel' => '中止',
                'destroy' => '删除'
            ),
        ));
        $js = "window.locale = {$messages}";

        \Yii::$app->view->registerJs( $js, View::POS_END,'XuploadI18N');
        /**
         * <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
         * <!--[if gte IE 8]><script src="<?php echo Yii::$app->baseUrl; ?>/js/cors/jquery.xdr-transport.js"></script><![endif]-->
         *
         */

    }


    /**
     * Generates the required HTML and Javascript
     */
    public function run()
    {
        $model = $this->model;
        if (!isset($this->htmlOptions['enctype'])) {
            $this->htmlOptions['enctype'] = 'multipart/form-data';
        }

        if (!isset($this->htmlOptions['id'])) {
            $this->htmlOptions['id'] = get_class($model) . "-form";
        }

        $this->options['url'] = $this->url;
        $this->options['autoUpload'] = $this->autoUpload;
        $this->options['formData'] = new JsExpression('{}');
        $this->options['dataType'] = 'json';

        if (!$this->multiple) {
            $this->options['maxNumberOfFiles'] = 1;
        }


        $options = Json::encode($this->options);
        if (isset($this->htmlOptions["class"])) {
            \Yii::$app->view->registerJs( "jQuery(\".{$this->htmlOptions['class']}:input[type='file']\").fileupload({$options});", View::POS_READY,__CLASS__ . 'class' . $this->htmlOptions['class']);

        } else {
            \Yii::$app->view->registerJs( "jQuery('#{$this->htmlOptions['id']}').fileupload({$options});", View::POS_READY,__CLASS__ . '#' . $this->htmlOptions['id']);

        }
        $htmlOptions = array();
        if ($this->multiple) {
            $htmlOptions["multiple"] = true;
        }

        $htmlOptions["id"] = $this->htmlOptions['id'];
        $htmlOptions["class"] = (isset($this->htmlOptions["class"]) ? $this->htmlOptions["class"] : '') . " file";
        return  $this->render($this->formView, ['model'=>$this->model,'hasModel'=>$this->hasModel(),'attribute'=>$this->attribute,'optinos'=>$htmlOptions,'name'=>$this->name,'value'=>$this->value]);

    }

}
