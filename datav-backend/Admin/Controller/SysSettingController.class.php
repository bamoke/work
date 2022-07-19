<?php
namespace Admin\Controller;
// use Think\Controller;
use Admin\Common\AuthController;


class SysSettingController extends AuthController {
    
    public function get_sys_date(){
        $result = M("SysSetting")->find(1);
        $endDate = date("Y-m-d",strtotime($result["sys_date"]));

        $backData = array(
            "code"  =>200,
            "msg"   =>"sucess",
            "data"  =>array(
                "start" =>"2020-12-1",
                "end"   =>$endDate
            )
        );
        $this->ajaxReturn($backData);
    }

    public function get_sys_nav(){
        $navList = array(
            array(
                "title"=>"经济统计",
                "icon"=>"/screen/demo3/assets/icon/index-icon-jingji.jpg",
                "url"=>"overview",
                "simpleUrl"=>"/bi/gdp"
            ),
            array(
                "title"=>"医疗卫生",
                "icon"=>"/screen/demo3/assets/icon/index-icon-yiliao.jpg",
            ),
            array(
                "title"=>"教育",
                "icon"=>"/screen/demo3/assets/icon/index-icon-jiaoyu.jpg",
            ),
            array(
                "title"=>"文化旅游",
                "icon"=>"/screen/demo3/assets/icon/index-icon-lvyou.jpg",
            ),
            array(
                "title"=>"交通运输",
                "icon"=>"/screen/demo3/assets/icon/index-icon-jiaotong.jpg",
            ),
            array(
                "title"=>"财政预算",
                "icon"=>"/screen/demo3/assets/icon/index-icon-caizheng.jpg",
            ),
            
        );
        $backData = array(
            "code"  =>200,
            "msg"   =>"sucess",
            "data"  =>array(
                "nav" => $navList
            )
        );
        $this->ajaxReturn($backData);
    }

}