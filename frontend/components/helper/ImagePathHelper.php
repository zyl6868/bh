<?php

namespace frontend\components\helper;

use Exception;
use Yii;
use yii\helpers\Url;

/**
 * Created by PhpStorm.
 * User: a
 * Date: 14-8-19
 * Time: 下午6:04
 */
class ImagePathHelper
{

    /**
     *   获取图片
     * @param $photo
     * @param string $size
     * @return string
     */
    public static function getImage($photo, $size = '100x100')
    {
        if (strlen($photo) == 0)
            return '';
        $size = strtolower($size);
        $paths = explode('/', $photo);
        $photoName = array_pop($paths);
        $resizePhoto = implode('/', $paths) . '/' . $size . '_' . $photoName;
        return $resizePhoto;
    }

    /** 转换资源url
     * @param $url
     * @return string
     */
    public static function resUrl($url)
    {
        if (empty($url))
            return '';

        if (stripos($url, '/upload') === 0) {

            $url = Url::to(['@web' . $url], true);
            return $url;
        } else {
            $url = Url::to(['@web/res' . $url], true);
            return $url;
        }
    }


    /** 转换资源url
     * @param $url
     * @return string
     */
    public static function resUrl1($url)
    {
        if (empty($url))
            return '';

        if (stripos($url, '/upload') === 0) {

            $url = Url::to('http://www.banhai.com' . $url, false);
            return $url;
        } else {
            $url = Url::to('http://www.banhai.com/res' . $url, false);
            return $url;
        }
    }


