<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

//继承关系还没搞清楚，先无视掉
class GetDataController extends AuthController
{
    public function __construct() {
        if ($this->STATUS=="ERROR"){
            return json_encode([
                'status'=>'error'
            ]);
        }
    }

    public function getInnovativeCredit()
    {
        $ch=curl_init("http://elearning.ustb.edu.cn/choose_courses/information/singleStuInfo_singleStuInfo_loadSingleStuCxxfPage.action");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Cookie: JSESSIONID=' . $this->JSEESIONID)); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $output = curl_exec($ch);
        var_dump($output);

    }
}