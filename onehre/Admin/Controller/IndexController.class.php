<?php
namespace Admin\Controller;
use Admin\Common\Auth;
// use Think\Controller;
class IndexController extends Auth {
    public function home(){
        $teacherNum = M("Teacher")->count();
        $courseNum = M("Course")->count();
        $memberNum = M("CourseMember")->count();
        $commentNum = M("CourseGrade")->count();
        $backData = array(
            "code"  =>200,
            "msg"   =>'success',
            'data'  =>array(
                "teahcerNum"    =>intval($teacherNum),
                "courseNum"     =>(int)$courseNum,
                "memberNum"     =>(int)$memberNum,
                "commentNum"    =>(int)$commentNum
            )
        );
        $this->ajaxReturn($backData);
    }
}