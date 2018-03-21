<?php
namespace common\controller;

use common\models\JsonMessage;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 * @property array $Layout_data 布局数据.
 */
class YiiController extends Controller
{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();


    /**
     * 布局数据
     * @var array
     */
    public $Layout_data = array();


    /**
     * Return data to browser as JSON
     * @param $data
     * @return string
     * @throws \yii\base\ExitException
     * @throws \yii\base\InvalidParamException
     */
    protected function renderJSON($data)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $jsoncallback = Yii::$app->request->getQueryParam('jsoncallback');
        //jsonp
        if (isset($jsoncallback)) {
            Yii::$app->response->format = Response::FORMAT_JSONP;
            return  $jsoncallback . '(' . JSON::encode($data) . ')';
        } else {
           return $data;
        }
    }

    /**  not found
     * @param string $message
     * @param int $code
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws HttpException
     * @throws \yii\base\ExitException
     */
    protected function  notFound($message = '', $code = 404)
    {
        if (!Yii::$app->request->isAjax) {
            if (empty($message)) {
                throw new HttpException(404, '页面不存在！');
            } else {
                throw new HttpException($code, $message);
            }

        }

        $jsonResult = new JsonMessage();
        if (empty($message)) {
            $jsonResult->message = '页面不存在！';
        } else {
            $jsonResult->message = $message;
        }
       return   $this->renderJSON($jsonResult);
    }

    /**
     * 是否已登录
     *
     */
    public function   isLogin()
    {
        return !Yii::$app->user->isGuest;

    }


    /**
     * 高亮导航标签
     * @param $url
     * @return bool
     */
    public function  highLightUrl($url,$defaultRoute=null)

    {
        $r='';
        if($defaultRoute)
        {
            $r=strtolower($defaultRoute);

        }else {
            $r = strtolower($this->getRoute());
        }



        if (is_array($url)) {
            $a = array();
            foreach ($url as $item) {
                $a[] = strtolower($item);
            }
            return in_array($r, $a);
        }

        return $r == strtolower($url);
    }

}