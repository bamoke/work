<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 * Date: 2016/8/4
 * Time: 17:14
 */

namespace Common\Common;

/*
 * 云表API接口
 * 初始通过$_SESSION['apitoken']判断是否登陆
 * 通过type实例化两个对象，type为out,logout实例；单独针对logout方法
 * */

class YbApi
{
    protected $apiBaseUrl;
    protected $serverId;
    protected $appName;
    protected $appKey;
    public $account;
    protected $password;
    protected $token;
    public $ybInfo;
    public function __construct($serverid='18006',$type='in'){
        if($type == "in"){
            $ybInfo = M("YbAccount")->where("serverid = '$serverid'")->fetchSql(false)->find();
            $this->serverId  = $serverid;
            $this->apiBaseUrl ="http://lansi.iyunbiao.cn/".$serverid;
            $this->ybInfo = $ybInfo;
            $this->appName  = $ybInfo['appname'];
            $this->appKey   = $ybInfo['appkey'];
            $this->account  = $ybInfo['name'];
            $this->password = strtoupper($ybInfo['password']);
    
            if(is_null($ybInfo['token']) || $ybInfo['expires'] < $this->getMicroTime() ){
                $this->login();
            }else {
                $this->token    = $ybInfo['token'];
            }
        }


    }

    /*
     * 用户登录
     * 登陆成功保存apitoken;
     * */
    public function login()
    {

        $headerParam = $this->createHeader();
        $url = $this->apiBaseUrl.'/openapi/1.0/login';
        $data = array("loginJson"=>'{"account":"'.$this->account.'","password":"'.$this->password.'"}');
        $curHttp = new \Org\Net\Http();
        $resp = json_decode($curHttp->sendHttpRequest($url,"post",$data,$headerParam));
        if($resp->token) {
            $this->token    = $resp->token;
            $updateData = array(
                "token" =>$resp->token,
                "expires"   =>$this->getMicroTime() + 5*60*1000
            );
            $condition =  array(
                "serverid"  =>$this->serverId
            );
            $updateToken = M("YbAccount")->where($condition)->save($updateData);
            if($updateToken === false) {
                var_dump($updateData);
            }
        }else {
            $this->login();
        }
    }

    /*
     * 用户退出登录
     * 检测session是否存在，防止重复退出发送接口请求
     * */
    public function logout(){
        if(isset($_SESSION['apitoken'])){
            $url = 'https://s10.iyunbiao.cn/openapi/1.0/logout';
            $headerParam = $this->createHeader($this->token);
            $curHttp = new \Org\Net\Http();
            $resp = json_decode($curHttp->sendHttpRequest($url,"get","",$headerParam));
            if($resp->error == 0){
                unset($_SESSION['apitoken']);
                $backdata=array("error"=>0);
            }else {
                $backdata=array("error"=>1,"msg"=>"错误");
            }
        }else {
            $backdata=array("error"=>1,"msg"=>"用户已退出登录");
        }
        return json_encode($backdata);
    }

    /**
     * 获取主表内容
     * @param str 模板名称
    */
    public function getMainData($tplname,$type="get",$data=null){
        $url = $this->apiBaseUrl.'/openapi/1.0/'.urlencode($tplname);
       
        $headerParam = $this->createHeader($this->token);
        $curHttp = new \Org\Net\Http();
        if(!is_null($data)){
            $postData = array(
                "formJson"  =>urldecode(json_encode($data))
            );
        }else{
            $postData = '';
        }
        $resp = json_decode($curHttp->sendHttpRequest($url,$type,$postData,$headerParam)); 
        if(!isset($resp->results)){
            return $headerParam;
        }else {
            return $resp;
        }
    }

        /**
     * 获取主表单条记录内容
     * @param string 模板名称
     * @param string row id
     * @type  string  request method
    */
    public function fetchObject($tplname,$objectId,$type="get",$data=null){
        $url = $this->apiBaseUrl.'/openapi/1.0/'.urlencode($tplname).'/'.urlencode($objectId);
       
        $headerParam = $this->createHeader($this->token);
        $curHttp = new \Org\Net\Http();
        if(!is_null($data)){
            $postData = array(
                "formJson"  =>urldecode(json_encode($data))
            );
        }else{
            $postData = '';
        }
        // var_dump($postData);
        $resp = json_decode($curHttp->sendHttpRequest($url,$type,$postData,$headerParam)); 
        return $resp;
    }  



    /**
     * insert 
     */
    public function insert($tplname,$data){
        $url = $this->apiBaseUrl.'/openapi/1.0/'.urlencode($tplname).'/new';
        $headerParam = $this->createHeader($this->token);
        $curHttp = new \Org\Net\Http();  
        $postData = array(
            "formJson"  =>urldecode(json_encode($data))
        );   
        $resp = json_decode($curHttp->sendHttpRequest($url,'post',$postData,$headerParam)); 
        return $resp; 
    }

    /**
     * update 
     */

