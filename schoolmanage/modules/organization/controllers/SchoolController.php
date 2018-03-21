<?php
declare(strict_types=1);
namespace schoolmanage\modules\organization\controllers;

use common\helper\DateTimeHelper;
use common\models\pos\SeSchoolInfo;
use common\models\pos\SeSchoolSummary;
use schoolmanage\components\SchoolManageBaseAuthController;
use Yii;
use yii\web\UploadedFile;

/**
 * Created by PhpStorm.
 * User: 邓奇文
 * Date: 2016/9/27
 * Time: 10:39
 */
class SchoolController extends SchoolManageBaseAuthController
{
    public $layout = 'lay_organization_index';
    public $enableCsrfValidation = false;

    /**
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionIndex()
    {
        $schoolID = $this->schoolId;
        $seSchoolInfoModel = SeSchoolInfo::find()->where(['schoolID' => $schoolID])->one();
        $brief = '';
        $seSchoolSummaryModel = SeSchoolSummary::find()->where(['schoolID' => $schoolID])->one();
        if(!empty($seSchoolSummaryModel)){
            $brief = $seSchoolSummaryModel->brief;
        }

        return $this->render('index',['seSchoolInfoModel' => $seSchoolInfoModel, 'brief' => $brief]);
    }


    /**
     * 编辑页面
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionModifySchoolSummary()
    {
        $this->layout = '@app/views/layouts/main';
        $schoolID = $this->schoolId;
        $seSchoolInfoModel = SeSchoolInfo::find()->where(['schoolID' => $schoolID])->one();
        $seSchoolSummaryModel = SeSchoolSummary::find()->where(['schoolID' => $schoolID])->one();
        if(empty($seSchoolSummaryModel)){
            $seSchoolSummaryModel = new SeSchoolSummary();
        }
        if ($_POST) {
            $schoolData = app()->request->getBodyParams();
            if(empty($schoolData['SeSchoolSummary'])){
                $brief = '';
            }else{
                $brief = $schoolData['SeSchoolSummary']['brief'];
            }
            //去掉学校简介html标签
            $brieflength = strip_tags($brief);
            if(mb_strlen($brieflength) > 10000){
                \Yii::$app->getSession()->setFlash('error','学校简介不允许超过10000字');
                return $this->render('modify_school', ['seSchoolInfoModel' => $seSchoolInfoModel, 'seSchoolSummaryModel' => $seSchoolSummaryModel]);
            }
            if(empty($seSchoolSummaryModel->createTime)){
                $seSchoolSummaryModel->schoolID = $schoolID;
                $seSchoolSummaryModel->brief = $brief;
                $seSchoolSummaryModel->creatorID = user()->id;
                $seSchoolSummaryModel->status = 1;
                $seSchoolSummaryModel->createTime = DateTimeHelper::timestampX1000();
                $seSchoolSummaryModel->save(false);
            }else{
                $seSchoolSummaryModel->schoolID = $schoolID;
                $seSchoolSummaryModel->brief = $brief;
                $seSchoolSummaryModel->creatorID = user()->id;
                $seSchoolSummaryModel->status = 1;
                $seSchoolSummaryModel->updateTime = DateTimeHelper::timestampX1000();
                $seSchoolSummaryModel->save(false);
            }
        }
        $logoUrl = $seSchoolInfoModel->logoUrl;
        if ($seSchoolInfoModel->load(Yii::$app->request->post())){
            $files = UploadedFile::getInstances($seSchoolInfoModel, 'logoUrl');
            if (!empty($files)) {
                $file = $files[0];
                $name = $this->img($file);
                if(!$name)
                {
                    \Yii::$app->getSession()->setFlash('error','图片大小超过100KB或者类型不符合要求');
                    return $this->render('modify_school', ['seSchoolInfoModel' => $seSchoolInfoModel, 'seSchoolSummaryModel' => $seSchoolSummaryModel,'logoUrl'=>$logoUrl]);
                }
                $logoUrl = '/uploads/school/' . date('Ymd', time()) . '/'.$name;
            }
            $seSchoolInfoModel->logoUrl = $logoUrl;
            $seSchoolInfoModel->save(false);
            return $this->redirect(['index']);
        }
        return $this->render('modify_school', ['seSchoolInfoModel' => $seSchoolInfoModel, 'seSchoolSummaryModel' => $seSchoolSummaryModel,'logoUrl'=>$logoUrl]);
    }


    /**图片上传
     * @param UploadedFile $file
     * @return bool|string
     * @throws \yii\base\InvalidParamException
     */
    public function img(UploadedFile $file){
        //图片类型
        $allowMime = array('image/jpeg', 'image/jpg', 'image/png','image/pjpeg','image/x-png');
        if (!in_array($file->type, $allowMime,false)) {
            return false;
        }
        if ($file->size > 102400){
            return false;
        }
        //目录
        $upload_path = \Yii::getAlias('@webroot') . '/uploads/school/' . date('Ymd', time()) . '/';
        if (!file_exists($upload_path) && !mkdir($upload_path, 0777, true)) {
            return false;
        }
        //文件名
        $name = date('YmdHis') . $this->schoolId . '.' . $file->extension;
        $bool = move_uploaded_file($file->tempName, $upload_path . $name);
        if($bool)
        {
            return $name;
        }
        return false;
    }


}