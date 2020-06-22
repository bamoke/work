<?php
/**
 * 班级
 */
namespace Api\Controller;
// use Think\Controller;
use Api\Common\Controller\AuthController;
class IndexController extends AuthController {

    public function index(){
        $superId = array("0"=>1,"1"=>11);
        $mobile = $this->mobile;
        $page = I("get.page/d",1);
        $pageSize = 10;
        if(in_array($this->uid,$superId)) {
            $classList = M("Class")
            ->alias("CS")
            ->field("CS.*,(select count(*) from x_course where class_id=CS.id) as course_total,(select count(*) from x_class_students where class_id=CS.id) as student_total")
            ->where($condition)
            ->page($page,$pageSize)
            ->fetchSql(false)
            ->select();
        }else {
            $condition = array(
                "CS.mobile"     =>$mobile
            );
            $classList = M("ClassStudents")
            ->alias("CS")
            ->join("__CLASS__ C on CS.class_id= C.id")
            ->field("C.*,(select count(*) from x_course where class_id=C.id) as course_total,(select count(*) from x_class_students where class_id=C.id) as student_total")
            ->where($condition)
            ->page($page,$pageSize)
            ->fetchSql(false)
            ->select();
        }

        $backData = array(
            "code" =>200,
            "msg"  =>"success",
            "data" =>array(
                "classList"        =>$classList
                )
        );
        $this->ajaxReturn($backData);


    }

    /**
     * 班级课程
     */
    public function course(){
        $classId = I("get.classid/d");
        if(empty($classId)) {
            $backData = array(
                "code" => 10001,
                "msg" => "参数错误"
            );
            return $this->ajaxReturn($backData);
        }

        // 更新班级学员memberid
        $studentModel = M("ClassStudents");
        $studentCondition = array(
            "mobile"    =>$this->mobile,
            "class_id"  =>$classId
        );
        $studentInfo = $studentModel->where($studentCondition)->find();
        // var_dump($studentInfo["member_id"]);
        if(!$studentInfo['member_id']) {
            $updateData = array(
                "member_id" =>$this->uid,
                "bind_time" =>time()
            );
            $updateWhere = array(
                "id"    =>$studentInfo["id"]
            );
            $updateStudent = $studentModel->where($updateWhere)->data($updateData)->save();

        }

        $thumbUrl = OSS_BASE_URL .'/images/';

        $courseCondition = array(
            "C.class_id"    =>$classId,
            "C.status"=>1
        );


        $page = I("get.page/d",1);
        $pageSize = 10;
        $memberId = $this->uid;
        $total = M("Course")->alias("C")->where($courseCondition)->count();        
        $courseList = M("Course")
        ->alias("C")
            ->field("C.id,C.title,C.type,concat('$thumbUrl',C.thumb) as thumb,C.description,C.period,IFNULL(MC.progress,0) as progress")
            ->join("LEFT JOIN __MY_COURSE__ as MC on MC.course_id = C.id and member_id = $memberId")
            ->where($courseCondition)
            ->page($page,$pageSize)
            ->fetchSql(false)
            ->select();
        //字符截取
        $String = new \Org\Util\String();
        foreach($courseList as $k=>$v){
            $courseList[$k]['title'] = $String->msubstr($v['title'],0,15,$charset="utf-8", $suffix=false);
            $courseList[$k]['description'] = $String->msubstr($v['description'],0,15,$charset="utf-8", $suffix=false);
        }
        $pageInfo = array(
            "page"  =>$page,
            "pageSize"  =>$pageSize,
            "total"     =>intval($total)
        );
        if($courseList !==false){
            $backData = array(
                "code"     =>200,
                "msg"      =>"success",
                "data"  =>array(
                    "list" =>$courseList,
                    "pageInfo"=>$pageInfo,
                )
            );
        }else {
            $backData = array(
                "code"     =>13001,
                "msg"      =>"数据读取错误"
            );
        }
        $this->ajaxReturn($backData);
    }


}