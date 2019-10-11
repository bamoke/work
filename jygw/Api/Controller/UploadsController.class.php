<?php
/*
 * mp upload
 * @Author: joy.wangxiangyin 
 * @Date: 2019-09-05 19:00:31 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2019-09-20 01:54:29
 */
namespace Api\Controller;
use Api\Common\Controller\BaseController;
use OSS\Core\OssException;
class UploadsController extends BaseController {
  public function save_img(){
    if(!$_FILES['img']['tmp_name']){
      $backData = array(
        "code"    =>13001,
        "msg"     =>"请上传图片"
      );
      $this->ajaxReturn($backData);
    }
      //图片处理

    $upload_conf=array(
        'maxSize' => 3145728,
        'rootPath' => ROOT_DIR.'/Uploads/',
        'savePath' => 'tmp/',
        'saveName' => (time().$this->uid),
        'exts' => array('jpg', 'gif', 'png', 'jpeg'),
        'autoSub' => false,
        'subName' => date("Ym",time())
    );
    $upload = new \Think\Upload($upload_conf);
    

    $uploadResult = $upload->uploadOne($_FILES["img"]);

    if(!$uploadResult){
        $backData = array(
          "code"    =>13001,
          "msg"     =>$upload->getError()
        );
        $this->ajaxReturn($backData);
    }
    /****** 上传阿里云OSS **********/
    Vendor("AliOss.autoload");
    $OssClient = new \OSS\OssClient(C("OSS_ACCESS_ID"),C("OSS_ACCESS_KEY"),C("OSS_ENDPOINT"));
    $object = 'papers/'.$uploadResult['savename'];
    $file = $upload_conf["rootPath"].$upload_conf["savePath"].$uploadResult['savename'];
    try{
        $ossUpload = $OssClient->uploadFile(C('OSS_BUCKET'),$object,$file);
        $getOssObjUrl = $ossUpload['info']['url'];
        if($getOssObjUrl){
            unlink($file);
        }
        $backData = array(
          "code"    =>200,
          "msg"     =>"上传成功",
          "img"   =>$object,
          "test"  =>$file
        );
        $this->ajaxReturn($backData);

    }catch(OssException $e){
        $backData = array(
          "code"    =>13001,
          "msg"     =>"图片上传失败",
          "info"    =>$e->getMessage()
        );
        $this->ajaxReturn($backData);
    }
    // 上传结束

   
    
  }

  public function img_delete(){
    if(empty($_GET["img"])) {
      $backData = array(
        "code"    =>10001,
        "msg"     =>"参数错误"
      );
      $this->ajaxReturn($backData);
    }
    $object = I("get.img");
    /****删除OSS数据 */
    Vendor("AliOss.autoload");
    $OssClient = new \OSS\OssClient(C("OSS_ACCESS_ID"),C("OSS_ACCESS_KEY"),C("OSS_ENDPOINT"));
    try{
        $ossUpload = $OssClient->deleteObject(C('OSS_BUCKET'),$object);
        $backData = array(
          "code"    =>200,
          "msg"     =>"success"
        );
        $this->ajaxReturn($backData);
    }catch(OssException $e){
        $backData = array(
          "code"    =>13001,
          "msg"     =>"图片删除失败",
          "info"    =>$e->getMessage()
        );
        $this->ajaxReturn($backData);
    }
  }
  /************ */
}