<?php
namespace Api\Controller;
use Api\Common\Controller\AuthController;
class HomeController extends AuthController {


    public function index(){
        $memberId = $this->uid;
        $userInfo = M("Member")
        ->alias("M")
        ->field("M.id,M.realname,M.study_duration DIV 60 as total_time,MI.avatar")
        ->join("__MEMBER_INFO__ as MI on M.id=MI.member_id","LEFT")
        ->where("M.id = $memberId")
        ->fetchSql(false)
        ->find();


        $thumbUrl = OSS_BASE_URL .'/images/';
        $recordList = array();
        $recordCondition = array(
            "SR.member_id"      =>$memberId
        );
        $recordList = M("StudyRecord")
        ->alias("SR")
        ->field("SR.*,SEC_TO_TIME(SR.play_time) as record_time,CONCAT('$thumbUrl',C.thumb) as thumb,C.title as course_title,S.title as section_title")
        ->join("__COURSE__ as C on C.id = SR.course_id")
        ->join("LEFT JOIN __COURSE_SECTION__ as S on S.id = SR.section_id")
        ->where($recordCondition)
        ->order("SR.time desc")
        ->limit(5)
        ->select();
        $backData = array(
            "code" =>200,
            "msg"  =>"success",
            "data"      =>array(
                "userInfo"  =>$userInfo,
                "recordList"    =>$recordList
            )
        );
        $this->ajaxReturn($backData);
    }



    /**
     * 我的课程
     **/
    function mycourse(){
        $thumbUrl = OSS_BASE_URL .'/images/';
        $memberId = $this->uid;
        $page = I("get.page/d",1);
        $pageSize=10;
        $condition = array(
            "MC.member_id" =>$memberId
        );
        $total = M("MyCourse")->alias("MC")->where($condition)->count();
        $list = M("MyCourse")
        ->alias("MC")
        ->field("C.id,C.title,CONCAT('$thumbUrl',C.thumb) as thumb,MC.progress")
        ->join("__COURSE__ as C on MC.course_id = C.id")
        ->page($page,$pageSize)
        ->order("MC.id desc")
        ->where($condition)
        ->fetchSql(false)
        ->select();


        $pageInfo = array(
            "page"  =>$page,
            "pageSize"  =>$pageSize,
            "total"     =>intval($total)
        );
        $backData = array(
            "code"=>200,
            "msg"   =>"success",
            "data"  =>array(
                "list"  =>$list,
                "pageInfo"  =>$pageInfo
            )
        );
        $this->ajaxReturn($backData);

    }





    /**
     * 我的评论
    **/

    public function mycomment($page=1){
        $memberId = A("Account")->getMemberId();
        $list = M("Comment")
            ->alias("C")
            ->field("C.*,M.nickname,M.avatar,R.content as reply,R.create_time as reply_time")
            ->join("__MEMBER_INFO__ as M on M.member_id=C.member_id")
            ->join("LEFT JOIN __REPLY__ as R on R.comment_id=C.id")
            ->where(" C.member_id=$memberId")
            ->page($page,15)
            ->order('C.id desc')
            ->select();
        if($list !== false){
            $backData = array(
                "errorCode" =>10000,
                "errorMsg"  =>"success",
                "list"      =>$list
            );
        }else {
            $backData = array(
                "errorCode" =>10001,
                "errorMsg"  =>"数据错误"
            );
        }
        $this->ajaxReturn($backData);
    }
   



    /**
     * 建议
     */
    public function feedback(){
        if(IS_POST){
            $model = M("Feedback");
            $insertData = array(
                "member_id"     =>$this->uid,
                "content"       =>I("post.content"),
                "contact"       =>I("post.contact")
            );
            $insertResult = $model->data($insertData)->add();
            if(!$insertResult){
                $backData = array(
                    "code" =>13001,
                    "msg"  =>"系统错误请稍后再试"
                );
                $this->ajaxReturn($backData);
            }else {
                $backData = array(
                    "code" =>200,
                    "msg"  =>"success"
                );
                $this->ajaxReturn($backData);
            }
        }
    }



}