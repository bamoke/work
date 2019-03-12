<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 */

namespace Enadmin\Controller;


use Enadmin\Common\Controller\AuthController;

class SysController extends AuthController
{


    public function index(){
        $sysInfo = array(
            "php_version"       =>PHP_VERSION,
            "os"                =>$_SERVER['SERVER_SOFTWARE'],
            "mysql_version"     =>$this->_get_mysql_version(),
            "time"              =>date("Y-m-d H:i:s",time()),
            "pc"                =>$_SERVER['SERVER_NAME'],
            "port"              =>$_SERVER['SERVER_PORT'],
            "language"          =>$_SERVER['HTTP_ACCEPT_LANGUAGE'],
            "osname"            =>php_uname()
        );
        $this->assign("output",$this->output);
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

    public function menu(){
        $this->display();
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