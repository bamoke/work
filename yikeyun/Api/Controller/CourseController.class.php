<?php
namespace Api\Controller;
use Api\Common\Controller\AuthController;
class CourseController extends AuthController {

    /**
     * 课程列表
    */
    public function vlist(){
        $thumbUrl = XZSS_BASE_URL .'/thumb/';
        $cateList = M('MainCate')->where('pid !=0 and identification = "course"')->fetchSql(false)->select();
        $orderBy = "C.recommend desc,C.sort,C.id desc";
        $courseCondition = array(
            "C.status"=>1
        );
        $cid = I("get.cid/d",0);
        if($cid){
            $courseCondition['C.cate_id'] = intval($cid);
        }
        if(!empty($_GET['tag'])){
            $tag = I("get.tag");
            if($tag == 'hot'){
                $orderBy = 'C.study_num desc,C.recommend desc,C.sort,C.id desc';
            }elseif($tag== 'free'){
                $courseCondition['isfree'] = 1;
            }elseif($tag=='latest'){
                $orderBy = 'C.id desc';
            }
        }
        $page = I("get.page/d",1);
        $pageSize = 10;
        $total = M("Course")->alias("C")->where($courseCondition)->count();        
        $courseList = M("Course")
        ->alias("C")
            ->field("C.id,C.title,C.type,concat('$thumbUrl',C.thumb) as thumb,C.description,C.isfree,C.price,C.period,C.study_num,CATE.name as cate_name")
            ->join("__MAIN_CATE__ as CATE on C.cate_id=CATE.id")
            ->where($courseCondition)
            ->page($page,$pageSize)
            ->order($orderBy)
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
            "total"     =>$total
        );
        if($cateList && $courseList !==false){
            $backData = array(
                "code"     =>200,
                "msg"      =>"success",
                "data"  =>array(
                    "cateList"   =>$cateList,
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

    /**
     * 课程详情
    */
    public function detail(){
        if(empty($_GET['id'])) {
            $backData = array(
                "code" => 10001,
                "msg" => "参数错误"
            );
            return $this->ajaxReturn($backData);
        }
        $thumbUrl = OSS_BASE_URL .'/images/';
        $videoBaseUrl = OSS_BASE_URL . "/video/";
        $courseId = I("get.id");
        $memberId = $this->uid;


        // 4.生成我的课程
        $myCourseCondition = array(
            "member_id"     =>$this->uid,
            "course_id"     =>$courseId
        );
        $myCourseInfo = M("MyCourse")->where($myCourseCondition)->find();
        $myCourseProgress = $myCourseInfo['progress'];
        if(!$myCourseInfo) {
            $insertMyCourseData = array(
                "member_id"     =>$this->uid,
                "course_id"     =>$courseId,
                "progress"      =>0
            );
            $insertMyCourseResult = M("MyCourse")->data($insertMyCourseData)->add();
            $myCourseProgress = 0;
        }

        // 1. 获取课程数据
        $courseInfo = M('Course')
            ->alias("C")
            ->field("C.*,CONCAT('$thumbUrl',C.thumb) as thumb,IF(C.source != '',CONCAT('$videoBaseUrl',C.source),'') as source")
            ->where("C.id = $courseId")
            ->fetchSql(false)
            ->find();
        $courseInfo["progress"] = $myCourseProgress;
        if($courseInfo['content']){
            $courseInfo['content'] = str_replace('src="/Upload/images','src="'.XZSS_BASE_URL.'/images',$courseInfo['content']);
        }

        if($courseInfo["type"] == 1) {
            // 2.获取章节数据
            $sectionCondition = array(
                "CS.course_id"     =>$courseId
            );

            $sectionList = M('CourseSection')
            ->alias("CS")
            ->field("CS.* ,CONCAT('$videoBaseUrl',source) as video, IFNULL(SR.play_time,0) as initial_time, SEC_TO_TIME(SR.play_time) as record_time,IFNULL(SR.complete,0) as complete")
            ->join ("LEFT JOIN __STUDY_RECORD__ as SR on SR.section_id=CS.id and member_id = $memberId")
            ->where($sectionCondition)
            ->order('CS.sort,CS.id')
            ->limit(20)
            ->select();
        }else {
            // 获取单节课程观看时间节点
            $recordCondition = array(
                "course_id"     =>$courseId,
                "member_id"     =>$memberId
            );
            $recordInfo = M("StudyRecord")
            ->where($recordCondition)
            ->field("play_time as initial_time,SEC_TO_TIME(play_time) as record_time")
            ->find();
            $courseInfo["initial_time"] =$recordInfo["initial_time"];
            $courseInfo["record_time"] =$recordInfo["record_time"];

        }

        // 3.获取讲师数据
        $teacherCondition =array(
            "id"    =>$courseInfo['teacher_id']
        );
        $teacherInfo = M("Teacher")->field("id,name,position,CONCAT('$thumbUrl',avatar) as avatar")->where($teacherCondition)->find();

 


 


        $backData = array(
            "code" =>200,
            "msg"  =>"success",
            "data" =>array(
                "info"  =>$courseInfo,
                "teacherInfo"   =>$teacherInfo,
                "sectionList"     =>$sectionList,
                "isCollected"  =>$isCollected,
                "studyStage"    =>$studyStage,
                "isStudent"     =>$isStudent,
                "commentList"   =>$commentList
            )
        );
        $this->ajaxReturn($backData);
    }



    /**
     * 课程目录
     * @param int   $courseid    课程ID
     * @param int   $page   页码
    */
    public function section(){
        if(empty($_GET['courseid'])){
            $backData = array(
                "code" => 10001,
                "msg" => "参数错误"
            );
            return $this->ajaxReturn($backData);
        }
        $videoBaseUrl = OSS_BASE_URL . "/video/";
        $page = I("get.page/d",1);
        $courseId = I("get.courseid");
        $sectionList = M('CourseSection')
        ->field("*,CONCAT('$videoBaseUrl',source) as video")
        ->where(array('course_id'=>$courseId))
        ->order('id')
        ->page($page,50)
        ->select();
        if($sectionList !==false){
            $backData = array(
                "code"     =>200,
                "msg"      =>"success",
                "data"      =>array(
                    "list" =>$sectionList
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





    /**
     * 观看记录,更新章节记录，更新我的课程进度
     * courseid
     * sectionid
     * time
     */
    public function study_record(){
        if(empty($_GET['courseid'])){
            $backData = array(
                "code" => 10001,
                "msg" => "参数错误"
            );
            return $this->ajaxReturn($backData);  
        }
        $courseId = I("get.courseid/d");
        $sectionId = I("get.sectionid/d",0);
        $newPlayTime = I("get.time");
        $percent = I("get.percent");

        $courseInfo = M("Course")->field("type,period")->find($courseId);
        if($courseInfo["type"] == 1  && empty($_GET["sectionid"])){
            $backData = array(
                "code" => 10001,
                "msg" => "参数错误"
            );
            return $this->ajaxReturn($backData);  
        }

        // 更新观看记录
        $recordModel = M("StudyRecord");
        if($courseInfo['type'] == 1) {
            $recordCondition = array(
                "member_id"     =>$this->uid,
                "section_id"    =>$sectionId
            );
        }else {
            $recordCondition = array(
                "member_id"     =>$this->uid,
                "course_id"    =>$courseId
            );
        }
        $recordInfo = $recordModel->where($recordCondition)->find();
        if($recordInfo) {
            $updateRecordData = array(
                "play_time"     =>$newPlayTime,
                "time"          =>time()
            );
            if($recordInfo["complete"] < 100) {
                $updateRecordData["complete"] = $percent;
            }
            $updateResult = $recordModel->where(array("id"=>$recordInfo["id"]))->data($updateRecordData)->save();
        }else {
            $insertRecordData =array(
                "type"          =>$courseInfo["type"],
                "member_id"     =>$this->uid,
                "course_id"     =>$courseId,
                "section_id"    =>$sectionId,
                "complete"      =>$percent,
                "play_time"     =>$newPlayTime,
                "time"          =>time()
            );
            $insertResult = $recordModel->data($insertRecordData)->add();

        }

        // 更新课程学习进度
        
        $myCondition = array(
            "member_id"     =>$this->uid,
            "course_id"     =>$courseId
        );
        $recordAllPercent = $recordModel->where($myCondition)->sum("complete");
        $newCourseProgress = $recordAllPercent / $courseInfo['period'];
        $myCourseData = array(
            "progress"  =>$newCourseProgress
        );
        $myCourseUpdate = M("MyCourse")->where($myCondition)->data($myCourseData)->save();

        // 更新累计学习时长
        $updateTotalTime = M("Member")
        ->where(array("id"=>$this->uid))
        ->setInc("study_duration",5);
        
        $backData = array(
            "code"     =>200,
            "msg"      =>"success"
        );
        $this->ajaxReturn($backData);


    }

}