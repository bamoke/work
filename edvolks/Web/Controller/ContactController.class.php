<?php
namespace Web\Controller;
use Web\Common\WebController;
class ContactController extends WebController {

    public function index($pid,$cid=null){

        //
        $info = M("Contact")->where(array("id"=>1))->find();
        $info['addr'] = explode(";",$info['addr']);
        $info['email'] = explode(";",$info['email']);
        $this->assign("info",$info);
        $this->display("Single/contact");
    }

}