<?php
namespace Web\Controller;
use Web\Common\WebController;
class IndexController extends WebController {
    public function index(){
        $this->assign("isIndex",1);
        $this->display();
    }
    public function test(){
        var_dump("nim");
    }
}