<?php
/**
 * 批改语音
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/5/25
 * Time: 19:08
 */
?>
<?php
if(!empty($hworkAnCorrectAudio)){
	foreach($hworkAnCorrectAudio as $item){ ?>

		<span class="voice voiceActive" style="width: 150px; line-height: 38px ">
			<object width="150" height="20">

				<param name="movie" value="<?php echo BH_CDN_RES.'/pub'?>/singlemp3player/player.swf?file=<?php echo $item->audioUrl;?>&showDownload=false&backColor=11ADE6" />
				<param name="wmode" value="transparent" />

				<embed wmode="transparent" width="150" height="20" src="<?php echo BH_CDN_RES.'/pub'?>/singlemp3player/player.swf?file=<?php echo $item->audioUrl;?>&showDownload=false&backColor=11ADE6" type="application/x-shockwave-flash" />
			</object>
		</span>


	<?php }} ?>
