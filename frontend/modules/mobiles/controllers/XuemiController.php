<?php
declare(strict_types = 1);
namespace frontend\modules\mobiles\controllers;

use common\components\WebDataCache;
use common\controller\YiiController;
use common\clients\XuemiMicroService;
use common\clients\XuemiShopService;
use yii\web\HttpException;

/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 17-4-21
 * Time: 上午11:07
 */
class XuemiController extends YiiController
{
    /**
     *学生身份
     */
    const STUDENT_TYPE = 0 ;
    public $layout = 'lay_mobile';


    /**
     * 学米商城页面
     * @return string
     * @throws HttpException
     */
    public function actionShowGoods()
    {
        $userId = (int)app()->request->get('user-id');
        $type = (int)app()->request->get('type');
        $accountType = (int)app()->request->get('account-type',0);

        if (!$userId) {
            throw new HttpException(404, '用户不存在');
        }

        $userType = WebDataCache::getUserType($userId);

        if ($userType != $type) {
            throw new HttpException(404, '用户不存在');
        }

        //学生没有结转账户 默认0
        if($type == self::STUDENT_TYPE){
            $accountType = 0;
        }
        $goods = [];
        if($type == 0){
            $xuemiShopService = new XuemiMicroService();
            $goods = $xuemiShopService->Goods($type,$accountType);
        }
        return $this->render("showGoods", ['userId' => $userId, 'goods' => $goods,'type'=>$type]);

    }

    /**
     * 学生学米规则
     * @return string
     */
    public function actionStudentRule()
    {
        $this->layout = 'lay_static';
        return $this->render('studentRule');
    }

    /**
     * 老师学米规则
     * @return string
     */
    public function actionTeacherRule()
    {
        $this->layout = 'lay_static';
        return $this->render('teacherRule');
    }
}