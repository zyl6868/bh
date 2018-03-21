<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/4
 * Time: 15:08
 */
use frontend\widgets\xupload\XUploadSimple;

foreach($model as $key=>$val)
{
   var_dump($val);
      }
?>
<?= \frontend\components\CLinkPagerNormalExt::widget(['pagination' => $pages,'updateId' => '#uploadId']); ?>

<?= \frontend\widgets\ueditor\MiniNoImgUEditor::widget(
    array(
        'id'=>'analytical',
        'name'=>'analytical',
        'UEDITOR_CONFIG'=>array(
            'maximumWords'=>'1000',
        ),
        'options' => array(
        'value' =>'aaaaa',
    )
    )

) ?>

<?php
$t2 = new frontend\widgets\xupload\models\XUploadForm();
echo XUploadSimple::widget(array(
    'url' => Yii::$app->urlManager->createUrl("upload/header"),
    'model' => $t2,
    'attribute' => 'file',
    'autoUpload' => true,
    'multiple' => true,
    'options' => array(
        'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(jpg|png|jpeg)$/i'),
        "done" => new \yii\web\JsExpression('done'),
        "processfail" => new \yii\web\JsExpression('function (e, data) {var index = data.index,file = data.files[index]; if (file.error) {alert(file.error);}}')

    ),
    'htmlOptions' => array(
        'id' => 't2',
    )
));

echo \frontend\components\CHtmlExt::dropDownListCustomize('good',null,['a'=>1,'b'=>2],[
        "defaultValue" => false, "prompt" => "请选择",
        'ajax' => [
            'url' => Yii::$app->urlManager->createUrl('ajax/get-area'),
            'data' => ['id' => new \yii\web\JsExpression('this.value')],
            'success' => 'function(html){jQuery("#a").html(html).change();}'
        ],
        "id" => 'dddd'
    ]);
?>
