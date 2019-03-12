<?php
namespace Web\Controller;
use Web\Common\WebController;
class StudioController extends WebController {

    public function index($pid,$cid=null){

        $info = M("Studio")->where(array("cid"=>$cid))->select();
        $this->assign("info",$info);
        $this->display("Single/studio");
    }

}