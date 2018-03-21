<?php
declare(strict_types = 1);
namespace frontend\controllers;

use common\clients\HomeworkPushService;
use common\clients\material\ChapterService;
use common\clients\material\MaterialMicroService;
use common\clients\material\MaterialSign;
use common\clients\OrganizationService;
use common\models\JsonMessage;
use common\models\pos\SeFavoriteMaterial;
use common\models\pos\SeHomeworkRel;
use common\models\pos\SeMaterialDownloadRecord;
use common\models\pos\SeUserControl;
use common\models\pos\SeUserinfo;
use common\models\sanhai\SrMaterial;
use common\clients\JfManageService;
use common\clients\UserPrivilegeService;
use common\clients\XuemiMicroService;
use Exception;
use frontend\components\BaseController;
use frontend\components\helper\AreaHelper;
use frontend\components\helper\ImagePathHelper;
use frontend\components\helper\TreeHelper;
use common\components\WebDataKey;
use common\models\dicmodels\ChapterInfoModel;
use common\models\dicmodels\LoadSubjectModel;
use common\models\dicmodels\LoadTextbookVersionModel;
use common\models\dicmodels\QueryTypeModel;
use common\models\dicmodels\SubjectModel;
use frontend\services\apollo\Apollo_BaseInfoService;
use frontend\services\BaseService;
use frontend\services\pos\pos_MessageSentService;
use frontend\services\pos\pos_UserRegisterService;
use Yii;
use yii\helpers\Html;


/**
 * Created by PhpStorm.
 * User: a
 * Date: 14-6-24
 * Time: 下午2:45
 */
class AjaxController extends BaseController
{

    /**
     * 队列名称
     */
    const  QUEUE_TYPE = 'queue_urge_home_work';

    /**
     *
     * 城市查询联动
     */
    public function actionGetArea($id)
    {
        echo Html::tag('option', '请选择', array('value' => ''));
        if (empty($id)) {
            return;
        }
        $data = AreaHelper::getList($id);
        foreach ($data as $item) {
            echo Html::tag('option', Html::encode($item["AreaName"]), array('value' => $item["AreaID"]));
        }


    }

    /**
     *
     * 城市查询联动
     */
    public function actionGetJsonArea($id)
    {
        $data = AreaHelper::getList($id);
        return $this->renderJSON($data);
    }

    /**
     *
     * 城市查询联动
     */
    public function actionGetJsonProvinceList()
    {
        $data = AreaHelper::getProvinceList();
        return $this->renderJSON($data);
    }

    /*
     * 根据年级查科目
     */
    public function actionGetItemForGrade($id)
    {
        echo Html::tag('option', '请选择', array('value' => ''));
        if (empty($id)) {
            return;
        }
        $obj = new Apollo_BaseInfoService();
        $data = $obj->loadSubjectByGrade($id, '');
        if ($data->resCode === BaseService::successCode) {
            foreach ($data->data->list as $item) {
                echo Html::tag('option', Html::encode($item->subjectName), array('value' => $item->subjectId));
            }
        }

    }

    /**
     * ajax检查手机号是否存在
     */
    public function actionCheckPhoneNum()
    {
        $_fieldId = $_GET['fieldId'];
        $phone = $_GET['fieldValue'];
        $info = SeUserinfo::find()->where(['bindphone' => $phone])->one();

        if ($info) {
            echo json_encode(array($_fieldId, false));
        } else {
            echo json_encode(array($_fieldId, true));
        }
    }

