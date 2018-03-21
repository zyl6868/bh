<?php

/**
 * This is the shortcut to DIRECTORY_SEPARATOR
 */
use frontend\components\helper\ImagePathHelper;
use frontend\components\helper\LetterHelper;
use frontend\components\helper\StringHelper;
use common\components\WebDataCache;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

defined('DS') or define('DS', DIRECTORY_SEPARATOR);

/**
 * This is the shortcut to Yii::app()
 */
function app()
{
    return Yii::$app;
}


/**
 * @return \yii\base\View|\yii\web\View
 */
function cs()
{
    // You could also call the client script instance via Yii::app()->clientScript
    // But this is faster
    return Yii::$app->view;
}


/**
 * This is the shortcut to Yii::app()->user.
 * @return  yii\web\User
 */
function user()
{
    return Yii::$app->getUser();
}

/**
 * @return frontend\components\User
 */
function   loginUser()
{

    return Yii::$app->getUser()->identity;
}

/**
 * This is the shortcut to \Yii::$app->urlManager->createUrl()
 */
function url($route, $params = array())
{
    return Yii::$app->urlManager->createUrl(array_merge((array)$route, $params));
}

/**
 * This is the shortcut to Html::encode
 */
function h($text)
{
    return htmlspecialchars($text, ENT_QUOTES, Yii::$app->charset);
}

/**
 * Set the key, value in Session
 * @param object $key
 * @param object $value
 * @return boolean
 */
function setSession($key, $value)
{
    Yii::$app->getSession()->set($key, $value);
}

/**
 * Get the value from key in Session
 * @param object $key
 *
 * @return object
 */
function getSession($key)
{
    return Yii::$app->getSession()->get($key);
}

/**
 * This is the shortcut to Html::a()
 */
function l($text, $url = '#', $htmlOptions = array())
{
    return Html::a($text, $url, $htmlOptions);
}

/**
 * This is the shortcut to Yii::t() with default category = 'stay'
 */
function t($message, $category = 'Default', $params = array(),  $language = null)
{
    return Yii::t($category, $message, $params, $language);
}

/**
 * This is the shortcut to Yii::app()->request->baseUrl
 * If the parameter is given, it will be returned and prefixed with the app baseUrl.
 */
function bu($url = null)
{
    static $baseUrl;
    if ($baseUrl === null)
        $baseUrl = Yii::$app->getRequest()->getBaseUrl();
    return $url === null ? $baseUrl : $baseUrl . '/' . ltrim($url, '/');
}

/**
 * 公共资源包 通常放js和css
 * @return string
 */
function publicResources()
{
    static $publicRes;
    if ($publicRes === null) {
        $publicRes = Yii::$app->getRequest()->getBaseUrl();
    }
    return $publicRes;
}


/**
 * Return the settings Component
 * @return type
 */
function settings()
{
    return Yii::$app->settings;
}

/**
 * var_dump($varialbe) and exit
 *
 */
function dump($a)
{
    var_dump($a);
    exit;
}

/**
 * 打印函数，友好的显示变量的输出
 * @param mix $var 需要打印的变量
 * @param string $color 输出颜色
 */
function show_msg($var, $color = 'green')
{
    header("Content-type:text/html;charset=utf-8;");
    echo "<pre style='color:{" . $color . "};'>";
    print_r($var);
    echo "</pre>";
    exit("变量输出结束并退出！");
}



/**
 * Convert local timestamp to GMT
 *
 */
function local_to_gmt($time = '')
{
    if ($time == '')
        $time = time();
    return mktime(gmdate("H", $time), gmdate("i", $time), gmdate("s", $time), gmdate("m", $time), gmdate("d", $time), gmdate("Y", $time));
}

/**
 * Get extension of a file
 *
 */
function getExt($filename)
{
    return strtolower(substr(strrchr($filename, '.'), 1));
}

/**
 * Get the current IP of the connection
 *
 */
function ip()
{
    if (isset($_SERVER)) {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip =  isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'';
        }
    } else {
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } else {
            $ip = getenv('REMOTE_ADDR');
        }
    }
    return $ip;
}

/**
 * Generate Unique File Name for the File Upload
 * @param int $len
 * @return string
 */
