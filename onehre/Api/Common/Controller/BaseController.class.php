<?php
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-08-27 13:59:40 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-11-03 00:25:47
 * 200 success
 * 10* access error 01 invalid request ;02 params error
 * 11*  login error
 * 12*  weixin error
 * 1300*  business logic error
 * 13000  invalid request
 * 13001  params error
 */

namespace Api\Common\Controller;
use Think\Controller;
class BaseController extends Controller
{
    public $uid;
    public $sessionInfo;
    protected function _initialize(){
        $this->_checklogin();
        $sessionInfo = $this->fetchSessionInfo();
        $this->uid = $sessionInfo['uid'];
        $this->sessionInfo = $sessionInfo;
    }

    protected function _checklogin(){
        if(empty($_SERVER["HTTP_X_ACCESS_TOKEN"])) {
            $backData = array(
                "code"  => 11001,
                "msg"   => "请登录后再操作"
            );
            $this->ajaxReturn($backData);
        }
        $sessionModel = M("Mysession");
        $where = array(
            "token" =>$_SERVER["HTTP_X_ACCESS_TOKEN"]
        );
        $res = $sessionModel->where($where)->find();
        if(!$res) {
            $backData = array(
                "code"  => 11002,
                "msg"   => "登陆态已过期，请重新登录"
            );
            $this->ajaxReturn($backData);          
        }
        if(!$res['phone']) {
            $backData = array(
                "code"  => 11001,
                "msg"   => "请登录后再操作"
            );
            $this->ajaxReturn($backData);           
        }
        
    }

    protected function fetchAccount(){
        return M("Member")->field("id,openid,phone,status")->where(array('id'=>$this->uid))->find();
    }

    protected function fetchSessionInfo (){
        $token = $_SERVER["HTTP_X_ACCESS_TOKEN"];
        $sessionResult = M("Mysession")->where(array("token"=>$token))->find();
        return $sessionResult;
    }

}