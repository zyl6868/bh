<?php
/**
 * Created by unizk.
 * User: ysd
 * Date: 2015/4/30
 * Time: 11:06
 */
/* @var $this yii\web\View */
$this->title = '班级文件';
use common\models\dicmodels\FileModel;
use common\models\dicmodels\GradeModel;
use common\models\dicmodels\SubjectModel;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


$searchArr = array(
    'classId' => $classId,
    'mattype' => $mattype,
    'gradeid' => $gradeid,
    'subjectid' => $subjectid,
    'fileName' => $fileName
);
$departmentId = loginUser()->getModel()->department;
$this->blocks['requireModule']='app/classes/classes_file';
?>

<div class="main classes_file col1200 clearfix" id="requireModule" rel="app/classes/classes_file">
    <div class="container classify">
        <div class="pd25">
            <div class="tc seFile">
                <?php $form = ActiveForm::begin(['id' => 'searchName' , 'method'=>'get' , 'action'=>Url::to([app()->request->url])]); ?>
                    <span class="sUI_searchBar sUI_searchBar_max">
                        <input type="text" class="text " id="mainSearch" name="fileName" value="<?= \yii\helpers\Html::encode($fileName)?>">
                        <button type="submit" class="searchBtn">搜索</button>
                    </span>
                <?php ActiveForm::end();?>
            </div>
            <?php
            if(!empty($subjectid) || !empty($gradeid) || !empty($mattype)){?>
            <div id="classes_file_crumbs" class="classes_file_crumbs">
                所选分类 >
                <?php if(!empty($subjectid)){?>
                    <span>科目:<em><?= SubjectModel::model()->getName((int)$subjectid)?></em>
                            <a href="<?php echo url('class/class-file', array_merge($searchArr, array('subjectid' => ''))) ?>"><i>×</i></a></span>
                <?php }?>

                <?php if(!empty($gradeid)){?>
                    <span>年级:<em><?= GradeModel::model()->getGradeName($gradeid)?></em>
                        <a href="<?php echo url('class/class-file', array_merge($searchArr, array('gradeid' => ''))) ?>"><i>×</i></a></span>
                <?php }?>

                <?php if(!empty($mattype)){?>
                    <span>类型:<em><?= FileModel::model()->getName($mattype)?></em>
                        <a href="<?php echo url('class/class-file', array_merge($searchArr, array('mattype' => ''))) ?>"><i>×</i></a></span>
                <?php }?>
            </div>
            <?php } ?>
            <div class="sUI_formList sUI_formList_min classes_file_list">
                <div class="row  classes_sel_list">
                    <div class="form_l tl">
                        <a class="<?php echo '' == app()->request->getParam('subjectid', $subjectid) ? 'sel_ac' : ''; ?>" data-sel-item
                           href="<?php echo url('class/class-file', array_merge($searchArr, array('subjectid' => ''))) ?>">全部科目</a>
                    </div>
                    <div class="form_r  moreContShow">

                        <ul>

                            <?php
                            $i = 0;
                            $subject = SubjectModel::model()->getSubjectByDepartment($departmentId);
                            foreach($subject as  $val){
                                ++$i;
                                ?>
                                <li>
                                    <a class="<?php echo $val->secondCode == app()->request->getParam('subjectid', $subjectid) ? 'sel_ac' : ''; ?>" data-sel-item
                                       href="<?php echo url('class/class-file', array_merge($searchArr, array('subjectid' => $val->secondCode))) ?>"><?= $val->secondCodeValue?></a>
                                </li>
                            <?php
                                if($i == 9){echo '<br />';}
                            }?>
                        </ul>

                        <?php if(count($subject) > 9){?>
                        <a class="showMoreBtn" href="javascript:;">更多<i></i></a>
                        <?php }?>
                    </div>
                </div>
                <div class="row  classes_sel_list">
                    <div class="form_l tl">
                        <a class="<?php echo '' == app()->request->getParam('gradeid', $gradeid) ? 'sel_ac' : ''; ?>" data-sel-item
                            href="<?php echo url('class/class-file', array_merge($searchArr, array('gradeid' => ''))) ?>">全部年级</a>
                    </div>
                    <div class="form_r moreContShow">
                        <a class="showMoreBtn" href="javascript:;">更多<i></i></a>
                        <ul>
                            <?php
                            $grade = GradeModel::model()->getWithList($departmentId,'');
                            foreach($grade as $val){
                                ?>
                                <li>
                                    <a class="<?php echo $val['gradeId'] == app()->request->getParam('gradeid', $gradeid) ? 'sel_ac' : ''; ?>" data-sel-item
                                       href="<?php echo url('class/class-file', array_merge($searchArr, array('gradeid' => $val['gradeId']))) ?>"><?= $val['gradeName']?></a>
                                </li>
                            <?php }?>
                        </ul>
                    </div>
                </div>
                <div class="row  classes_sel_list">
                    <div class="form_l tl">
                        <a class="<?php echo '' == app()->request->getParam('mattype', $mattype) ? 'sel_ac' : ''; ?>" data-sel-item
                           href="<?php echo url('class/class-file', array_merge($searchArr, array('mattype' => ''))) ?>">全部类型</a>
                    </div>
                    <div class="form_r moreContShow">
                        <a class="showMoreBtn" href="javascript:;">更多<i></i></a>
                        <ul>
                            <?php
                            $file = FileModel::model()->getList();
                            foreach($file as $val){
                                ?>
                                <li>
                                    <a class="<?php echo $val->secondCode == app()->request->getParam('mattype', $mattype) ? 'sel_ac' : ''; ?>" data-sel-item
                                       href="<?php echo url('class/class-file', array_merge($searchArr, array('mattype' => $val->secondCode))) ?>"><?= $val->secondCodeValue?></a>
                                </li>
                            <?php }?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container no_bg">
        <div class="sUI_pannel sUI_pannel_bg bg_blue_l classes_fList">
            <div class="pannel_l clsoption_list">
                <span class="sort_a"><i class="bq1"></i>排序</span>
                    <span>
                        <a class="read <?php if(app()->request->get('sortType') == 'readNum'){echo 'cur';}?>" href="<?php echo url('class/class-file', array_merge($searchArr, array('sortType' => 'readNum'))) ?>"><i></i>阅读</a>
                    </span>
                    <span>
                        <a class="fav <?php if(app()->request->get('sortType') == 'favoriteNum'){echo 'cur';}?>" href="<?php echo url('class/class-file', array_merge($searchArr, array('sortType' => 'favoriteNum'))) ?>"><i></i>收藏</a>
                    </span>
                    <span>
                        <a class="download <?php if(app()->request->get('sortType') == 'downNum'){echo 'cur';}?>" href="<?php echo url('class/class-file', array_merge($searchArr, array('sortType' => 'downNum'))) ?>"><i></i>下载</a>
                    </span>
            </div>
        </div>
        <div id="classFile">
            <?php echo $this->render('_classfile_list', array('shareMaterialData'=>$shareMaterialData,'materialList' => $materialList, 'classId' => $classId, 'pages' => $pages)) ?>
        </div>

    </div>
</div>