function gen_uuid($len = 8)
{

    $hex = md5('aaaaa' . uniqid("", true));

    $pack = pack('H*', $hex);
    $tmp = base64_encode($pack);

    $uid = preg_replace("/[^A-Za-z0-9]/", "", $tmp);

    $len = max(4, min(128, $len));

    while (strlen($uid) < $len)
        $uid .= gen_uuid(22);

    $res = substr($uid, 0, $len);
    return $res;
}

function get_subfolders_name($path, $file = false)
{

    $list = array();
    $results = scandir($path);
    foreach ($results as $result) {
        if ($result === '.' or $result === '..' or $result === '.svn')
            continue;
        if (!$file) {
            if (is_dir($path . '/' . $result)) {
                $list[] = trim($result);
            }
        } else {
            if (is_file($path . '/' . $result)) {
                $list[] = trim($result);
            }
        }
    }

    return $list;
}

function stripVietnamese($str)
{
    $unicode = array(
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd' => 'đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i' => 'í|ì|ỉ|ĩ|ị',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
        'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'D' => 'Đ',
        'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
        'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ứ|Ữ|Ự',
        'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );

    foreach ($unicode as $nonUnicode => $uni) {
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    }
    return $str;
}

/**
 * 上传文件url前辍
 * @param $url
 * @return string
 */
function uploadBaseUrl($url)
{
    if (isset($url)) {
        return bu() . "/uploads/" . $url;
    } else {
        return "";
    }


}

/**
 * 上传文件根路径
 * @return string
 */
function uploadRoot()
{
    return Yii::getAlias('@webroot') . '/uploads/';
}

/**
 * 检查路径并创建
 * @param $filename
 * @return bool
 */
function check_path($filename)
{
    //检查路径
    $arr_path = explode('/', $filename);
    $path = '';
    $cnt = count($arr_path) - 1;
    if ($cnt >= 0 && $arr_path[0] == '')
        chdir('/');
    for ($i = 0; $i < $cnt; $i++) {
        if ($arr_path [$i] == '')
            continue;
        $path .= $arr_path [$i] . '/';
        if (!is_dir($path))
            if (!mkdir($path, 0755))
                return false;
    }

    return true;
}

function toSlug($string, $force_lowercase = true, $anal = false)
{
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
        "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
        "â€”", "â€“", ",", "<", ".", ">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
    return ($force_lowercase) ?
        (function_exists('mb_strtolower')) ?
            mb_strtolower($clean, 'UTF-8') :
            strtolower($clean) :
        $clean;
}

function clean($var)
{
    return trim(strip_tags($var));
}

function fn_clean_input($data)
{
    if (defined('QUOTES_ENABLED')) {
        $data = fn_strip_slashes_deep($data);
    }

    return $data;
}

function fn_strip_slashes_deep($data)
{
    $data = is_array($data) ?
        array_map('fn_strip_slashes_deep', $data) :
        stripslashes($data);

    return $data;
}




/**
 * 获取请求并解码
 * @param $name
 * @param null $defaultValue
 * @return string
 */
function urlDecodeParam($name, $defaultValue = null)
{
    return trim(urldecode(app()->request->getQueryParam($name, $defaultValue)));
}

function recursive_remove_directory($directory, $empty = FALSE)
{
    // if the path has a slash at the end we remove it here
    if (substr($directory, -1) == '/') {
        $directory = substr($directory, 0, -1);
    }

    // if the path is not valid or is not a directory ...
    if (!file_exists($directory) || !is_dir($directory)) {
        // ... we return false and exit the function
        return FALSE;

        // ... if the path is not readable
    } elseif (!is_readable($directory)) {
        // ... we return false and exit the function
        return FALSE;

        // ... else if the path is readable
    } else {

        // we open the directory
        $handle = opendir($directory);

        // and scan through the items inside
        while (FALSE !== ($item = readdir($handle))) {
            // if the filepointer is not the current directory
            // or the parent directory
            if ($item != '.' && $item != '..') {
                // we build the new path to delete
                $path = $directory . '/' . $item;

                // if the new path is a directory
                if (is_dir($path)) {
                    // we call this function with the new path
                    recursive_remove_directory($path);

                    // if the new path is a file
                } else {
                    // we remove the file
                    unlink($path);
                }
            }
        }
        // close the directory
        closedir($handle);

        // if the option to empty is not set to true
        if ($empty == FALSE) {
            // try to delete the now empty directory
            if (!rmdir($directory)) {
                // return false if not possible
                return FALSE;
            }
        }
        // return success
        return TRUE;
    }
}


// add time function
function times()
{
    return date("Y-m-d H:i:s", time());
}

function toCNcap1($data)
{
    $capnum = array("零", "壹", "贰", "叁", "肆", "伍", "陆", "柒", "捌", "玖");
    return $capnum[$data];
}

function toFloat($data)
{
    return sprintf("%01.2f", $data);
}

function toCNcap($data)
{
    $data = str_replace(".00", "", $data);
    $capnum = array("零", "壹", "贰", "叁", "肆", "伍", "陆", "柒", "捌", "玖");
    $capdigit = array("", "拾", "佰", "仟");
    $subdata = explode(".", $data);
    $_count = count($subdata);
    $yuan = $subdata[0];
    $j = 0;
    $nonzero = 0;
    for ($i = 0; $i < strlen($subdata[0]); $i++) {

        $cncap = null;
        if (0 == $i) { //确定个位 
            if ($subdata[1]) {
                $cncap = (substr($subdata[0], -1, 1) != 0) ? "元" : "元零";
            } else {
                $cncap = "元";
            }
        }
        if (4 == $i) {
            $j = 0;
            $nonzero = 0;
            $cncap = "万" . $cncap;
        } //确定万位
        if (8 == $i) {
            $j = 0;
            $nonzero = 0;
            $cncap = "亿" . $cncap;
        } //确定亿位
        $numb = substr($yuan, -1, 1); //截取尾数
        $cncap = ($numb) ? $capnum[$numb] . $capdigit[$j] . $cncap : (($nonzero) ? "零" . $cncap : $cncap);
        $nonzero = ($numb) ? 1 : $nonzero;
        $yuan = substr($yuan, 0, strlen($yuan) - 1); //截去尾数	  
        $j++;
    }

    if ($subdata[1]) {
        $chiao = (substr($subdata[1], 0, 1)) ? $capnum[substr($subdata[1], 0, 1)] . "角" : "零";
        $cent = (substr($subdata[1], 1, 1)) ? $capnum[substr($subdata[1], 1, 1)] . "分" : "零分";
    }
    $cncap = preg_replace("/(零)+/", "\\1", $cncap); //合并连续“零”
    if ($cent == "零分" || $_count == 1) {
        $cncap .= $chiao . $cent . "整";
    } else {
        $cncap .= $chiao . $cent;
    }
    return $cncap;
}


/** 是否闰年
 * @param $year
 * @return bool
 */
function isleapyear($year)
{

    if ($year % 4 == 0) {
        return true;
    } else if ($year % 100 == 0) {
        return true;
    } else if ($year % 400 == 0) {
        return true;
    }
    return false;
}

/**
 * 通过身份证获取年龄
 * @param $IdentityID
 * @return float
 */
function getAgeByIdentityID($id)
{

//过了这年的生日才算多了1周岁
    if (empty($id))
        return '';
    $date = strtotime(substr($id, 6, 8));
//获得出生年月日的时间戳
    $today = strtotime('today');
//获得今日的时间戳
    $diff = floor(($today - $date) / 86400 / 365);
//得到两个日期相差的大体年数
//strtotime加上这个年数后得到那日的时间戳后与今日的时间戳相比
    $age = strtotime(substr($id, 6, 8) . ' +' . $diff . 'years') > $today ? ($diff + 1) : $diff;

    return $age;
}

/**
 *  * 返回发标时间
 * @param $time 发标时间
 * @return string
 */
function tranTime($time)
{
    //获取时间戳
    $time = strtotime($time);
    $time = time() - $time;

    if ($time < 60) {
        $str = '刚刚';
    } elseif ($time < 60 * 60) {
        $min = floor($time / 60);
        $str = $min . '分钟前';
    } elseif ($time < 60 * 60 * 24) {
        $h = floor($time / (60 * 60));
        $str = $h . '小时前 '; //. $htime;
    } //elseif ($time < 60 * 60 * 24 * 3) {
//            $d = floor($time / (60 * 60 * 24));
//            if ($d == 1)
//                $str = '昨天 ' . $rtime;
//            else
//                $str = '前天 ' . $rtime;
//        }
    else {
        //$str = $rtime;
        $d = floor($time / (60 * 60 * 24));
        $str = $d . '天前';
    }
    return $str;
}

/** 剩余时间
 * @param $time
 * @return string
 */
function timeRemaining($time)
{
    //获取时间戳
    $time = strtotime($time);
    $time = $time - time();
    if ($time < 0) {
        return "已结束";
    }

    if ($time < 60 * 60) {
        $min = floor($time / 60);
        $str = $min . '分钟';
    } elseif ($time < 60 * 60 * 24) {
        $h = floor($time / (60 * 60));
        $str = $h . '小时 ';
    } else {
        $d = floor($time / (60 * 60 * 24));
        $str = $d . '天';
    }
    return $str;
}


//同时支持 utf-8、gb2312都支持的汉字截取函数 ,默认编码是utf-8
function cut_str($string, $sublen, $addstr = '...', $start = 0, $code = 'UTF-8')
{
    if ($code == 'UTF-8') {
        $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
        preg_match_all($pa, $string, $t_string);
        if (count($t_string[0]) - $start > $sublen)
            return join('', array_slice($t_string[0], $start, $sublen)) . $addstr;
        return join('', array_slice($t_string[0], $start, $sublen));
    } else {
        $start = $start * 2;
        $sublen = $sublen * 2;
        $strlen = strlen($string);
        $tmpstr = '';
        for ($i = 0; $i < $strlen; $i++) {
            if ($i >= $start && $i < ($start + $sublen)) {
                if (ord(substr($string, $i, 1)) > 129) {
                    $tmpstr .= substr($string, $i, 2);
                } else {
                    $tmpstr .= substr($string, $i, 1);
                }
            }
            if (ord(substr($string, $i, 1)) > 129)
                $i++;
        }
        if (strlen($tmpstr) < $strlen)
            $tmpstr .= $addstr;
        return $tmpstr;
    }
}

/**
 * 生成验证码
 * @return string
 */
function create_guid()
{
    $chars = md5(uniqid(mt_rand(), true));
    $uuid = substr($chars, 0, 8);
    $uuid .= substr($chars, 8, 4);
    $uuid .= substr($chars, 12, 4);
    $uuid .= substr($chars, 16, 4);
    $uuid .= substr($chars, 20, 12);
    return strtolower($uuid);
}

/**
 * 年份
 * @return array
 */
function  getYears()
{

    $ys = date("Y", strtotime("+1 year"));
    $yearsArr = array();
    for (; 2000 <= $ys; $ys--) {
        array_push($yearsArr, array("year" => $ys));
    }
    return $yearsArr;

}


/**
 *  年级（几级）
 * @return array
 */
function  getClassYears()
{

    $ys = date("Y", time())+1;
    $yearsArr = array();

    for (; 2000 <= $ys; $ys--) {
        $yearsArr[$ys] = $ys;
    }
    return $yearsArr;

}

/**
 * 班级
 * @param int $number
 * @return array
 */
function  getClassNumber($number = 20)
{

    $yearsArr = array();
    for ($i = 1; $i <= $number; $i++) {
        $yearsArr[$i] = sprintf("%02d", $i);
    }
    return $yearsArr;

}


/**
 * 查找题
 * @param $item
 * @return array|string
 */
function getanswerContent($item, $level = 0)
{
    $result = '';
    if ($item == null)
        $result = '';


    $childQues=[];
    if(isset($item->childQues))
    {
        $childQues=$item->childQues;
    }

    if( method_exists($item, 'getQuestionChildCache' ))
    {
        $childQues=$item->getQuestionChildCache();
    }

    if (WebDataCache::getShowTypeID($item->tqtid) == 1) {
        if (isset($item->answerContent)) {
            $result = $result . LetterHelper::getLetter($item->answerContent);
        }

    } elseif (WebDataCache::getShowTypeID($item->tqtid) == 2) {
        if (isset($item->answerContent)) {
            $arr = StringHelper::splitNoEMPTY($item->answerContent);
            $res = [];
            foreach ($arr as $i) {
                $res[] = LetterHelper::getLetter($i);
            }
            $result = implode(',', $res);
        }
    } elseif(WebDataCache::getShowTypeID($item->tqtid) == 3){
        if (isset($item->answerContent) && !empty($item->answerContent)) {
            $answerContents=null;
            if(is_json($item->answerContent,$answerContents)){
                foreach($answerContents as $answerContent){
                    $result .= StringHelper::htmlPurifier($answerContent) . '&nbsp;&nbsp;';
                }
            }else{
                $result = StringHelper::htmlPurifier($item->answerContent) . '&nbsp;&nbsp;';
            }
        }
    } elseif (WebDataCache::getShowTypeID($item->tqtid) == 8) {
        if (isset($item->answerContent) && !empty($item->answerContent)) {
            $imgArray = ImagePathHelper::getPicUrlArray($item->answerContent);
            echo '<br>';
            foreach ($imgArray as $val) {
                echo '<img width="120" height="90" style="margin-right:10px" src="' .resCdn($val) . '" />';
            }
        }
    } elseif (WebDataCache::getShowTypeID($item->tqtid) == 9 && empty($childQues)) {
           $result=$item->answerContent?'对':'错';
    } else {
        $result = $item->answerContent . '&nbsp;';
    }

    if (empty($childQues)) {
        return $result;
    } else {
        foreach ($childQues as $i) {
            $result = $result.'&nbsp;' . getanswerContent($i, $level + 1);

        }
    }
    return $result;
}


/**
 * Parses a user agent string into its important parts
 *
 * @author Jesse G. Donat <donatj@gmail.com>
 * @link https://github.com/donatj/PhpUserAgent
 * @link http://donatstudios.com/PHP-Parser-HTTP_USER_AGENT
 * @param string|null $u_agent User agent string to parse or null. Uses $_SERVER['HTTP_USER_AGENT'] on NULL
 * @throws InvalidArgumentException on not having a proper user agent to parse.
 * @return string[] an array with browser, version and platform keys
 */
function parse_user_agent($u_agent = null)
{
    $platform = null;
    $browser = null;
    $version = null;
    $empty = array('platform' => $platform, 'browser' => $browser, 'version' => $version);
    if (is_null($u_agent)) {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $u_agent = $_SERVER['HTTP_USER_AGENT'];
        } else {
            return $empty;
        }
    }

    if (!$u_agent) return $empty;
    if (preg_match('/\((.*?)\)/im', $u_agent, $parent_matches)) {
        preg_match_all('/(?P<platform>BB\d+;|Android|CrOS|iPhone|iPad|Linux|Macintosh|Windows(\ Phone)?|Silk|linux-gnu|BlackBerry|PlayBook|(New\ )?Nintendo\ (WiiU?|3DS)|Xbox(\ One)?)
				(?:\ [^;]*)?
				(?:;|$)/imx', $parent_matches[1], $result, PREG_PATTERN_ORDER);
        $priority = array('Android', 'Xbox One', 'Xbox');
        $result['platform'] = array_unique($result['platform']);
        if (count($result['platform']) > 1) {
            if ($keys = array_intersect($priority, $result['platform'])) {
                $platform = reset($keys);
            } else {
                $platform = $result['platform'][0];
            }
        } elseif (isset($result['platform'][0])) {
            $platform = $result['platform'][0];
        }
    }
    if ($platform == 'linux-gnu') {
        $platform = 'Linux';
    } elseif ($platform == 'CrOS') {
        $platform = 'Chrome OS';
    }
    preg_match_all('%(?P<browser>Camino|Kindle(\ Fire\ Build)?|Firefox|Iceweasel|Safari|MSIE|Trident|AppleWebKit|Chrome|
			IEMobile|Opera|OPR|Silk|Midori|Edge|
			Baiduspider|Googlebot|YandexBot|bingbot|Lynx|Version|Wget|curl|
			NintendoBrowser|PLAYSTATION\ (\d|Vita)+)
			(?:\)?;?)
			(?:(?:[:/ ])(?P<version>[0-9A-Z.]+)|/(?:[A-Z]*))%ix',
        $u_agent, $result, PREG_PATTERN_ORDER);
    // If nothing matched, return null (to avoid undefined index errors)
    if (!isset($result['browser'][0]) || !isset($result['version'][0])) {
        if (!$platform && preg_match('%^(?!Mozilla)(?P<browser>[A-Z0-9\-]+)(/(?P<version>[0-9A-Z.]+))?([;| ]\ ?.*)?$%ix', $u_agent, $result)
        ) {
            return array('platform' => null, 'browser' => $result['browser'], 'version' => isset($result['version']) ? $result['version'] ?: null : null);
        }
        return $empty;
    }
    if (preg_match('/rv:(?P<version>[0-9A-Z.]+)/si', $u_agent, $rv_result)) {
        $rv_result = $rv_result['version'];
    }
    $browser = $result['browser'][0];
    $version = $result['version'][0];
    $find = function ($search, &$key) use ($result) {
        $xkey = array_search(strtolower($search), array_map('strtolower', $result['browser']));
        if ($xkey !== false) {
            $key = $xkey;
            return true;
        }
        return false;
    };
    $key = 0;
    $ekey = 0;
    if ($browser == 'Iceweasel') {
        $browser = 'Firefox';
    } elseif ($find('Playstation Vita', $key)) {
        $platform = 'PlayStation Vita';
        $browser = 'Browser';
    } elseif ($find('Kindle Fire Build', $key) || $find('Silk', $key)) {
        $browser = $result['browser'][$key] == 'Silk' ? 'Silk' : 'Kindle';
        $platform = 'Kindle Fire';
        if (!($version = $result['version'][$key]) || !is_numeric($version[0])) {
            $version = $result['version'][array_search('Version', $result['browser'])];
        }
    } elseif ($find('NintendoBrowser', $key) || $platform == 'Nintendo 3DS') {
        $browser = 'NintendoBrowser';
        $version = $result['version'][$key];
    } elseif ($find('Kindle', $key)) {
        $browser = $result['browser'][$key];
        $platform = 'Kindle';
        $version = $result['version'][$key];
    } elseif ($find('OPR', $key)) {
        $browser = 'Opera Next';
        $version = $result['version'][$key];
    } elseif ($find('Opera', $key)) {
        $browser = 'Opera';
        $find('Version', $key);
        $version = $result['version'][$key];
    } elseif ($find('Midori', $key)) {
        $browser = 'Midori';
        $version = $result['version'][$key];
    } elseif ($browser == 'MSIE' || ($rv_result && $find('Trident', $key)) || $find('Edge', $ekey)) {
        $browser = 'MSIE';
        if ($find('IEMobile', $key)) {
            $browser = 'IEMobile';
            $version = $result['version'][$key];
        } elseif ($ekey) {
            $version = $result['version'][$ekey];
        } else {
            $version = $rv_result ?: $result['version'][$key];
        }
    } elseif ($find('Chrome', $key)) {
        $browser = 'Chrome';
        $version = $result['version'][$key];
    } elseif ($browser == 'AppleWebKit') {
        if (($platform == 'Android' && !($key = 0))) {
            $browser = 'Android Browser';
        } elseif (strpos($platform, 'BB') === 0) {
            $browser = 'BlackBerry Browser';
            $platform = 'BlackBerry';
        } elseif ($platform == 'BlackBerry' || $platform == 'PlayBook') {
            $browser = 'BlackBerry Browser';
        } elseif ($find('Safari', $key)) {
            $browser = 'Safari';
        }
        $find('Version', $key);
        $version = $result['version'][$key];
    } elseif ($key = preg_grep('/playstation \d/i', array_map('strtolower', $result['browser']))) {
        $key = reset($key);
        $platform = 'PlayStation ' . preg_replace('/[^\d]/i', '', $key);
        $browser = 'NetFront';
    }
    return array('platform' => $platform ?: null, 'browser' => $browser ?: null, 'version' => $version ?: null);
}



//字符串是不是json
function is_json($string, &$obj)
{
    if (empty($string)) {
        return false;
    }
    if (!is_string($string)) {
        return false;
    }
    $obj = json_decode($string);

    return (is_array($obj)|is_object($obj)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
}

/**
 * 资源cdn
 * 一些上传资源如图片
 * @param $res
 */
function resCdn($res=null)
{
    if( isset(Yii::$app->params['resCdn'])){
        $resCdn=   Yii::$app->params['resCdn'];
        if (!is_array($resCdn)){
            return $resCdn.$res;
        }

        if(count($resCdn)>0){
            return $resCdn[array_rand($resCdn)].$res;
        }
    }
    return $res;
}

/**
 * 资源
 * @param $res
 */
function assetCdn($res)
{




}



?>