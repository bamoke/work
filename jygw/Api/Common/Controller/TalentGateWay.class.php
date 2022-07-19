<?php 
namespace Api\Common\Controller;

class TalentGateWay 
{

    // protected $paasid ="fczj0001-test";
    // protected $token = "paSvvHftQb5gtuPBvN2AILQKHjk6OX7J";
    protected $paasid ="fczj0001";
    protected $token = "AnsP1PgAVxPBlm9BW2s4PYtMiunB98Vlvd7KIf9ik";

    protected function getNonce(){
        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';//62个字符
        $strlen = 64;
        while ($length > $strlen) {
            $str .= $str;
            $strlen += 64;
        }
        $str = str_shuffle($str);
        $mi = idate("i");
        $mi = $mi < 10 ?'0'.$mi:$mi;
        $str = substr($str, 0, 8);
        return strtoupper($str.$mi);
    }

    protected function getTimeStamp(){
        return time();
    }

    /**
     * 签名
     */
    protected function getSignature($timeStamp,$nonce){
        $token = $this->token;
        $str = $timeStamp . $token . $nonce . $timeStamp;

        $re=hash('sha256', $str,true);
        return \strtoupper(bin2hex($re)) ;
    }

    public function getHeader(){
        $timeStamp = $this->getTimeStamp();
        $nonce = $this->getNonce();
        $header= array(
            "x-tif-nonce"     =>$nonce,
            "x-tif-timestamp" =>$timeStamp,
            "x-tif-paasid"    =>$this->paasid,
            "x-tif-signature" =>$this->getSignature($timeStamp,$nonce)
        );
        $headerArr = array();
        foreach ($header as $k=>$v){
            $headerArr[] = $k.":".$v;
        }
        return $headerArr;
    }

  
}