<?php
namespace Frame\Vendor;
//验证码类
final class Captcha{
    private $code;
    private $codeLength;
    private $width;
    private $height;
    private $img;
    private $fontSize;
    private $fontFile;
    public function __construct($codeLenth=4,$width=85,$height=40,$fontSize=24)
    {

        $this->codeLength=$codeLenth;
        $this->code=$this->createCode();
        $this->width=$width;
        $this->height=$height;
        $this->fontSize=$fontSize;
        //字体问题找msyth.ttf
        $this->fontFile="/毕设/Public/Admin/VerifyCode/font/calibri.ttf";

        $this->img=$this->createImage();
        $this->createBg();
        $this->createText();
        $this->outPut();
    }
    private function createCode()
    {
        //生成 0-9 a-z A-Z
        $arr_str=array_merge(range('a','z'),range(0,9),range('A','Z'));
        //打乱数组三次

        for($i = 0; $i < 3; $i++)
        {
            shuffle($arr_str);
        }

        //随机选验证码对应元素的下标
       $arr_index = array_rand($arr_str,$this->codeLength);
       //print_r($arr_str);
       //print_r($arr_index);
        $str='';

        //生成验证码字符串
        foreach($arr_index as $i)
        {
            $str.=$arr_str[$i];
        }

        //echo $str;
        return $str;
    }
    private function createImage()
    {
        return imagecreatetruecolor($this->width,$this->height);
    }
    private function createBg()
    {
        //背景颜色 每次都会随机颜色
        $color=imagecolorallocate($this->img,mt_rand(0,225),mt_rand(0,200),mt_rand(0,255));

        //矩形的颜色
        imagefilledrectangle($this->img,0,0,$this->width,$this->height,$color);
    }

    private function createText()
    {
        $color=imagecolorallocate($this->img,mt_rand(0,225),mt_rand(0,200),mt_rand(0,255));
        imagettftext($this->img,$this->fontSize,0,5,30,$color,$this->fontFile,$this->code);

    }
    private function outPut()
    {
        echo  $this->fontFile;
        //声明输出内容的MIME类型
        //header("content-type:image/png");
        //imagepng($this->img);
        //imagedestroy($this->img);
    }

}

