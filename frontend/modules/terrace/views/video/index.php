<?php
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-11-18
 * Time: 上午10:04
 */
/* @var $this yii\web\View */  $this->title="视频库";
$searchArr = array(

    //'gradeid' => app()->request->getParam('gradeid',$gradeid),
    'subjectid' => app()->request->getParam('subjectid',$subjectid),
   // 'type' => app()->request->getParam('type',$type),
    'year' => app()->request->getParam('year',$year),

);

?>

<script>
    $(function(){
        $('.tree').tree({openSubMenu:true,operate:false});
        $('.orderBar span').click(function(){
            $(this).addClass('ac').siblings().removeClass('ac');
        });

        $('.searchBtn').click(function(){
            var videoName = $('#searchText').val();
            var gradeid = '<?= app()->request->getParam('gradeid', $gradeid)?>';
            var subjectid = '<?= app()->request->getParam('subjectid', $subjectid)?>';
            var type = '<?= app()->request->getParam('type', $type)?>';
            var year = '<?= app()->request->getParam('year', $year)?>';
            location.href = '<?= url("terrace/video");?>'+'?gradeid='+gradeid+'&subjectid='+subjectid+'&type='+type+'&year='+year+'&videoName='+videoName;
        });


        $('.subTitleBar_text').placeholder({value:'视频名称',ie6Top:10})
    })
</script>
<div class="grid_24 main_center">
    <div class="main_cont video_store">
        <div class="title">
            <h4>视频库</h4>
            <div class="title_r">
                <!--<input id="searchText" tabindex="-1" type="text" class="text searchText" name="videoName" value="<?/*=$videoName*/?>">
                <button type="button" class="hideText searchBtn">搜索</button>-->
            </div>
        </div>
        <div class="form_list">
            <div class="row">
                <div class="formR">
                    <ul class="resultList" >
                        <input id="searchText" tabindex="-1" type="text" class="text searchText subTitleBar_text" name="videoName" value="<?=$videoName?>" style="width:550px">
                        <button type="button" class="hideText searchBtn search">搜索视频</button>
                    </ul>
                </div>
            </div>
            <!--<div class="row">
                <div class="formR">
                    <ul class="resultList" >
                        <li><a href="#">知识点选视频</a></li>
                        <li class="ac"><a href="#">试卷选视频</a></li>
                    </ul>
                </div>
            </div>-->
            <!--<div class="row">
                <div class="formR">
                    <ul class="resultList" >
                        <li class="<?php /*echo '' == app()->request->getParam('gradeid', $gradeid) ? 'ac' : ''; */?>">
                            <a href="<?php /*echo url('terrace/video', array_merge($searchArr, array('gradeid' => ''))) */?>">全部年级</a>
                        </li>
                        <?php
/*                        $grade = GradeModel::model()->getList();
                        foreach($grade as $val){
                            */?>
                            <li class="<?php /*echo $val->gradeName == app()->request->getParam('gradeid', $gradeid) ? 'ac' : ''; */?>">
                                <a href="<?php /*echo url('terrace/video', array_merge($searchArr, array('gradeid' => $val->gradeName))) */?>"><?/*= $val->gradeName*/?></a>
                            </li>
                        <?php /*}*/?>
                    </ul>
                </div>
            </div>-->
            <div class="row">
                <!--<div class="formL">
                    <label>学科:</label>
                </div>-->
                <div class="formR" style="max-width: 1140px;">
                    <ul class="resultList" >
                        <li class="<?php echo '' == app()->request->getParam('subjectid', $subjectid) ? 'ac' : ''; ?>">
                            <a href="<?php echo url('terrace/video', array_merge($searchArr, array('subjectid' => ''))) ?>">全部科目</a>
                        </li>
                        <?php
