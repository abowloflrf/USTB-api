<?php
namespace API\CourseHandler;

class Course
{
    //输入JSON对象，返回JSON数组
    public static function Simplify($SingleCourseJSON)
    {
        //可能会有多个教师因此列成数组
        $teachers=[];
        if(count($SingleCourseJSON->JSM)>=0)
        {
            foreach ($SingleCourseJSON->JSM as $teacher) {
                array_push($teachers,$teacher->JSM);
            }
        }
        $course_info=[
            'course_name'=>$SingleCourseJSON->KCM,
            'teachers'=>$teachers,
            //FIXME:MOOC没有上课时间地点老师，需要再添加一项备注remark=>"慕课"
            'direct_msg'=>$SingleCourseJSON->SKSJDDSTR,
            'capacity'=>$SingleCourseJSON->SKRS,
            'credit'=>$SingleCourseJSON->XF,
            'detail'=>$SingleCourseJSON->SKSJDD
        ];

        return $course_info;
    }

    //只发返回课程名，分数，学分
    public static function PrettySimplify($SingleCourseJSON)
    {
        $course_info=[
            'course_name'=>$SingleCourseJSON->KCM,
            'credit'=>(float)$SingleCourseJSON->XF,
            'score'=>(float)$SingleCourseJSON->GPACJ
        ];
        return $course_info;
    }
}