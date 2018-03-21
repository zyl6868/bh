<?php

use common\models\dicmodels\KnowledgePointModel;
use yii\helpers\Html;

if ($hasModel) {
    $nodeList = KnowledgePointModel::findKnowledge(Html::getAttributeValue($model, $attribute));
} else {
    $nodeList = KnowledgePointModel::findKnowledge($val);
}

?>

<?php if ($hasModel) { ?>
    <div
        id="knowledge_<?php echo isset($htmlOptions['id']) ? $htmlOptions['id'] : Html::getInputId($model, $attribute); ?>"
        class="treeParent">
        <button type="button" class="<?php echo $htmlOptions['class'] ?>"><?php echo $buTitle ?>
        </button>
        <div class="pointArea <?php echo count($nodeList) > 0 ? '' : 'hide' ?>">
            <?php $htmlOptions['class'] = "hidVal";
            echo Html::activeHiddenInput($model, $attribute, $htmlOptions); ?>
            <h6>已选中:</h6>
            <ul class=" labelList clearfix">

                <?php foreach ($nodeList as $item) { ?>

                    <li val="<?php echo $item['id'] ?>"><?php echo $item['name'] ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
<?php } else { ?>
    <div id="knowledge_<?php echo isset($htmlOptions['id']) ? $htmlOptions['id'] : $name . '_id' ?>"
         class="treeParent">
        <button type="button" class="<?php echo $htmlOptions['class'] ?>"
        ><?php echo $buTitle ?>
        </button>
        <div class="pointArea  <?php echo count($nodeList) > 0 ? '' : 'hide' ?>">
            <?php $htmlOptions['class'] = "hidVal";
            echo Html::hiddenInput($name, $value, $htmlOptions); ?>
            <h6>已选中:</h6>
            <ul class="labelList clearfix">
                <?php foreach ($nodeList as $item) { ?>
                    <li val="<?php echo $item['id'] ?>"><?php echo $item['name'] ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
<?php } ?>
