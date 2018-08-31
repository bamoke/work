<?php
namespace Wechat\Common;
use Think\Controller;
class WebController extends Controller{
    public $navList=null;
    public function _initialize(){
        // $baseInfo = M("SiteConfig")->where("id=1")->find();
        // $otherPage = M("Single")->field("id,title,pid")->where("pid=7 and status=1")->select();
        $navList = M("ContentCate")->field("id,type,title")->where("is_nav=1 and status=1")->order("sort,id")->select();
  
        $this->navList = $navList;
    }
}