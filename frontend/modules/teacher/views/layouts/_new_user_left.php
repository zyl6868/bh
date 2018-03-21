<?php
/**
 * Created by wangchunlei
 * User: Administrator
 * Date: 15-4-13
 * Time: 上午9:55
 */
use frontend\components\helper\ImagePathHelper;

?>
<?php
//用户个人管理中心统计项查询
//$infoService = new pos_PersonalInformationService();
//$userItemCnt = $infoService->queryUserItemCnt(user()->id);
//$ClassInfoList=loginUser()->getClassInfo();

$classid = app()->request->getParam('classid')?app()->request->getParam('classid'):app()->request->getParam('classID');

?>
<div class="grid_5 main_l">
    <div class="clearfix item l_userInfo" style="height: auto;"><img data-type="header" onerror="userDefImg(this);"  width="230" height="230"
                                                                     src="<?php echo  ImagePathHelper::imgThumbnail(loginUser()->getFaceIcon(),220,220)  ?>">
    </div>
    <div class="item l_asideMenu">
        <!--        <h4>我的档案</h4>-->
        <ul class="setupMenu">

	        <li><a class="lisA noBg <?php echo $this->context->highLightUrl(['teacher/setting/personal-center', 'teacher/setting/change-password', 'teacher/setting/set-head-pic']) ? 'ac' : '' ?>"
                   href="<?php echo url('teacher/setting/personal-center') ?>"><i></i>个人中心</a>
            </li>
            <li><a class="lisA" href="javascript:"><i></i>我的积分</a>
                <ul class="subMenu hide">

                    <li>
                        <a class="<?php echo $this->context->highLightUrl(['teacher/integral/income-details']) ? 'ac' : '' ?>"
                           href="<?php echo url('teacher/integral/income-details') ?>">收入明细</a></li>

                    <li>
                        <a class="<?php echo $this->context->highLightUrl(['teacher/integral/my-ranking']) ? 'ac' : '' ?>"
                           href="<?php echo url('teacher/integral/my-ranking') ?>">我的积分</a></li>
                </ul>
            </li>

            <li>
                <a class="lisC noBg <?php echo $this->context->highLightUrl([ 'teacher/managetask/new-update-work-detail',
                    'teacher/managetask/new-fixup-work','teacher/managetask/new-update-work','teacher/managetask/new-correct-paper','teacher/managetask/organize-work-details-new']) ? 'ac' : '' ?>"
                   href="<?php echo url('teacher/resources/collect-work-manage');?>">作业</a>
            </li>

            <li>
                <a class="lisE noBg <?php echo $this->context->highLightUrl(['teacher/managepaper/index', 'teacher/managepaper/index','teacher/managepaper/upload-paper','teacher/makepaper/paper-subject',
                    'teacher/make-paper/index','teacher/make-paper/paper-structure','teacher/make-paper/paper-set-score']) ? 'ac' : '' ?>"
                   href="<?php echo url('teacher/managepaper/index'); ?>">试卷管理</a>
            </li>

            <li>
                <a class="noBg <?php echo $this->context->highLightUrl(['teacher/answer/my-questions', 'teacher/answer/view-test', 'teacher/answer/add-question', 'teacher/answer/update-question']) ? 'ac' : '' ?>"
                   href="<?php echo url('teacher/answer/my-questions') ?>">答疑</a></li>
        </ul>
    </div>
</div>