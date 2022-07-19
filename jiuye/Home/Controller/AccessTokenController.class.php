<?php
namespace Home\Controller;
use Think\Controller;

class AccessTokenController extends Controller {
    protected $appId = "wx9eb1b96be10c0603";
    protected $appSecret = "1cfe2f1b6f0221482c9a7b99f61a494c";


    public function getToken(){
        $tokenWhere = array(
            "keyname"   => "base_token"
        );
        $tokenModel = M("MpToken");
        $tokenInfo = $tokenModel->where($tokenWhere)->find();
        if($tokenInfo["expires_time"] <= time()){
            $mpToken = $this->getMpToken();
            $updateData = array(
                "token"     =>$mpToken["access_token"],
                "expires_time"  =>time() + intval($mpToken["expires_in"])-120
            );
            $updateResult = $tokenModel->where($tokenWhere)->data($updateData)->save();
            return $mpToken["access_token"];
        }else {
            return $tokenInfo["token"];
        }


        
    }

    protected function getMpToken (){
        $Http = new \Org\Net\Http();
        $apiUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appId."&secret=".$this->appSecret;
        $ret = json_decode($Http->sendHttpRequest($apiUrl,"get"),true);
        return $ret;
    }

    public function test(){
        
    }
}