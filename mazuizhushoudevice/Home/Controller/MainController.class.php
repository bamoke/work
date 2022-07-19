<?php
namespace Home\Controller;
use Think\Controller;
class MainController extends Controller {
    public function login(){
        layout(false);
        $this->assign("debugTime",1);
        $this->display();
    }

    public function home(){
        layout(false);
        $this->assign("debugTime",1);
        $this->display();
    }
 
}