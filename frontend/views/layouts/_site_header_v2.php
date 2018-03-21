<?php
use common\models\pos\SeClassMembers;
use frontend\components\helper\ImagePathHelper;
use common\components\WebDataCache;
use yii\helpers\Url;


/* @var $this yii\web\View */

$r = $this->context->getRoute();
$g = $this->context->getUniqueId();

$key = user()->id . '_' . $r . '_' . $g;

$userModel = loginUser();
$userId = $userModel->userID;

$classArr = $userModel->getClassInfoCache();
$schoolid = $userModel->schoolID;

if (loginUser()->isStudent()) {
	$homeUrl = url('student/setting/my-center');
	$msgUrl = url('student/message/message-list?show=sendwin');
	$userSetUrl = url('student/setting/basic-information');
	$userUrl = Url::to(['/student/default/index', 'studentId' => $userId]);
}
if (loginUser()->isTeacher()) {
	$homeUrl = url('teacher/setting/personal-center');
	$msgUrl = url('teacher/message/message-list?show=sendwin');
	$userSetUrl = url('teacher/setting/basic-information');
	$userUrl = Url::to(['/teacher/default/index', 'teacherId' => $userId]);
}

?>
<style>
    .gnn_QRCode{
        z-index: 30;
        width: 360px;
        height: 400px;
        position: absolute;
        right: 280px;
        background-color: #fff;
        text-align: center;
        transform: scale(0);
        animation: one 1s forwards;
    }
    @keyframes one {
        100%{
            transform: scale(1);
        }
    }
    .gnn_QRCode h2{
        font-weight: normal;
        margin: 0;
        font-size: 16px;
        height: 70px;
        line-height: 70px;
    }
    .gnn_QRCode hr{
        margin: 0 0 0 -130px;
        width: 260px;
        border-bottom-color:#d7f2fc ;
        position: absolute;
        top: 50%;
        left: 50%;
    }
    .gnn_QRCode:hover{
        cursor: pointer;
    }