    /**
     * ajax检查验证码是否正确
     */
    public function actionCheckVerifycode()
    {
        $jsonResult = new JsonMessage();
        $verifycode = $_POST['verifycode'];
        $phoneNum = $_POST['mobile'];
        $userControl = SeUserControl::find()->where(['phoneReg' => $phoneNum])->orderBy('generateCodeTime desc')->one();
        if ($userControl) {
            $generateCodeTime = $userControl->generateCodeTime;
            if ((time() - $generateCodeTime / 1000) < 1800) {
                $activateMailCode = $userControl->activateMailCode;
                if ($verifycode != $activateMailCode) {
                    $jsonResult->success = true;
                    $jsonResult->message = '验证码错误!';
                }
            } else {
                $jsonResult->success = true;
                $jsonResult->message = '验证码已超时!';
            }

        } else {
            $jsonResult->success = true;
            $jsonResult->message = '验证码错误!';
        }
        return $this->renderJSON($jsonResult);
    }


    /**
     * 检查登录名是否存在
     */
    public function actionCheckLoginName()
    {
        $_fieldId = $_GET['fieldId'];
        $loginName = $_GET['fieldValue'];
        $info = SeUserinfo::find()->where(['phoneReg' => $loginName])->one();
        if ($info) {
            echo json_encode(array($_fieldId, false));
        } else {
            echo json_encode(array($_fieldId, true));
        }
    }

    /**
     *  ajax验证邮箱
     */
    public function actionCheckPhone()
    {

        $_fieldId = $_GET['fieldId'];
        $phone = $_GET['fieldValue'];
        $student = new  pos_UserRegisterService();
        echo json_encode(array($_fieldId, !$student->phoneIsExist($phone)));
    }


    /**
     *  裁剪图片
     */
    public function actionImage()
    {
        $oldname = $_POST['name'];
        $x = $_POST['x'];
        $y = $_POST['y'];
        $width = $_POST['width'];
        $height = $_POST['height'];
        $oldPic = \Yii::getPathOfAlias('webroot') . $oldname;

        $newPicName = "header" . rand(1, 1000) . basename($oldPic);
        $path = dirname($oldPic);


        $image = \Gregwar\Image\Image::open($oldPic);
        $newImagePath = $path . '/' . $newPicName;
        $image->crop($x, $y, $width, $height)->save($path . '/' . $newPicName);
        //缩略图
        $thumbImage = \Gregwar\Image\Image::open($newImagePath);
        $thumbImage->cropResize(200, 200)->save($path . '/200x200_' . $newPicName);
        $thumbImage = \Gregwar\Image\Image::open($newImagePath);
        $thumbImage->cropResize(100, 100)->save($path . '/100x100_' . $newPicName);
        $thumbImage = \Gregwar\Image\Image::open($newImagePath);
        $thumbImage->cropResize(50, 50)->save($path . '/50x50_' . $newPicName);


        $paths = explode('/', $oldname);
        array_pop($paths);
        echo implode('/', $paths) . '/' . $newPicName;
    }

    public function actionImagePic()
    {
        $oldname = $_POST['name'];
        $x = $_POST['x'];
        $y = $_POST['y'];
        $width = $_POST['width'];
        $height = $_POST['height'];
        $oldPic = \Yii::getAlias('@webroot') . $oldname;

        $newPicName = "header" . rand(1, 1000) . basename($oldPic);
        $path = dirname($oldPic);


        $image = \Gregwar\Image\Image::open($oldPic);
        $newImagePath = $path . '/' . $newPicName;
        $image->crop($x, $y, $width, $height)->save($path . '/' . $newPicName);
        //缩略图
        $thumbImage = \Gregwar\Image\Image::open($newImagePath);
        $thumbImage->cropResize(230, 230)->save($path . '/230x230_' . $newPicName);
        $thumbImage = \Gregwar\Image\Image::open($newImagePath);
        $thumbImage->cropResize(70, 70)->save($path . '/70x70_' . $newPicName);
        $thumbImage = \Gregwar\Image\Image::open($newImagePath);
        $thumbImage->cropResize(50, 50)->save($path . '/50x50_' . $newPicName);

        $paths = explode('/', $oldname);
        array_pop($paths);
        $headPic = implode('/', $paths) . '/' . $newPicName;

        loginUser()->UpdateHeader($headPic);
//                    修改头像增加积分
        $jfHelper = new JfManageService;
        $jfHelper->addJfXuemi("pos-picture", user()->id);

        $jsonResult = new JsonMessage();
        $jsonResult->success = true;
        return $this->renderJSON($jsonResult);
    }


