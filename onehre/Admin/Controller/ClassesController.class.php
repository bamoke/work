<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-10 20:05:00 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 00:52:03
 */

namespace Admin\Controller;
use Admin\Common\Auth;
 class ClassesController extends Auth {

    /**
     * 获取班级动态
     */
    public function dynamic(){
      if(empty($_GET["courseid"])){
        $backData = array(
          'code'      => 13000,
          "msg"       => "非法请求"    
        );
        $this->ajaxReturn($backData);     
      }
      $courseId = I("get.courseid");
      $page = I("get.page/d",1);
      $pageSize=20;
      $condition = array(
        "CD.course_id"  =>$courseId
      );
      $total = M("CourseDynamic")->alias("CD")->where($condition)->count();
      $list = M("CourseDynamic")
      ->alias("CD")
      ->field("CD.*,CM.realname as membername")
      ->join("__COURSE_MEMBER__ as CM on CD.member_id= CM.id")
      ->where($condition)
      ->page($page,$pageSize)
      ->fetchSql(false)
      ->order('id desc')
      ->select();
      $backData = array(
        'code'      => 200,
        "msg"       => "ok",
        'data'      => array(
            "list"  =>$list,
            "total" =>intval($total),
            "page"  =>$page,
            "pageSize"  =>$pageSize,
            "hasMore" =>$total > $page*$pageSize
        )
      );
      $this->ajaxReturn($backData);
    }

    // 班级主页
    public function index(){
      if(empty($_GET["id"])){
        $backData = array(
          'code'      => 13000,
          "msg"       => "非法请求"    
        );
        $this->ajaxReturn($backData);     
      }
      $courseId = I("get.id");
      $page = I("get.p/d",1);
      $pageSize=20;
      $dynamicCondition = array(
        "CD.course_id"  =>$courseId
      );
      $courseInfo = M("Course")->field("id,title,type")->where(array("id"=>$courseId))->find();
      $dynamicTotal = M("CourseDynamic")->alias("CD")->where($dynamicCondition)->count();
      $dynamicList = M("CourseDynamic")
      ->alias("CD")
      ->field("CD.*,CM.realname as membername")
      ->join("__COURSE_MEMBER__ as CM on CD.member_id= CM.id")
      ->where($dynamicCondition)
      ->page($page,$pageSize)
      ->fetchSql(false)
      ->select();

      $backData = array(
        'code'      => 200,
        "msg"       => "success",
        "data"      =>array(
          "courseInfo"  =>$courseInfo,
          "dynamicHasmore"  => $dynamicTotal > $page*$pageSize,
          "dynamicList" =>$dynamicList
        )    
      );
      $this->ajaxReturn($backData);     
    }




  /**
   * 笔记
   */
  public function notes(){
    if(empty($_GET["courseid"])){
      $backData = array(
        'code'      => 13000,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);     
    }
    $courseId = I("get.courseid");
    $page = I("get.page/d",1);
    $pageSize=20;
    $condition = array(
      "CN.course_id"  =>$courseId
    );
    $total = M("CourseNotes")->alias("CN")->where($condition)->count();
    $list = M("CourseNotes")
    ->alias("CN")
    ->field("CN.*,CM.realname as membername")
    ->join("__COURSE_MEMBER__ as CM on CN.member_id= CM.id")
    ->where($condition)
    ->page($page,$pageSize)
    ->fetchSql(false)
    ->order('id desc')
    ->select();
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "list"  =>$list,
          "total" =>intval($total),
          "page"  =>$page,
          "pageSize"  =>$pageSize,
          "hasMore" =>$total > $page*$pageSize
      )
    );
    $this->ajaxReturn($backData);
  }

  /**
  * 点评记录
  */
 public function remark(){
   if(empty($_GET["courseid"])){
     $backData = array(
       'code'      => 13000,
       "msg"       => "非法请求"    
     );
     $this->ajaxReturn($backData);     
   }
   $courseId = I("get.courseid");
   $page = I("get.page/d",1);
   $pageSize=20;
   $condition = array(
     "CG.course_id"  =>$courseId
   );
   $total = M("CourseGrade")->alias("CG")->where($condition)->count();
   $list = M("CourseGrade")
   ->alias("CG")
   ->field("CG.*,CM.realname as membername")
   ->join("__COURSE_MEMBER__ as CM on CG.member_id= CM.id")
   ->where($condition)
   ->page($page,$pageSize)
   ->fetchSql(false)
   ->order('id desc')
   ->select();
   $backData = array(
     'code'      => 200,
     "msg"       => "ok",
     'data'      => array(
         "list"  =>$list,
         "total" =>intval($total),
         "page"  =>$page,
         "pageSize"  =>$pageSize,
         "hasMore" =>$total > $page*$pageSize
     )
   );
   $this->ajaxReturn($backData);
 }




  //==============//
 }