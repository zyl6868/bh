<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/8/17
 * Time: 14:20
 */
use common\components\WebDataCache;

/** @var common\models\pos\SeClassMembers $item */
/** @var common\models\pos\SeUserinfo $classSub */
?>
<tr>
	<td><?php echo WebDataCache::getClassesNameByClassId($item->classID); ?></td>
	<td><?php echo WebDataCache::getSubjectNameById($classSub['subjectID']); ?></td>
	<td><?php
		if ($item->identity == 20401) {
			echo '班主任';
		} elseif ($item->identity == 20402) {
			echo '任课教师';
		} else {
			echo '*';
		} ?></td>
	<td class="clId" clId="<?php echo $item->classID; ?>">
		<a href="javascript:;" class="q_class">退出该班</a>
	</td>
</tr>
