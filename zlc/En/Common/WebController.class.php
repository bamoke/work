<?php
namespace En\Common;
use Think\Controller;
class WebController extends Controller{
    public function _initialize(){
        $baseInfo = M("SiteConfig")->where("id=1")->find();
        $navList = M("ContentCate")->field("id,pid,type,controller_name,action_name,en_title,is_nav")->where("status=1")->order("sort,id")->select();
        $navArr = array();
        foreach ($navList as $key=>$val){
            $navInfo = array();
            if($val['is_nav'] == 1) {
                $navInfo['parent']['title'] = $val['en_title'];
                $navInfo['parent']['isActive'] = 0;
                if(isset($_GET['pid']) && $_GET['pid']== $val['id']){
                    $navInfo['parent']['isActive'] = 1;
                }
                foreach ($navList as $k=>$v){
                    if($v['pid'] == $val['id']){
                        $routeParam = array('navid'=>$v['pid'],'cid'=>$v['id']); 
                        switch ($v['type']){
                            case "custom":
                            $url = U(ucfirst($val['controller_name'])."/".$val['action_name'],$routeParam); 
                            break;
                            case "single":
                            $url = U('Single/index',$routeParam);
                            break;
                            case "news":
                            $url = U("News/index",$routeParam);
                            break;
                            case "download":
                            $url = U("Download/index",$routeParam);
                            break;
                        }
                        $navInfo['child'][] = array(
                            "url"       =>$url,
                            "title"     =>$v['en_title'],
                        );
                    }
                }
                $navArr[] = $navInfo;
            }
        }        
        $this->assign("baseInfo",$baseInfo);
        $this->assign("nav",$navArr);
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