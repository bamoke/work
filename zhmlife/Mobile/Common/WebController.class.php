<?php
namespace Mobile\Common;
use Think\Controller;
class WebController extends Controller{
    public function _initialize(){
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
}