<?php
namespace Business\Controller;
use Think\Controller;
class MainController extends Controller {
    public function login(){
        layout(false);
        $this->assign("debugTime",1);
        $this->display();
    }


    public function logout(){
        session(null);
        $this->redirect("Main/login");
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
    public function dologin(){
        
        $verify = new \Think\Verify();
        if($verify->check(I("post.code")) === false){
            $backData=array(
                'status'    =>false,
                'msg'       =>"验证码错误",
            );
            $this->ajaxReturn($backData);
        }

        $user_model=M('BusinessUser');
        $userWhere = array(
            "username"  =>I("post.username"),
            "password"  => md5(I("post.password"))
        );

        $userInfo = $user_model
        ->where($userWhere)
        ->fetchSql(false)
        ->find();
        if(!$userInfo) {
            $backData=array(
                'status'    =>false,
                'msg'       =>"用户名或密码错误",
            );
            $this->ajaxReturn($backData);  
        }
        if($userInfo["status"] != 1) {
            $backData=array(
                'status'    =>false,
                'msg'       =>"用户被锁定,请联系平台管理员",
            );
            $this->ajaxReturn($backData);   
        }

        session("uid",intval($userInfo['id']));
        session("bid",intval($userInfo['b_id']));
        session("username",I("post.username"));
        session("realname",$userInfo['realname']);
        $backData=array(
            'status'    =>true,
            'jump'       =>U("Index/index"),
        );
        $this->ajaxReturn($backData);   


    }
}