</style>
<?php if(strpos($userModel->phoneReg,'he_') !== false){?>
    <div style="height: 30px;width:1200px;margin:auto;">
        <span>为给您提供最佳的用户体验，我们强烈建议您下载使用班海APP。下载后请使用【账号：<?php echo $userModel->phoneReg;?>】【初始默认密码：123456】登录 </span>
        <a id="downloadQR" href="javascript:;" style="margin: 60px">马上下载</a>
    </div>

    <div class="gnn_QRCode pop" id="gnn_QRCode" style="display: none">
        <h2>教师客户端扫码安装</h2>
        <img style="width: 115px" src="<?php echo BH_CDN_RES.'/static'?>/images/gnn_QRCode_teacher.png">
        <hr/>
        <h2>学生客户端扫码安装</h2>
        <img style="width: 115px" src="<?php echo BH_CDN_RES.'/static'?>/images/gnn_QRCode_student.png">
    </div>
    <script>
        $(function(){
            $("#downloadQR").click(function () {
                $("#gnn_QRCode").slideToggle();

            });
        })
    </script>
<?php }?>
<div class="headWrap">
	<div class="col1200">
		<div class="head">
			<a><h1>班海网</h1></a>
			<?php if (!user()->isGuest) { ?>
				<ul class="head_nav">
					<li>
                        <?php if (loginUser()->isTeacher()) { ?>
						<a class="has_subMenu  <?= $this->context->highLightUrl(['platform/question/keywords-choose', 'platform/question/chapter-choose', 'platform/question/knowledge-choose', 'platform/video/list', 'platform/video/index', 'platform/video/detail', 'platform/managetask/index']) ? 'ac' : '' ?>"
						   href="javascript:;">教学资源<i></i></a>
						<ul class="subMenu hide">
								<li>
									<a class="<?= $this->context->highLightUrl(['platform/question/keywords-choose', 'platform/question/chapter-choose', 'platform/question/knowledge-choose'], $r) ? 'ac' : '' ?>"
									   href="<?= url('platform/question/chapter-choose') ?>">试题库</a></li>
								<li><a class="<?= $g == 'platform/file' ? 'ac' : '' ?>"
								       href="<?= url('/platform/file') ?>">课件库</a></li>
								<li><a class="<?= $g == 'platform/managetask' ? 'ac' : '' ?>"
								       href="<?= url('/platform/managetask/index') ?>">作业库</a>
								</li>
						</ul>
                        <?php } ?>
					</li>
					<li><a class="has_subMenu tacit" href="javascript:;">班海应用<i></i></a>
						<ul class="subMenu hide">
							<li>
								<a class="<?= $this->context->highLightUrl(['platform/answer/index'], $r) ? 'ac' : '' ?>"
								   href="<?= url('platform/answer/index') ?>">问题答疑</a>
							</li>
							<?php if (loginUser()->isTeacher()) { ?>
								<li><a class="" href="http://zixun.banhai.com">班海资讯</a></li>
							<?php } ?>
						</ul>
					</li>
					<li><a class="has_subMenu tacit <?= $g == 'school' ? 'ac' : '' ?>"
					       href="<?= url('school/index', array('schoolId' => $schoolid)); ?>">学校</a>
					</li>
					<li><a class="has_subMenu tacit">班级帮<i></i></a>
						<ul class="subMenu hide">
							<li>
								<?php foreach ($classArr as $valClass) { ?>
									<a class="<?= $this->context->highLightUrl(['classes/managetask/details', 'class/work-detail', 'workstatistical/work-statistical-student', 'workstatistical/work-statistical-topic', 'workstatistical/work-statistical-all', 'class/index', 'class/homework', 'class/member-manage', 'class/class-file', 'class/answer-questions', 'class/memorabilia', 'class/add-memorabilia', 'class/memorabilia-album'], $r) ? 'ac' : '' ?>"
									   href="<?= url('class/index', array('classId' => $valClass->classID)); ?>"
									   title="<?= $valClass->className ?>"><?= $valClass->className ?></a>
								<?php } ?>
							</li>
						</ul>
					</li>
                    <?php if (loginUser()->isTeacher()){?>
                        <li>
                            <a href="javascript:;" id="materialShow">资源投屏</a>
                        </li>
                    <?php }?>
				</ul>
				<div class="userCenter">
					<div class="userChannel">

						<div class="centerBox">
							<i></i>
							<ul class="personal_center">
								<li>
									<a class="<?= $this->context->highLightUrl(['teacher/setting/personal-center'], $r) ? 'ac' : '' ?>"
									   href="<?= $homeUrl ?>"><i class="center_pep"></i>个人中心</a>
								</li>
								<li>
									<a href="<?= $userUrl ?>"><i class="center_space"></i>我的空间</a>
								</li>
								<li>
									<a href="<?= $userSetUrl ?>"><i class="center_set"></i>账号设置</a>
								</li>
								<li>
									<a href="<?= url('site/logout') ?>" class="logOff"><i
											class="center_quit"></i>退出登录</a>
								</li>
							</ul>
						</div>
						<a class="userName" href="<?= $homeUrl ?>" title="<?= loginUser()->getTrueName() ?>">
							<img
								src="<?= ImagePathHelper::imgThumbnail(WebDataCache::getFaceIconUserId(user()->id), 70, 70) ?>"
								style="vertical-align: middle;" data-type="header" onerror="userDefImg(this);"/>
							<?= loginUser()->getTrueName() ?>
						</a>
					</div>
					<a class="help" href="http://www.banhai.com/pub/help/focus_map_video.html" title="帮助"></a>
				</div>
			<?php } ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function () {
		$(document).ready(function (sumCnt, priMsg, notice, sysMsg) {
			$.get("<?php echo url("/ajax/msg-num")?>", {}, function (data) {
				$("#messageCount").html("(" + data.sumCnt + ")");

				if (data.notice > 99) {
					$("#messageNotice").html("99+");
					$("#messageNotice").css("color", "#ff0000");
				} else {
					$("#messageNotice").html(data.notice);
					$("#messageNotice").css("color", "#11ADE6");
				}


				if (data.sysMsg > 99) {
					$("#messageSys").html("99+");
					$("#messageSys").css("color", "#ff0000");
				} else {
					$("#messageSys").html(data.sysMsg);
					$("#messageSys").css("color", "#11ADE6");
				}

				if (data.sumCnt > 99) {
					$(".sysMsg").addClass("over99");
				}
			});
		});

		//资源投屏
		$("#materialShow").click(function () {
            window.open("https://tp.banhai.com/");
        })
	})
</script>

