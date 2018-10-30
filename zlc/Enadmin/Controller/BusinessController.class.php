<?php
namespace Admin\Controller;
use Admin\Common\Controller\AuthController;

class BusinessController extends AuthController {
  public function index ($cid){
    $curModel = M("Business");
    $condition = array(
      "cid" =>$cid
    );
    $count = $curModel->where($condition)->count();
    $Page = new \Think\Page($count,15);
    $Page->setConfig("next","下一页");
    $Page->setConfig("prev","上一页");
    $show = $Page->show();
    $data = $curModel
        ->where($condition)
        ->field("id,cid,title,FROM_UNIXTIME(create_time) as datetime,status")
        ->order('id desc')
        ->limit($Page->firstRow.','.$Page->listRows)
        ->select();
    $this->assign('page',$show);
    $this->assign('data',$data);
    $this->display();
  }


  public function detail($id){
    $data = M("Business")->field("*,FROM_UNIXTIME(create_time) as date")->where(array("id"=>$id))->find();
    $this->assign("data",$data);
    $output['script'] = CONTROLLER_NAME."/main";
    $this->assign('output',$output);
    $this->display();
  }


  public function verify($id,$status){
    $model = M("Business");
    $updateResult = $model->where(array("id"=>$id))->data("status=$status")->save();
    if($updateResult !== false) {
      $backData['status'] = 1;
      $backData['msg'] = "操作成功";
      $backData['jump'] = U("index",array("navid"=>I('get.navid'),"cid"=>I('get.cid')));
    }else {
      $backData['status'] = 0;
      $backData['msg'] = $model->getError();
    }
    $this->ajaxReturn($backData);
  }

}