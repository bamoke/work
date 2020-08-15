<?php
namespace Api\Controller;
// use Api\Common\Controller\BaseController;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $bannerList = array(
            array(
                "id"    =>4,
                "img"   =>C("OSS_BASE_URL")."/banner/index-banner-4.jpg?v=1",
                "url"   =>""
            ),
            array(
                "id"    =>5,
                "img"   =>C("OSS_BASE_URL")."/banner/index-banner-5.jpg?v=4",
                "url"   =>""
            )
        );
        $thumbBase = C("OSS_BASE_URL")."/";
        $articleList = M("Article")
        ->field("A.id,A.title,CONCAT('$thumbBase',A.thumb) as thumb,DATE(A.create_time) as date,M.name as cateName,A.click")
        ->alias("A")
        ->join("__MAIN_CATE__ as M on M.id = A.cate_id")
        ->where(array("A.status"=>1))
        ->limit(5)
        ->order("recommend desc,id desc")
        ->fetchSql(false)
        ->select();
        $backData = array(
            "code"  =>200,
            "msg"   =>"success",
            "data"  =>array(
                "bannerList"      =>$bannerList,
                "articleList"   =>$articleList,
            )
        );
        $this->ajaxReturn($backData);

    }

}