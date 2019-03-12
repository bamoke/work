<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 */

namespace Enadmin\Controller;


use Think\Controller;

class PluploadController extends Controller {
  public function upload(){
    $upload_conf=array(
      'maxSize' => 3145728,
      'rootPath' => ROOT.'/Uploads/',
      'savePath' => 'plupload/',
      'saveName' => "",
      'exts' => array('jpg', 'gif', 'png', 'jpeg'),
      'autoSub' => false,
      'subName' => date("Ym",time()),
      "replace" =>true
    );
    //图片上传
    $upload = new \Think\Upload($upload_conf);
    $uploadResult = $upload->upload();
    $files = array();
    if(!$uploadResult) {
      $backData = array(
        "code"  =>13001,
        "msg"   =>"type error"
      ); 
      $this->ajaxReturn($backData);
    }else {
      foreach($uploadResult as $file){ 
        $files[] = $file['savename'];
      }
      $backData = array(
        "code"  =>200,
        "msg"   =>"success",
        "data"  =>array(
          "files" =>$files
        )
      ); 
      $this->ajaxReturn($backData);
    }

  }

  // 上传banner
  public function banner(){
    $upload_conf=array(
      'maxSize' => 3145728,
      'rootPath' => ROOT.'/Uploads/',
      'savePath' => 'banner/',
      'saveName' => "",
      'exts' => array('jpg', 'gif', 'png', 'jpeg'),
      'autoSub' => false,
      'subName' => date("Ym",time()),
      "replace" =>true
  );
  //图片上传
  $upload = new \Think\Upload($upload_conf);
  $uploadResult = $upload->uploadOne($_FILES['file']); 
  if(!$uploadResult) {
    $backData = array(
      "code"  =>13001,
      "msg"   =>"type error"
    ); 
    $this->ajaxReturn($backData);
  }else {
    $file= $uploadResult['savename'];
    $backData = array(
      "code"  =>200,
      "msg"   =>"success",
      "data"  =>array(
        "fullpath"=>ROOT.'/Uploads/banner'.$file,
        "file" =>$file
      )
    ); 
    $this->ajaxReturn($backData);
  }

  }
/**============ */
}
