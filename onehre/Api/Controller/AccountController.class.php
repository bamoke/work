<?php
namespace Api\Controller;
use Think\Controller;
class AccountController extends Controller {

    protected function createSessionId(){
        $session_id=`head -n 80 /dev/urandom | tr -dc A-Za-z0-9 | head -c 32`;
        return $session_id;
    }

    function test (){
        echo "s";
    }
    
    /** 
     * member regist
     */
    public function regist(){
        if(!IS_POST){
            $backData = array(
                "code" =>10001,
                "msg"  =>'请求错误',
            );
            return $this->ajaxReturn($backData);       
        }
        // 1.1 check data
        $phone = I("post.phone");
        $password = I("post.password"); 
        $password2 = I("post.password2"); 
        $code = I("post.code");
        // 1.1.1 validate phone 
        if(empty($_POST['phone'])){
            $backData = array(
                "code" =>13001,
                "msg"  =>'手机号不能为空'
            );
            return $this->ajaxReturn($backData);   
        }
        // 1.1.2 validate password
        if($password !== $password2){
            $backData = array(
                "code" =>13001,
                "msg"  =>'两次密码不一致'
            );
            return $this->ajaxReturn($backData);   
        }
        // 1.1.3 validate phone
        $isExist = M("Member")->where(array("phone"=>$phone))->find();
        if($isExist) {
            $backData = array(
                "code" =>13001,
                "msg"  =>'用户已存在'
            );
            return $this->ajaxReturn($backData);              
        }
        // 1.1.4 validate code
        $codeInfo = M("SmsCode")->where(array("phone"=>$phone))->find();
        if(!$codeInfo || $code != $codeInfo['code']) {
            $backData = array(
                "code" =>13001,
                "msg"  =>'验证码不正确'
            );
            return $this->ajaxReturn($backData);  
        }
        if(($codeInfo['send_time'] + 600) < time()) {
            $backData = array(
                "code" =>13001,
                "msg"  =>'验证码已过期'
            );
            return $this->ajaxReturn($backData);            
        }

        // 1.2 insert
        $memberData = array(
            "phone"         => $phone,
            "password"      => md5($password."onehre"),
            "reg_time"      => time()
        );
        
        $model = M();
        $model->startTrans();
        $insertMemberId = M("Member")->data($memberData)->add();
        $sessionData = array(
            "uid"           => $insertMemberId,
            "token"         => $this->createSessionId(),
            "expires_time"  => time() + (3600 * 24 * 7)
        );
        $insertSession = M("Mysession")->data($sessionData)->add();
        if(!$insertMemberId || !$insertSession) {
            $model->rollback();
            $backData = array(
                "code" =>13002,
                "msg"  =>'登录失败'
            );
            $this->ajaxReturn($backData); 
        }

        $model->commit();
        $backData = array(
            "code" =>200,
            "msg"  =>'注册成功'
        );
        $this->ajaxReturn($backData); 
    }
    /**
     *  Account login
     */
    public function login(){
        if(!IS_POST){
            $backData = array(
                "code" =>10001,
                "msg"  =>'请求错误',
            );
            return $this->ajaxReturn($backData);       
        }
        $memberModel = M("Member");
        $phone  = I("post.phone");
        $password = md5(I("post.password")."onehre");
        $condition = array(
            "phone"     => $phone
        );
        $memberInfo = $memberModel->field("id,error_time,error_limit")->where($condition)->find();
        if(!$memberInfo){
            $backData = array(
                "code" =>13001,
                "msg"  =>'账号不存在',
            );
            return $this->ajaxReturn($backData);      
        }
        if($memberInfo['error_time'] >= 5 && $memberInfo['error_limit'] > time()) {
            $backData = array(
                "code" =>13002,
                "msg"  =>"密码错误超过五次，账号锁定2小时",
            );
            return $this->ajaxReturn($backData);            
        }
        $error_time = $memberInfo["error_time"];
        $condition['password'] = $password;
        $memberInfo = $memberModel->field("id")->where($condition)->find();
        if(!$memberInfo){
            // update error info
            $updateData =array(
                "error_time"    => $error_time + 1
            );
            if($error_time >= 4){
                $updateData['error_limit'] = time() + 7200;
            }
            $updateError = $memberModel->where(array("phone"=>$phone))->save($updateData);
            $backData = array(
                "code" =>13003,
                "msg"  =>'密码错误',
            );
            return $this->ajaxReturn($backData);      
        }

        $model = M();
        $model->startTrans();
        // update session
        $accessToken = $this->createSessionId();
        $sessionData = array(
            "token" =>$accessToken
        );
        $updateSession = M("Mysession")->where(array("uid"=>$memberInfo['id']))->data($sessionData)->fetchSql(false)->save();
        // update member
        $memberData = array(
            "error_time"    => 0,
            "error_limit"   => null

        );
        $updateMemer = M("Member")->where(array("id"=>$memberInfo['id']))->data($memberData)->fetchSql(false)->save();
        if(!$updateSession || $updateMemer === false) {
            $model->rollback();
            $backData = array(
                "code" =>13004,
                "msg"  =>'数据更新错误',
            );
            return $this->ajaxReturn($backData);              
        }
        $model->commit();
        $backData = array(
            "code" =>200,
            "msg"  =>'登录成功',
            "info"  => array(
                "token" => $accessToken,
                "user" => array(
                    "uid"   => $memberInfo["id"],
                    "phone" => $phone
                )
            )
        );
        return $this->ajaxReturn($backData);    





        
    }

