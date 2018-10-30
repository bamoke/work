<?php
namespace Web\Controller;
use Web\Common\WebController;
class OtherController extends WebController {
        function login() {
            
            if(IS_POST){
                $this->verifyLogin($_POST);
            }else {
                layout(false);
                $this->display();
            }
    
        }
    
        public function register(){
            layout(false);
            $this->display();
        }
        public function logout(){
            session(null);
            $this->redirect("Index/index");
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
            }else {
                $memberModel=D('Member');
                $member=$memberModel
                    ->where(array("username"=>I("post.username"),"password"=>md5(I("post.password"))))
                    ->find();
                if($member){
                    session("webuid",intval($member['id']));
                    session("webusername",I("post.username"));
                    $backData=array(
                        'status'    =>true,
                        'jump'       =>U("Member/index"),
                    );
                }else {
                    $backData=array(
                        'status'    =>false,
                        'msg'       =>"用户名或密码错误",
                    );
                }
            }
            $this->ajaxReturn($backData);
    
        }

        public function doreg (){
            if(IS_POST){
                $curModel = M("Member");
                $isExisted = $curModel->where(array('username'=>I("post.username")))->find();
                if($isExisted) {
                    $backData=array(
                        'status'    =>false,
                        'msg'       =>"邮箱被占用",
                    );
                    return $this->ajaxReturn($backData);    
                }
                $createResult = $curModel->create();
                if(!$createResult){
                    $backData=array(
                        'status'    =>false,
                        'msg'       =>"数据错误",
                    );
                    return $this->ajaxReturn($backData);   
                }
                $curModel->password = md5(I('post.password'));
                $curModel->reg_time = time();
                $insertResult = $curModel->add();
                if($insertResult){
                    $backData=array(
                        'status'    =>true,
                        'msg'       =>"注册成功,请登录",
                        "jump"      =>U("login")
                    );
                }else {
                    $backData=array(
                        'status'    =>false,
                        'msg'       =>"注册失败请稍后再试",
                    );
                }
                $this->ajaxReturn($backData);
            }
        }
    }