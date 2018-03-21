<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2014/12/11
 * Time: 14:00
 */
/* @var $this yii\web\View */
use common\models\dicmodels\ChapterInfoModel;
use yii\helpers\Html;

if ($hasModel) {
    $nodeList = ChapterInfoModel::findChapter(Html::getAttributeValue($model, $attribute));
} else {
    $nodeList = ChapterInfoModel::findChapter($val);

}

?>

<?php if ($hasModel) { ?>
    <div
        id="knowledge_<?php echo isset($htmlOptions['id']) ? $htmlOptions['id'] : Html::getInputId($model, $attribute); ?>"
        class="treeParent">
        <button type="button" class="<?php echo $htmlOptions['class'] ?>"     ><?php echo $buTitle ?>
        </button>
        <div class="pointArea <?php echo count($nodeList) > 0 ? '' : 'hide' ?>" >
            <?php $htmlOptions['class'] = "hidVal";
            echo Html::activeHiddenInput($model, $attribute, $htmlOptions); ?>

            <h6>已选中:</h6>
            <ul class=" labelList clearfix">
                <?php foreach ($nodeList as $item) { ?>
                    <li val="<?php echo $item->id ?>"><?php echo $item->name ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
<?php } else { ?>
    <div id="chapter_<?php echo isset($htmlOptions['id']) ? $htmlOptions['id'] : $name.'_id' ?>"
         class="treeParent">
        <button type="button" class="<?php echo $htmlOptions['class'] ?>"
            ><?php echo $buTitle ?>
        </button>
        <div class="pointArea  <?php echo count($nodeList) > 0 ? '' : 'hide' ?>">
            <?php $htmlOptions['class'] = "hidVal";
            echo Html::activeHiddenInput($name, $value, $htmlOptions);?>
            <h6>已选中:</h6>
            <ul class="labelList clearfix">
                <?php foreach ($nodeList as $item) { ?>
                    <li val="<?php echo $item->id ?>"><?php echo $item->name ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
<?php } ?>
