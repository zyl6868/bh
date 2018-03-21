<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/1/21
 * Time: 16:59
 */
?>
<div class="container  " style="margin-top: 0">
    <div class="pd25">
        <div class="sUI_formList sUI_formList_min classes_file_list">
            <div id="classes_sel_list" class="row" >
                <?php echo $this->render('topic_type_view',['result'=>$result,'searchArr'=>$searchArr])?>
            </div>
            <div id="hard_list" class="row">
                <?php echo $this->render('topic_dif_list_view',['searchArr'=>$searchArr]);?>
            </div>
        </div>
    </div>

</div>
<div class="container  classify no_bg topic_list">
    <?php echo $this->render('topic_list',['dataList'=>$dataList,'pages'=>$pages,'searchArr'=>$searchArr]);?>
</div>