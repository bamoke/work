<?php
namespace Web\Controller;
use Web\Common\WebController;
class ArticleController extends WebController {
    public function index($cid){
        $this->display();
    }
    public function detail($cid,$id){
        $this->assign("pageTitle","帶着媽媽去旅行！嚴選4間媽媽必冧性價比極高大阪住宿
        ");
        $this->display();
    }
}