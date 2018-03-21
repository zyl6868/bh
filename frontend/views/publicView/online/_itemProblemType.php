<?php
/**
 * Created by wangchunlei
 * User: Administrator
 * Date: 14-12-18
 * Time: 上午11:58
 */
/*
49  209	题型显示	1	单选题	1
50	209	题型显示	2	多选题	1
51	209	题型显示	3	填空题	1
52	209	题型显示	4	问答题	1
53	209	题型显示	5	应用题	1
96	209	题型显示	7	阅读理解	1
95	209	题型显示	6	完形填空	1
*/

use common\models\sanhai\ShTestquestion;
use frontend\components\helper\ImagePathHelper;
use frontend\components\helper\LetterHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

if (!isset($no)) {
    $no = '';
}
?>
<?php if ($item->showTypeId == ShTestquestion::QUESTION_DAN_XUAN_TI || $item->showTypeId == ShTestquestion::QUESTION_DUO_XUAN_TI) { ?>
	<?php
	if(isset($no) && !empty($no)){
		echo '<p>小题'.$no .'：'. $item->content.'</p>';
	}elseif(isset($item->questionId) && !empty($item->questionId)){
		echo '<h5>题'.$item->questionId.'</h5>';
		echo '<h6>【'. $item->year.'年】'. $item->provenanceName . $item->questiontypename .'</h6>';
		echo '<p>'.$item->content.'</p>';
	} ?>
    <div class="checkArea">
        <?php
        $showTypeId = $item->showTypeId;
        $select = array(
            '0'=>array('id'=>'0','content'=>'A'),
            '1'=>array('id'=>'1','content'=>'B'),
            '2'=>array('id'=>'2','content'=>'C'),
            '3'=>array('id'=>'3','content'=>'D')
        );
        if($item->answerOption == ''){?>
            <?php

            if ($showTypeId == ShTestquestion::QUESTION_DAN_XUAN_TI) {
                echo Html::radioList('item[' . $item->questionId . ']',$item->userAnswerOption ,ArrayHelper::map($select,"id","content"), ['separator' => '<br />','class'=>'radio','encode'=>false]);
            } else {
                echo Html::checkboxList('item[' . $item->questionId . ']', $item->userAnswerOption, ArrayHelper::map($select,"id","content"), ['separator' => '<br />','class'=>'checkbox','encode'=>false,]);
            }

            ?>
        <?php }elseif($item->answerOption == null){?>
            <?php

            if ($showTypeId == ShTestquestion::QUESTION_DAN_XUAN_TI) {
                echo Html::radioList('item[' . $item->questionId . ']',$item->userAnswerOption ,ArrayHelper::map($select,"id","content"), ['separator' => '<br />','class'=>'radio','encode'=>false,]);
            } else {
                echo Html::checkboxList('item[' . $item->questionId . ']', $item->userAnswerOption, ArrayHelper::map($select,"id","content"), ['separator' => '<br />','class'=>'checkbox','encode'=>false]);
            }

            ?>
        <?php }elseif($item->answerOption == '[]'){?>
            <?php

            if ($showTypeId == ShTestquestion::QUESTION_DAN_XUAN_TI) {
                echo Html::radioList('item[' . $item->questionId . ']',$item->userAnswerOption ,ArrayHelper::map($select,"id","content"), array('separator' => '<br />','class'=>'radio','encode'=>false));
            } else {
                echo Html::checkboxList('item[' . $item->questionId . ']', $item->userAnswerOption, ArrayHelper::map($select,"id","content"), array('separator' => '<br />','class'=>'checkbox','encode'=>false));
            }

            ?>
        <?php }else{?>
            <?php
            $result = json_decode($item->answerOption);
            $select = (from($result)->select(function ($v) {
                return '<em>'.LetterHelper::getLetter($v->id) . '</em>&nbsp;<p>' . $v->content.'</p>';
            }, '$k')->toArray());
            if ($item->showTypeId == ShTestquestion::QUESTION_DAN_XUAN_TI) {
                echo Html::radioList('item[' . $item->questionId . ']',$item->userAnswerOption , $select, array('separator' => '','class'=>'radio','encode'=>false));
            } else {
                echo Html::checkboxList('item[' . $item->questionId . ']', $item->userAnswerOption, $select, array('separator' => '','class'=>'checkbox','encode'=>false));
            }
            ?>
        <?php }?>

    </div>
<?php } ?>

