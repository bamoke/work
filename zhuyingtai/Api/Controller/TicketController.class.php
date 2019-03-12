<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class TicketController extends BaseController {
  /**
   * @page
   */
  public function index_bf(){
    $type = I("get.type");//type为1代表扫描入场码进入，
    $model = M("Ticket");
    $condition = array(
      "member_id" =>$this->uid
    );
    // 检测是否已经入场
    $ticketInfo = $model->where($condition)->find();
    // 检测是否已经填写了简历
    $hasResume = M("Resume")->where(array("uid"=>$this->uid))->count();
    if($ticketInfo) {
      $backData = array(
        "code"      =>200,
        "msg"       =>"ok",
        "data"      => array(
          "code"  =>$ticketInfo['code'],
          "hasResume" =>$hasResume
        )
      );
    }else {
      if($type == 1){
        // type为1，生成入场码
        $ticketModel = M("Ticket");
        $code = "NO.".str_pad($this->uid,5,"0",STR_PAD_LEFT);
        $insertData = array(
          "member_id" =>$this->uid,
          "code"      =>$code
        );
        $insertResult = $ticketModel->data($insertData)->add();
        if($insertResult){
          $backData = array(
            "code"      =>200,
            "msg"       =>"ok",
            "data"      => array(
              "code"  =>$code,
              "hasResume" =>$hasResume
            )
          );
        }else {
          $backData = array(
            "code"      =>13001,
            "msg"       =>"系统错误"
          );
        }
        
      }else {
        $backData = array(
          "code"      =>200,
          "msg"       =>"ok",
          "data"      => array(
            "code"  =>"",
            "hasResume" =>$hasResume
          )
        );
      }

    }

    $this->ajaxReturn($backData);
  }


  public function index(){
    $model = M("Ticket");
    $condition = array(
      "member_id" =>$this->uid
    );
    // 检测是否已经入场
    $ticketInfo = $model->where($condition)->find();
    // 检测是否已经填写了简历
    $hasResume = M("Resume")->where(array("uid"=>$this->uid))->count();
    if($ticketInfo) {
      $backData = array(
        "code"      =>200,
        "msg"       =>"ok",
        "data"      => array(
          "code"  =>$ticketInfo['code'],
          "hasResume" =>$hasResume
        )
      );
    }else {
      if($hasResume == 1){
        $ticketModel = M("Ticket");
        $code = "NO.".str_pad($this->uid,5,"0",STR_PAD_LEFT);
        $insertData = array(
          "member_id" =>$this->uid,
          "code"      =>$code
        );
        $insertResult = $ticketModel->data($insertData)->add();
        if($insertResult){
          $backData = array(
            "code"      =>200,
            "msg"       =>"ok",
            "data"      => array(
              "code"  =>$code
            )
          );
        }else {
          $backData = array(
            "code"      =>13001,
            "msg"       =>"系统错误"
          );
        }
        
      }else {
        $backData = array(
          "code"      =>200,
          "msg"       =>"ok",
          "data"      => array(
            "code"  =>""
          )
        );
      }

    }

    $this->ajaxReturn($backData);
  }

  public function enroll(){
    $model = M("Ticket");
    $insertData = array(
      "member_id" =>$this->uid,
      "code"      =>"NO".str_pad($this->uid,5,"0")
    );
    $insertResult = $model->data($insertData)->add();
    if($insertResult) {
      $backData = array(
        "code"      =>200,
        "msg"       =>"ok",
      );
    }else {
      $backData = array(
        "code"      =>13001,
        "msg"       =>"系统错误"
      );
    }

    $this->ajaxReturn($backData);
  }


}