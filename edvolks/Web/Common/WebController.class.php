<?php
namespace Web\Common;
use Think\Controller;
class WebController extends Controller{
    public function _initialize(){

        $baseInfo = M("SiteConfig")->where("id=1")->find();
        $navList = M("ContentCate")->field("id,pid,type,controller_name,action_name,title,is_nav")->where("status=1")->order("sort,id")->select();
        $navArr = array();
        foreach ($navList as $parentKey=>$parentVal){
            $navItemInfo = array(
                "parent"=>array(),
                "children"  =>array()
            );
            $parentInfo =array();
            $parentUrl = "";
            if($parentVal['is_nav'] == 1) {
                $routeParam = array('pid'=>$parentVal['pid'],'cid'=>$parentVal['id']); 
                switch ($parentVal['type']){
                    case "custom":
                    $parentUrl = U(ucfirst($parentVal['controller_name'])."/".$parentVal['action_name'],$routeParam); 
                    break;
                    case "single":
                    $parentUrl = U('Single/index',$routeParam);
                    break;
                    case "news":
                    $parentUrl = U("Article/index",$routeParam);
                    break;
                    case "pic":
                    $parentUrl = U("pic/index",$routeParam);
                    break;
                    case "download":
                    $parentUrl = U("Download/index",$routeParam);
                    break;
                }
                $parentInfo['title'] = $parentVal['title'];
                $parentInfo['isActive'] = 0;
                if(isset($_GET['pid']) && $_GET['pid']== $parentVal['id']){
                    $parentInfo['isActive'] = 1;
                }
                foreach ($navList as $childKey=>$childVal){
                    if($childVal['pid'] == $parentVal['id']){
                        $routeParam = array('pid'=>$childVal['pid'],'cid'=>$childVal['id']); 
                        switch ($childVal['type']){
                            case "custom":
                            $url = U(ucfirst($childVal['controller_name'])."/".$childVal['action_name'],$routeParam); 
                            break;
                            case "single":
                            $url = U('Single/index',$routeParam);
                            break;
                            case "news":
                            $url = U("Article/index",$routeParam);
                            break;
                            case "pic":
                            $url = U("pic/index",$routeParam);
                            break;
                            case "download":
                            $url = U("Download/index",$routeParam);
                            break;
                        }
                        $navItemInfo['children'][] = array(
                            "url"       =>$url,
                            "title"     =>$childVal['title'],
                        );
                    }
                }
                if(count($navItemInfo['children'])){
                    $parentInfo['url'] = $navItemInfo['children'][0]['url'];
                }else {
                    $parentInfo['url'] = $parentUrl;
                }
                $navItemInfo['parent'] = $parentInfo;
                $navArr[] = $navItemInfo;
            }
        }
 
        
        $this->assign("baseInfo",$baseInfo);
        $this->assign("nav",$navArr);
    }

    protected function emptyHtml($tips="暂无相关数据！"){
        $emptyHtml = '<div class="m-empty"><img src="'.MODULE_ASSET.'Images/rest.png"><p class="tips">'.$tips.'</p></div>';
        $this->assign("emptyHtml",$emptyHtml);
    }

}