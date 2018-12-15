<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class LikeController extends BaseController {

  /**
   * Handle 收藏
   * @cardid
   */
  public function dolike(){
    if(empty($_GET["cardid"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }

    $cardId = I("get.cardid/d");
    $model = M("Like");
    $insertData = array(
      "uid"     =>$this->uid,
      "card_id"  =>$cardId
    );
    $insertResult = M("Like")->data($insertData)->add();
    if($insertResult){
      $backData = array(
        "code"      =>200,
        "msg"       =>"success"
      );
    }else {
      $backData = array(
        "code"      =>13001,
        "msg"       =>"操作失败"
      );
    }
    $this->ajaxReturn($backData);
  }



}