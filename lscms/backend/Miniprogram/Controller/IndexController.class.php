<?php
namespace Miniprogram\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $mainModel = M("Single");
        $companyInfo = $mainModel->find(1);
        $teamInfo = $mainModel->find(2);
        $imagesBaseUrl = C("UPLOAD_BASE_URL");
        $companyInfo["content"] = \str_replace("/lscms/backend/Uploads/images",$imagesBaseUrl,$companyInfo["content"]);
        $teamInfo["content"] = \str_replace("/lscms/backend/Uploads/images",$imagesBaseUrl,$teamInfo["content"]);

        $backData = array(
            "code"  =>200,
            "msg"   =>"success",
            "data"  =>array(
                "companyInfo"   =>$companyInfo,
                "teamInfo"      =>$teamInfo,
                "banner"        =>$imagesBaseUrl."/index-banner.jpg"
            )
        );
        $this->ajaxReturn($backData);
    }
}