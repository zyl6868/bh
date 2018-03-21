<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/3/2
 * Time: 16:03
 */

use common\components\WebDataCache;

?>
<div class="pd25 tableWrap">
    <table class="sUI_table">
        <tbody>

        <tr>
            <th width="100">教师名称</th>
            <?php foreach($allDataArray as $v){?>
            <td align="center"><?php echo $v['teacherId']==0?'': WebDataCache::getTrueNameByuserId($v['teacherId']) ?></td>
            <?php }?>
        </tr>

        <tr>
            <th width="100">班级名称</th>
            <?php foreach($allDataArray as $v){?>
                <td align="center"><?php
                       $classIdArray=explode(',',$v['classData']);
                    $classNameArray=[];
                      foreach($classIdArray as $value){
                          $className= \common\components\WebDataCache::getClassesNameByClassId($value);
                          array_push($classNameArray,$className);
                      }
                     $classResult=implode(',',$classNameArray);
                    echo $classResult ?></td>
            <?php }?>
       <input type="hidden" class="dataResult" value='<?=json_encode($allDataArray)?>' />
        </tr>
        </tbody>
    </table>
</div>
