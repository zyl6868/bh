<?php
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 15-4-16
 * Time: 下午3:08
 */
use common\models\dicmodels\LoadSubjectModel;
use common\models\dicmodels\SchoolLevelModel;
use yii\helpers\Url;

$subject = LoadSubjectModel::model()->getData($department,true); //查询科目
?>
    <dt><?php echo SchoolLevelModel::model()->getName($department);?></dt>
<?php
//小学部
if($department == 20201){ ?>
	<dd class="<?php echo 10010==app()->request->getParam('subjectid',$subjectid)&& $department ==app()->request->getParam('department',$departments) ?'ac':'';?>">
		<a href="<?= Url::to(['', 'department'=>$department,'subjectid'=>10010]); ?>"><?php echo '语文'; ?></a>
	</dd>
	<dd class="<?php echo 10011==app()->request->getParam('subjectid',$subjectid)&& $department ==app()->request->getParam('department',$departments) ?'ac':'';?>">
		<a href="<?= Url::to(['', 'department'=>$department,'subjectid'=>10011]); ?>"><?php echo '数学'; ?></a>
	</dd>
	<dd class="<?php echo 10012==app()->request->getParam('subjectid',$subjectid)&& $department ==app()->request->getParam('department',$departments) ?'ac':'';?>">
		<a href="<?= Url::to(['', 'department'=>$department,'subjectid'=>10012]); ?>"><?php echo '英语'; ?></a>
	</dd>
<?php } ?>

<?php
//中学部
if($department == 20202){ ?>
	<dd class="<?php echo 10010==app()->request->getParam('subjectid',$subjectid)&& $department ==app()->request->getParam('department',$departments) ?'ac':'';?>">
		<a href="<?= Url::to(['', 'department'=>$department,'subjectid'=>10010]); ?>"><?php echo '语文'; ?></a>
	</dd>
	<dd class="<?php echo 10011==app()->request->getParam('subjectid',$subjectid)&& $department ==app()->request->getParam('department',$departments) ?'ac':'';?>">
		<a href="<?= Url::to(['', 'department'=>$department,'subjectid'=>10011]); ?>"><?php echo '数学'; ?></a>
	</dd>
	<dd class="<?php echo 10012==app()->request->getParam('subjectid',$subjectid)&& $department ==app()->request->getParam('department',$departments) ?'ac':'';?>">
		<a href="<?= Url::to(['', 'department'=>$department,'subjectid'=>10012]); ?>"><?php echo '英语'; ?></a>
	</dd>
	<dd class="<?php echo 10013==app()->request->getParam('subjectid',$subjectid)&& $department ==app()->request->getParam('department',$departments) ?'ac':'';?>">
		<a href="<?= Url::to(['', 'department'=>$department,'subjectid'=>10013]); ?>"><?php echo '生物'; ?></a>
	</dd>
	<dd class="<?php echo 10014==app()->request->getParam('subjectid',$subjectid)&& $department ==app()->request->getParam('department',$departments) ?'ac':'';?>">
		<a href="<?= Url::to(['', 'department'=>$department,'subjectid'=>10014]); ?>"><?php echo '物理'; ?></a>
	</dd>
	<dd class="<?php echo 10015==app()->request->getParam('subjectid',$subjectid)&& $department ==app()->request->getParam('department',$departments) ?'ac':'';?>">
		<a href="<?= Url::to(['', 'department'=>$department,'subjectid'=>10015]); ?>"><?php echo '化学'; ?></a>
	</dd>
	<dd class="<?php echo 10016==app()->request->getParam('subjectid',$subjectid)&& $department ==app()->request->getParam('department',$departments) ?'ac':'';?>">
		<a href="<?= Url::to(['', 'department'=>$department,'subjectid'=>10016]); ?>"><?php echo '地理'; ?></a>
	</dd>
	<dd class="<?php echo 10017==app()->request->getParam('subjectid',$subjectid)&& $department ==app()->request->getParam('department',$departments) ?'ac':'';?>">
		<a href="<?= Url::to(['', 'department'=>$department,'subjectid'=>10017]); ?>"><?php echo '历史'; ?></a>
	</dd>
	<dd class="<?php echo 10029==app()->request->getParam('subjectid',$subjectid)&& $department ==app()->request->getParam('department',$departments) ?'ac':'';?>">
		<a href="<?= Url::to(['', 'department'=>$department,'subjectid'=>10029]); ?>"><?php echo '思想品德'; ?></a>
	</dd>
<?php } ?>
<?php
//中学部
if($department == 20203){ ?>
	<dd class="<?php echo 10010==app()->request->getParam('subjectid',$subjectid)&& $department ==app()->request->getParam('department',$departments) ?'ac':'';?>">
		<a href="<?= Url::to(['', 'department'=>$department,'subjectid'=>10010]); ?>"><?php echo '语文'; ?></a>
	</dd>
	<dd class="<?php echo 10011==app()->request->getParam('subjectid',$subjectid)&& $department ==app()->request->getParam('department',$departments) ?'ac':'';?>">
		<a href="<?= Url::to(['', 'department'=>$department,'subjectid'=>10011]); ?>"><?php echo '数学'; ?></a>
	</dd>
	<dd class="<?php echo 10012==app()->request->getParam('subjectid',$subjectid)&& $department ==app()->request->getParam('department',$departments) ?'ac':'';?>">
		<a href="<?= Url::to(['', 'department'=>$department,'subjectid'=>10012]); ?>"><?php echo '英语'; ?></a>
	</dd>
	<dd class="<?php echo 10013==app()->request->getParam('subjectid',$subjectid)&& $department ==app()->request->getParam('department',$departments) ?'ac':'';?>">
		<a href="<?= Url::to(['', 'department'=>$department,'subjectid'=>10013]); ?>"><?php echo '生物'; ?></a>
	</dd>
	<dd class="<?php echo 10014==app()->request->getParam('subjectid',$subjectid)&& $department ==app()->request->getParam('department',$departments) ?'ac':'';?>">
		<a href="<?= Url::to(['', 'department'=>$department,'subjectid'=>10014]); ?>"><?php echo '物理'; ?></a>
	</dd>
	<dd class="<?php echo 10015==app()->request->getParam('subjectid',$subjectid)&& $department ==app()->request->getParam('department',$departments) ?'ac':'';?>">
		<a href="<?= Url::to(['', 'department'=>$department,'subjectid'=>10015]); ?>"><?php echo '化学'; ?></a>
	</dd>
	<dd class="<?php echo 10016==app()->request->getParam('subjectid',$subjectid)&& $department ==app()->request->getParam('department',$departments) ?'ac':'';?>">
		<a href="<?= Url::to(['', 'department'=>$department,'subjectid'=>10016]); ?>"><?php echo '地理'; ?></a>
	</dd>
	<dd class="<?php echo 10017==app()->request->getParam('subjectid',$subjectid)&& $department ==app()->request->getParam('department',$departments) ?'ac':'';?>">
		<a href="<?= Url::to(['', 'department'=>$department,'subjectid'=>10017]); ?>"><?php echo '历史'; ?></a>
	</dd>
	<dd class="<?php echo 10018==app()->request->getParam('subjectid',$subjectid)&& $department ==app()->request->getParam('department',$departments) ?'ac':'';?>">
		<a href="<?= Url::to(['', 'department'=>$department,'subjectid'=>10018]); ?>"><?php echo '政治'; ?></a>
	</dd>
<?php } ?>