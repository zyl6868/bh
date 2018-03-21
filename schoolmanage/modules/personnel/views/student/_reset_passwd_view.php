<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/3/4
 * Time: 13:09
 */
?>
<div class="popCont">
	<div class="subTitleBar">
		<h5><em style="color: red"><?php echo $userInfo["trueName"]?></em>的密码重置为</h5>
	</div>
	<div class="new_sch_con">
		<div class="password_d clearfix">
			<span>1</span>
			<span>2</span>
			<span>3</span>
			<span>4</span>
			<span>5</span>
			<span>6</span>
		</div>
	</div>
</div>
<div class="popBtnArea">
	<button type="button" class="okBtn res_passwd" uId="<?php echo $userInfo["userID"]?>">确定</button>
	<button type="button" class="cancelBtn">取消</button>
</div>