<?php if ($item->showTypeId == ShTestquestion::QUESTION_BU_KE_PAN_TIAN_KONG_TI) { ?>
	<?php
	if(isset($no) && !empty($no)){
		echo '<p>小题'.$no .'：'. $item->content.'</p>';
	}elseif(isset($item->questionId) && !empty($item->questionId)){
		echo '<h5>题'.$item->questionId.'</h5>';
		echo '<h6>【'. $item->year.'年】'. $item->provenanceName . $item->questiontypename .'</h6>';
		echo '<p>'.$item->content.'</p>';
	} ?>
    <div class="checkArea">
        <?php if (empty($item->childQues)) { ?>
            <p><label></label>
            <ul class="addPicUl addImage clearfix sub_Q_List">
                <?php foreach($item->picList as $v){?>
	        <li>
		        <?php if(!empty($item->picList)){ ?>
			        <div class="checkArea" style="margin:0 ">
				        <div class="oneself clearfix">
					        <p class="onese">
						        <span style="display: inline">我的答案：</span>
						        <?php foreach($item->picList as $v){?>
							        <a href="<?php echo url('student/managetask/view-correct',array('questionId'=>$item->questionId,"homeworkAnswerID"=>$homeworkAnswerID))?>">  <img width="50" height="48" alt="" src="<?php echo resCdn($v->picUrl) ?>"></a>
						        <?php } ?>
					        </p>

				        </div>
			        </div>

		        <?php }?>
	        </li>

                <?php }?>
            </ul>
            </p>
        <?php } else {
            foreach ($item->childQues as $key => $i) {
                ?>
                <p><label><?php echo $key+1 ?>、<?php echo $i->content ?> </label>
                <ul class="addPicUl addImage clearfix">
                   <?php foreach($i->picList as $v){?>
		            <li>
			            <?php if(!empty($item->picList)){ ?>
				            <div class="checkArea" style="margin:0 ">
					            <div class="oneself clearfix">
						            <p class="onese">
							            <span style="display: inline">我的答案：</span>
							            <?php foreach($item->picList as $v){?>
								            <a href="<?php echo url('student/managetask/view-correct',array('questionId'=>$item->questionId,"homeworkAnswerID"=>$homeworkAnswerID))?>">  <img width="50" height="48" alt="" src="<?php echo resCdn($v->picUrl) ?>"></a>
							            <?php } ?>
						            </p>

					            </div>
				            </div>

			            <?php }?>
		            </li>

                    <?php }?>
                </ul>
                </p>
            <?php }
        }
        ?>
    </div>
<?php } ?>

<?php //if ($item->showTypeId == 4) { ?>
<!--	--><?php
//	if(isset($no) && !empty($no)){
//		echo '<p>小题'.$no .'：'. $item->content.'</p>';
//	}elseif(isset($item->questionId) && !empty($item->questionId)){
//		echo '<h5>题'.$item->questionId.'</h5>';
//		echo '<h6>【'. $item->year.'年】'. $item->provenanceName . $item->questiontypename .'</h6>';
//		echo '<p>'.$item->content.'</p>';
//	} ?>
<!--    <div class="checkArea">-->
<!--		<label>我的回答：</label>--><?php //echo  Html::textArea('item[' . $item->questionId . ']') ?>
<!--    </div>-->
<?php //} ?>


