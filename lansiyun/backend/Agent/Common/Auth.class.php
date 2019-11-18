<?php
/**
 * User: joy.wangxiangyin
 * Date: 2018/8/6
 * Time: 23:52
 * back data code
 * 200 success
 * 1000*  request error
 * 1100*  login error
 * 1200*  auth error
 * 1300*  business logic error
 */

namespace Agent\Common;
use Think\Controller;
class Auth extends Controller
{

    /**
     * 1.初始化检测登录状态;
     * 2.检测访问权限 validate access promise
     */
    public $accessToken;
    protected $sessionModel;
    public $requestData;
    public $uid;
    public $userInfo;
    public function _initialize(){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods:POST,GET'); 
        header("Access-Control-Allow-Headers:Content-type,accept,X-URL-PATH,x-access-token");
        if($_SERVER['REQUEST_METHOD'] != "OPTIONS") {
            if($_SERVER['REQUEST_METHOD'] == "POST") {
                $this->requestData = json_decode(file_get_contents("php://input"),true);
            }elseif($_SERVER['REQUEST_METHOD'] == "GET") {
                $this->requestData = $_GET;
            }
            $this->accessToken = $_SERVER["HTTP_X_ACCESS_TOKEN"];
            $this->sessionModel = M("AgentSession");
            $this->_checkLogin($this->accessToken);
            $this->uid = $this->sessionModel->where(array('token'=>$this->accessToken))->getField('uid');
            $this->fetchUserInfo($this->uid);
        }else {
            header("HTTP/1.0 204 Not Content");
            exit;
        }
    }

    /**
     * 检测是否登录
     * @return bool
     */
    protected function _checkLogin($token)
    {
        // If token is null;
        if(is_null($token)){
            $backData = array(
                "code"  =>11001,
                "msg"   =>"请先登录"
            );
            $this->ajaxReturn($backData);
        }else {

            // check time if expires
            $sessionCondistion = array(
                "token" =>$token
            );
            $expiresTime = $this->sessionModel->where($sessionCondistion)->fetchSql(false)->getField("expires_time");
            if(!$expiresTime || $expiresTime < time()){
                $backData = array(
                    "code"  =>11002,
                    "msg"   =>"登录状态已过期"
                );
                $this->ajaxReturn($backData);
            }
            // update expires
            $updateData = array(
                "expires_time"  =>time() + 3600
            );
            $updateResult = $this->sessionModel->where($sessionCondistion)->data($updateData)->save();
        }
    }

    /**
     * 获取用户信息
     * 检测合同状态
     */
    protected function fetchUserInfo($uid){
        $info = M("AgentAdmin")->field("id,agent_id,realname,username")->where(array("id"=>$uid))->find();
        $this->userInfo = $info;
        // 检测合同状态

        // 检测是否在合同期内
        $agentCondition = array(
            "id"    =>$info['agent_id']
        );
        $agentInfo = M("AgentInfo")->field("status,contract_end")->where($agentCondition)->find();
        if($agentInfo['status'] == 0) {
            $backData = array(
                "code"  =>204,
                "msg"   =>"代理合同已被中止,请联系平台客服",
                "info"  =>$agentInfo
            );
            $this->ajaxReturn($backData); 
        }
        if(strtotime($agentInfo['contract_end']) < time()) {
            $backData = array(
                "code"  =>205,
                "msg"   =>"代理合同已到期,请联系平台客服",
                "info"  =>$agentInfo
            );
            $this->ajaxReturn($backData); 
        }
    }





}