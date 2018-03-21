<?php
/**
 * Created by unizk.
 * User: ysd
 * Date: 14-12-12
 * Time: 上午10:52
 */
use frontend\components\helper\StringHelper;
use frontend\components\helper\ViewHelper;
use yii\helpers\Html;

?>


<ul class="notice_list">
	<?php if ($model->list):
		foreach ($model->list as $val) { ?>
			<li>
				<h4 title="<?= Html::encode($val->messageContent) ?>" class="<?php if ($val->isRead == '0') {
					echo 'font_w';
				} ?>">
					<div>
						<?php echo Html::encode($val->messageContent); ?>
					</div>
					<i class="cut" data-messageId="<?php echo $val->messageID ?>"></i>
				</h4>
				<p>
					From&nbsp;:&nbsp;
					<span><?php echo $val->sentName; ?></span>
					<span><?php echo $val->sentTime; ?></span>
					<?php if (isset($val->messageType) && $val->messageType == 507009 && $val->isRead != '0'){
						echo "<a>";
					} elseif (isset($val->messageType) && $val->messageType == 507009 && $val->isRead == '0'){ ?>
					<a class="float_right white tc readed" href="javascript:void(0);"
					   data-messageType="<?php echo $val->messageType; ?>"
					   data-messageID="<?php echo $val->messageID; ?>" data-objectID="<?php echo $val->objectID ?>">
						<?php }else{ ?>
						<a class="float_right white tc"
						   href="<?php echo url('student/message/is-read', array('messageID' => $val->messageID, 'messageType' => $val->messageType, 'objectID' => $val->objectID))
						   ?>">
							<?php }
							if (isset($val->messageType) && $val->messageType != 507009) {
								if (isset($val->objectID) && $val->objectID != 0) {
									if ($val->messageType == 507001) {
										echo "前去完成";
									} elseif ($val->messageType == 507402) {
										echo "前去完成";
									} elseif ($val->messageType == 507202) {
										echo "查看详情";
									} elseif ($val->messageType == 507203) {
										echo "查看详情";
									} elseif ($val->messageType == 507204) {
										echo "查看详情";
									} elseif ($val->messageType == 507205) {
										echo "查看排名变化";
									}
								}
							} elseif (isset($val->messageType) && $val->messageType == 507009 && $val->isRead == '0') {
								echo "标记为已读";
							} ?>
						</a>
				</p>
			</li>
		<?php }
	else:
		ViewHelper::emptyView();
	endif;
	?>
</ul>
<?php
echo \frontend\components\CLinkPagerExt::widget(array(
		'pagination' => $pages,
		'updateId' => '#notice',
		'maxButtonCount' => 5,
		'showjump' => true
	)
);
?>
<div id="caution" class="caution">
	<div id="caution_header" class="tl caution_header">删除通知<i></i></div>
	<div id="caution_main" class="tc caution_main"><i></i>确定删除所选消息吗?</div>
	<div class="btn_c">
		<button class="okBtn">确定</button>
		<button class="cancelBtn btn">取消</button>
	</div>
</div>