    /**
     *根据学部获取科目
     */
    public function actionGetSubject($schoolLevel)
    {
        echo Html::tag('option', '请选择', array('value' => ''));
        if (empty($schoolLevel)) {
            return;
        }
        $data = LoadSubjectModel::model()->getData($schoolLevel, 1);
        foreach ($data as $item) {
            echo Html::tag('option', Html::encode($item->secondCodeValue), array('value' => $item->secondCode));
        }
    }

    /**
     * 根据科目查询版本
     * @param string $subject
     * @param bool $prompt
     * @param string $grade
     */
    public function actionGetVersion($subject, $prompt = true, $grade)
    {
        if ($prompt) {
            echo Html::tag('option', '请选择', array('value' => ''));
        }
        if (empty($subject)) {
            return;
        }
        $data = LoadTextbookVersionModel::model($subject, $grade)->getListData();
        foreach ($data as $key => $item) {
            echo Html::tag('option', Html::encode($item), array('value' => $key));
        }
    }

    /**
     * 根据 学段 科目查询版本
     * @param string $subject
     * @param string $department
     * @param bool $prompt
     */
    public function actionGetVersions($subject, $department, $prompt = true)
    {

        if ($prompt == true) {

            echo Html::tag('option', '请选择', array('value' => ''));
        }

        if (empty($subject) || empty($department)) {
            return;
        }
        $data = LoadTextbookVersionModel::model($subject, null, $department)->getListData();
        foreach ($data as $key => $item) {
            echo Html::tag('option', Html::encode($item), array('value' => $key));
        }
    }

    /**
     *根绝学部获取科目列表
     */
    public function actionGetSubjectByDepartment()
    {
        $department = app()->request->getBodyParam('department');

        $subjectList = SubjectModel::getSubjectByDepartment($department);

        foreach ($subjectList as $v) {
            echo Html::tag('option', $v->secondCodeValue, ['value' => $v->secondCode]);
        }


    }

    /**
     *根据科目，学段，版本查询分册
     */
    public function actionGetChapterTome()
    {
        $subjectID = app()->request->getBodyParam('subjectID');

        $version = app()->request->getBodyParam('version');

        $department = app()->request->getBodyParam('department');

        $chapterTomeResult = ChapterService::getTomeList($subjectID, $version, $department);
        foreach ($chapterTomeResult as $v) {
            echo Html::tag('option', $v->name, ['value' => $v->id]);
        }
    }

    /**
     *根据学部，科目版本，分册查询章节树
     */
    public function actionGetChapterTree()
    {
        $subjectID = app()->request->getBodyParam('subjectID');

        $version = app()->request->getBodyParam('version');

        $department = app()->request->getBodyParam('department');

        $chapterId = app()->request->getBodyParam('chapterId');

        $chapterTree = ChapterInfoModel::searchChapterPointToTree((int)$subjectID, (int)$department, (int)$version, 0, (int)$chapterId);

        echo TreeHelper::streefun($chapterTree, [], 'tree pointTree');
    }

    /**
     *根据科目查询题型
     */
    public function actiongetTopic($subject, $schoolLevel)
    {

        echo Html::tag('option', '请选择', array('value' => ''));
        if (empty($schoolLevel) || empty($subject)) {
            return;
        }
        $data = QueryTypeModel::queryQuesType($schoolLevel, $subject);
        foreach ($data as $item) {
            echo Html::tag('option', Html::encode($item->typeName), array('value' => $item->typeId));
        }
    }


