<?php
/**
 * Created by PhpStorm.
 * User: 邓奇文
 * Date: 2016/7/30
 * Time: 18:52
 */
use frontend\components\helper\ViewHelper;

if (empty($messageInfo)) {
	ViewHelper::emptyView();
} else {
	?>

	<h4><?php echo $messageInfo->title; ?></h4>
	<p><?php echo str_replace(' ', '&nbsp;', str_replace(chr(10), '<br/>', $messageInfo->addContent)); ?></p>
	<ul>
		<?php
		if (!empty($url)) {

			foreach ($url as $v) {
				?>
				<li>
					<a class="fancybox" href="<?php echo $v ?>" data-fancybox-group="gallery">
						<img alt="" src="<?php echo resCdn($v) ?>">
					</a>
				</li>
			<?php }
		}
		?>
	</ul>
<?php } ?>