     public function update($tplname,$objectId,$data){
        $url = $this->apiBaseUrl.'/openapi/1.0/'.urlencode($tplname).'/'.urlencode($objectId);
        $headerParam = $this->createHeader($this->token);
        $postData = array(
            "formJson"  =>urldecode(json_encode($data))
        );
        $curHttp = new \Org\Net\Http();
/*         $test = $curHttp->sendHttpRequest($url,'post',$postData,$headerParam);
        var_dump($test);
        exit(); */
        $resp = json_decode($curHttp->sendHttpRequest($url,'post',$postData,$headerParam));
        return $resp; 
     }

    /**
     * 获取单条记录 by objectID
     * */ 
    public function getone($tplname,$objectId,$type="get"){
        $url = $this->apiBaseUrl.'/openapi/1.0/'.urlencode($tplname).'/'.urlencode($objectId);
        $headerParam = $this->createHeader($this->token);
        $curHttp = new \Org\Net\Http();
        $request = $curHttp->sendHttpRequest($url,$type,'',$headerParam);
        $resp = json_decode($request); 
        return $resp;
    }

    /**
     * 获取单条记录 by field
     */

     public function getonebyfield($tplName,$condition,$page=1,$pageSize=10){
        if($tplName == '' || !is_array($condition)) return false;
        
        $url = $this->apiBaseUrl.'/openapi/1.0/'.urlencode($tplName);
        $headerParam = $this->createHeader($this->token);
        $curHttp = new \Org\Net\Http();


        // set filter
        $filter = array();
        foreach($condition as $key=>$val){
            $filter[$key] = array(
                "expressionList"    =>array(
                    array(
                    "operator"  =>'$e',
                    "isAnd"     =>true,
                    "value"     =>$val['value']
                    )
                ),
                "filterField"=>$val['field']
            );
        }
        $filterData = array(
            "pageInfo"=>array(
                "isUseRowIndex" =>false,
                "pageCount"     =>1,
                "pageIndex"     =>$page-1,
                "pageSize"      =>$pageSize,
                "rowIndex"      =>0
            ), 
            "filter"    =>$filter
        );
        $postData = array(
            "formJson"  =>urldecode(json_encode($filterData))
        );
        $YbResutl = json_decode($curHttp->sendHttpRequest($url,'post',$postData,$headerParam));
        if(!isset($YbResutl->results)) {
            return false;
        }
        return $YbResutl->results[0];
     }

    /**
     * 删除单条记录 by objectID
     * */ 
    public function delone($tplname,$objectId,$type="DELETE"){
        $url = $this->apiBaseUrl.'/openapi/1.0/'.urlencode($tplname).'/'.urlencode($objectId);
        $headerParam = $this->createHeader($this->token);
        $curHttp = new \Org\Net\Http();
        $resp = json_decode($curHttp->sendHttpRequest($url,$type,'',$headerParam)); 
        return $resp;
    }

    /**
     * 通过云表数据规则获取数据
     * @param templete 云表模板名称
     * @param rule 规则名称
     * @param queryData 查询内容
     */
    public function getByDataRule($tplName,$rule,$queryData,$page=1,$pageSize=50){
        $url = $this->apiBaseUrl.'/openapi/1.0/'.urlencode($tplName).'/'.urlencode($rule).'/query';
        $headerParam = $this->createHeader($this->token);
        $curHttp = new \Org\Net\Http();
        $filterData = array(
            "paramList"     =>$queryData,
            "pageInfo"=>array(
                "isUseRowIndex" =>false,
                "pageCount"     =>1,
                "pageIndex"     =>$page-1,
                "pageSize"      =>$pageSize,
                "rowIndex"      =>0
            )
        );
        $postData = array(
            "queryParams"  =>json_encode($filterData)
        );
        $resp = json_decode($curHttp->sendHttpRequest($url,'post',$postData,$headerParam)); 
        return $resp;
    }

    /*
     * 生成header parameter
     * @param string token,登陆时token默认为空，其他请求传入token值
     * @return array
     * */
    protected function createHeader($token=''){
        $timestamp = $this->getMicroTime();
        $sign = $this->setSign($timestamp);
        $header = array(
            "x-eversheet-request-sign"=>$sign.",".$timestamp,
            "x-eversheet-application-name"=>$this->appName,
            "x-eversheet-session-token"=>$token
        );
        $headerArr = array();
        foreach ($header as $k=>$v){
            $headerArr[] = $k.":".$v;
        }
        return $headerArr;
    }

    /**获取毫秒时间戳**/
    protected function getMicroTime(){
        list($s1, $s2) = explode(' ', microtime());  
        $timestamp=(float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
        return $timestamp;
        $time = microtime(true);
        return $time*100;
        // return intval(( $timeArr[1] + $timeArr[0] )*1000);
    }
    /*
     * 生产签名
     * @param int 毫秒时间戳
     * */
    protected function setSign($timestamp){
        $sign = strtoupper(md5($timestamp.$this->appKey));
        return $sign;
    }
}