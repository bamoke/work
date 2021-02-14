<?php
namespace Adviser\Controller;
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

        $user_model=M('AdviserUser');
        $userWhere = array(
            "username"  =>I("post.username"),
            "password"  => md5(I("post.password"))
        );

        $userInfo = $user_model
        ->where($userWhere)
        ->fetchSql(false)
        ->find();
        $username =I("post.username");
        if(!$userInfo) {
            $this->insertLog($username,0,'用户名或密码错误');
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
        session("username",I("post.username"));
        session("realname",$userInfo['realname']);
        session("special",$userInfo["special"]);
        if($userInfo["avatar"]){
            session("avatar",C("OSS_BASE_URL")."/".$userInfo['avatar']);
        }

        $this->insertLog($username,1,'登录成功');
        $backData=array(
            'status'    =>true,
            'jump'       =>U("Index/index"),
        );
        $this->ajaxReturn($backData);   


    }

    /**
     * log
     */
    protected function insertLog($username,$status,$description){
        $logModel = M("AdviserLoginLog");
        // $IpLocation = new \Org\Net\IpLocation();
        // var_dump($IpLocation->getlocation());
        $ip= $this->get_client_ip();
        $insertData = array(
            "username"  =>$username,
            "status"    =>$status,
            "description"   =>$description,
            "ip"        =>$ip,
        );
        // var_dump($insertData);
        $logResult = $logModel->data($insertData)->fetchSql(false)->add();
    }

    /**
     * 获取ip地址
     */
    protected function get_client_ip($type = 0) {
        $type       =  $type ? 1 : 0;
        static $ip  =   NULL;
        if ($ip !== NULL) return $ip[$type];
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos    =   array_search('unknown',$arr);
            if(false !== $pos) unset($arr[$pos]);
            $ip     =   trim($arr[0]);
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip     =   $_SERVER['HTTP_CLIENT_IP'];
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = ip2long($ip);
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }


}