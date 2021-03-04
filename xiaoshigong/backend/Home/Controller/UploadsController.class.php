<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2019-05-20 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2019-05-20 22:16:59 
 */
namespace Platform\Controller;
use Platform\Common\Auth;
class UploadsController extends Auth {
  
  // aliyun oss save
  public function save(){
    $folder = I("get.f");
    if($_FILES['img']['tmp_name']){
      $fileSaveName = md5(time().$this->uid);
      Vendor("AliOss.autoload");
      $OssClient = new \OSS\OssClient(C("OSS_ACCESS_ID"),C("OSS_ACCESS_KEY"),C("OSS_ENDPOINT"));
      
      $file = $_FILES['img'];
      $exts = array('jpg', 'gif', 'png', 'jpeg');
      $maxSize = 2097152;
      $curExts = end(explode(".",$file['name']));
      $curSize = $file['size'];
      $object = $folder.'/'.$fileSaveName.".".$curExts;
      // check extension and file size
      if(!in_array($curExts,$exts)) {
        $backData = array(
          "errno" =>1,
          "errorMsg"   =>"只支持jpg,gif,png,jpeg文件格式"
        );
        $this->ajaxReturn($backData); 
      }
      if($curSize > $maxSize) {
        $backData = array(
          "errno" =>1,
          "errorMsg"   =>"文件大小在2M以内"
        );
        $this->ajaxReturn($backData); 
      }

      try{
          $ossUpload = $OssClient->uploadFile(C('OSS_BUCKET'),$object,$file['tmp_name']);
          $getOssObjUrl = $ossUpload['info']['url'];
          $backData = array(
            "code"  =>200,
            "errno" =>0,
            "data"=>array($getOssObjUrl),//完整url
            "filename"=>$object //oss 文件名包括目录
          );
          $this->ajaxReturn($backData);   
      }catch(OssException $e){
          // printf($e->getMessage() . "\n");
          $backData = array(
            "code"  =>13001,
            "errno" =>1,
            "msg"   =>$e->getMessage()
          );
          $this->ajaxReturn($backData); 
      }

    }
  }


  public function delete(){
    if(empty($_GET['filename'])){
      $backData = array(
        "code"  =>13001,
        "msg"   =>"文件名不能为空"
      );
      $this->ajaxReturn($backData); 
    }
    $fileName = I("get.filename");
    Vendor("AliOss.autoload");
    $OssClient = new \OSS\OssClient(C("OSS_ACCESS_ID"),C("OSS_ACCESS_KEY"),C("OSS_ENDPOINT"));
    try{
      $result = $OssClient->deleteObject(C("OSS_BUCKET"),"fileName.jpg");
      $backData = array(
        "code"  =>200,
        "msg"   =>"success"
      );
      $this->ajaxReturn($backData); 
     }catch(OssException $e){
      // printf($e->getMessage() . "\n");
      $backData = array(
        "code"  =>13001,
        "msg"   =>$e->getMessage()
      );
      $this->ajaxReturn($backData); 
      }

  }

  //==================//
}