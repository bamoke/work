<?php
namespace Web\Controller;
use Web\Common\WebController;
use Web\Common\BasePage;
class CountryController extends WebController {

    public function index($pid,$cid=null){
        //cate
        $BasePage = new BasePage();
        $curCateInfo = $BasePage->index($pid,$cid);
        //

        $this->display();
    }

}