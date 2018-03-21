<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\components;

use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\captcha\Captcha;
use yii\helpers\Url;
use yii\web\Response;

/**
 * CaptchaAction renders a CAPTCHA image.
 *
 * CaptchaAction is used together with [[Captcha]] and [[\yii\captcha\CaptchaValidator]]
 * to provide the [CAPTCHA](http://en.wikipedia.org/wiki/Captcha) feature.
 *
 * By configuring the properties of CaptchaAction, you may customize the appearance of
 * the generated CAPTCHA images, such as the font color, the background color, etc.
 *
 * Note that CaptchaAction requires either GD2 extension or ImageMagick PHP extension.
 *
 * Using CAPTCHA involves the following steps:
 *
 * 1. Override [[\yii\web\Controller::actions()]] and register an action of class CaptchaAction with ID 'captcha'
 * 2. In the form model, declare an attribute to store user-entered verification code, and declare the attribute
 *    to be validated by the 'captcha' validator.
 * 3. In the controller view, insert a [[Captcha]] widget in the form.
 *
 * @property string $verifyCode The verification code. This property is read-only.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CaptchaAction extends \yii\captcha\CaptchaAction
{
    /**
     * @var string the rendering library to use. Currently supported only 'gd' and 'imagick'.
     * If not set, library will be determined automatically.
     * @since 2.0.7
     */

    /**
     * [$disturbCharCount 干扰字符数量]
     * @var [type]
     */
    public $disturbCharCount=2;


    /**
     * Renders the CAPTCHA image based on the code using GD library.
     * @param string $code the verification code
     * @return string image contents in PNG format.
     */

    protected function renderImage($code)
    {
       return $this->renderImageByGD($code);
    }

    protected function renderImageByGD($code)
    {
        $image = imagecreatetruecolor($this->width, $this->height);

        $backColor = imagecolorallocate(
            $image,
            (int) ($this->backColor % 0x1000000 / 0x10000),
            (int) ($this->backColor % 0x10000 / 0x100),
            $this->backColor % 0x100
        );
        imagefilledrectangle($image, 0, 0, $this->width, $this->height, $backColor);
        imagecolordeallocate($image, $backColor);

        if ($this->transparent) {
            imagecolortransparent($image, $backColor);
        }

        $foreColor = imagecolorallocate(
            $image,
            (int) ($this->foreColor % 0x1000000 / 0x10000),
            (int) ($this->foreColor % 0x10000 / 0x100),
            $this->foreColor % 0x100
        );

        $length = strlen($code);
        $box = imagettfbbox(30, 0, $this->fontFile, $code);
        $w = $box[4] - $box[0] + $this->offset * ($length - 1);
        $h = $box[1] - $box[5];
        $scale = min(($this->width - $this->padding * 2) / $w, ($this->height - $this->padding * 2) / $h);
        $x = 20;
        $y = round($this->height * 27 / 40);
        for ($i = 0; $i < $length; ++$i) {
            $fontSize = (int) (rand(26, 32) * $scale * 0.8);
            $angle = rand(-10, 10);
            $letter = $code[$i];
            $box = imagettftext($image, $fontSize, $angle, $x, $y, $foreColor, $this->fontFile, $letter);
            $x = $box[2] + $this->offset;
        }





        ob_start();
        //画干扰点
        $this->_writeNoise($image);
        //画干扰线
        $this->_writeCurve($image);
        imagepng($image);
        imagedestroy($image);
        return ob_get_clean();
    }

    /**
     * 画杂点
     * 往图片上写不同颜色的字母或数字
     */
    private function _writeNoise($image) {
        $codeSet = '2345678abcdefhijkmnpqrstuvwxyz';
        for($i = 0; $i < $this->disturbCharCount; $i++){
            //杂点颜色
            $noiseColor = imagecolorallocate($image, mt_rand(150,225), mt_rand(150,225), mt_rand(150,225));
            for($j = 0; $j < 10; $j++) {
                // 绘杂点
                imagestring($image, 10, mt_rand(-10, $this->width),  mt_rand(-10, $this->height), $codeSet[mt_rand(0, 29)], $noiseColor);
            }
        }
    }




    /**
     * 画一条由两条连在一起构成的随机正弦函数曲线作干扰线(你可以改成更帅的曲线函数)
     *
     *      高中的数学公式咋都忘了涅，写出来
     *      正弦型函数解析式：y=Asin(ωx+φ)+b
     *      各常数值对函数图像的影响：
     *        A：决定峰值（即纵向拉伸压缩的倍数）
     *        b：表示波形在Y轴的位置关系或纵向移动距离（上加下减）
     *        φ：决定波形与X轴位置关系或横向移动距离（左加右减）
     *        ω：决定周期（最小正周期T=2π/∣ω∣）
     *
     */
    // 验证码字体随机颜色
    // $this->_color = imagecolorallocate($this->_image, mt_rand(1,150), mt_rand(1,150), mt_rand(1,150));
    private function _writeCurve($image) {
        $px = $py = 0;

        // 曲线前部分
        $A = mt_rand(1, $this->height/2);                  // 振幅
        $b = mt_rand(-$this->height/4, $this->height/4);   // Y轴方向偏移量
        $f = mt_rand(-$this->height/4, $this->height/4);   // X轴方向偏移量
        $T = mt_rand($this->height, $this->width*2);  // 周期
        $w = (2* M_PI)/$T;

        $px1 = 0;  // 曲线横坐标起始位置
        $px2 = mt_rand($this->width/2, $this->width * 0.8);  // 曲线横坐标结束位置

        for ($px=$px1; $px<=$px2; $px = $px + 1) {
            if ($w!=0) {
                $py = $A * sin($w*$px + $f)+ $b + $this->height/2;  // y = Asin(ωx+φ) + b
                $i = (int) (15/5);
                while ($i > 0) {
                    imagesetpixel($image, $px + $i , $py + $i, imagecolorallocate($image, mt_rand(1,150), mt_rand(1,150), mt_rand(1,150)));  // 这里(while)循环画像素点比imagettftext和imagestring用字体大小一次画出（不用这while循环）性能要好很多
                    $i--;
                }
            }
        }

        // 曲线后部分
        $A = mt_rand(1, $this->height/2); // 振幅
        $f = mt_rand(-$this->height/4, $this->height/4); // X轴方向偏移量
        $T = mt_rand($this->height, $this->width*2);  // 周期
        $w = (2* M_PI)/$T;
        $b = $py - $A * sin($w*$px + $f) - $this->height/2;
        $px1 = $px2;
        $px2 = $this->width;

        for ($px=$px1; $px<=$px2; $px=$px+ 1) {
            if ($w!=0) {
                $py = $A * sin($w*$px + $f)+ $b + $this->height/2;  // y = Asin(ωx+φ) + b
                $i = (int) (15/5);
                while ($i > 0) {
                    imagesetpixel($image, $px + $i, $py + $i, imagecolorallocate($image, mt_rand(1,150), mt_rand(1,150), mt_rand(1,150)));
                    $i--;
                }
            }
        }
    }

    /**
     * Renders the CAPTCHA image based on the code using ImageMagick library.
     * @param string $code the verification code
     * @return string image contents in PNG format.
     */
    protected function renderImageByImagick($code)
    {
        $backColor = $this->transparent ? new \ImagickPixel('transparent') : new \ImagickPixel('#' . str_pad(dechex($this->backColor), 6, 0, STR_PAD_LEFT));
        $foreColor = new \ImagickPixel('#' . str_pad(dechex($this->foreColor), 6, 0, STR_PAD_LEFT));

        $image = new \Imagick();
        $image->newImage($this->width, $this->height, $backColor);

        $draw = new \ImagickDraw();
        $draw->setFont($this->fontFile);
        $draw->setFontSize(30);
        $fontMetrics = $image->queryFontMetrics($draw, $code);

        $length = strlen($code);
        $w = (int) ($fontMetrics['textWidth']) - 8 + $this->offset * ($length - 1);
        $h = (int) ($fontMetrics['textHeight']) - 8;
        $scale = min(($this->width - $this->padding * 2) / $w, ($this->height - $this->padding * 2) / $h);
        $x = 10;
        $y = round($this->height * 27 / 40);
        for ($i = 0; $i < $length; ++$i) {
            $draw = new \ImagickDraw();
            $draw->setFont($this->fontFile);
            $draw->setFontSize((int) (rand(26, 32) * $scale * 0.8));
            $draw->setFillColor($foreColor);
            $image->annotateImage($draw, $x, $y, rand(-10, 10), $code[$i]);
            $fontMetrics = $image->queryFontMetrics($draw, $code[$i]);
            $x += (int) ($fontMetrics['textWidth']) + $this->offset;
        }

        $image->setImageFormat('png');
        return $image->getImageBlob();
    }
}