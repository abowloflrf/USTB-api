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
}