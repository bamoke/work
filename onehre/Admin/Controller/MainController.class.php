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

namespace Admin\Controller;
class MainController
{
    public function __construct(){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods:POST,GET'); 
        header("Access-Control-Allow-Headers:Content-type,accept,X-URL-PATH,x-access-token");
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
        $postData = json_decode(file_get_contents("php://input"),true);
        $where = array(
            "username"  =>$postData['userName']
        );
        $userFirst = M("User")->where($where)->fetchSql(false)->find();

        if(!$userFirst) {
            $backData = array(
                "code"  =>201,
                "msg"   =>"用户不存在"

            );
            $this->ajaxReturn($backData);
        }
        $where['password']  = md5($postData['password']);
        $user = M("User")->field("id,username,realname,group_id,status")->where($where)->fetchSql(false)->find();
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
        $sessionModel = M("AdminSession");
        $newToken = md5(time().$uid);
        $sessionWhere = array(
            "uid"   =>$user['id']
        );
        $sessionInfo = $sessionModel->where($sessionWhere)->find();
        $sessionData = array(
            "token" =>$newToken,
            "expires_time"  => time()+3600
        );
        if($sessionInfo){
            $sessionResult = $sessionModel->where($sessionWhere)->save($sessionData);
        }else {
            $sessionData["uid"] = $user['id'];
            $sessionResult = $sessionModel->where($sessionWhere)->data($sessionData)->add();
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

    protected function ajaxReturn($data){
        if(is_array($data)){
            exit(json_encode($data));
        }else {
            exit($data);
        }
    }
}