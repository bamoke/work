<?php
namespace Web\Controller;
use Web\Common\WebController;
class StudioController extends WebController {

    public function index($pid,$cid=null){

        $info = M("Studio")->where(array("cid"=>$cid))->select();
        $introduce = M("StudioIntroduce")->limit(1)->select();
        $this->assign("introduce",$introduce[0]);
        $this->assign("info",$info);
        $this->display("Single/studio");
    }

}