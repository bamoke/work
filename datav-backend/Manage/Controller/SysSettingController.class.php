<?php
namespace Manage\Controller;
// use Think\Controller;
use Manage\Common\Auth;


class SysSettingController extends Auth {
    public function get_sys_info(){
        $result = M("SysSetting")->find(1);
        $endDate = date("Y-m-d",strtotime($result["sys_date"]));

        $navList = array(
            array(
                "title"=>"经济统计",
                "icon"=>"/demo3/assets/icon/index-icon-jingji.jpg",
                "url"=>"overview",
                "simpleUrl"=>"http://39.108.189.211:8088/demo2"
            ),
            array(
                "title"=>"医疗卫生",
                "icon"=>"/demo3/assets/icon/index-icon-yiliao.jpg",
            ),
            array(
                "title"=>"教育",
                "icon"=>"/demo3/assets/icon/index-icon-jiaoyu.jpg",
            ),
            array(
                "title"=>"文化旅游",
                "icon"=>"/demo3/assets/icon/index-icon-lvyou.jpg",
            ),
            array(
                "title"=>"交通运输",
                "icon"=>"/demo3/assets/icon/index-icon-jiaotong.jpg",
            ),
            array(
                "title"=>"财政预算",
                "icon"=>"/demo3/assets/icon/index-icon-caizheng.jpg",
            ),
            
        );
        $backData = array(
            "code"  =>200,
            "msg"   =>"sucess",
            "data"  =>array(
                "navList" =>$navList,
                "sysDate"   =>$endDate
            )
        );
        $this->ajaxReturn($backData);
    }
    
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
                "icon"=>"/demo3/assets/icon/index-icon-jingji.jpg",
                "url"=>"overview",
                "simpleUrl"=>"http://39.108.189.211:8088/demo2"
            ),
            array(
                "title"=>"医疗卫生",
                "icon"=>"/demo3/assets/icon/index-icon-yiliao.jpg",
            ),
            array(
                "title"=>"教育",
                "icon"=>"/demo3/assets/icon/index-icon-jiaoyu.jpg",
            ),
            array(
                "title"=>"文化旅游",
                "icon"=>"/demo3/assets/icon/index-icon-lvyou.jpg",
            ),
            array(
                "title"=>"交通运输",
                "icon"=>"/demo3/assets/icon/index-icon-jiaotong.jpg",
            ),
            array(
                "title"=>"财政预算",
                "icon"=>"/demo3/assets/icon/index-icon-caizheng.jpg",
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