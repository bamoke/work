<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class GrantsController extends BaseController {


  /**
   * 我的提问
   */
  public function vlist(){
    $where = array(
      "status"  =>1
    );

    $thumbBase = C("OSS_BASE_URL")."/";
    $mainModel = M("Grants");
    $total = $mainModel->where($where)->fetchSql(false)->count();

    $page = I("get.page/d",1);
    $pageSize = 15;
    $list = $mainModel
    ->field("id,title,description,CONCAT('$thumbBase',thumb) as thumb")
    ->where($where)
    ->page($page,$pageSize)
    ->fetchSql(false)
    ->select();
    $backData = array(
      "code"  =>200,
      "msg"   =>'success',
      "data"  =>array(
        "list"  =>$list,
        "pageInfo" =>array(
          "total"   =>intval($total),
          "page"    =>$page,
          "pageSize"  =>$pageSize
        )
      )
    );
    $this->ajaxReturn($backData);
  }

  /**
   * 助学详情
   */
  public function detail(){
    if(empty($_GET['id']) || $_GET["id"] == 'undefined') {
      $backData = array(
        "code" =>10001,
        "msg"  =>'非法请求',
      );
      return $this->ajaxReturn($backData);
    }
    $grantsId = I("get.id");


    $thumbBase = C("OSS_BASE_URL")."/";
    
    $info = M("Grants")
    ->field("*,CONCAT('$thumbBase',thumb) as thumb")
    ->find($grantsId);

    $applyWhere = array(
      "uid"   =>$this->uid,
      "grant_id"  =>$grantsId
    );
    $applyInfo =M("GrantsApply")
    ->where($applyWhere)
    ->find();
    $backData = array(
      "code"  =>200,
      "msg"   =>'success',
      "data"  =>array(
        "info" =>$info,
        "applyInfo" =>$applyInfo
      )
    );
    $this->ajaxReturn($backData);
  }

 

  /**
   * 提交申请
   */
  public function doapply(){
    if(!IS_POST) {
      $backData = array(
        "code" =>10001,
        "msg"  =>'非法请求',
      );
      return $this->ajaxReturn($backData);
    }


    //
    $this->checkTalentInfo($this->uid);


    $mainModel = M("GrantsApply");
    $create = $mainModel->create($_POST);
    if(!$create) {
      $backData = array(
        "code" =>13001,
        "msg"  =>'数据错误',
      );
      return $this->ajaxReturn($backData);
    }
    $mainModel->uid =  $this->uid;
    $result = $mainModel->add();
    if(!$result) {
      $backData = array(
        "code" =>13002,
        "msg"  =>'数据保存错误',
      );
      return $this->ajaxReturn($backData);
    }
    $grantWhere = array(
      "id"  =>I("post.grant_id")
    );
    $updateGrants = M("Grants")
    ->where($grantWhere)
    ->setInc("apply_num");
    $backData = array(
      "code" =>200,
      "msg"  =>'success',
    );
    return $this->ajaxReturn($backData);
  }

  /**
   * 
   */
  public function fetchuserinfo(){
    $this->checkTalentInfo($this->uid);
    $where =array(
      "uid"   =>$this->uid
    );
    $userInfo = M("TalentApply")
    ->field("realname,phone")
    ->where($where)
    ->find();
    $backData = array(
      "code" =>200,
      "msg"  =>'success',
      "data"  =>array(
        "userInfo"  =>$userInfo
      )
    );
    return $this->ajaxReturn($backData);
  }


  /**
   * 
   */
  protected function checkTalentInfo($uid){
      // 检测是否拥有人才卡

      $talentCondition = array(
        "uid" =>$uid
      );
      $talentInfo = M("TalentCard")
      ->field("id,end_date")
      ->where($talentCondition)
      ->fetchSql(false)
      ->find();

      if(!$talentInfo) {
        $backData = array(
          "code" =>13001,
          "msg"  =>'您还不是人才卡用户',
        );
        return $this->ajaxReturn($backData);
      }

      if(strtotime($talentInfo['end_date']) < time()) {
        $backData = array(
          "code" =>13001,
          "msg"  =>'您的人才卡已过期',
        );
        return $this->ajaxReturn($backData);
      }
       return $talentInfo;
  }
 
  /***============== */
}