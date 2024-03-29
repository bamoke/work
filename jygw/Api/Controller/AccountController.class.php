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
     * mini program login
     */
    public function mplogin(){
        if(empty($_GET['code'])) {
            $backData = array(
                "code" =>10001,
                "msg"  =>'参数错误',
            );
            return $this->ajaxReturn($backData);
        }

        // 1. 登录微信服务器，
        $APP_ID = "wxaa14c7aa5e3fd67a";
        $APP_SECRET = "5ab41a47452cd6f224391a1d029bfd27";
        $code = I('get.code');
        $Http = new \Org\Net\Http();
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$APP_ID.'&secret='.$APP_SECRET.'&js_code='.$code.'&grant_type=authorization_code';
        $mpRresult = json_decode($Http->sendHttpRequest($url),true);
        // var_dump($mpRresult);
        $result = $mpRresult;
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
        // $accessToken = $this->createSessionId();
        $accessToken = $result['openid'];
        $sessionModel = M("Mysession");
        $sessionInfo = $sessionModel->where(array("openid"=>$openid))->fetchSql(false)->find();
        if($sessionInfo){
            $updateData = array(
                "token" =>$accessToken,
                "sessionkey" =>$sessionkey
            );
            $updateSession = $sessionModel->where(array("openid"=>$openid))->save($updateData);
            if($updateSession !== false){
                $backData = array(
                    "code" =>200,
                    "msg"  =>'ok',
                    "data"  => array(
                        "token" => $accessToken
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
                "uid"           =>$insertMember,
                "token"         =>$accessToken,
                "openid"        =>$openid,
                "sessionkey"    =>$sessionkey
            );
            $insertSession = $sessionModel->fetchSql(false)->add($insertSessionData);
            // 1.5 数据提交;
            if($insertSession && $insertMember){
                $backData = array(
                    "code" =>200,
                    "msg"  =>'ok',
                    "data"  => array(
                        "token" => $accessToken
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
        $memberInfo = M("Mysession")->field("uid")->where(array("token"=>$accessToken))->find();
        if($memberInfo){
            $memberId = $memberInfo['id'];
        }
        return (int)$memberId;
    }





}