<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \API\BaseCurl\Curl;
use \API\CourseHandler\Course;

class QueryController extends Controller
{
    public $JSEESIONID = "";
    public $STATUS = "ERROR";

    public function __construct(Request $request)
    {
        //拼接request中的学号密码
        $post_data = "j_username=" . $request->id . "%2Cundergraduate&j_password=" . $request->pw;
        $output=Curl::getJSON("http://elearning.ustb.edu.cn/choose_courses/j_spring_security_check",$post_data,null,1);
        $outputArr = explode("\r\n", $output);
        foreach ($outputArr as $header) {
            if (strpos($header, "JSESSIONID")) {
                $header = substr($header, 23);
                $header = substr($header, 0, stripos($header, ';'));
                $this->JSEESIONID = $header;
            }
            if (strpos($header, "loginsucc.action")) {
                $this->STATUS = "OK";
            }
        }

    }

    //获取验证信息
    public function getInfo()
    {
        $data = [
            'status' => $this->STATUS,
            'jsessionid' => $this->JSEESIONID
        ];
        return $data;
    }
    //创新学分
    public function getInnovativeCredit()
    {
        //验证不通过直接返回错误信息
        if ($this->STATUS == "ERROR")
            return array(['status' => 'error']);
        //初始化curl
        $htmlDom = Curl::getDOM("http://elearning.ustb.edu.cn/choose_courses/information/singleStuInfo_singleStuInfo_loadSingleStuCxxfPage.action", $this->JSEESIONID);
        //解析dom
        $tableBody = $htmlDom->getElementsByTagName('tbody');
        $tableBody = $tableBody->item(0);
        //总创新学分
        $totalCredit = 0;
        $eachCredit=[];
        foreach ($tableBody->childNodes as $table)
            {
            $singleData = [
                'class_name' => $table->childNodes->item(2)->nodeValue,
                'credit' => (float)$table->childNodes->item(3)->nodeValue
            ];
            $totalCredit += (float)$table->childNodes->item(3)->nodeValue;
            array_push($eachCredit, $singleData);
        }

        $returnData=[
            'status'=>'OK',
            'total_credit'=>$totalCredit,
            'single_credit'=>$eachCredit
        ];

        return $returnData;
    }

    public function getScore()
    {
        //验证不通过直接返回错误信息
        if ($this->STATUS == "ERROR")
            return array(['status' => 'error']);
        //初始化成功时的返回信息返回信息
        $returnData = [];
        $htmlDom = Curl::getDOM("http://elearning.ustb.edu.cn/choose_courses/information/singleStuInfo_singleStuInfo_loadSingleStuScorePage.action", $this->JSEESIONID);
        //解析dom
        $table = $htmlDom->getElementsByTagName('table');
        $table = $table->item(0);
        $mainScoreNodes = [];
        $scores = [];//所有已出成绩详细
        foreach ($table->childNodes as $node) {
            if ($node->nodeName == 'h5')
                array_push($mainScoreNodes, $node->nodeValue);
            if ($node->nodeName == 'tbody') {
                foreach ($node->childNodes as $tableRow) {
                    $singleCourse = [];
                    $tdNodes = $tableRow->getElementsByTagName('td');
                    $singleCourse['semester'] = $tdNodes->item(0)->nodeValue;
                    $singleCourse['course_id'] = $tdNodes->item(1)->nodeValue;
                    $singleCourse['course_name'] = $tdNodes->item(2)->nodeValue;
                    $singleCourse['course_type'] = $tdNodes->item(3)->nodeValue;
                    $singleCourse['course_period'] = $tdNodes->item(4)->nodeValue;
                    $singleCourse['course_credit'] = $tdNodes->item(5)->nodeValue;
                    if (is_numeric($tdNodes->item(6)->nodeValue)) {
                        $singleCourse['first_score'] = (float)$tdNodes->item(6)->nodeValue;
                        $singleCourse['final_score'] = (float)$tdNodes->item(7)->nodeValue;
                    }
                    else {
                        $singleCourse['first_score'] = $tdNodes->item(6)->nodeValue;
                        $singleCourse['final_score'] = $tdNodes->item(7)->nodeValue;
                    }

                    array_push($scores, $singleCourse);
                }
            }
        }
        array_pop($mainScoreNodes);
        $mainScores = [];//0=>GPA,1=>AVG
        foreach ($mainScoreNodes as $mainString) {
            array_push($mainScores, (float)substr($mainString, strpos($mainString, ':') + 1));
        }

        return [
            'status'=>'OK',
            'gpa' => $mainScores[0],
            'avg' => $mainScores[1],
            'scores'=>$scores
        ];
    }

    public function getTimetable(Request $request)
    {
        //验证不通过直接返回错误信息
        if ($this->STATUS == "ERROR")
            return array(['status' => 'error']);
        //curl请求
        $post_data = "listXnxq=" . $request->semester;
        $output=Curl::getJSON("http://elearning.ustb.edu.cn/choose_courses/choosecourse/commonChooseCourse_courseList_loadTermCourses.action",$post_data,$this->JSEESIONID,0);
        $output=json_decode($output);
        $timetable=[];
        foreach($output->selectedCourses as $course)
        {   
            array_push($timetable,Course::Simplify($course));
        }
        return $timetable;
    }
    public function getElectiveScore()
    {
        //验证不通过直接返回错误信息
        if ($this->STATUS == "ERROR")
        return array(['status' => 'error']);

        $post_data="limit=5000&start=0";
        $output=Curl::getJSON("http://elearning.ustb.edu.cn/choose_courses/choosecourse/normalChooseCourse_normalPublicSelective_loadFormalNormalPublicSelectiveCourses.action",$post_data,$this->JSEESIONID,0);
        $output=json_decode($output);
        $learnedCourses=[];
        $totalCredit=0;
        foreach($output->learnedPublicCourses as $singleCourse)
        {
            array_push($learnedCourses,Course::PrettySimplify($singleCourse));
            if((float)$singleCourse->GPACJ>=60)
            {
                $totalCredit+=(float)$singleCourse->XF;
            }
        }
        
        return [
            'status'=>'OK',
            'total_credit'=>$totalCredit,
            'need_credit'=>(float)$output->zxf,
            'learned_courses'=>$learnedCourses
        ];
        
        

    }
}
