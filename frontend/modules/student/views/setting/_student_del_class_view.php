<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/8/17
 * Time: 15:32
 */
use common\components\WebDataCache;

?>
<div id="caution_header" class="tl caution_header">退出班级<i></i></div>
<div id="caution_main" class="tc caution_main">
	是否确认退出<u class="red"><?php echo WebDataCache::getClassesNameByClassId($classInfo["classID"]) ?></u>班级？
</div>
<div class="btn_c">
	<a href="javascript:;">
		<button class="okBtn" id="quit_class" clId="<?php echo $classInfo["classID"]; ?>">确定</button>
	</a>
	<button class="cancelBtn btn">取消</button>
</div>
