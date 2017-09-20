<?php
namespace API\BaseCurl;

class Curl
{
    public static function getDOM($url,$jsessionid)
    {
        //初始化curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Cookie: JSESSIONID=' . $jsessionid));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        //解析htmldom
        $htmlDom = new \DOMDocument();
        $htmlDom->loadHTML($output);
        return $htmlDom;
    }

    public static function getJSON($url,$data,$jsessionid,$withHeader)
    {
        //初始化url
        $ch = curl_init($url);
        //为了得到Cookie，设置接受header信息
        curl_setopt($ch, CURLOPT_HEADER, $withHeader);
        //需要返回字符串
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //设置需要post的数据
        if($data!=null){
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        //设置请求Header
        if($jsessionid!=null){
            curl_setopt($ch,CURLOPT_HTTPHEADER,array('Cookie: JSESSIONID='.$jsessionid));
        }
        //执行请求并将结果储存在output中
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}