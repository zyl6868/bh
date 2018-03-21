<?php
use yii\helpers\Url;

?>
<?php
$yDate = date('Y',time());//年
$mDate = date("m",time());//月
$no = 0;
$joinYear = '';
foreach ($gradeModel as $key=>$item) {
	$no = count($gradeModel)-$key;
    if ($upTime) {
        $joinYear = $yDate - $no + 1;
    } else {
        $joinYear = $yDate - $no;
    }
	?>
<li>
	<a class="<?php echo app()->request->getParam('gradeId', '') == $item['gradeId'] ? 'cur' : ''; ?>"
	   href="<?php echo Url::to(array_merge(['/shortboard/default/index'], $searchArr, ['gradeId'=>$item['gradeId'],'joinYear' => $joinYear]))?>">
		<?php echo $item['gradeName']. '（' . $joinYear . '级）';?>
	</a>
</li>
<?php } ?>