<?php if ($item->showTypeId == ShTestquestion::QUESTION_JIE_DA_TI) { ?>
	<?php
	if(isset($no) && !empty($no)){
		echo '<p>小题'.$no .'：'. $item->content.'</p>';
	}elseif(isset($item->questionId) && !empty($item->questionId)){
		echo '<h5>题'.$item->questionId.'</h5>';
		echo '<h6>【'. $item->year.'年】'. $item->provenanceName . $item->questiontypename .'</h6>';
		echo '<p>'.$item->content.'</p>';
	} ?>
    <ul class="sub_Q_List">
        <li>
			<?php if(!empty($item->picList)){ ?>
				<div class="checkArea" style="margin:0 ">
					<div class="oneself clearfix">
						<p class="onese">
							<span style="display: inline">我的答案：</span>
							<?php foreach($item->picList as $v){?>
								<a href="<?php echo url('student/managetask/view-correct',array('questionId'=>$item->questionId,"homeworkAnswerID"=>$homeworkAnswerID))?>">  <img width="50" height="48" alt="" src="<?php echo resCdn($v->picUrl) ?>"></a>
							<?php } ?>
							</p>
						</div>
					</div>

		<?php }else{
            foreach ($item->childQues as $key => $i) {
                echo $this->render('//publicView/online/_itemChildProblemType', array('item' => $i, 'no' => $key+1,'homeworkAnswerID'=>$homeworkAnswerID));
            }}
            ?>
        </li>
    </ul>
<?php } ?>

<?php if ($item->showTypeId == ShTestquestion::QUESTION_PAN_DUAN_TI) { ?>
    <div class="paper">

        <input type="hidden" class="bigType" value="<?php echo $item->showTypeId?>">
        <input type="hidden" class="bigTitleID" value="<?php echo $item->questionId?>" />
        <h5>题 <?php echo $item->questionId;?> </h5>
        <h6>【<?php echo $item->year ?>年】 <?php echo $item->provenanceName ?>  <?php echo $item->questiontypename ?></h6>
        <p><?php echo $item->content ?></p>
        <div class="checkArea">
            <?php
            $showTypeId = $item->showTypeId;
            $op_list = array(
                '0'=>array('id'=>'0','content'=>'错'),
                '1'=>array('id'=>'1','content'=>'对'),
            );
            if($item->answerOption == ''){

                echo '<li><div class="checkArea">'.Html::radioList("answer[$item->questionId]",$item->userAnswerOption,ArrayHelper::map($op_list,'id','content'),
                        ['class'=>"radio alternative",'qid'=>$item->questionId,'tpid'=>$item->showTypeId,'separator'=>'&nbsp;','encode'=>false]).'</div></li>';
            }elseif($item->answerOption == null){

                echo '<li><div class="checkArea">'.Html::radioList("answer[$item->questionId]",$item->userAnswerOption,ArrayHelper::map($op_list,'id','content'),
                        ['class'=>"radio alternative",'qid'=>$item->questionId,'tpid'=>$item->showTypeId,'separator'=>'&nbsp;','encode'=>false]).'</div></li>';
            }elseif($item->answerOption == '[]'){


                echo '<li><div class="checkArea">'.Html::radioList("answer[$item->questionId]",$item->userAnswerOption,ArrayHelper::map($op_list,'id','content'),
                        ['class'=>"radio alternative",'qid'=>$item->questionId,'tpid'=>$item->showTypeId,'separator'=>'&nbsp;','encode'=>false]).'</div></li>';


            }else{
                $result = json_decode($item->answerOption);
                $result=$result==null?array():$result;
                $select = (from($result)->select(function ($v) {
                    return '<em>'.LetterHelper::getLetter($v->id) . '</em>&nbsp;<p>' . $v->content.'</p>';
                }, '$k')->toArray());

                    echo Html::radioList('item[' . $item->questionId . ']', $item->userAnswerOption, $select, array('separator' => '','class'=>'radio','encode'=>false));

          }?>

        </div>
        <br>
        <div style="clear: both"></div>


    </div>
    <hr>
<?php } ?>

