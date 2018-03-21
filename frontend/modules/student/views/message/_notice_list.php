<?php
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 15-4-23
 * Time: 下午2:52
 */

use frontend\components\helper\StringHelper;
use frontend\components\helper\ViewHelper;
use yii\helpers\Html;


?>
<div class="tab_1 tab main_h4">
	<ul>
		<?php if (!empty($model->list)) {
			foreach ($model->list as $key => $val) {
				?>
				<li data-msgid="<?php echo $val->messageID; ?>">
					<h4 <?php if ($val->isRead == 0) {
						echo 'class="font_bold"';
					} ?>>
                        <span class="receiver" infoid="<?php echo $val->messageID; ?>"
                              title="<?php echo Html::encode($val->messageTiltle); ?>">
                            <?php echo StringHelper::cutStr(Html::encode($val->messageTiltle), 30); ?>
                        </span>
						<i class="cut delmes" delId="<?php echo $val->messageID; ?>"></i>
					</h4>

					<p>
						From&nbsp;:&nbsp;
						<span><?php echo $val->sentName; ?></span>
						<span><?php echo $val->sentTime; ?></span>
					</p>
				</li>
			<?php } ?>
		<?php } else {
			ViewHelper::emptyView();
		}
		?>

	</ul>
</div>
<div class="page ">
	<?php
	echo \frontend\components\CLinkPagerExt::widget(array(
			'pagination' => $pages,
			'updateId' => '#notice',
			'maxButtonCount' => 5,
			'showjump' => true
		)
	);
	?>
</div>

<div id="alert" class="alert" style="display:none;">
	<div id="alert_head" class="alert_head">通知详情<i id="alert_remove" class="alert_remove"></i></div>
	<div id="alert_main" class="alert_main">

	</div>
</div>
<div id="caution" class="caution">
	<div id="caution_header" class="tl caution_header">删除通知<i></i></div>
	<div id="caution_main" class="tc caution_main"><i></i>确定删除所选通知吗?</div>
	<div class="btn_c">
		<button class="okBtn">确定</button>
		<button class="cancelBtn btn">取消</button>
	</div>
</div>