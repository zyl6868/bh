<?php
namespace frontend\modules\mobiles\controllers;
use common\controller\YiiController;
use yii\web\HttpException;
use common\clients\JfManageService;

/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/6/23
 * Time: 15:10
 */
class JfController extends YiiController
{
	public $layout = 'lay_mobile';

	public function actionShowGood($userId, $type, $token)
	{

		if(!$userId){
			throw new HttpException(404, '用户不存在');
		}

		$jfManageHelperModel=new JfManageService();
		$goods = $jfManageHelperModel->Goods($type);
		return $this->render("showGood", ['userId' => $userId,'goods' => $goods]);

	}

    /**
     * 积分规则页面
     * @return string
     */
    public function actionRule()
    {
        $this->layout = 'lay_static';
        return $this->render('rule');
    }
}