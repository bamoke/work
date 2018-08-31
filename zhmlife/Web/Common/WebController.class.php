<?php
namespace Web\Common;
use Think\Controller;
class WebController extends Controller{
    public function _initialize(){
        if($this->isMobile()){
            redirect("/mobile.php/index");
        }
        $baseInfo = M("SiteConfig")->where("id=1")->find();
        $otherPage = M("Single")->field("id,title,pid")->where("pid=7 and status=1")->select();
        $navList = M("ContentCate")->field("id,type,title")->where("is_nav=1 and status=1")->order("sort,id")->select();
        //set url;
        $nav =array();
        foreach ($navList as $key=>$val){
            switch ($val['type']){
                case "single":
                $url = U('Single/index',array('cid'=>$val['id']));
                break;
                case "news":
                $url = U("Article/index",array("cid"=>$val['id']));
                break;
            }
            $isActive = false;
            if(isset($_GET['cid']) && $_GET['cid']== $val['id']){
                $isActive = true;
            }
            // var_dump($nav);
            $nav[] = array(
                "url"       =>$url,
                "title"     =>$val['title'],
                "isActive"  =>$isActive
            );
        }
        
        $this->assign("baseInfo",$baseInfo);
        $this->assign("otherPage",$otherPage);
        $this->assign("nav",$nav);
    }

    protected function isMobile(){
           // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        {
            return true;
        } 
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA']))
        { 
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        } 
        if (isset ($_SERVER['HTTP_USER_AGENT']))
        {
            $clientkeywords = array ('nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
                ); 
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            {
                return true;
            } 
        } 
    }
}