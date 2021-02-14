<?php
namespace Api\Controller;
// use Api\Common\Controller\BaseController;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        ////首页设置内容
        $settingId = 1;
        $sysSettingInfo = M("Setting")->find($settingId);


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
        ->field("A.id,A.title,CONCAT('$thumbBase',A.thumb) as thumb, A.web_url,DATE(A.create_time) as date,M.name as cateName,A.click")
        ->alias("A")
        ->join("__MAIN_CATE__ as M on M.id = A.cate_id")
        ->where(array("A.status"=>1))
        ->limit(5)
        ->order("recommend desc,id desc")
        ->fetchSql(false)
        ->select();

        //
        $grantsInfo =array(
            "isShow"=>$sysSettingInfo["grants_show"],
            "thumb" =>$thumbBase."/banner/grants-banner.jpg?v=2"
        );

        // 抽奖
        $choujiangInfo = array();
        if($sysSettingInfo["choujiang_show"]) {
            $choujiangCondition = array(
                "status"    =>1
            );
            $choujiangInfo = M("Choujiang")
            ->field("id,CONCAT('$thumbBase',thumb) as thumb")
            ->where($choujiangCondition)
            ->find();
            $choujiangInfo['isShow'] = true;
        }

        $backData = array(
            "code"  =>200,
            "msg"   =>"success",
            "data"  =>array(
                "bannerList"      =>$bannerList,
                "articleList"   =>$articleList,
                "grantsInfo"    =>$grantsInfo,
                "choujiangInfo"    =>$choujiangInfo
            )
        );
        $this->ajaxReturn($backData);

    }

}