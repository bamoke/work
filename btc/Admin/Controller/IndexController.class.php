<?php
namespace Admin\Controller;
//use Admin\Common\CheckLoginController;
use Think\Controller;

class IndexController extends Controller {
    public function _initialize(){
        B('Admin\Behavior\LoginCheck');
    }
    public function index(){
        $pageVariable['curJsModule']='main';
        $this->assign('pageVariable',$pageVariable);//js模块名称
        $this->display('Main/home');

    }

}