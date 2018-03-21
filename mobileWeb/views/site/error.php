<?php
/* @var $this yii\web\View */
/* @var $error array */

$this->title = 'Error';


?>



<?php
/* @var $this yii\web\View */
use frontend\components\CHtmlExt;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '走丢了';
?>

<!doctype html>
<html id="html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=7;IE=9;IE=8;IE=10;IE=11;IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="班海,班海网,班海平台,banhai,学校,教师,学生,老师,当周问题,当周解决"/>
    <meta name="description"
          content="班海网专注K12中小学在线教育，是基于移动互联网技术、云技术、语言交互技术而创建的最专业的中小学教学管理平台，力求当周问题当周解决，为全国5000多所学校提供全方位的教学管理解决方案。"/>
    <meta name="x5-fullscreen" content="true">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
        }

        .header {
            height: 60px;
            background-color: #0099ff;
        }

        .header img {
            width: 40px;
            margin-top: 10px;
        }

        p {
            margin-top: 100px;
            text-align: center;
        }
    </style>

</head>
<body>
<div class="header">
    <img src="<?php BH_CDN_RES ?>/static/img/errBack.png" id="back">
</div>

<?php if (isset($code) && ($code == 401)) { ?>
<?php } else { ?>
    <p><?php echo isset($message) ? $message : "内容走丢了    <span>...</span>" ?>  </p>
<?php } ?>
<script type="text/javascript">
    document.getElementById('back').addEventListener('touchend', function () {
        try {
            if (BHWEB.pop && typeof(BHWEB.pop) === "function") {
                BHWEB.pop();
            } else {
                history.back();
                return false;
            }
        }
        catch(err) {
            history.back();
            return false;
        }
    }, false);

    <?php if (isset($code) && ($code == 401)) { ?>
        BHWEB.tokenInvalid();
    <?php } ?>
</script>
</body>
</html>