    //点击下载，不是浏览器打开，而是直接下载
    /**
     * @param $id
     */
    public function actionDownloadFile($id)
    {

        try {

            $time = (int)app()->request->get('time');
            $sign = (string)app()->request->get('sign');

            MaterialSign::validateSign($time, $sign);

            $srMaterial = SrMaterial::findOne($id);
            $url = $srMaterial->url;
            if (stripos($url, '/upload') !== 0) {
                $url = '/res' . $url;
            }
            $file = \Yii::getAlias('@webroot') . $url;
            $name = $srMaterial->name;
            $flag = parse_user_agent();
            if ($flag['browser'] == 'MSIE') {
                $name = urlencode($name);
            }
            /** @var string $name */
            $newName = $name . strtolower(strrchr($file, '.'));
            yii::$app->response->sendFile($file, $newName)->send();
            return;
        } catch (Exception $e) {
            echo '无法下载';
            \Yii::error('课件文件无法下载错误信息' . '------' . $e->getMessage());
        }

    }

    //点击下载，不是浏览器打开，而是直接下载
    public function actionNewDownloadFile($id)
    {

        $transaction = Yii::$app->db_school->beginTransaction();

        try {

            $time = (int)app()->request->get('time');
            $sign = (string)app()->request->get('sign');

            MaterialSign::validateSign($time, $sign);

            $material = SrMaterial::find()->where(['id' => $id])->one();
            $url = $material->url;
            $name = $material->name;
            $isBoutique = $material->isBoutique;

            $userModel = loginUser();
            $userId = $userModel->userID;
            $memberLevel = $userModel->memberLevel;

            $price = $material->price;

            if ($memberLevel == 1) {
                $price = ceil($price / 2);
            }

            //查询学米
            $xuemiService = new XuemiMicroService();
            $userXuemi = $xuemiService->getStudentUsableXuemi($userId);

            if ($userXuemi < $price) {
                throw new Exception("学米不足");
            }

            if (stripos($url, '/upload') !== 0) {
                $url = '/res' . $url;
            }
            $file = \Yii::getAlias('@webroot') . $url;
            $flag = parse_user_agent();
            if ($flag['browser'] == 'MSIE') {
                $name = urlencode($name);
            }
            $name = $name . strtolower(strrchr($file, '.'));
            yii::$app->response->sendFile($file, $name)->send();

            $downloadRecordModel = SeMaterialDownloadRecord::getDownloadRecord($id, $userId);

            if ($downloadRecordModel == null) {

                //扣除学米
                $xuemiService->deductXuemi("pos-deduct-xue-mi", (int)-$price, $userId);

                //保存下载记录
                $materialDownloadRecordModel = new SeMaterialDownloadRecord();
                $materialDownloadRecordModel->favoriteId = $id;
                $materialDownloadRecordModel->matType = $material->matType;
                $materialDownloadRecordModel->userId = $userId;
                $materialDownloadRecordModel->isBoutique = $isBoutique;
                $materialDownloadRecordModel->save(false);
            }

            //增加下载次数
            $material->downNum = $material->downNum + 1;
            $material->save(false);

            $transaction->commit();
        } catch (Exception $e) {
            echo "下载失败";
            \Yii::error('课件文件无法下载错误信息' . '------' . $e->getMessage());
            $transaction->rollBack();
        }
    }

    /**
     * 下载课件
     * @return string
     */
    public function actionDownloadMaterial()
    {

        $jsonMessage = new JsonMessage();
        $fileId = (int)app()->request->post('fileId');
        $userId = user()->id;
        $materialService = new MaterialMicroService();
        $result = $materialService->download($fileId, $userId);
        if (isset($result->status) && $result->status != 200) {
            if ($result->status == 401) {
                $jsonMessage->code = 401;
            } else {
                $jsonMessage->code = 400;
            }
            $jsonMessage->message = $result->message;

        } else {
            $sign = MaterialSign::getDownMaterialSign();
            $url = '/ajax/download-file/' . $fileId . '?time=' . time() . '&sign=' . $sign;
            $jsonMessage->data = $url;
            $jsonMessage->success = true;
        }
        return $this->renderJSON($jsonMessage);

    }


