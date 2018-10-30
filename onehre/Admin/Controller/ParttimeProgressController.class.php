<?php 
/*
 * 兼职项目
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 23:42:10
 */
namespace Admin\Controller;
use Admin\Common\Auth;
// use Think\Controller;
class ParttimeProgressController extends Auth {
  public function index(){
    if(empty($_GET["ptid"])){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);     
    }
    $ptid = I("get.ptid");
    $condition = array(
      "pt_id" =>$ptid
    );
    $list = M("ParttimeProgress")->where($condition)->order('sort,id')->fetchSql(false)->select();
    // var_dump($list);
    if($list !== false){
      $backData = array(
        'code'      => 200,
        "msg"       => "success",
        "data"  =>array(
          "list"=>$list
          )    
      );
    }else {
      $backData = array(
        'code'      => 13001,
        "msg"       => "系统错误"
      );
    }
    $this->ajaxReturn($backData);
  }

  protected function _stage(){
    return array(
      array('name'=>"未开始","class"=>""),
      array('name'=>"进行中","class"=>"s-text-info"),
      array('name'=>"已完成","class"=>"s-text-success"),
      array('name'=>"项目中止","class"=>"s-text-light-grey")
    );
  }



  
  






  //==================//
}