    /**
     * mini program login
     */
    public function mp_login(){
        if(empty($_GET['code'])) {
            $backData = array(
                "code" =>10001,
                "msg"  =>'参数错误',
            );
            return $this->ajaxReturn($backData);
        }
        // 1. 登录微信服务器，
        $APP_ID = "wx20e37dd9f2ca7886";
        $APP_SECRET = "65ea53b18f617a7d5bd36a5366253b9c";
        $code = I('get.code');
        $Http = new \Org\Net\Http();
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$APP_ID.'&secret='.$APP_SECRET.'&js_code='.$code.'&grant_type=authorization_code';
        $mpRresult = json_decode($Http->sendHttpRequest($url),true);
        $result = $mpRresult["info"];
        if(!isset($result['openid'])){
            $backData = array(
                "code" =>12001,
                "msg"  =>'微信登陆连接失败',
                "info"      =>$result
            );
            $this->ajaxReturn($backData);
        }

        //1.2 session manage
        $openid = $result['openid'];
        $sessionkey = $result['session_key'];
        $accessToken = $this->createSessionId();
        $sessionModel = M("Mysession");
        $sessionInfo = $sessionModel->where(array("openid"=>$openid))->find();
        if($sessionInfo){
            $updateData = array(
                "token" =>$accessToken,
                "sessionkey" =>$sessionkey
            );
            $updateSession = $sessionModel->where(array("openid"=>$openid))->save($updateData);
            if($updateSession !== false){
                $accountInfo = M("Member")->field("id,phone")->where(array("openid"=>$openid))->find();
                $backData = array(
                    "code" =>200,
                    "msg"  =>'ok',
                    "info"  => array(
                        "token" => $accessToken,
                        "user"  => array(
                            "uid"   =>$accountInfo['id'],
                            "phone" => $accountInfo['phone']
                        )
                    )
                );
            }else {
                $backData = array(
                    "code" =>13002,
                    "msg"  =>'登录失败'
                );
            }

        }else {
            $model = M();
            $model->startTrans();
            // 1.3 创建用户
            $memberModel = M("Member");
            $insertMemberData = array(
                "openid"    =>$openid,
                "reg_time"  =>time()
            );
            $insertMember = $memberModel->fetchSql(false)->add($insertMemberData);
            
            //1.4 创建session
            $insertSessionData = array(
                "token"         =>$accessToken,
                "openid"        =>$openid,
                "sessionkey"    =>$sessionkey
            );
            $insertSession = $sessionModel->fetchSql(false)->add($insertSessionData);
            // var_dump($insertSession);
            // 1.5 数据提交;
            if($insertSession && $insertMember){
                $backData = array(
                    "code" =>200,
                    "msg"  =>'ok',
                    "info"  => array(
                        "token" => $accessToken,
                        "user"  => array(
                            "uid"    =>$insertMember,
                            "phone" => ''
                        )
                    )
                );
                $model->commit();
            }else {
                $model->rollback();
                $backData = array(
                    "code" =>13002,
                    "msg"  =>'登录失败'
                );
            }
        }
        $this->ajaxReturn($backData);

    }

