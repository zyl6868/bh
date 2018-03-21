<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2015/4/29
 * Time: 16:39
 */
?>
<ul class="tabList clearfix">
	<li>
		<a href="<?php echo url('teacher/default/index',array('teacherId'=>$teacherId,'t'=>'1'))?>" class="<?php echo $this->context->highLightUrl(['teacher/default/index', '']) ? 'ac' : '' ?>">
			<?php if($teacherId == user()->id){
				echo 'Wo';
			}else{
				echo 'Ta';
			}?>
			的文件
		</a></li>
	<li>
		<a href="<?php echo url('teacher/default/collect-list',array('teacherId'=>$teacherId,'t'=>'2'))?>" class="<?php echo $this->context->highLightUrl(['teacher/default/collect-list', '']) ? 'ac' : '' ?>">
			<?php if($teacherId == user()->id){
				echo 'Wo';
			}else{
				echo 'Ta';
			}?>
			的收藏
		</a>
	</li>
</ul>