    /**
     * 判断是否有权限下载课件
     * @throws \yii\base\ExitException
     */
    public function actionIsPrivilegeToDownload()
    {

        $jsonMessage = new JsonMessage();
        $fileId = (int)app()->request->post('fileId');

        $userModel = loginUser();
        $memberLevel = $userModel->memberLevel;

        $material = SrMaterial::getMaterialInfo($fileId);
        $isBoutique = $material->isBoutique;

        if ($memberLevel == 0 && $isBoutique == 1) {
            $jsonMessage->success = false;
        } else {
            $jsonMessage->success = true;
        }
        return $this->renderJSON($jsonMessage);

    }

    /**
     * 预览课件
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionPreviewMaterial()
    {

        $jsonMessage = new JsonMessage();
        $id = (int)app()->request->get('fileId');
        $userId = (int)user()->id;

        $materialService = new MaterialMicroService();
        $result = $materialService->preview($id, $userId);

        if (isset($result->status) && $result->status != 200) {
            if ($result->status == 401) {
                $jsonMessage->code = 401;
            } else {
                $jsonMessage->code = 400;
            }
            $jsonMessage->message = $result->message;
            return $this->renderJSON($jsonMessage);
        }

        $materialModel = SrMaterial::getMaterialInfo($id);
        $url = $materialModel->url;
        try {
            if (ImagePathHelper::judgeImage($url)) {
                $url = ImagePathHelper::resUrl1($url);
            } else {
                $url = 'https://officeweb365.com/o/?i=13233&furl=' . urlencode(ImagePathHelper::resUrl1($url));
            }
            $jsonMessage->success = true;
            $jsonMessage->data = $url;
        } catch (Exception $e) {
            \Yii::error('课件文件无法预览错误信息' . '------' . $e->getMessage());
        }

        return $this->renderJSON($jsonMessage);
    }

    /**
     * 收藏课件
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\ExitException
     */
    public function actionCollectMaterial()
    {

        $jsonMessage = new JsonMessage();
        $favoriteId = (int)app()->request->post('fileId');
        $userId = user()->id;

        $materialService = new MaterialMicroService();
        $result = $materialService->collect($favoriteId, $userId);

        if (isset($result->status) && $result->status != 200) {
            if ($result->status == 401) {
                $jsonMessage->code = 401;
            } else {
                $jsonMessage->code = 400;
            }
            $jsonMessage->message = $result->message;

        } else {
            $jsonMessage->success = true;
        }
        return $this->renderJSON($jsonMessage);

    }

    /**
     * 取消收藏课件
     * @return string
     */
    public function actionCancelCollectMaterial()
    {

        $jsonMessage = new JsonMessage();
        $favoriteId = (int)app()->request->post('fileId');
        $userId = user()->id;

        $materialService = new MaterialMicroService();
        $result = $materialService->cancelCollect($favoriteId, $userId);

        if (isset($result->status) && $result->status != 200) {
            $jsonMessage->message = $result->message;
        } else {
            $jsonMessage->success = true;
        }

        return $this->renderJSON($jsonMessage);

    }

    /**
     * 班级文件详情
     */
    public function actionFileDetails()
    {

        $id = app()->request->getQueryParam('id');
        $url = app()->request->getQueryParam('url');

        $materialModel = SrMaterial::find()->where(['id' => $id])->one();
        $materialModel->readNum = $materialModel->readNum + 1;
        $materialModel->save(false);

        if (ImagePathHelper::judgeImage($url)) {
            $this->redirect(ImagePathHelper::resUrl1($url));
        } else {
            $this->redirect('http://officeweb365.com/o/?i=13233&furl=' . urlencode(ImagePathHelper::resUrl1($url)));
        }

    }

