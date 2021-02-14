<?php
/** 
 * Api auth
 * author:bamoke@163.com
 * create:2018-05-22 
 */
namespace Api\Common;
use Think\Controller;
//back code
/**
 * 11001 未登陆
 * 11002 
 * 11003 未绑定
 */
class Auth extends Controller
{
    public $accountInfo;
    public function __construct(){
        $this->checkSignIn();
    }

    /**
     * Check sign in
     * @return boolean
     */
    protected function checkSignIn(){
        $accessToken = $_SERVER["HTTP_X_ACCESS_TOKEN"];
        if(empty($accessToken)){
            $backData =  array(
                "code"  => "11001",
                "msg"   => "请登陆后操作"
            );          
            $this->ajaxReturn($backData);
        }
        $accessToken = $_SERVER["HTTP_X_ACCESS_TOKEN"];
        $uid = M("UserSession")
        ->where(array('token'=>$accessToken))
        ->getField('uid');
        
        if(!$uid){
            $backData =  array(
                "code"  => "11002",
                "msg"   => "登陆状态已过期"
            );          
            $this->ajaxReturn($backData);
        }

        $accountInfo = M("User")->find($uid);
        if(empty($accountInfo['object_id'])){
            $backData =  array(
                "code"  => "11003",
                "msg"   => "账号未绑定"
            );          
            $this->ajaxReturn($backData);
        }

        $YB = new \Common\Common\YbApi();


        
        // 从云表获取用户信息
        $YbResult = $YB->getone("车主供应商管理",$accountInfo["object_id"]);
        if(!isset($YbResult->objectId)) {
            $backData =  array(
                "code"  => "12001",
                "msg"   => "数据读取错误",
                "test"  =>$YbResult
            );          
            $this->ajaxReturn($backData);
        }

        $userInfo = array(
            "uid"           =>$uid,
            "object_id"          =>$YbResult->objectId,
            "name"                =>$YbResult->收货姓名,
            "phone"            =>$YbResult->收货手机,
            "comname"       =>$YbResult->客户名称,
            "belong_comname"    =>$YbResult->所属机构,
            "origin"        =>$YbResult
        );
        $this->accountInfo = $userInfo;
    }
}
