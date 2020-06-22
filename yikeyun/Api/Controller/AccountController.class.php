<?php
namespace Api\Controller;
use Think\Controller;
class AccountController extends Controller {

    protected function createSessionId(){
        $session_id=`head -n 80 /dev/urandom | tr -dc A-Za-z0-9 | head -c 32`;
        return $session_id;
    }

    /**
     * 手机号绑定
     */
    public function bind(){
        if(!IS_POST){
            $backData = array(
                "code" =>10001,
                "msg"  =>'请求错误',
            );
            return $this->ajaxReturn($backData);       
        }
        $this->_checklogin();
        $memberId = $this->getMemberId();
        // 1.1 check data
        $phone = I("post.mobile");
        $code = I("post.vcode");
        $realname = I("post.realname");
        // 1.1.1 validate phone 
        if(empty($phone)){
            $backData = array(
                "code" =>13001,
                "msg"  =>'手机号不能为空'
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
        if(($codeInfo['create_time'] + 300) < time()) {
            $backData = array(
                "code" =>13001,
                "msg"  =>'验证码已过期'
            );
            return $this->ajaxReturn($backData);            
        }


        // 1.2 update member
        $memberData = array(
            "phone"         => $phone,
            "realname"      =>$realname
        );


        $updateCondition = array(
            "id"    =>$memberId
        );
        $updateResult = M("Member")->data($memberData)->fetchSql(false)->where($updateCondition)->save();

        $updateStudent = M("ClassStudents")->where(array("mobile"=>$phone))->data(array("member_id"=>$memberId,"bind_time"=>time()))->save();
        if(!$updateResult || !$updateStudent) {
            $backData = array(
                "code" =>13002,
                "msg"  =>'绑定失败'
            );
            $this->ajaxReturn($backData); 
        }


        $backData = array(
            "code" =>200,
            "msg"  =>'绑定成功'
        );
        $this->ajaxReturn($backData); 
    }
 
    /**
     * 微信登陆
     * 1.检测是否已经注册过（第一次登陆生成新用户）
     */
    public function mplogin(){
       if(empty($_GET['code'])) {
            $backData = array(
                "code" =>10001,
                "msg"  =>'参数错误',
            );
            return $this->ajaxReturn($backData);
        }
        // 1. 登录获取openid，
        $code = I('get.code');
        $Http = new \Org\Net\Http();
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.APP_ID.'&secret='.APP_KEY.'&js_code='.$code.'&grant_type=authorization_code';
        $result = json_decode($Http->sendHttpRequest($url),true);
        if(!isset($result['openid'])) {
            $backData = array(
                "code" =>12001,
                "msg"  =>'微信登陆连接失败',
                "data" =>array(
                    "info"  =>$result
                )
            );
            $this->ajaxReturn($backData);
        }

        $openid = $result['openid'];
        $wxSessionkey = $result['session_key'];
        $accessToken = $this->createSessionId();

        // 1.2 查询是否已经有注册
        $memberCondition = array(
            "openid"    =>$openid
        );
        $sessionInfo = M("Mysession")->where($memberCondition)->fetchSql(false)->find();
        if($sessionInfo) {
            // 更新SESSION Token
            $updateData = array(
                "token" =>$accessToken,
                "expires_time"  => time() + (3600 * 24 * 7)
            );
            $updateSession = M("Mysession")->where(array("id"=>$sessionInfo['id']))->save($updateData);
            if($updateSession !== false){
                $backData = array(
                    "code" =>200,
                    "msg"  =>'ok',
                    "data"=>array(
                        "accessToken" =>$accessToken
                    )
                );
            }else {
                $backData = array(
                    "code" =>13002,
                    "msg"  =>'登陆态更新失败'
                );
            }
            $this->ajaxReturn($backData);

        }else {
            $model = M();
            $model->startTrans();
            // 新建用户
            $memberInsertData = array(
                "openid"    =>$openid,
                "reg_time" =>time()
            );
            $memberInsertResult = M("Member")->data($memberInsertData)->fetchSql(false)->add();

            $sessionInsertData = array(
                "uid"           =>$memberInsertResult,
                "openid"        =>$openid,
                "token"         =>$accessToken,
                "expires_time"  =>time() + (3600*24*7)
            );
            $sessionInsertResult = M("Mysession")->data($sessionInsertData)->add();
            
            // 2.1 新建session
            if(!$memberInsertResult || !$sessionInsertResult) {
                $model->rollback();
                $backData = array(
                    "code" =>13002,
                    "msg"  =>'数据创建错误'
                );   
            }else {
                $model->commit();
                $backData = array(
                    "code" =>200,
                    "msg"  =>'success',
                    "data"  =>array(
                        "accessToken"   =>$accessToken
                    )
                ); 
            }
            $this->ajaxReturn($backData);
        }
        
    }

    /**
     * 获取用户OPENID
    */
    public function getopenid(){
        $accessToken = $_SERVER["HTTP_X_ACCESS_TOKEN"];
        $sessionInfo = M("Mysession")
        ->where(array('token'=>$accessToken))
        ->find();
        return $sessionInfo ? $sessionInfo['openid'] : null;
    }

    /**
     * 检测是否已经微信登录
     */
    protected function _checklogin(){
        if(empty($_SERVER["HTTP_X_ACCESS_TOKEN"])) {
            $backData = array(
                "code"  => 11001,
                "msg"   => "请登录后再操作"
            );
            $this->ajaxReturn($backData);
        }
        $sessionModel = M("Mysession");
        $where = array(
            "token" =>$_SERVER["HTTP_X_ACCESS_TOKEN"]
        );
        $res = $sessionModel->where($where)->find();
        if(!$res) {
            $backData = array(
                "code"  => 11002,
                "msg"   => "登陆态已过期，请重新登录"
            );
            $this->ajaxReturn($backData);          
        }
        
    }

    /**
     * 获取用户ID
    */
    public function getMemberId(){
        $accessToken = $_SERVER["HTTP_X_ACCESS_TOKEN"];
        $memberId = null;
        $sessionInfo = M("Mysession")->field("uid")->where(array("token"=>$accessToken))->fetchSql(false)->find();
        if($sessionInfo){
            $memberId = intval($sessionInfo['uid']);
        }
        return $memberId;
    }

  


    /**
     * Fetch member info
     */
    public function getUserinfo(){
        $memberId = $this->getMemberId();
        $info = M("MemberInfo")->where("member_id=$memberId")->find();
        if($info){
            $backData = array(
                "code" =>200,
                "msg"  =>"ok",
                "data"  =>$info
            );
        }else {
            $backData = array(
                "code" =>13001,
                "msg"  =>"系统繁忙"
            );
        }
        $this->ajaxReturn($backData);
    }

    /**
     *  新增&更新用户头像和昵称
     *
    */
    public function updateUserinfo(){
        if(IS_POST){
            $memberId = $this->getMemberId();
            $model = M("MemberInfo");

            $data = I("post.");
            $userInfo = $model->where(array('member_id'=>$memberId))->find();
            if($userInfo){
                $result = $model->where(array('id'=>$userInfo['id']))->data($data)->fetchSql(false)->save();
            }else {
                $data['member_id'] = $memberId;
                $result = $model->data($data)->fetchSql(false)->add();
            }

            if($result !== false){
                $backData = array(
                    "code" =>200,
                    "msg"  =>"ok",

                );
            }else {
                $backData = array(
                    "code" =>13001,
                    "msg"  =>"更新资料错误",
                );
            }
            $this->ajaxReturn($backData);
        }
    }

    /**
     * 获取手机验证码 
     */
    public function mpcode($phone){
        //1.1 检测手机号码
        if($this->check_phone($phone)){
            $backData = array(
                "code"     =>13001,
                "msg"      =>"手机号码已经存在"
            );
            $this->ajaxReturn($backData);
        }


        //1.2 检测时效，发送间隔必须在60秒
        $codeMode = M("SmsCode");
        $prevTime = $codeMode->field("id,create_time")->where("phone=$phone")->fetchSql(false)->find();
        $curTime = time();
        if($prevTime && $curTime < $prevTime['create_time']){
            $backData = array(
                "code"     =>13002,
                "msg"      =>"发送过于频繁"
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
        $params["SignName"] = "一课云";
        $params["TemplateCode"] = "SMS_143300249";
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
                "create_time"   =>time()+60
            );
            if($prevTime){
                $codeResult = $codeMode->where("id=".$prevTime['id'])->data($dataArr)->save();
            }else{
                $dataArr['phone'] = $phone;
                $codeResult = $codeMode->data($dataArr)->add();
            }
            if($codeResult){
                $backData = array(
                    "code"     =>200,
                    "msg"      =>"OK"
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
                "msg"      =>$content->Message
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


    /** 
     * 手机号绑定
     * actype 1绑定手机,
     */
    public function bindphone(){
        $memberId = $this->getMemberId();
        //1.1检测验证码
        $phone = I("post.phone");
        $code = I("post.code");
        $verifyCondition = array(
            "phone" =>$phone,
            "code"  =>$code
        );
        $vertifyNum = M("SmsCode")->where($verifyCondition)->fetchSql(false)->count();
        if(0 == $vertifyNum){
            $backData = array(
                "code"     =>13001,
                "msg"      =>"验证码不正确"
            );
            $this->ajaxReturn($backData);
        }

        // 1.1.1 检测号码是否存在
        $accountInfo = M("Member")->field("id")->where(array("phone"=>$phone))->fetchSql(false)->find();
        if($accountInfo){
            $backData = array(
                "code"     =>13002,
                "msg"      =>"该手机号码已被占用"
            );
            $this->ajaxReturn($backData); 
        }

        $model = M();
        $model->startTrans();

        //1.2 更新用户表
        $addBalanceVal = 10;
        $updateData =array(
            "phone"             =>$phone
        );
        $updateMember = M("Member")->where("id=".$memberId)->fetchSql(false)->save($updateData);


        //1.3 增加余额
        $addBalanceResult = true;
        // $addBalanceResult = $this->addBalance($addBalanceVal,"手机号绑定奖励",$memberId);
        
        if($updateMember && $addBalanceResult){
            $backData = array(
                "code"     =>200,
                "msg"      =>"success",
                "data"  =>array("tips"=>"绑定成功")
            ); 
            // $backData['errorMsg'] = $acType==1? "恭喜您完成手机号绑定，并获得".(int)$addBalanceVal."元现金奖励" : "已绑定为新手机号码";
            $model->commit();
        }else {
            $backData = array(
                "code"     =>13001,
                "msg"      =>"系统繁忙"
            );
            $model->rollback();
        }
        $this->ajaxReturn($backData);

    }


}