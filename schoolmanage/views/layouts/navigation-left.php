<?php
/**
 * navigation-left.php
 *
 * @copyright Copyright &copy; Pedro Plowman, https://github.com/p2made, 2015
 * @author Pedro Plowman
 * @package p2made/yii2-sb-admin-theme
 * @license MIT
 */


use backend\components\sbNav;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use mdm\admin\components\MenuHelper;


$callback = function ($menu) {
    $item = [
        'label' => $menu['name'],
        'url' => MenuHelper::parseRoute($menu['route']),
    ];
    if ($menu['children'] != []) {
        $item['items'] = $menu['children'];
    };
    $item['label'] = $menu['data'] . $item['label'];
    return $item;

};
$items = MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback, true);
?>





<section class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <?= sbNav::widget([
            'dropDownCaret' => Html::tag('span', '', ['class' => 'fa arrow']),
            'encodeLabels' => false,
            'options' => ['class' => "nav", "id" => "side-menu"],
            'items' => $items,
        ]) ?>

    </div>

</section>
