<?php
/**
 * navigation-top.php
 *
 * @copyright Copyright &copy; Pedro Plowman, https://github.com/p2made, 2015
 * @author Pedro Plowman
 * @package p2made/yii2-sb-admin-theme
 * @license MIT
 */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */
?>
<div class="navbar-header">
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>
	<?= Html::a('三海教育', Yii::$app->homeUrl, ['class' => 'navbar-brand']) ?>
</div>

<ul class="nav navbar-top-links navbar-right">
	<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?=Yii::$app->user->identity->username ?>
		<i class="fa fa-user fa-fw"></i><i class="fa fa-caret-down"></i>
		</a>
		<ul class="dropdown-menu dropdown-user">
			<li><a href="#"><i class="fa fa-user fa-fw"></i> 用户属性</a>
			</li>
			<li><a href="#"><i class="fa fa-gear fa-fw"></i> 设置</a>
			</li>
			<li class="divider"></li>
			<li>
				<?= Html::a(
					'<i class="fa fa-sign-out fa-fw"></i> 退出',
					['/site/logout']
				) ?>
			</li>
		</ul><!-- /.dropdown-user -->
	</li><!-- /.dropdown -->
</ul>