    /**
     * 收藏讲义
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\ExitException
     */
    public function actionCollect()
    {
        $jsonResult = new JsonMessage();
        $favoriteId = app()->request->post('id');
        $userId = user()->id;

        $srMaterial = SrMaterial::getMaterialInfo($favoriteId);     //创建默认分组的科目——使用文件自身的学段，科目
        if (empty($srMaterial)) {
            $jsonResult->message = '收藏失败！';
            return $this->renderJSON($jsonResult);
        }

        if ($srMaterial->creator == $userId) {
            $jsonResult->message = '自己上传的课件不能收藏！';
            return $this->renderJSON($jsonResult);
        }


        $totalNumResult = SeFavoriteMaterial::getTotalMaterialNum($userId);
        if ($totalNumResult >= 1000) {
            $jsonResult->message = '已经达到最大收藏数1000！';
            return $this->renderJSON($jsonResult);
        }

        $result = SeFavoriteMaterial::materialCollect($srMaterial, $favoriteId, $userId);    //收藏课件操作

        if ($result == false) {
            $jsonResult->message = '收藏失败！';
        } else {
            $jsonResult->success = true;
            $jsonResult->message = '收藏成功！';
        }

        return $this->renderJSON($jsonResult);
    }

    /**
     * 取消收藏
     * @return string
     * @throws \Exception
     */
    public function actionCancelCollect()
    {
        $jsonResult = new JsonMessage();
        $favoriteId = app()->request->post('id');
        $userId = user()->id;

        $result = SeFavoriteMaterial::materialCancelCollect($favoriteId, $userId);     //取消收藏课件操作

        if ($result == false) {
            $jsonResult->message = '取消收藏失败！';
        } else {
            $jsonResult->success = true;
            $jsonResult->message = '取消收藏成功！';
        }

        return $this->renderJSON($jsonResult);
    }

    /**
     * 加载整个页面判断每个课件是否被收藏了
     */
    public function actionFileIsCollected()
    {
        $jsonResult = new JsonMessage();
        $jsonResult->success = true;
        $materialIdArray = Yii::$app->request->post('materialIdArray');

        $result = SeFavoriteMaterial::getMaterialIsCollected($materialIdArray, user()->id);     //课件是否收藏
        $jsonResult->data = $result;
        return $this->renderJson($jsonResult);
    }

    /**
     * 检查是否签到
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \yii\base\ExitException
     */
    public function actionCheckSign()
    {
        $jsonResult = new JsonMessage();

        $signService = new JfManageService();
        $checkSign = $signService->checkSign(user()->id);

        if ($checkSign === false) {
            $jsonResult->success = false;
        } else {
            $jsonResult->success = true;
        }

        return $this->renderJSON($jsonResult);
    }

    /**
     * 签到积分
     * @return string
     * @throws \yii\base\ExitException
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function actionSign()
    {
        $jsonResult = new JsonMessage();
        $jfHelper = new JfManageService();
        $cache = Yii::$app->cache;
        $key = WebDataKey::USER_IS_SIGN . user()->id;
        if ($cache->get($key) === false) {
            $checkSign = $jfHelper->checkSign(user()->id);
            if ($checkSign == false) {
                $jfHelper->Sign(user()->id);
                $endTime = strtotime(date('Y-m-d 23:59:59', time()));
                $nowTime = strtotime(date('Y-m-d H:i:s', time()));
                if ($endTime - $nowTime > 0) {
                    Yii::$app->cache->set($key, true, $endTime - $nowTime);
                }
                $jsonResult->success = true;
                $jsonResult->code = 1;
            } else {
                $jsonResult->success = false;
                $jsonResult->code = 2;
            }

        } else {
            $jsonResult->success = false;
            $jsonResult->code = 2;
        }


        return $this->renderJSON($jsonResult);
    }


    /**
     * 积分兑换
     */
    public function actionJfExchange()
    {

        $goodsId = app()->request->post('goodsId');

        $contact = app()->request->post('contact');
        $contactPhone = app()->request->post('contactPhone');
        $address = app()->request->post('address');
        $jfManageModel = new JfManageService();
        $userId = user()->id;
        $result = $jfManageModel->JfExchange($userId, $contact, $contactPhone, $address, $goodsId);

        return $this->renderJSON($result);

    }


