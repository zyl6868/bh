<?php
/**
 * 布置语音
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/5/25
 * Time: 18:59
 */

?>
<?php if(!empty($homeworkRelAudio)){?>
	<p>
		<em style="float: left;">补充内容：</em>
		<span class="voice voiceActive" id="voice" style="width:150px; line-height: 38px ">
			<object width="150" height="20">

				<param name="movie" value="<?php echo BH_CDN_RES.'/pub'?>/singlemp3player/player.swf?file=<?php echo $homeworkRelAudio;?>&showDownload=false&backColor=11ADE6" />
				<param name="wmode" value="transparent" />

				<embed wmode="transparent" width="150" height="20" src="<?php echo BH_CDN_RES.'/pub'?>/singlemp3player/player.swf?file=<?php echo $homeworkRelAudio;?>&showDownload=false&backColor=11ADE6" type="application/x-shockwave-flash" />
			</object>
		</span>
		<br />
	</p>

<?php  } ?>
