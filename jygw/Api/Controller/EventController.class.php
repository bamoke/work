<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class EventController extends BaseController {
  /**
   * Event 活动
   * @condition
   * @page
   */
  public function vlist(){
    $page = I("get.page/d",1);
    $pageSize = 10;
    $condition = array(
      "status"  =>1
    );
    $type = I("get.type/d");
    if($type !== 0) {
      $condition['type'] = $type;
    }
    $thumbBase = C("OSS_BASE_URL")."/";
    $fieldInfo = "id,title,concat('$thumbBase',thumb) as thumb,enroll_start_date,enroll_end_date,event_time";
    $total = M("Event")->where($condition)->count();
    $list = M("Event")
    ->field($fieldInfo)
    ->where($condition)
    ->page($page,$pageSize)
    ->order("recommend desc,id desc")
    ->select();

    if(count($list)) {
      foreach($list as $key=>$val){
        if(strtotime($val['enroll_end_date']) < time()) {
          $stage = 2;
          $stageTxt = "已结束";
        }else {
          if(strtotime($val['enroll_start_date']) > time()) {
            $stage = 0;
            $stageTxt = "未开始";
          }else {
            $stage = 1;
            $stageTxt = "进行中";
          }
        }
        $list[$key]['stage'] = $stage;
        $list[$key]['stageTxt'] = $stageTxt;
      }
    }

    $backData = array(
      "code"      =>200,
      "msg"       =>"ok",
      "data"      => array(
        "list"  =>$list,
        "pageInfo"  =>array(
          "page"  =>$page,
          "pageSize"=>$pageSize,
          "total" =>intval($total),
          "hasMore" => intval($total) - ($page*$pageSize) > 0
        )
      )
    );
    $this->ajaxReturn($backData);
  }


  /**
   * detail
   */
  /**
   * detail
   */
  public function detail(){
    if(empty($_GET['id'])) {
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $eventId = I("get.id/d");
    $eventCondition = array(
      "id"  =>$eventId
    );
    $thumbBase = C("OSS_BASE_URL")."/";
    $info = M("Event")->field("*,DATE(create_time) as date,concat('$thumbBase',thumb) as thumb,event_time")->where($eventCondition)->find();

    if(strtotime($info['enroll_end_date']) < time()) {
      $stage = 2;
      $stageTxt = "已结束";
    }else {
      if(strtotime($info['enroll_start_date']) > time()) {
        $stage = 0;
        $stageTxt = "未开始";
      }else {
        $stage = 1;
        $stageTxt = "进行中";
      }
    }
    $info['stage'] = $stage;
    $info['stagetxt'] = $stageTxt;
    // update view num
    $updateResult = M("Event")->where($eventCondition)->setInc('click');

    // check is collected
    $collectionWhere = array(
      "uid"     =>$this->uid,
      "type"    =>1,
      "obj_id"  =>$eventId
    );

    $collectionInfo = M("MainCollection")->where($collectionWhere)->fetchSql(false)->find();
    $isCollection = false;
    if($collectionInfo && $collectionInfo['status'] == 1) {
      $isCollection = true;
    }

    // 检测是否已经报名了
    $enrollWhere = array(
      "uid"       =>$this->uid,
      "event_id"  =>$eventId
    );
    $enrollNum = M("EventEnroll")->where($enrollWhere)->fetchSql(false)->count();

    $backData = array(
      "code"  =>200,
      "msg"   =>'success',
      "data"  =>array(
        "info"  =>$info,
        "isCollection" =>$isCollection,
        "enrolled"    =>!!$enrollNum
      )
    );
    $this->ajaxReturn($backData);
  }



  /**
   * collction
   */
  public function collection(){
    if(empty($_GET['id'])) {
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $eventId = I("get.id/d");
    $condition = array(
      "type"  =>1,
      "obj_id"  =>$eventId
    );
    $curModel = M("MainCollection");
    $collectionInfo = $curModel->where($condition)->find();
    if($collectionInfo) {
      $updateData = array(
        "status"=> intval(!$collectionInfo['status'])
      );
      $result = $curModel->where(array("id"=>$collectionInfo['id']))->data($updateData)->save();
    }else {
      $insertData =array(
        "uid"     =>$this->uid,
        "type"    =>1,
        "obj_id"  =>$eventId,
        "status"  =>1
      );
      $result = $curModel->data($insertData)->add();
    }
    if($result){
      $backData = array(
        "code"      =>200,
        "msg"       =>"ok"
      );
    }else {
      $backData = array(
        "code"      =>13001,
        "msg"       =>"操作失败;ERR_CODE:13001"
      );
    }
    $this->ajaxReturn($backData);
  }

  /**
   * enroll
   */
  public function enroll(){
    if(IS_POST){
      // do
      $insertData = I("post.");
      $insertData['uid']  = $this->uid;
      // 检测是否已经有记录
      $enrollWhere = array(
        "uid"       =>$this->uid,
        "event_id"  =>$insertData['event_id']
      );
      $enrollNum = M("EventEnroll")->where($enrollWhere)->fetchSql(false)->count();
      if($enrollNum > 0) {
        $backData = array(
          "code"  => 13002,
          "msg"   => "已经报过名了不能重复报名"
        );  
        $this->ajaxReturn($backData); 
      }

      $insertResult = M("EventEnroll")->add($insertData);
      $updateResult = M("Event")->where(array("id"=>$insertData['event_id']))->setInc("enroll_num");
      if(!$insertResult) {
        $backData = array(
          "code"  => 13001,
          "msg"   => "数据保存错误"
        );  
        $this->ajaxReturn($backData); 
      }else {
        $backData = array(
          "code"  => 200,
          "msg"   => "success"
        );  
        $this->ajaxReturn($backData); 
      }

    }else {
      if(empty($_GET['eventid'])) {
        $backData = array(
          "code"  => 10002,
          "msg"   => "访问参数错误"
        );  
        $this->ajaxReturn($backData); 
      }
      $eventId = I("get.eventid/d");

      // 检测是否已经报名了
      $enrollWhere = array(
        "uid"       =>$this->uid,
        "event_id"  =>$eventId
      );
      $enrollNum = M("EventEnroll")->where($enrollWhere)->fetchSql(false)->count();
      if($enrollNum > 0) {
        $backData = array(
          "code"  => 13009,
          "msg"   => "您已经报过名了;不能重复报名"
        );  
        $this->ajaxReturn($backData); 
      }
      $info = M("Event")->field("id,title,enroll_start_date,enroll_end_date,status")->where(array("id"=>$eventId))->fetchSql(false)->find();

      // 活动时间检测
      if($info['status'] === 0) {
        $backData = array(
          "code"  => 13009,
          "msg"   => "活动已中止"
        );  
        $this->ajaxReturn($backData); 
      }
      if(strtotime($info['enroll_end_date']) < time()) {
        $stage = 2;
        $stageTxt = "已结束";
      }else {
        if(strtotime($info['enroll_start_date']) > time()) {
          $stage = 0;
          $stageTxt = "未开始";
        }else {
          $stage = 1;
          $stageTxt = "进行中";
        }
      }
      if($stage !== 1) {
        $backData = array(
          "code"  => 13009,
          "msg"   => "活动".$stageTxt
        );  
        $this->ajaxReturn($backData); 
      }

      $backData = array(
        "code"  =>200,
        "msg"   =>'success',
        "data"  =>array(
          "info"  =>$info
        )
      );
      $this->ajaxReturn($backData);

    }
  }

  /***============== */
}