    /**
     * 学米兑换
     */
    public function actionXuemiExchange()
    {

        $goodsId = (int)app()->request->post('goodsId');
        $contact = (string)app()->request->post('contact');
        $contactPhone = (string)app()->request->post('contactPhone');
        $address = (string)app()->request->post('address');
        $monthAccountId = (int)app()->request->post('monthAccountId');
        $xuemiShopModel = new XuemiMicroService();
        $userId = (int)user()->id;
        $result = $xuemiShopModel->XuemiExchange($userId, $goodsId, $monthAccountId, $contact, $contactPhone, $address);

        return $this->renderJSON($result);

    }

    /**
     * 判断用户特权状态
     */
    public function actionUserPrivilege()
    {
        $jsonResult = new JsonMessage();
        $xuemiMicroModel = new UserPrivilegeService();
        $userId = (int)user()->id;
        $result = $xuemiMicroModel->getUserPrivilege_cache($userId);

        $jsonResult->success = true;
        $jsonResult->data = $result;

        return $this->renderJSON($jsonResult);

    }


    /**
     * 催作业
     * 班级作业列表 和 教师个人中心作业列表共用
     * @return string
     */
    public function actionUrgeHomework()
    {
        $jsonResult = new JsonMessage();
        $relId = (int)app()->request->post('relId');
        try {
            $relHomeworkQuery = SeHomeworkRel::isSendMsgStudent($relId);
            if (empty($relHomeworkQuery)) {
                $jsonResult->success = false;
                $jsonResult->message = "催作业失败";
            } else {

                $homeworkPush = new  HomeworkPushService();
                $result = $homeworkPush->urge($relId);
                if ($result->code == 200) {
                    $jsonResult->success = true;
                    $jsonResult->message = "催作业成功";
                }
            }

        } catch (Exception $e) {
            \Yii::error('催作业失败错误信息' . $relId . '------' . $e->getMessage());
        }
        return $this->renderJSON($jsonResult);
    }


    /**
     * 网站头部导航 通知数字显示
     * @return string
     */
    public function actionMsgNum()
    {
        $userId = user()->id;
        $obj = new pos_MessageSentService();
        $cache = Yii::$app->cache;
        $key = WebDataKey::TOP_NAV_MSG_NUM_CACHE_KEY . "_" . $userId;
        $data = $cache->get($key);
        if ($data === false) {
            $data = $obj->stasticUserMessage($userId);
            if (!empty($data)) {
                $cache->set($key, $data, 300);
            }
        }
        return $this->renderJSON($data);
    }

    /**
     * 确认加入班级
     * wgl
     * @return string
     */
    public function actionJoinClass()
    {
        $jsonResult = new JsonMessage();
        $userId = user()->id;
        $code = (string)app()->request->get('code');

        $model = new OrganizationService();

        $result = $model->AddClass($userId, $code);
        if ($result->success) {
            $jsonResult->success = true;
            $jsonResult->message = $result->message;
        } else {
            $jsonResult->success = false;
            $jsonResult->message = $result->message;
        }
        return $this->renderJSON($jsonResult);
    }

    /**
     * 退出班级
     * wgl
     * @return string
     */
    public function actionDelClass()
    {
        $jsonResult = new JsonMessage();
        $userId = user()->id;
        $classId = (int)app()->request->get('classId');
        $model = new OrganizationService();

        $result = $model->OutClass($userId, $classId);
        $checkClass = loginUser()->IsExistClass();
        if ($result->success) {
            $jsonResult->success = true;
            $jsonResult->message = $result->message;
            $jsonResult->checkClass = $checkClass;
        } else {
            $jsonResult->success = false;
            $jsonResult->message = $result->message;
        }
        return $this->renderJSON($jsonResult);
    }
} 