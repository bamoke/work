<?php
namespace Api\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $page = I("get.p/d",1);
        $pageSize = 10;
        $list = M("Course")->field("id,title,thumb,description,type")->where(array("status"=>1))->page($page,$pageSize)->order("id desc")->select();
        if(count($list)){
            foreach($list as $k=>$v){
                if($v['thumb']){
                    $list[$k]['thumb'] = C("OSS_BASE_URL") ."/thumb/".$v['thumb'];
                }
            }
        }
        $banner = M("Banner")->where("status=1")->order("sort,id desc")->select();
        if(count($banner)) {
            foreach($banner as $k=>$v){
                if($v['img']){
                    $banner[$k]['img'] = C("OSS_BASE_URL") ."/images/".$v['img'];
                }
            }
        }
        $backData = array(
            "code"      =>200,
            "msg"       =>"ok",
            "data"      =>array(
                "banner"    => $banner,
                "courseList"=>$list,
            )
        );
        $this->ajaxReturn($backData);
    }
}