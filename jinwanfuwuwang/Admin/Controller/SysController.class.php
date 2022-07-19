<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 */

namespace Admin\Controller;


use Admin\Common\Controller\AuthController;

class SysController extends AuthController
{


    public function index(){
        $sysInfo = array(
            "sys_start"         =>"2019-08-31",
            "sys_end"           =>"2020-08-31",
            "php_version"       =>PHP_VERSION,
            "os"                =>$_SERVER['SERVER_SOFTWARE'],
            "mysql_version"     =>$this->_get_mysql_version(),
            "time"              =>date("Y-m-d H:i:s",time()),
            "pc"                =>$_SERVER['SERVER_NAME'],
            "port"              =>$_SERVER['SERVER_PORT'],
            "language"          =>$_SERVER['HTTP_ACCEPT_LANGUAGE'],
            "osname"            =>php_uname()
        );
        $this->assign("sysInfo",$sysInfo);
        $this->display();
    }

    public function conf(){
        $config= M("Site_config")->where('id=1')->find();
        $output['config'] = $config;
        $output['script'] = CONTROLLER_NAME."/conf";
        $this->assign("output",$output);
        $this->display();
    }

    public function save_conf(){
        if(IS_POST){
            $model = D('Site_config');
            if($model->create() && ($model->where('id=1')->save()) !==false){
                $backData = array(
                    "status"    =>1,
                    "msg"       =>"修改成功"
                );
            }else {
                $backData = array(
                    "status"    =>0,
                    "msg"       =>$model->getError()
                );
            }
            $this->ajaxReturn($backData);
        }
    }


    /**
     * 岗位滚动屏设置
     */
    public function scroll(){
        $backInfo = array();
        $scrollInfo = M("Scroll")->where("id=1")->find();
        if($scrollInfo) {
            $backInfo = $scrollInfo;
        }
        $this->assign("data",$backInfo);
        $output['script'] = CONTROLLER_NAME."/conf";
        $this->assign("output",$output);
        $this->display();
    }

    public function save_scroll(){
        if(!IS_POST){
            $backData = array(
                "status"    =>0,
                "msg"       =>"非法请求"
            );
            $this->ajaxReturn($backData); 
        }
        $model = D('Scroll');
        if(!$model->create()) {
            $backData = array(
                "status"    =>0,
                "msg"       =>"数据更新失败"
            );
            $this->ajaxReturn($backData); 
        }
        if($model->where('id=1')->save() !==false){
            $backData = array(
                "status"    =>1,
                "msg"       =>"修改成功"
            );
        }else {
            $backData = array(
                "status"    =>0,
                "msg"       =>"系统错误"
            );
        }
        $this->ajaxReturn($backData); 
    }


    /**
     * 获取Mysql版本
     * @return string
    */
    private function _get_mysql_version (){
        $model = M();
        $version = $model->query("select version() as ver");
        return $version[0]['ver'];
    }

}