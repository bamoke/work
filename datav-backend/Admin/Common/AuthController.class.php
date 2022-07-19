<?php
namespace Admin\Common;
use Think\Controller;

class AuthController extends Controller
{
    protected $curYear;
    protected $curMonth;
    protected $curDateObj;

    public $uid;

    public function _initialize(){
        $this->check_login();
        $requestDate = $_SERVER["HTTP_X_ACCESS_DATE"];
        if(!$requestDate) {
            $sysDate = M("SysSetting")->getField('sys_date');
        }else {
            $sysDate = $requestDate;
        }
        $this->curDateObj = $date = \date_create($sysDate);
        $this->curYear = I("get.year",date_format($date,'Y'));
        $this->curMonth = I("get.month",date_format($date,'m'));
    }

    /**
     * check
     */
    protected function check_login_bk(){
        $token = $_SERVER["HTTP_X_ACCESS_TOKEN"];
        if(!$token) {
            $backData = array(
                "code"  =>10001,
                "msg"   =>"请登录"
            );
            $this->ajaxReturn($backData);
        }
        
        $sessionWhere = array(
            "token" =>$token
        );
        $sessionInfo = M("UserSession")->field("uid")->where($sessionWhere)->find();
        if(!$sessionInfo){
            $backData = array(
                "code"  =>10002,
                "msg"   =>"请重新登录"
            );
            $this->ajaxReturn($backData);
        }

        $this->uid = $sessionInfo["uid"];
    }

    protected function check_login(){
        $token = session("token");
        if(!$token) {
            $backData = array(
                "code"  =>10001,
                "msg"   =>"请登录"
            );
            $this->ajaxReturn($backData);
        }

        $this->uid = session("uid");
    }
}