/*                        $subject = SubjectModel::model()->getData();
                        foreach($subject as $val){
                            */?><!--
                            <li class="<?php /*echo $val->value == app()->request->getParam('subjectid', $subjectid) ? 'ac' : ''; */?>">
                                <a href="<?php /*echo url('terrace/video', array_merge($searchArr, array('subjectid' => $val->value))) */?>"><?/*= $val->value*/?></a>
                            </li>
                        --><?php /*}*/?>


                        <li class="<?php echo '数学' == app()->request->getParam('subjectid', $subjectid) ? 'ac' : ''; ?>">
                            <a href="<?php echo url('terrace/video', array_merge($searchArr, array('subjectid' => '数学'))) ?>"><?= '数学'?></a>
                        </li>
                        <li class="<?php echo '物理' == app()->request->getParam('subjectid', $subjectid) ? 'ac' : ''; ?>">
                            <a href="<?php echo url('terrace/video', array_merge($searchArr, array('subjectid' => '物理'))) ?>"><?= '物理'?></a>
                        </li>
                        <li class="<?php echo '化学' == app()->request->getParam('subjectid', $subjectid) ? 'ac' : ''; ?>">
                            <a href="<?php echo url('terrace/video', array_merge($searchArr, array('subjectid' => '化学'))) ?>"><?= '化学'?></a>
                        </li>
                    </ul>
                </div>
            </div>
            <!--<div class="row">
                <div class="formR">
                    <ul class="resultList" >
                        <li class="<?php /*echo '' == app()->request->getParam('type', $subjectid) ? 'ac' : ''; */?>">
                            <a href="<?php /*echo url('terrace/video', array_merge($searchArr, array('type' => ''))) */?>">全部类型</a>
                        </li>
                        <li class="<?php /*echo '小升初' == app()->request->getParam('type', $type) ? 'ac' : ''; */?>">
                            <a href="<?php /*echo url('terrace/video', array_merge($searchArr, array('type' => '小升初'))) */?>">小升初</a>
                        </li>
                        <li class="<?php /*echo '月考' == app()->request->getParam('type', $type) ? 'ac' : ''; */?>">
                            <a href="<?php /*echo url('terrace/video', array_merge($searchArr, array('type' => '月考'))) */?>">月考</a>
                        </li>
                        <li class="<?php /*echo '一模' == app()->request->getParam('type', $type) ? 'ac' : ''; */?>">
                            <a href="<?php /*echo url('terrace/video', array_merge($searchArr, array('type' => '一模'))) */?>">一模</a>
                        </li>
                        <li class="<?php /*echo '二模' == app()->request->getParam('type', $type) ? 'ac' : ''; */?>">
                            <a href="<?php /*echo url('terrace/video', array_merge($searchArr, array('type' => '二模'))) */?>">二模</a>
                        </li>
                        <li class="<?php /*echo '中考' == app()->request->getParam('type', $type) ? 'ac' : ''; */?>">
                            <a href="<?php /*echo url('terrace/video', array_merge($searchArr, array('type' => '中考'))) */?>">中考</a>
                        </li>
                        <li class="<?php /*echo '高考' == app()->request->getParam('type', $type) ? 'ac' : ''; */?>">
                            <a href="<?php /*echo url('terrace/video', array_merge($searchArr, array('type' => '高考'))) */?>">高考</a>
                        </li>

                    </ul>
                </div>
            </div>-->
            <div class="row">
                <!--<div class="formL">
                    <label>年份:</label>
                </div>-->
                <div class="formR" style="max-width: 1140px;">
                    <ul class="resultList" >
                        <li class="<?php echo '' == app()->request->getParam('year', $year) ? 'ac' : ''; ?>">
                            <a href="<?php echo url('terrace/video', array_merge($searchArr, array('year' => ''))) ?>">全部年份</a>
                        </li>
                        <!--<li class="<?php /*echo '2010' == app()->request->getParam('year', $year) ? 'ac' : ''; */?>">
                            <a href="<?php /*echo url('terrace/video', array_merge($searchArr, array('year' => '2010'))) */?>">2010</a>
                        </li>
                        <li class="<?php /*echo '2011' == app()->request->getParam('year', $year) ? 'ac' : ''; */?>">
                            <a href="<?php /*echo url('terrace/video', array_merge($searchArr, array('year' => '2011'))) */?>">2011</a>
                        </li>
                        <li class="<?php /*echo '2012' == app()->request->getParam('year', $year) ? 'ac' : ''; */?>">
                            <a href="<?php /*echo url('terrace/video', array_merge($searchArr, array('year' => '2012'))) */?>">2012</a>
                        </li>-->
                        <li class="<?php echo '2013' == app()->request->getParam('year', $year) ? 'ac' : ''; ?>">
                            <a href="<?php echo url('terrace/video', array_merge($searchArr, array('year' => '2013'))) ?>">2013</a>
                        </li>
                        <li class="<?php echo '2014' == app()->request->getParam('year', $year) ? 'ac' : ''; ?>">
                            <a href="<?php echo url('terrace/video', array_merge($searchArr, array('year' => '2014'))) ?>">2014</a>
                        </li>
                        <!--<li class="<?php /*echo '2015' == app()->request->getParam('year', $year) ? 'ac' : ''; */?>">
                            <a href="<?php /*echo url('terrace/video', array_merge($searchArr, array('year' => '2015'))) */?>">2015</a>
                        </li>-->
                    </ul>
                </div>
            </div>

        </div>
        <div class="problem_box clearfix clearBoth">
            <div class="omega alpha">
                <div class="tab pr">
                    <ul class="tabList clearfix">
                        <li><a href="javascript:;" class="ac">视频库</a></li>
                    </ul>
                    <div class="tabCont">
                        <div class="tabItem">
                            <div class="title item_title noBorder">
                                <h4 class="green" style="width: auto;">全部视频(<?= $pages->totalCount?>)</h4>
                            </div>
                            <!--<div class="orderBar" style="width:1120px;">
                                &nbsp;&nbsp;&nbsp;排序&nbsp;&nbsp;&nbsp;发布时间:<span class="up_seq"></span><span class="down_seq"></span>
                            </div>-->
                            <div id="video">
                                <?php echo $this->render('_list_video',array('pages' => $pages,'model'=>$model))?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