    function replace_outer_links($message)
    {
        $local_domain_arr = ['http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER["SERVER_PORT"]];

        $pattern = '/<[^>]*href=[\'\"]http[s]?:\/\/(?!';
        $i = 0;
        foreach ($local_domain_arr as $local_domain) {
            if ($i == 0) {
                $pattern .= 'www.' . $local_domain . '|' . $local_domain . '|[\w\_]+\.' . $local_domain;
            } else {
                $pattern .= '|www.' . $local_domain . '|' . $local_domain . '|[\w\_]+\.' . $local_domain;
            }
            $i++;
        }
        $pattern .= ')[^\'^\"]*[\'\"][^>]*>(.+?)<\/a>/is';
        return preg_replace($pattern, '$1', $message);
    }

    /**
     * 剔换图片本地地址
     * @param $input
     * @return mixed
     */
    public static function replace_pic($input)
    {
        return str_replace(Yii::$app->getRequest()->getHostInfo(), '', $input);
    }


    /**
     *  获取分隔url数组
     * @param $urlStr
     * @return array
     */
    public static function    getPicUrlArray($urlStr)
    {

        if (isset($urlStr)) {
            $urlStr = trim($urlStr);
            if (!empty($urlStr)) {
                $urlArr = explode(",", $urlStr);
                return $urlArr;
            }
        }
        return array();
    }

    /**
     *  根据图片取相应图片校列
     * @param $urlStr
     * @return string
     */
    public static function    getPicUrl($urlStr)
    {
        $result = self::getPicUrlArray($urlStr);
        if (empty($result)) {
            return publicResources() . '/images/picture.png';
        }
        $r = $result[0];
        $reg = '/\.(gif|jpe?g|png)$/i';
        if (preg_match($reg, $r)) {
            return publicResources() . $r;
        }
        return publicResources() . '/images/picture.png';
    }

    /**
     * 取正文的图片
     * @param $context
     * @return mixed
     */
    public static function   getRegPic($context)
    {
        preg_match_all("/<img.*?src\s*=\s*[\"|\']?\s*([^>\"\'\s]*)/i", $context, $matches);
        return $matches[1];
    }

    /**
     * 班级文件类型显示对应的图片
     */
    public static function getFilePic($url)
    {

        $result = self::getPicUrlArray($url);
        if (empty($result)) {
            return BH_CDN_RES.'/pub/images/test_paper_img.png';
        }
        $r = $result[0];

        $regtxt = '/\.(txt)$/i';
        $regPic = '/\.(gif|jpe?g|png)$/i';
        $regPpt = '/\.(ppt|pptx)$/i';
        $regDoc = '/\.(doc|docx)$/i';
        $regPdf = '/\.(pdf)$/i';
        $regxls = '/\.(xls|xlsx)$/i';

        if (preg_match($regPic, $r)) {
            return BH_CDN_RES.'/pub/images/test_paper_img3.png';
        }
        if (preg_match($regPpt, $r)) {
            return BH_CDN_RES.'/pub/images/test_paper_img4.png';
        }
        if (preg_match($regDoc, $r)) {
            return BH_CDN_RES.'/pub/images/test_paper_img2.png';
        }
        if (preg_match($regPdf, $r)) {
            return BH_CDN_RES.'/pub/images/test_paper_img15.png';
        }
        if (preg_match($regxls, $r)) {
            return BH_CDN_RES.'/pub/images/test_paper_img19.png';
        }
        if (preg_match($regtxt, $r)) {
            return BH_CDN_RES.'/pub/images/test_paper_img7.png';
        }

        return BH_CDN_RES.'/pub/images/test_paper_img.png';


    }

    /**
     * 班级文件类型显示对应的图片
     */
    public static function getNewFilePic($url)
    {

        $result = self::getPicUrlArray($url);
        if (empty($result)) {
            return '';
        }
        $r = $result[0];

        $regtxt = '/\.(txt)$/i';
        $regPic = '/\.(gif|jpe?g|png)$/i';
        $regPpt = '/\.(ppt|pptx)$/i';
        $regDoc = '/\.(doc|docx)$/i';
        $regPdf = '/\.(pdf)$/i';
        $regxls = '/\.(xls|xlsx)$/i';

        if (preg_match($regPic, $r)) {
            return 'picture';
        }
        if (preg_match($regPpt, $r)) {
            return 'ppt';
        }
        if (preg_match($regDoc, $r)) {
            return 'word';
        }
        if (preg_match($regPdf, $r)) {
            return '';
        }
        if (preg_match($regxls, $r)) {
            return '';
        }
        if (preg_match($regtxt, $r)) {
            return '';
        }

        return "";


    }

    public static function  resImage($url)
    {
        if (empty($url)) {
            return [];
        }
        $url = self::resUrl($url);

        $regPic = '/\.(gif|jpe?g|png)$/i';
        if (preg_match($regPic, $url)) {

            return [$url];
        }
//        $paths = explode('/', $url);
//        $photoName = array_pop($paths);
//        $masterName = pathinfo($photoName)['filename'];
//
//        $fileUrl = implode('/', $paths) . '/' . $masterName . '/';
//        $jsonFile = $fileUrl . 'pagelist.json';
//
        $picArr = [];
//        $curlHelper = new   XcurlHelper();
//        if ($curlHelper->getRemoteFileExist($jsonFile)) {
//            $picArr = [];
//
//            $json = $curlHelper->get_content($jsonFile);
//            $arr = json_decode($json);
//            foreach ($arr as $i) {
//                $picArr[] = $fileUrl . $i;
//            }
//        }

        return $picArr;

    }

    /**
     *  获取图片缩络图
     * @param $imagePath
     * @param $w
     * @param $h
     * @return string
     */
    public static function   imgThumbnail($imagePath, $w, $h)
    {

        return self::picFitFormat('thumbnail', $imagePath, $w, $h);


    }

    /**
     * 图片压缩
     * @param $imagePath
     * @param $w
     * @param $h
     * @return string
     */
    public static function   imgResize($imagePath, $w, $h)
    {
        return self::picFitFormat('resize', $imagePath, $w, $h);
    }

    /**
     * @param $op
     * @param $path
     * @param $w
     * @param $h
     * @return string
     */
    protected static function  picFitFormat($op, $orgPath, $w, $h)
    {
        try {

            if (!isset(Yii::$app->params['picFit']) || empty(Yii::$app->params['picFit'])) {
                return $orgPath;
            }

            if (!$w || !$h) {
                return $orgPath;
            }

            //去除左侧 /
            $path = ltrim($orgPath, "/");

            $par = ['op' => $op,
                'path' => urlencode($path),
                'w' => $w,
                'h' => $h
            ];

            //移除空值项
            $par = array_filter($par, create_function('$v', 'return  !empty($v);'));

            //排序
            ksort($par);

            //组成字段串
            $arr = [];
            foreach ($par as $key => $value) {
                $arr[] = "$key=$value";
            }

            $str = implode('&', $arr);
            $sig = hash_hmac('sha1', $str, Yii::$app->params['picFitKey']);

            $wh = $w . 'x' . $h;
            return Yii::$app->params['picFit'] . "display/$sig/{$par['op']}/$wh/{$par['path']}";

        } catch (Exception $e) {

        }
        return $orgPath;

    }

    /**
     * 获取头像
     * @param $imgUrl
     * @return string
     */
    public static  function  getFaceIcon($imgUrl)
    {
        $faceIcon = "/pub/images/tx.jpg";
        if ($imgUrl != null && trim($imgUrl) != '') {
            return $imgUrl;
        }

        return $faceIcon;
    }

    //判断资源是否是图片
    public static function judgeImage($url){
        $flag = false;
        //正则判断文件是否是图片
        $reg = '/\.(gif|jpe?g|png|jpg)$/i';
        if (preg_match($reg, $url)) {
            $flag = true;
        }
        return $flag;
    }
}