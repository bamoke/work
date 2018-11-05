<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class DiscussController extends BaseController {

  /**
   * 获取当前课程的成员ID
   */
  protected function fetchMemberId($courseId){
    $memberId = null;
    $condition = array(
      "coourse_id"=>$courseId,
      "uid"   =>$this->uid,
      "status"  =>1
    );
    $courseMember = M("CourseMember")
    ->field("id")
    ->where($condition)
    ->find();
    if($courseMember) {
      $memberId = $courseMember['id'];
    }
    return $memberId;
  }
  /**
   * News list
   * @condition
   * @page
   */
  public function index(){
    if(empty($_GET["obj_id"]) || empty($_GET['type'])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $objId = I("get.obj_id");
    $discussType = I("get.type");
    $page = I("get.p/d",1);
    $pageSize = 20;
    $condition = array(
      "DM.uid"    =>$this->uid,
      "DC.obj_id"     =>$objId,
      "DC.type"   =>$discussType
    );

    $list = M("DiscussMember")
    ->alias("DM")
    ->field("DM.uid,DC.id,DC.title as discuss_name,DC.stage")
    ->join("__DISCUSS__ as DC on DC.id=DM.dc_id")
    ->where($condition)
    ->page($page,$pageSize)
    ->fetchSql(false)
    ->select();


    $backData = array(
      "code"      =>200,
      "msg"       =>"ok",
      "data"      => array(
        "list"  =>$list
      )
    );
    $this->ajaxReturn($backData);  
  }



  /**
   * Detail 讨论组详情
   * @id
   */
  public function detail(){
    if(empty($_GET["id"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $discussId = I("get.id");
    $memberCondition = array(
      "dc_id" =>$discussId,
      "uid"   =>$this->uid
    );
    $memberInfo = M("DiscussMember")->where($memberCondition)->find();
    if(!$memberInfo) {
      $backData = array(
        "code"  => 14001,
        "msg"   => "不是讨论组成员"
      );  
      $this->ajaxReturn($backData);  
    }
    $discussInfo = M("Discuss")->field("title,stage,type")->where("id=$discussId")->find();

    $nodesList = M("DiscussNode")->where(array("dc_id"=>$discussId))->select();
    $nodeIdArr = array();
    if(count($nodesList)) {
      foreach($nodesList as $key=>$val){
        array_push($nodeIdArr,$val['id']);
      }
    }

    $nodeIdList = implode(",",$nodeIdArr);
    $contentCondition = array(
      "DC.node_id"=>array("in",$nodeIdList)
    );

    if($discussInfo['type'] ==  1){
      $contentList = M("DiscussContent")
      ->alias("DC")
      ->field("DC.*,CM.realname as membername")
      ->join("__COURSE_MEMBER__ as CM on DC.uid=CM.uid")
      ->where($contentCondition)
      ->limit(10)
      ->fetchSql(false)
      ->select();
    }elseif($discussInfo['type'] ==  2){
      $contentList = M("DiscussContent")
      ->alias("DC")
      ->field("DC.*,PM.realname")
      ->join("__PARTTIME_MEMBER__ as PM on DC.uid=PM.uid")
      ->where($contentCondition)
      ->limit(10)
      ->select();
    }

    $nodes = array();
    if(count($nodesList)) {
      foreach ($nodesList as $key=>$val){
        $nodeContentList = array();
        if(count($contentList)) {
          foreach($contentList as $k=>$v){
            if($v['node_id'] == $val['id']) {
              $nodeContentList[] = $v;
            }
          }
        }
        $nodes[] = array(
          "id"=>$val['id'],
          "title"=>$val['title'],
          "contentList" =>$nodeContentList
        );
      }
    }

    $backData = array(
        "code"      =>200,
        "msg"       =>"ok",
        "data"      => array(
          "discuss" =>$discussInfo,
          "memberInfo"  =>$memberInfo,
          "nodes"  =>$nodes
        )
    );
    $this->ajaxReturn($backData);
  }

    /**
   * 更多内容
   */
  public function more(){
    if(empty($_GET["nodeid"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $nodeId = I("get.nodeid");
    $page = I("get.p/d",1);
    $pageSize=20;
    $condition = array(
      "node_id"  =>$nodeId
    );
    $total = M("DiscussContent")->where($condition)->count();
    $list = M("DiscussContent")
    ->where($condition)
    ->page($page,$pageSize)
    ->select();
 
    $backData = array(
        "code"      =>200,
        "msg"       =>"ok",
        "data"      => array(
          "list"  =>$list,
          "page"  =>$page,
          "total" =>$total,
          "hasMore" => $total - ($page*$pageSize) > 0
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
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $courseId = I("get.courseid");
    $page = I("get.p/d",1);
    $pageSize=8;
    $condition = array(
      "course_id"  =>$courseId,
      "uid"         =>$this->uid
    );
    $total = M("CourseNotes")->where($condition)->count();
    $list = M("CourseNotes")
    ->where($condition)
    ->page($page,$pageSize)
    ->select();
 
    $backData = array(
        "code"      =>200,
        "msg"       =>"ok",
        "data"      => array(
          "list"  =>$list,
          "page"  =>$page,
          "total" =>$total,
          "hasMore" => $total - ($page*$pageSize) > 0
        )
    );
    $this->ajaxReturn($backData);
  }

  /**
   * 讨论组内容详情
   */
  public function content(){
    if(empty($_GET["contentid"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $contentId = I("get.contentid");
    $contentInfo = M("DiscussContent")->where("id=$contentId")->find();
    $discussInfo = M("Discuss")
    ->alias("D")
    ->field("D.*")
    ->join("__DISCUSS_NODE__ as DN on DN.dc_id=D.id")
    ->where(array("DN.id"=>$contentInfo['node_id']))
    ->find();
    if($discussInfo['type'] == 1) {
      $commentJoinTable = "__COURSE_MEMBER__";
      $memberModelName = "CourseMember";
      $memberCondition = array(
        "course_id" =>$discussInfo['obj_id'],
        "uid"       =>$this->uid
      );
    }elseif($discussInfo['type'] == 2){
      $commentJoinTable = "__PARTTIME_MEMBER__";
      $memberModelName = "ParttimeMember";
      $memberCondition = array(
        "pt_id"     =>$discussInfo['obj_id'],
        "uid"       =>$this->uid
      );
    }
    $memberInfo = M($memberModelName)->where($memberCondition)->find();
    $contentInfo['member_name'] = $memberInfo['realname'];

    // 获取评论列表
    $commentCondition = array(
      "DC.content_id" =>$contentId
    );
    $total = M("DiscussComment")->alias("DC")->count();
    $commentList = M("DiscussComment")
    ->alias("DC")
    ->field("DC.*,MB.realname as membername")
    ->join($commentJoinTable."  as MB on MB.uid=DC.uid")
    ->where($commentCondition)
    ->order("DC.id desc")
    ->limit(20)
    ->select();

    $backData = array(
      "code"  => 200,
      "msg"   => "success",
      "data"  =>array(
        "content" =>$contentInfo,
        "comment"=>$commentList,
        "hasMore"=>$total > 20
      )
    );  
    $this->ajaxReturn($backData); 
  }


  /***
   * 保存评论
   */
  public function savecomment(){
    if(!IS_POST){
      $backData = array(
        "code"  => 10001,
        "msg"   => "非法请求"
      );  
      $this->ajaxReturn($backData); 
    }
    // 通过contentID网上查找用户的名字
    $contentId = I("post.contentid");
    $contentInfo = M("DiscussContent")->field("node_id")->where("id=$contentId")->find();
    $discussInfo = M("Discuss")
    ->alias("D")
    ->field("D.*")
    ->join("__DISCUSS_NODE__ as DN on DN.dc_id=D.id")
    ->where(array("DN.id"=>$contentInfo['node_id']))
    ->find();
    if($discussInfo['type'] == 1) {
      $memberModelName = "CourseMember";
      $memberCondition = array(
        "course_id" =>$discussInfo['obj_id'],
        "uid"       =>$this->uid
      );
    }elseif($discussInfo['type'] == 2){
      $memberModelName = "ParttimeMember";
      $memberCondition = array(
        "pt_id"     =>$discussInfo['obj_id'],
        "uid"       =>$this->uid
      );
    }
    $memberInfo = M($memberModelName)->where($memberCondition)->find();

    // 插入数据
    $insertData = array(
      "content_id" =>$contentId,
      "content"       =>I("post.content"),
      "uid"       =>$this->uid
    );
    $insertResult = M("DiscussComment")->data($insertData)->fetchSql(false)->add();
    if(!$insertResult) {
      $backData = array(
        "code"  => 13002,
        "msg"   => "保存失败"
      );  
      $this->ajaxReturn($backData); 
    }

    $info = M("DiscussComment")->where("id=$insertResult")->find();
    $info['membername'] = $memberInfo['realname'];

    $backData = array(
      "code"  => 200,
      "msg"   => "操作成功",
      "data"  =>array(
        "info"  =>$info
      )
    );  
    $this->ajaxReturn($backData); 
  }
  /*** 保存节点 */
  public function savenode(){
    if(!IS_POST){
      $backData = array(
        "code"  => 10001,
        "msg"   => "非法请求"
      );  
      $this->ajaxReturn($backData); 
    }
    $insertData = array(
      "dc_id" =>I("post.discussid"),
      "title"       =>I("post.title")
    );
    $insertResult = M("DiscussNode")->data($insertData)->fetchSql(false)->add();

    if(!$insertResult) {
      $backData = array(
        "code"  => 13002,
        "msg"   => "保存失败"
      );  
      $this->ajaxReturn($backData); 
    }

    $backData = array(
      "code"  => 200,
      "msg"   => "操作成功"
    );  
    $this->ajaxReturn($backData); 
  }

   /*** 保存讨论内容 */
   public function savecont(){
    if(!IS_POST){
      $backData = array(
        "code"  => 10001,
        "msg"   => "非法请求"
      );  
      $this->ajaxReturn($backData); 
    }
    $insertData = array(
      "dc_id"     =>I("post.discussid"),
      "node_id"   =>I("post.nodeid"),
      "uid"       =>$this->uid,
      "content"   =>I("post.content"),
      "color"     =>I("post.color")
    );
    $insertResult = M("DiscussContent")->data($insertData)->fetchSql(false)->add();

    if(!$insertResult) {
      $backData = array(
        "code"  => 13002,
        "msg"   => "保存失败"
      );  
      $this->ajaxReturn($backData); 
    }

    $backData = array(
      "code"  => 200,
      "msg"   => "操作成功"
    );  
    $this->ajaxReturn($backData); 
  }


/************************ */
}