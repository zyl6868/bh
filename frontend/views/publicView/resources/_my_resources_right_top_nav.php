<?php
/**
 * 右部导航 公告页面
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/5/30
 * Time: 15:46
 */
use yii\helpers\Url;

?>
<div class="sUI_pannel tab_pannel">
	<div class="pannel_l">
		<div class="sUI_tab">
			<ul class="tabList clearfix">
				<li>
					<a href="<?php echo Url::to(["/teacher/resources/collect-work-manage"])?>"
					   class="tch_hmwk_ic <?php echo $this->context->highLightUrl(['teacher/resources/collect-work-manage','teacher/resources/my-create-work-manage']) ? 'ac' : '' ?>"><i></i>作业</a>
				</li>
				<li>
					<a href="<?php echo Url::to(["/teacher/question/index"])?>"
					   class="tch_question_ic <?php echo $this->context->highLightUrl(['teacher/question/index']) ? 'ac' : '' ?>"><i></i>题目</a>
				</li>
				<li>
					<a href="<?php echo Url::to(["/teacher/favoritematerial/index"])?>"
					   class="tch_courseware_ic <?php echo $this->context->highLightUrl(['teacher/favoritematerial/index','teacher/favoritematerial/index-create']) ? 'ac' : '' ?>"><i></i>课件</a>
				</li>
				<li><a href="<?php echo Url::to(["/teacher/managepaper/index"])?>"
					   class="tch_exam_ic <?php echo $this->context->highLightUrl(['teacher/managepaper/index']) ? 'ac' : '' ?>"><i></i>试卷</a></li>
			</ul>
		</div>
	</div>
	<div class="pannel_r favbar"></div>
</div>

