<?php
namespace Web\Common;
use Think\Controller;
class WebController extends Controller{
    public function _initialize(){

        $baseInfo = M("SiteConfig")->where("id=1")->find();
        $navList = M("ContentCate")->field("id,pid,type,controller_name,action_name,title,is_nav")->where("status=1")->order("sort,id")->select();
        $navArr = array();
        foreach ($navList as $key=>$val){
            $navInfo = array();
            if($val['is_nav'] == 1) {
                $navInfo['parent']['title'] = $val['title'];
                $navInfo['parent']['isActive'] = 0;
                if(isset($_GET['pid']) && $_GET['pid']== $val['id']){
                    $navInfo['parent']['isActive'] = 1;
                }
                foreach ($navList as $k=>$v){
                    if($v['pid'] == $val['id']){
                        $routeParam = array('pid'=>$v['pid'],'cid'=>$v['id']); 
                        switch ($v['type']){
                            case "custom":
                            $url = U(ucfirst($val['controller_name'])."/".$val['action_name'],$routeParam); 
                            break;
                            case "single":
                            $url = U('Single/index',$routeParam);
                            break;
                            case "news":
                            $url = U("Article/index",$routeParam);
                            break;
                            case "download":
                            $url = U("Download/index",$routeParam);
                            break;
                        }
                        $navInfo['child'][] = array(
                            "url"       =>$url,
                            "title"     =>$v['title'],
                        );
                    }
                }
                $navArr[] = $navInfo;
            }
        }
        //set url;
/*         $nav =array();
        foreach ($navList as $key=>$val){
            $routeParam = array('pid'=>$val['id']); 
            switch ($val['type']){
                case "custom":
                $url = U(ucfirst($val['controller_name'])."/".$val['action_name'],$routeParam); 
                break;
                case "single":
                $url = U('Single/index',$routeParam);
                break;
                case "news":
                $url = U("Article/index",$routeParam);
                break;
                case "download":
                $url = U("Download/index",$routeParam);
                break;
            }
            $isActive = false;
            if(isset($_GET['pid']) && $_GET['pid']== $val['id']){
                $isActive = true;
            }
            // var_dump($nav);
            $nav[] = array(
                "url"       =>$url,
                "title"     =>$val['title'],
                "isActive"  =>$isActive
            );
        } */
        
        $this->assign("baseInfo",$baseInfo);
        $this->assign("nav",$navArr);
    }

    protected function emptyHtml($tips="暂无相关数据！"){
        $emptyHtml = '<div class="m-empty"><img src="'.MODULE_ASSET.'Images/rest.png"><p class="tips">'.$tips.'</p></div>';
        $this->assign("emptyHtml",$emptyHtml);
    }

}