<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class DiscussController extends BaseController {

  /**
   * 获取当前讨论组的成员信息
   * params type    1:课程；2：项目
   * params objId   课程ID或项目ID
   */
  protected function fetchMemberInfo($type,$objId){
    $sessionInfo = $this->sessionInfo;
    $condition = array();
    $tableName = "";
    if($type == 1){
      $condition['phone'] = $sessionInfo['phone'];
      $condition['course_id'] = $objId;
      $tableName = 'CourseMember';
    }else {
      $condition['uid'] =$this->uid;
      $condition['pt_id'] =$objId;
      $tableName = 'ParttimeMember';
    }
    $memberInfo = M($tableName)
    ->where($condition)
    ->find();

    return $memberInfo;
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
    $memberInfo = $this->fetchMemberInfo($discussType,$objId);
    $memberId = $memberInfo['id'];
    
    $page = I("get.p/d",1);
    $pageSize = 20;
    $condition = array(
      "DM.member_id"    =>$memberId,
      "DC.obj_id"     =>$objId,
      "DC.type"   =>$discussType
    );

    $list = M("DiscussMember")
    ->alias("DM")
    ->field("DM.member_id,DC.id,DC.title as discuss_name,DC.stage")
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
    $discussInfo = M("Discuss")->where("id=$discussId")->find();
    $memberInfo = $this->fetchMemberInfo($discussInfo['type'],$discussInfo['obj_id']);
    $memberId = $memberInfo['id'];
    $memberCondition = array(
      "dc_id" =>$discussId,
      "member_id"   =>$memberId
    );
    $dicMemberInfo = M("DiscussMember")->where($memberCondition)->fetchSql(false)->find();
 
    if(!$dicMemberInfo) {
      $backData = array(
        "code"  => 14001,
        "msg"   => "不是讨论组成员"
      );  
      $this->ajaxReturn($backData);  
    }

    $nodesList = M("DiscussNode")->where(array("dc_id"=>$discussId))->select();
    $nodes = array();
    if(count($nodesList)){
      foreach ($nodesList as $key=>$val){
        $contentCondition = array(
          "DC.node_id"=>$val['id']
        );
        if($discussInfo['type'] ==  1){
          $contentList = M("DiscussContent")
          ->alias("DC")
          ->field("DC.*,CM.realname as membername")
          ->join("__DISCUSS_MEMBER__ as DM on DC.member_id = DM.id")
          ->join("__COURSE_MEMBER__ as CM on DM.member_id=CM.id")
          ->where($contentCondition)
          ->limit(5)
          ->fetchSql(false)
          ->select();
        }elseif($discussInfo['type'] ==  2){
          $contentList = M("DiscussContent")
          ->alias("DC")
          ->field("DC.*,PM.realname as membername")
          ->join("__DISCUSS_MEMBER__ as DM on DC.member_id = DM.id")     
          ->join("__PARTTIME_MEMBER__ as PM on DM.member_id=PM.id")
          ->where($contentCondition)
          ->limit(5)
          ->select();
        }

        $nodes[] = array(
          "id"=>$val['id'],
          "title"=>$val['title'],
          "contentList" =>$contentList
        );
      }

    }


    $backData = array(
        "code"      =>200,
        "msg"       =>"ok",
        "data"      => array(
          "discuss" =>$discussInfo,
          "memberInfo"  =>$dicMemberInfo,
          "nodes"  =>$nodes
        )
    );
    $this->ajaxReturn($backData);
  }

    /**
   * 更多内容
   */
  public function content_list(){
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

    $nodeInfo = M("DiscussNode")->where(array("id"=>$nodeId))->find();
    $discussInfo = M("Discuss")
    ->alias("D")
    ->field("D.*")
    ->join("__DISCUSS_NODE__ as DN on DN.dc_id= D.id")
    ->where(array('DN.id'=>$nodeId))
    ->fetchSql(false)
    ->find();

    $contentCondition = array(
      "DC.node_id"  =>$nodeId
    );
    $total = M("DiscussContent")->alias("DC")->where($contentCondition)->count();
    if($discussInfo['type'] ==  1){
      $contentList = M("DiscussContent")
      ->alias("DC")
      ->field("DC.*,CM.realname as membername")
      ->join("__DISCUSS_MEMBER__ as DM on DC.member_id = DM.id")
      ->join("__COURSE_MEMBER__ as CM on DM.member_id=CM.id")
      ->where($contentCondition)
      ->page($page,$pageSize)
      ->select();
    }elseif($discussInfo['type'] ==  2){
      $contentList = M("DiscussContent")
      ->alias("DC")
      ->field("DC.*,PM.realname as membername")
      ->join("__DISCUSS_MEMBER__ as DM on DC.member_id = DM.id")     
      ->join("__PARTTIME_MEMBER__ as PM on DM.member_id=PM.id")
      ->where($contentCondition)
      ->page($page,$pageSize)
      ->select();
    }

 
    $backData = array(
        "code"      =>200,
        "msg"       =>"ok",
        "data"      => array(
          "nodeInfo"  =>$nodeInfo,
          "list"  =>$contentList,
          "page"  =>$page,
          "total" =>$total,
          "hasMore" => $total > ($page*$pageSize)
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
    $discussId = I("get.discussid");
    $contentInfo = M("DiscussContent")->where("id=$contentId")->find();

    // 通过讨论组的成员信息获得Discuss ID及ObjMember ID
    $discussMember = M("DiscussMember")->where(array('id'=>$contentInfo['member_id']))->find();
    
    // 获取Discuss 信息
    $discussInfo = M("Discuss")
    ->field("*")
    ->where(array("id"=>$discussMember['dc_id']))
    ->find();

    if($discussInfo['type'] == 1) {
      $commentJoinTable = "__COURSE_MEMBER__";
      $memberModelName = "CourseMember";

    }elseif($discussInfo['type'] == 2){
      $commentJoinTable = "__PARTTIME_MEMBER__";
      $memberModelName = "ParttimeMember";

    }
    $objMemberInfo = M($memberModelName)->where(array("id"=>$discussMember['member_id']))->fetchSql(false)->find();
    $contentInfo['member_name'] = $objMemberInfo['realname'];


    // 获取评论列表
    $commentCondition = array(
      "DC.content_id" =>$contentId
    );
    $total = M("DiscussComment")->alias("DC")->count();
    $commentList = M("DiscussComment")
    ->alias("DC")
    ->field("DC.*,MB.realname as membername")
    ->join("__DISCUSS_MEMBER__ as DM on DC.member_id=DM.id")
    ->join($commentJoinTable."  as MB on MB.id=DM.member_id")
    ->where($commentCondition)
    ->order("DC.id desc")
    ->fetchSql(false)
    ->limit(50)
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
    // 通过contentID往上查找用户的名字
    $contentId = I("post.contentid");
    $discussId = I("post.discussid");
    $contentInfo = M("DiscussContent")->field("node_id")->where("id=$contentId")->find();
    $discussInfo = M("Discuss")
    ->where(array("id"=>$discussId))
    ->find();
    
    // 用户组来源信息（courseMember or parttimeMember）
    $memberInfo = $this->fetchMemberInfo($discussInfo['type'],$discussInfo['obj_id']);
    $memberId = $memberInfo['id'];

    //获取当前用户的discuss Member info
    $discussMemberInfo = M("DiscussMember")->where(array("dc_id"=>$discussId,'member_id'=>$memberId))->find();
    // 插入数据
    $insertData = array(
      "dc_id"     =>$discussId,
      "content_id" =>$contentId,
      "content"       =>I("post.content"),
      "member_id"       =>$discussMemberInfo['id']
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
    if(empty($_POST['discussid']) || empty($_POST['nodeid'])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $discussId = I("post.discussid");
    $nodeId = I("post.nodeid");
    $discussInfo = M("Discuss")->where(array("id"=>$discussId))->find();
    // 用户组来源信息（courseMember or parttimeMember）
    $memberInfo = $this->fetchMemberInfo($discussInfo['type'],$discussInfo['obj_id']);
    $memberId = $memberInfo['id'];

    //获取当前用户的discuss Member info
    $discussMemberInfo = M("DiscussMember")->where(array("dc_id"=>$discussId,'member_id'=>$memberId))->find();
    $insertData = array(
      "dc_id"           =>$discussId,
      "node_id"         =>I("post.nodeid"),
      "member_id"       =>$discussMemberInfo['id'],
      "content"         =>I("post.content"),
      "color"           =>I("post.color")
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