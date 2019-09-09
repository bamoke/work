<?php
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-08-07 00:35:20 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-08-09 03:57:56
 * error code
 * 200 success
 * 201 user does not exist
 * 202 validate code error
 */
namespace Agent\Controller;
use Think\Controller;
class MainController extends Controller
{

    public $requestData;
    public function _initialize(){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods:POST,GET,OPTIONS'); 
        header("Access-Control-Allow-Headers:Content-Type,accept,X-URL-PATH,x-access-token");
/*         if($_SERVER['REQUEST_METHOD'] != "OPTIONS") {
            if($_SERVER['REQUEST_METHOD'] == "POST") {
                $this->requestData = json_decode(file_get_contents("php://input"),true);
            }elseif($_SERVER['REQUEST_METHOD'] == "GET") {
                $this->requestData = $_GET;
            }
        }else {
            header("HTTP/1.0 204 Not Content");
            // exit;
        } */

    }
    public function logout(){
        session(null);
        
    }

    /*
     * 验证码
     * */
    public function code()
    {
        $config = array(
            'expire' => 600,//验证码过期时间
            'useImgBg' => false,//是否使用背景图,默认false;
            'useCurve' => false,//是否使用混淆曲线,默认true;
            'useNoise' => false,//是否添加杂点；默认true;
            'fontSize' => '16px',//设置字体大小，默认25px;
            'imageW' => '120px',//验证码宽度;
            'imageH' => '34px',//验证码高度;
            'length' => 4,//验证码字符数
            'bg' => array(190, 190, 190)
        );
        $verify = new \Think\Verify($config);
        $verify->entry();
    }

    /*
     * 用户登录操作
     * @param array
     * @return json
     * */
    public function login(){
        if(!IS_POST){
            $backData = array(
                "code"  =>10001,
                "msg"   =>"非法操作"
            );
            $this->ajaxReturn($backData);
        }

        $postData = json_decode(file_get_contents("php://input"),true);
        $where = array(
            "username"  =>$postData['userName']
        );
        $userFirst = M("AgentAdmin")->where($where)->fetchSql(false)->find();
        if(!$userFirst) {
            $backData = array(
                "code"  =>201,
                "msg"   =>"用户不存在"

            );
            $this->ajaxReturn($backData);
        }

        $where['password']  = md5($postData['password']);
        $user = M("AgentAdmin")
        ->field("id,username,realname,status")
        ->where($where)
        ->fetchSql(false)
        ->find();

        if(!$user) {
            $backData = array(
                "code"  =>202,
                "msg"   =>"账号或密码错误",
                "info"  =>$where
            );
            $this->ajaxReturn($backData);
        }
        if($user["status"] != 1){
            $backData = array(
                "code"  =>203,
                "msg"   =>"账号被锁定;请联系管理员",
                "info"  =>$where
            );
            $this->ajaxReturn($backData); 
        }

        // insert or update session token
        $sessionModel = M("AgentSession");
        $newToken = md5(time().$uid);
        $sessionWhere = array(
            "uid"   =>$user['id']
        );
        $sessionInfo = $sessionModel->where($sessionWhere)->fetchSql(false)->find();
   
        $sessionData = array(
            "token" =>$newToken,
            "expires_time"  => time()+3600
        );
        if(!$sessionInfo){
            $sessionData["uid"] = $user['id'];
            $sessionResult = $sessionModel->where($sessionWhere)->add($sessionData);
        }else {
            $sessionResult = $sessionModel->where($sessionWhere)->save($sessionData);
        }
        
        // insert login log


        // fetch access rules

        $backData = array(
            "code"      => 200,
            "msg"       =>'success',
            "data"      =>array(
                "userInfo"  =>$user,
                "access"    =>"",
                "token"     =>$newToken
            )
        );
        $this->ajaxReturn($backData); 
    }


}