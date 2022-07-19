<?php
namespace Admin\Controller;

use Think\Controller;

class UserController extends Controller
{

    public function do_login()
    {
        if (IS_POST) {
            $postData = json_decode(file_get_contents("php://input"),true);
            $condition = array(
                "username" => $postData["username"],
                "password" => md5($postData["password"]),
            );
            $userInfo = M("Users")->field("id")->where($condition)->fetchSql(false)->find();

            if (!$userInfo) {
                $backData = array(
                    "code" => 13001,
                    "msg" => "账号或密码错误"
     
                );
                $this->ajaxReturn($backData);

            }

            $token = bin2hex(random_bytes('12'));

            $sessionData = array(
                "token" =>$token,
                "expires_time"  =>time() + (12*60*60)
            );

            $sessionWhere = array(
                "uid"   =>$userInfo["id"]
            );
            $sessionModel = M("UserSession");
            $sessionExists = $sessionModel->where($sessionWhere)->count();
            if($sessionExists) {
                $sessionResult = $sessionModel->data($sessionData)->where($sessionWhere)->save();
            }else {
                $sessionData["uid"] = $userInfo["id"];
                $sessionResult = $sessionModel->data($sessionData)->add();
            }

            if(!$sessionResult) {
                $backData = array(
                    "code" => 13001,
                    "msg" => "系统错误"
     
                );
                $this->ajaxReturn($backData); 
            }

            $backData = array(
                "code" => 200,
                "msg" => "sucess",
                "data" => array(
                    "token" => $token,
                ),
            );
            $this->ajaxReturn($backData);
        }
    }

}
