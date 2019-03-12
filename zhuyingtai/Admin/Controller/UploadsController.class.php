<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 22:48:12
 */
namespace Admin\Controller;
use Admin\Common\Auth;
class UploadsController extends Auth {



  public function save(){
    $upload_conf=array(
      'maxSize' => 3145728,
      'rootPath' => ROOT.'/Uploads/',
      'savePath' => 'images/',
      'saveName' => md5(time().$this->uid),
      'exts' => array('jpg', 'gif', 'png', 'jpeg'),
      'autoSub' => true,
      'subName' => date("Ym",time())
    );
    
    if($_FILES['img']['tmp_name']){
      //图片处理
      $upload = new \Think\Upload($upload_conf);
      $uploadResult = $upload->uploadOne($_FILES['img']);
      if($uploadResult) {
        $imageUrl = "http://www.bamoke.com/zhuyingtai/Uploads/".$uploadResult['savepath']."/".$uploadResult['savename'];
        $backData = array(
          "errno" =>0,
          "data"=>array($imageUrl)
        );
      }else {
        $backData = array(
          "errno" =>1
        );
      }
      $this->ajaxReturn($backData);   
    }
  }


  //==================//
}