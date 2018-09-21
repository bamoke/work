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
    if($_FILES['thumb']['tmp_name']){
      //图片处理
      $upload_conf=array(
          'maxSize' => 3145728,
          'rootPath' => ROOT.'/Uploads/',
          'savePath' => 'thumb/',
          'saveName' => time().I("session.uid"),
          'exts' => array('jpg', 'gif', 'png', 'jpeg'),
          'autoSub' => false,
          'subName' => date("Ym",time())
      );
      $upload = new \Think\Upload($upload_conf);
      $uploadResult = $upload->uploadOne($_FILES['thumb']);
      if(!$uploadResult){
          $backData['status'] = 0;
          $backData['msg'] = $upload->getError();
          return $this->ajaxReturn($backData);
      }else {
          $model->thumb = $uploadResult['savename'];
      }
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
    if($_FILES['thumb']['tmp_name']){
      $upload_conf=array(
        'maxSize' => 3145728,
        'rootPath' => ROOT.'/Uploads/',
        'savePath' => 'thumb/',
        'saveName' => time().I("session.uid"),
        'exts' => array('jpg', 'gif', 'png', 'jpeg'),
        'autoSub' => false,
        'subName' => date("Ym",time())
      );
      $info = $model->field('thumb')->where("id=$id")->find();
      //图片处理
      $upload = new \Think\Upload($upload_conf);
      $uploadResult = $upload->uploadOne($_FILES['thumb']);
      if(!$uploadResult){
          $backData['status'] = 0;
          $backData['msg'] = $upload->getError();
          return $this->ajaxReturn($backData);
      }else {
          $model->thumb = $uploadResult['savename'];
          //删除旧图片
          if(isset($_POST['old_img']) && $_POST['old_img'] == ''){
              unlink($upload_conf['rootPath'].$upload_conf['savePath'].$info['thumb']);
          }
      }

  }else {
      // 删除旧图片
      if(isset($_POST['old_img']) && $_POST['old_img'] == ''){
          $info = $model->field('thumb')->where("id=$id")->find();
          $model->thumb = '';
          @unlink($upload_conf['rootPath'].$upload_conf['savePath'].$info['thumb']);
      }
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