<?php
namespace common\clients\material;
use Exception;

/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 18-1-23
 * Time: 上午10:43
 */
class MaterialSign{
    /**
     * 下载资源签名
     */
    const  MATERIAL_SIGN = 'ban_hai_download_material';


    /**
     * 获取下载资源的签名
     * @return string
     */
    public static function getDownMaterialSign()
    {
        $key = self::MATERIAL_SIGN;
        $time = time();
        $sign = strtoupper(md5($time.$key));
        return $sign;
    }

    public static function VeryDownMaterialSign($time,$sign)
    {
        $key = self::MATERIAL_SIGN;
        return  strtoupper($sign) == strtoupper(md5($time.$key));

    }

    /**
     * 验证url签名
     * @param integer $time
     * @param string $sign
     * @throws Exception
     */
    public static function validateSign(int $time,string $sign){

        $nowTime = time();
        if($time > $nowTime+300 || $time < $nowTime-300){
            throw new Exception('请求时间无效');
        }

        if(!self::VeryDownMaterialSign($time, $sign)){
            throw new Exception('签名匹配错误:time:'.$time.'------,sign:'.$sign);
        }
    }
}