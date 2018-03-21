<?php
/**
 * Created by PhpStorm.
 * User: WangShiKui
 * Date: 17-11-14
 * Time: 下午5:43
 */
use yii\helpers\Url;

?>
<?php foreach ($questionList as $item) { ?>
    <div class="errWorkBox">
        <div class="errWorkCtn"><a style="color: #000"
                    href="<?= Url::to(['/web/weakness/error-questions/question-info', 'questionId' => $item->questionId, 'date' => $date]); ?>"><?= $item->content; ?></a>
        </div>
        <div class="gradeStart">
            <?php
            $str = '<img src="' . BH_CDN_RES . '/static/img/gradeStart.png">';
            switch ($item->difficult) {
                case 21101:
                    echo $str . '<span>容易</span>';
                    break;
                case 21102:
                    echo $str . $str . '<span>较易</span>';
                    break;
                case 21103:
                    echo $str . $str . $str . '<span>一般</span>';
                    break;
                case 21104:
                    echo $str . $str . $str . $str . '<span>较难</span>';
                    break;
                case 21105:
                    echo $str . $str . $str . $str . $str . '<span>困难</span>';
                    break;
                default:
                    echo $str . '<span>容易</span>';
            }
            ?>
            <p><?= date("Y", strtotime($item->wrongTime)) . '/' . date("m", strtotime($item->wrongTime)) . '/' . date("d", strtotime($item->wrongTime)) ?></p>
        </div>
    </div>
<?php } ?>