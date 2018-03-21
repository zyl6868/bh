<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2015/6/5
 * Time: 18:41
 */


use common\helper\DateTimeHelper;
use frontend\components\helper\ImagePathHelper;

/** @var common\models\sanhai\SrMaterial  $val */

//分享数
$shareNum = $val->getSharedNum()->count();

//是否收藏过
$isCollect = $val->getCollectNum()->where(['creatorID'=>user()->id])->exists();

//收藏列表
$collect = $val->getCollectNum()->where(['creatorID'=>$teacherId])->all();

?>
<li >
	<img src="<?php echo ImagePathHelper::getFilePic($val->url);?>" alt="<?php echo cut_str($val->name,18);; ?>" width="57" height="57">
	<h6><?php echo cut_str($val->name,18);; ?></h6>
	<p>
		<em class="file_btn">
			<?php if ($type == 1) {
				echo "教案";
			} elseif ($type == 7) {
				echo "教学计划";
			} elseif ($type == 8) {
				echo "课件";
			} elseif ($type == 6) {
				echo "素材";
			} elseif ($type == 99) {
				echo "其他";
			} ?>
		</em>
		<?php

		echo date('Y-m-d', DateTimeHelper::timestampDiv1000($val->createTime));

		?>
		<span> <?php  echo $shareNum;  ?>人已分享</span>

	</p>
	<div class="mask_link hide">
		<div class="mask_link_BG"></div>
		<div class="mask_link_cont">
			<?php
			if($listType == 1){
				if($val->creator != user()->id){
				if(empty($isCollect)){ ?>
					<a class="addfavLink" action="1" collectID="<?php echo $val->id;?>" typeId="<?php echo $val->matType;?>">收藏</a>
				<?php }else{
					?>
					<a class="addfavLink favLink" action="0" collectID="<?php echo $val->id; ?>" typeId="<?php echo $val->matType;?>">取消收藏</a>
				<?php }} ?>
                <a class="readLink" id="previewMaterial"  fileId="<?php echo $val->id;?>" href="javascript:;">阅读</a>

			<?php }elseif($listType == 2){
				if($teacherId == user()->id){ ?>
					<a class="delfavLink favLink" action="0" collectID="<?php echo $val->id ?>" typeId="<?php echo $val->matType;?>">取消收藏</a>
				<?php } ?>
                <a class="readLink" id="previewMaterial"  fileId="<?php echo $val->id;?>" href="javascript:;">阅读</a>
			<?php } ?>
		</div>
	</div>
</li>