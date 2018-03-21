<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/30
 * Time: 13:21
 */

use yii\helpers\Url;
use common\helper\DateTimeHelper;
use frontend\components\helper\StringHelper;
use frontend\components\helper\ViewHelper;

?>

<div id="questionTypes" class="container manipulate no_bg">
    <?php if(empty($data)){
        ViewHelper::emptyView();
    }else{
    foreach($data as $key=>$item){ ?>
    <div data-id="<?=$key+1?>" id="delBtnP<?=$key+1?>" class="question_types clearfix">
        <dl class="clearfix">
                <?php if($item->getType==0){ ?>
                    <a  href="<?php echo url('/teacher/exam/paper-preview',array('paperID'=>$item->id));?>"><dt class="paper"></dt></a>
                    <?php
                }else{?>
                    <a href="<?php echo url('/teacher/exam/paper-preview',array('paperID'=>$item->id));?>"><dt class="electron"></dt></a>
                <?php } ?>
            <dd>
                <h4><a href="<?php echo url('teacher/exam/paper-preview',array('paperID'=>$item->id));?>"><?php echo $item->name;?></a></h4>
                <?php if(!empty($item->paperDescribe)){ ?>
                <p>
                    简介：<span title="<?php echo strip_tags($item->paperDescribe);?>">
                        <?php echo StringHelper::cutStr(strip_tags($item->paperDescribe),40); ?>
                    </span>
                </p>
                <?php }else{?> <br> <?php } ?>
                <span><?php echo date("Y-m-d H:i", DateTimeHelper::timestampDiv1000($item->uploadTime));?></span>
            </dd>
        </dl>
        <u class="delBtn" style="display: none;" data-paperId="<?php echo $item->id;?>"></u>
    </div>
    <?php }  }?>
</div>

<?php
echo \frontend\components\CLinkPagerExt::widget(array(
        'pagination' => $pages,
        'updateId' => '#paper_list',
        'maxButtonCount' => 5,
        'showjump' => true
    )
);
?>