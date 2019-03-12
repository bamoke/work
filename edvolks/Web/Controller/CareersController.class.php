<?php
namespace Web\Controller;
use Web\Common\WebController;
class CareersController extends WebController {

    public function index($pid,$cid=null){

        //
        $this->display("Single/careers");
    }

}