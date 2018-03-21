<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/7/13
 * Time: 18:51
 */
use common\models\dicmodels\SubjectModel;
/** @var common\models\pos\SeUserinfo $userResult */
?>
<tbody>
<tr id="table_header" class="table_header">
    <td class="short"></td>
    <td class="short">姓名</td>
    <td class="short">性别</td>
    <td class="long">手机号</td>
    <td class="long">帐号</td>
    <td class="short">学科</td>
</tr>
<?php foreach($userResult as $v){?>
    <tr>
        <td class="short">
            <label>
                <input type="radio" value="<?php echo $v->userID?>" name="find_name">
            </label>
        </td>
        <td class="short"><?php echo $v->trueName?></td>
        <td class="short"><?php
            if($v->sex==1){
                echo '男';
            }elseif($v->sex==2){
                echo '女';
            }else{
                echo '*';
            }
            ?></td>
        <td class="long"><?php echo $v->bindphone?></td>
        <td class="long"><?php echo $v->phoneReg?></td>
        <td class="short"><?php echo SubjectModel::model()->getName((int)$v->subjectID)?></td>
    </tr>
<?php }?>
</tbody>