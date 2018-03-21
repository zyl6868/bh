<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2015/4/20
 * Time: 17:53
 */
use frontend\components\helper\PinYinHelper;
use frontend\components\helper\ViewHelper;
use common\models\dicmodels\SubjectModel;

/* @var $this yii\web\View */  $this->title="错题列表";
$this->registerCssFile(BH_CDN_RES.'/static/css/stu_error_subject.css' . RESOURCES_VER);
$subject=new SubjectModel();
?>

<!--主体-->
<div id="errorRecognition" class="Recognition">
	<ul class="errorRecognition clearfix">
		<?php
		if(empty($questionList)){
			echo ViewHelper::emptyView();
		}else{
		foreach($questionList as $val){
		?>
		<li class="errorList fl">
			<img src="<?= BH_CDN_RES.'/static/images/subjectIco/'.PinYinHelper::firstChineseToPin($subject->getName((int)$val->subjectId))?>.jpg" alt="" class="fl">
			<ul class="fl">
				<li><h4><?=$subject->getName((int)$val->subjectId)?>错题集</h4></li>
				<li><?php echo $val->questionNum?>道题</li>
			</ul>
			<a href="<?= url('student/wrongtopic/wro-top-for-item',array('subjectId'=>$val->wrongSubjectId)); ?>" class="btn">查看错题</a>
		</li>
		<?php }} ?>
	</ul>
</div>