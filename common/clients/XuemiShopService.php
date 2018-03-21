<?php
/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 2017/4/20
 * Time: 10:00
 */

namespace common\clients;


use Httpful\Mime;
use Httpful\Request;
use Yii;

/**
 * Class XuemiService
 * @package common\clients
 */
class XuemiShopService
{

	private $uri = null;

	/**
	 * JfManageService constructor.
     */
	function __construct()
	{
		$this->uri = Yii::$app->params['banhai_webService'];
	}

	/**
	 * 学米商品列表
	 * @param int $type 用户身份  0 学生  1 老师
	 * @param int $accountType 账户类型  0  月账户  1 结转账户
	 * @return mixed
	 * @throws \Httpful\Exception\ConnectionErrorException
	 */
	public function Goods(int $type,int $accountType = 0)
	{
		$result = Request::get($this->uri . '/xueMi/xm-goods?' . http_build_query(['type' => $type,'account-type'=>$accountType]))
			->expectsType(Mime::JSON)
			->send();
		return $result->body;
	}

    /**
     * 学米兑换
     * @param integer $userId 用户id
     * @param integer $goodsId 商品id
     * @param integer $monthAccountId   月账户id
     * @param string $contact 联系人
     * @param string $contactPhone 联系方式
     * @param string $address 联系地址
     * @return mixed
     */
    public function XuemiExchange(int $userId, int $goodsId,int $monthAccountId, string $contact, string $contactPhone, string $address)
    {
        $result = Request::post( $this->uri . '/xueMi/xm-orders')
            ->body(http_build_query(['userId' => $userId, 'goodsId' => $goodsId,'monthAccountId'=>$monthAccountId, 'contact' => $contact, 'contactPhone' => $contactPhone,"address" => $address]))
            ->contentType('')
            ->sendsType(Mime::FORM)
            ->send();
        return $result->body;
    }


} 