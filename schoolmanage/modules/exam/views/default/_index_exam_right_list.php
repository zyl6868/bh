<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/2/17
 * Time: 15:32
 * 考务管理：右側列表 片段
 */
use frontend\components\CLinkPagerExt;

?>

<div id="answerPage" class="answerPage">
<div class="sch_mag_list clearfix" >
	<?php
	echo $this->render("_index_exam_list", ["examSchoolModel"=>$examSchoolModel]);
	?>

</div>

<div class="page">
	<?php
	echo CLinkPagerExt::widget(
			array(
					'pagination' => $pages,
					'updateId' => '#answerPage',
					'maxButtonCount' => 10,
					'showjump'=>true
			)
	)
	?>
</div>
</div>