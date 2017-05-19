<?php
/**
 * 管理员控制器
 * Model: wc_admin
 */

namespace Admin\Controller;
use Think\Controller;

class UserController extends Controller
{
   public function login(){
       if(IS_POST){
           $backData=array();
           $username=I('post.username');
           $password=I('post.password');
           $verify=I('post.verify');
           /*
            * 1.判断post数据是否为空
            * 2.判断验证码是否正确
            * 3.查询数据表是否存在此用户
            *
            * */
           if($username == ''){
               $backData=array("status"=>false,'tips'=>"请输入用户名");
           }elseif($password == ''){
               $backData=array("status"=>false,'tips'=>"请输入密码");
           }elseif(!$this->_check_verify($verify)){
               $backData=array("status"=>false,'tips'=>"验证码错误");
           }else {
               $user=D('User');
               $map['username']=$username;
               $map['password']=$this->_pswEncrypt($password);
               $result=$user->where($map)->field('id,username,usergroup')->find();
               if(!$result){
                   $backData=array("status"=>false,'tips'=>"用户名或密码错误");
               }else {
                   session('username',$username);
                   session('uid',$result['id']);
                   session('ugroup',$result['usergroup']);
                   $backData=array("status"=>true,'jumpUrl'=>U('Index/index'),'result'=>$result);
               }
           }
           $this->ajaxReturn($backData);
       }else {
           $this->display('Main/login');
       }

   }

    public function create_verify(){
        $config=array(
            'expire'=>600,//验证码过期时间
            'useImgBg'=>false,//是否使用背景图,默认false;
            'useCurve'  =>false,//是否使用混淆曲线,默认true;
            'useNoise'  =>false,//是否添加杂点；默认true;
            'fontSize'  =>'20px',//设置字体大小，默认25px;
//            'imageW'    =>'230px',//图片宽度;
//            'imageH'    =>'40px',//图片高度;
            'length'    =>4,//验证码字符数

        );
        $verify= new \Think\Verify($config);
        $verify->entry();
    }

// 检测输入的验证码是否正确，$code为用户输入的验证码字符串
   private function _check_verify($code, $id = ''){
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }

//    加密管理员登录密码
    private function _pswEncrypt($psw){
        return md5($psw.'bmk');
    }

    /*
     * 用户退出
     * */
    public function logout(){
        session(null);
        $this->redirect('login');
    }
}