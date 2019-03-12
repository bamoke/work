<?php
namespace Api\Controller;
use Think\Controller;
class MemberController extends Controller {
  /**
   * company list
   * @condition
   * @page
   */
  public function getuid(){
    if(empty($_SERVER["HTTP_X_ACCESS_TOKEN"])) return null;
    $token = $_SERVER["HTTP_X_ACCESS_TOKEN"];
    $sessionResult = M("Mysession")->field("uid")->where(array("token"=>$token))->find();
    return $sessionResult["uid"];
  }




}