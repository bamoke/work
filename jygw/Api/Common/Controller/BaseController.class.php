<?php
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-08-27 13:59:40 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2019-09-20 02:10:38
 * 200 success
 * 10* access error
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
    protected $uid;
    protected $accountInfo;
    protected function _initialize(){
        $this->_checklogin();
        $this->uid = $this->fetchUid();
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
        $accountInfo = M("Member")->where(array('id'=>$res["uid"]))->find();
        $this->accountInfo = $accountInfo;
        
    }

    protected function fetchUid (){
        $token = $_SERVER["HTTP_X_ACCESS_TOKEN"];
        $sessionResult = M("Mysession")->field("uid")->where(array("token"=>$token))->find();
        return $sessionResult["uid"];
    }

    /**
     * @return -1,人才卡已过期，0,非人才卡用户,1,2,3....人才类型
     */
    // 检测是否是人才卡用户
    protected function is_talent_user(){
        $condition = array(
            "uid"   =>$this->uid
        );
        $talentInfo = M("TalentCard")
        ->where($condition)
        ->find();
        if(!$talentInfo) {
            return 0;
        }
        if(strtotime($talentInfo["end_date"]) <= time() ) {
            return -1;
        }
         return $talentInfo["type"];
    }
}