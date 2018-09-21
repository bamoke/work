<?php
namespace Admin\Controller;
use Admin\Common\Controller\AuthController;

class FairsController extends AuthController {
  public function index ($cid = null){
    $curModel = M("Fairs");
    $condition = array();
    if(!is_null($cid)){
      $condition['cid'] = $cid;
    }
    $count = $curModel->where($condition)->count();
    $Page = new \Think\Page($count,15);
    $Page->setConfig("next","下一页");
    $Page->setConfig("prev","上一页");
    $show = $Page->show();
    $data = $curModel
        ->where($condition)
        ->order('recommend desc,id desc')
        ->limit($Page->firstRow.','.$Page->listRows)
        ->select();
    $this->assign('page',$show);
    $this->assign('data',$data);
  }


  public function edit($id){
    $data = M("fairs")->where(array("id"=>$id))->find();
    $this->assign("data",$data);
  }

  public function do_add(){
    $model = M("Fairs");
    $result = $model->create($_POST);
    $backData = array();
    if(!$result) {
        $backData['status'] = 0;
        $backData['msg'] = $model->getError();
        return $backData;
    }
    $insertResult = $model->add();
    if(!$insertResult) {
      $backData['status'] = 0;
      $backData['msg'] = $model->getError();
      return $backData;
    }
    $backData['status'] = 1;
    $backData['msg'] = "操作成功";
    return $backData;

  }

  public function do_update($id){
    $model = M("Fairs");
    $result = $model->create($_POST);
    $backData = array();
    if(!$result) {
        $backData['status'] = 0;
        $backData['msg'] = $model->getError();
        return $backData;
    }
    $updateResult = $model->where(array("id"=>$id))->save();
    if($updateResult !== false) {
      $backData['status'] = 1;
      $backData['msg'] = "操作成功";
      return $backData;
    }
    $backData['status'] = 0;
    $backData['msg'] = $model->getError();
    return $backData;

  }

}