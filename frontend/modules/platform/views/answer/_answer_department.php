<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/3/24
 * Time: 16:30
 */
use yii\helpers\Url;

?>
<div class="form_l tl is_department">
	<a class="sel_ac" department_type="" data-sel-item href="<?php echo Url::to(array_merge(['/platform/answer/index'], $searchArr, ['department' => ""])) ?>">全部学段</a>
</div>
<div class="form_r">
	<ul>
		<li class="is_department">
			<a data-sel-item
			   href="<?php echo Url::to(array_merge(['/platform/answer/index'], $searchArr, ['department' => 20201])) ?>"
			   department_type="20201">小学</a>
		</li>
		<li class="is_department">
			<a data-sel-item
			   href="<?php echo Url::to(array_merge(['/platform/answer/index'], $searchArr, ['department' => 20202])) ?>"
			   department_type="20202">初中</a>
		</li>
		<li class="is_department">
			<a data-sel-item
			   href="<?php echo Url::to(array_merge(['/platform/answer/index'], $searchArr, ['department' => 20203])) ?>"
			   department_type="20203">高中</a>
		</li>
	</ul>
</div>