    public function getopenid(){
        $accessToken = $_SERVER["HTTP_X_ACCESS_TOKEN"];
        $sessionInfo = M("Mysession")->field('openid')->where(array("token"=>$accessToken))->find();
        return $sessionInfo ? $sessionInfo['openid'] : null;
    }

    /**
     * 获取用户账号信息
    */
    public function getMemberId(){
        $accessToken = $_SERVER["HTTP_X_ACCESS_TOKEN"];
        $memberId = null;
        $memberInfo = M("Member")->field("id")->where(array("token"=>$accessToken))->find();
        if($memberInfo){
            $memberId = $memberInfo['id'];
        }
        return (int)$memberId;
    }

    


    /**
     * 获取手机验证码 
     */
    public function mpcode(){
        if(empty($_GET['phone'])){
            $backData = array(
                "code"     =>13000,
                "msg"      =>"请求参数错误"
            );
            $this->ajaxReturn($backData);
        }
        $phone = $_GET['phone'];
        //1.1 检测手机号码
        if($this->check_phone($phone)){
            $backData = array(
                "code"     =>13001,
                "msg"      =>"手机号码已经存在"
            );
            $this->ajaxReturn($backData);
        }


        //1.2 检测时效，发送间隔必须在60秒
        $codeModel = M("SmsCode");
        $codeInfo = $codeModel->field("id,send_time")->where("phone=$phone")->fetchSql(false)->find();
        $curTime = time();
        if($codeInfo && $curTime - $codeInfo['send_time'] < 60){
            $backData = array(
                "errorCode"     =>13002,
                "errorMsg"      =>"发送过于频繁"
            );
            $this->ajaxReturn($backData);
        }

        //1.3 创建验证码
        $code = mt_rand(100000,999999);
        
        //1.4 发送验证码
        $params = array ();
        $accessKeyId = "LTAINblZBk0NW7B2";
        $accessKeySecret = "2dwoD97kbxNQxhWVI20acjOxpXv0PZ";
        $params["PhoneNumbers"] = $phone;
        $params["SignName"] = "校招汇";
        $params["TemplateCode"] = "SMS_143300246";
        $params['TemplateParam'] = Array (
            "code" => $code
            // "product" => "阿里通信"
        );

            // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }
        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new \Vendor\AliSmsApi\SignatureHelper();
        try {
            $content = $helper->request(
                $accessKeyId,
                $accessKeySecret,
                "dysmsapi.aliyuncs.com",
                array_merge($params, array(
                    "RegionId" => "cn-hangzhou",
                    "Action" => "SendSms",
                    "Version" => "2017-05-25",
                ))
            );
            
        } catch( \Exception $e) {
            $backData = array(
                "code"     =>13004,
                "msg"      =>$e->getMessage()
            );
            $this->ajaxReturn($backData);
        }

        //1.5 写入code表
        if($content->Message == "OK"){
            $codeResult = false;
            $dataArr = array(
                "code"          =>$code,
                "send_time"   =>time()
            );
            if($codeInfo){
                $codeResult = $codeModel->where("id=".$codeInfo['id'])->data($dataArr)->save();
            }else{
                $dataArr['phone'] = $phone;
                $codeResult = $codeModel->data($dataArr)->fetchSql(false)->add();
            }
            if($codeResult){
                $backData = array(
                    "code"     =>200,
                    "msg"      =>"ok"
                );
            }else {
                $backData = array(
                    "code"     =>13005,
                    "msg"      =>"insert error"
                );
            }
            $this->ajaxReturn($backData);

        }else{
            $backData = array(
                "code"     =>13004,
                "msg"      =>"短信通道错误",
                "errorInfo"=>$content->Message
            );
            $this->ajaxReturn($backData);
        }

    }

    /**
     * 检测手机号码
      */
    
    public function check_phone($phone){
        $where = array(
            "phone" =>$phone
        );
        $result = M("Member")->where($where)->fetchSql(false)->find();
        if($result){
            return true;
        }else {
            return false;
        }
    }




}