<?php
/**
 * Created by PhpStorm.
 * User: mahongru
 * Date: 15-8-19
 * Time: 下午6:01
 */
use yii\helpers\Url;

/* @var $this yii\web\View */  $this->title="视频库";
$searchArr = array(

    'grade' => app()->request->getParam('grade',$grade),
    'subjectid' => app()->request->getParam('subjectid',$subjectid),
    'province' => app()->request->getParam('province',$province),
    // 'type' => app()->request->getParam('type',$type),
    'year' => app()->request->getParam('year',$year),

);

?>
<!--主体-->
<div class="grid_24 main_r">
    <div class="main_cont video_library">
        <div class="title">
            <h4>视频库</h4>
        </div>
        <div class="subTitle_r pr">
        </div>
        <div class="form_list no_padding_form_list">
                    <div class="row">
                        <div class="formR">
                            <ul class="resultList testClsList" >
                                <li class="<?php echo '' == app()->request->getParam('subjectid', $subjectid) ? 'ac' : ''; ?>">
                                    <a href="<?php echo Url::to(array_merge(['/terrace/videopaper'],$searchArr, array('subjectid' => ''))) ?>">全部学科</a>
                                </li>
                                <li class="<?php echo '10011' == app()->request->getParam('subjectid', $subjectid) ? 'ac' : ''; ?>">
                                    <a href="<?php echo Url::to(array_merge(['/terrace/videopaper'],$searchArr, array('subjectid' => '10011'))) ?>">数学</a>
                                </li>
                                <li class="<?php echo '10014' == app()->request->getParam('subjectid', $subjectid) ? 'ac' : ''; ?>">
                                    <a href="<?php echo Url::to(array_merge(['/terrace/videopaper'],$searchArr, array('subjectid' => '10014'))) ?>">物理</a>
                                </li>
                                <li class="<?php echo '10015' == app()->request->getParam('subjectid', $subjectid) ? 'ac' : ''; ?>">
                                    <a href="<?php echo Url::to(array_merge(['/terrace/videopaper'], array_merge($searchArr, array('subjectid' => '10015')))) ?>">化学</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="formR">
                            <ul class="resultList testClsList" >
                                <li class="<?php echo '' == app()->request->getParam('grade', $grade) ? 'ac' : ''; ?>">
                                    <a href="<?php echo Url::to(array_merge(['/terrace/videopaper'],$searchArr, array('grade' => ''))) ?>">全部类型</a>
                                </li>
                                <li class="<?php echo '20202' == app()->request->getParam('grade', $grade) ? 'ac' : ''; ?>">
                                    <a href="<?php echo Url::to(array_merge(['/terrace/videopaper'],$searchArr, array('grade' => '20202'))) ?>">中考真题</a>
                                </li>
                                <li class="<?php echo '20203' == app()->request->getParam('grade', $grade) ? 'ac' : ''; ?>">
                                    <a href="<?php echo Url::to(array_merge(['/terrace/videopaper'],$searchArr, array('grade' => '20203'))) ?>">高考真题</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="formR">
                            <ul class="resultList testClsList" >
                                <li class="<?php echo '' == app()->request->getParam('year', $year) ? 'ac' : ''; ?>">
                                    <a href="<?php echo Url::to(array_merge(['/terrace/videopaper'],$searchArr, array('year' => ''))) ?>">全部年份</a>
                                </li>
                                <li class="<?php echo '2015' == app()->request->getParam('year', $year) ? 'ac' : ''; ?>">
                                    <a href="<?php echo Url::to(array_merge(['/terrace/videopaper'],$searchArr, array('year' => '2015'))) ?>">2015</a>
                                </li>
                                <li class="<?php echo '2014' == app()->request->getParam('year', $year) ? 'ac' : ''; ?>">
                                    <a href="<?php echo Url::to(array_merge(['/terrace/videopaper'],$searchArr, array('year' => '2014'))) ?>">2014</a>
                                </li>
                                <li class="<?php echo '2013' == app()->request->getParam('year', $year) ? 'ac' : ''; ?>">
                                    <a href="<?php echo Url::to(array_merge(['/terrace/videopaper'],$searchArr, array('year' => '2013'))) ?>">2013</a>
                                </li>
                                <li class="<?php echo '2012' == app()->request->getParam('year', $year) ? 'ac' : ''; ?>">
                                    <a href="<?php echo Url::to(array_merge(['/terrace/videopaper'],$searchArr, array('year' => '2012'))) ?>">2012</a>
                                </li>
                                <li class="<?php echo '2011' == app()->request->getParam('year', $year) ? 'ac' : ''; ?>">
                                    <a href="<?php echo Url::to(array_merge(['/terrace/videopaper'],$searchArr, array('year' => '2011'))) ?>">2011</a>
                                </li>
                                <li class="<?php echo '2010' == app()->request->getParam('year', $year) ? 'ac' : ''; ?>">
                                    <a href="<?php echo Url::to(array_merge(['/terrace/videopaper'],$searchArr, array('year' => '2010'))) ?>">2010</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="formR">
                            <ul class="resultList testClsList" >
                                <li class="<?php echo '' == app()->request->getParam('province', $province) ? 'ac' : ''; ?>">
                                    <a href="<?php echo Url::to(array_merge(['/terrace/videopaper'],$searchArr, array('province' => ''))) ?>">全部省份</a>
                                </li>
                                <?php foreach($provinces as $key => $province) : ?>
                                    <?php if($key < 31) : ?>
                                <li class="<?php echo $province->AreaName == app()->request->getParam('province', $province) ? 'ac' : ''; ?>">
                                    <a href="<?php echo Url::to(array_merge(['/terrace/videopaper'],$searchArr, array('province' => $province->AreaName))) ?>"><?= $province->AreaName; ?></a>
                                </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="problem_box videos_box clearfix">
                    <div class="grid_18 omega alpha videobox_con">
                        <div class="tab video_library_con">
                            <div class="tabCont">
                                <div class="tabItem">

                                    <div id="video">
                                        <?php echo $this->render('_list_video',array('pages' => $pages,'papers'=>$papers))?>
                                    </div>
                                </div>
                                <div class="tabItem hide"> </div>
                                <div class="tabItem hide"> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>
    <!--主体end-->