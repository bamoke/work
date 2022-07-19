<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {



    public function index(){
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }

    public function test(){
        $text = "09D9HAPQLX2TOMEIJA1 ";
        $pad = ord(substr($text, -1));
        var_dump($pad);

        // $pkc_encoder = new \PKCS7Encoder;
        
        
    }

    /**
     * 申请二维码接口
     * 
     */
    public function apply_code(){
        $tokenController = A("AccessToken");
        $token = $tokenController->getToken();

        $apiUrl ="https://api.weixin.qq.com/intp/marketcode/applycode?access_token=".$token;
        $requestData = array(
            "code_count"=>10000,
            "isv_application_id"    =>"jyqx01"
        );

        // var_dump(json_encode($requestData));
        // exit();

        //
        $Http = new \Org\Net\Http();
        $ret = json_decode($Http->sendHttpRequest($apiUrl,"post",json_encode($requestData)));
        var_dump($ret);
    }


    /**
     * 查询二维码申请
     */

     public function apply_code_query(){

        $tokenController = A("AccessToken");
        $token = $tokenController->getToken();

        $apiUrl ="https://api.weixin.qq.com/intp/marketcode/applycodequery?access_token=".$token;
        $requestData = array(
            "isv_application_id"    =>"jyqx01"
        );

        // var_dump(json_encode($requestData));
        // exit();

        //
        $Http = new \Org\Net\Http();
        $ret = json_decode($Http->sendHttpRequest($apiUrl,"post",json_encode($requestData)),true);
        var_dump($ret);


     }


    /**
     * 下载二维码包
     */

     public function code_download(){
        $tokenController = A("AccessToken");
        $token = $tokenController->getToken();

        $applicationId = "715479145";

        $startIndex = I("get.start",0);
        $endIndex = I("get.end",9999);
        $apiUrl ="https://api.weixin.qq.com/intp/marketcode/applycodedownload?access_token=".$token;
        $requestData = array(
            "application_id"    =>$applicationId,
            "code_start"    =>$startIndex,
            "code_end"      =>$endIndex
        );


        //
        $Http = new \Org\Net\Http();
        $ret = json_decode($Http->sendHttpRequest($apiUrl,"post",json_encode($requestData)));
        if($ret->errcode != 0) {
            var_dump($ret);
            exit();
        }



        // 解密
        $iv = "1nmaIcdAVuj3ME3l";
        $buffer = \base64_decode($ret->buffer);
        $text = openssl_decrypt($buffer, 'AES-128-CBC', $iv, OPENSSL_CIPHER_AES_128_CBC, $iv);

        // var_dump($text);
        // exit();


        //PKCS7 unpadding
        $pad = ord(substr($text, -1));

        if ($pad < 1 || $pad > 32) {
            $pad = 0;
        }

        $text =  substr($text, 0, (strlen($text) - $pad));
        echo $text;
        exit();

        // save file
        $file = ROOT."/Uploads/code/".$applicationId.".txt";
        // $fp = fopen($file,"w");
        echo file_put_contents($file,$text);
        // \fclose($fp);


     }

     /**
      * 二维码激活
      */

      public function code_active(){

        $tokenController = A("AccessToken");
        $token = $tokenController->getToken();

        $applicationId = "715479145";

        $startIndex = I("get.start",0);
        $endIndex = I("get.end",10);
        $apiUrl ="https://api.weixin.qq.com/intp/marketcode/codeactive?access_token=".$token;
        $requestData = array(
            "application_id"    =>$applicationId,
            "code_start"    =>$startIndex,
            "code_end"      =>$endIndex,
            "activity_name" =>'酱香经典',// 活动名称
            "product_brand" =>"古月迁香",//品牌名称
            "product_title" =>"15年老酒",//
            "product_code"  =>"6941873400136",// 商品条码

            "wxa_appid"     =>"wx51f96025c17e6817",// 小程序ID
            "wxa_path"      =>"pages/code/result",
            "wxa_type"      =>0
        );

        $Http = new \Org\Net\Http();
        $ret = json_decode($Http->sendHttpRequest($apiUrl,"post",json_encode($requestData)));

        var_dump($ret);

      }

     /**
      * 文件转换
      */
     public function transform($applicationId){
        $file = ROOT."/Uploads/code/".$applicationId.".txt";
        $fp = fopen($file,"r");
     }


}