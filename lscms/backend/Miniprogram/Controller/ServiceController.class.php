<?php
namespace Miniprogram\Controller;
use Think\Controller;
class ServiceController extends Controller {
    public function vlist(){
        $mainModel = M("Service");
        $page=I("get.page/d",1);
        $pageSize = 20;
        $condition = array(
            "status"    =>1
        );
        // $uploadsBase = "http://www.pykscloud.com/".__ROOT__."/Uploads/images/";
        $imagesBaseUrl = C("UPLOAD_BASE_URL")."/";
        $total = $mainModel->where($condition)->count();
        $list = $mainModel
        ->field("*,CONCAT('$imagesBaseUrl',thumb) as thumb,CONCAT('$imagesBaseUrl',icon) as icon")
        ->where($condition)
        ->page($page,$pageSize)
        ->select();

        $origin = I("get.origin","jz");
        $banner = $imagesBaseUrl."index-banner-".$origin.".jpg";

        $pageInfo = array(
            "total"     =>intval($total),
            "pageSize"  =>$pageSize,
            "page"      =>$page
        );
        $backData = array(
            "code"  =>200,
            "msg"   =>"success",
            "data"  =>array(
                "list"   =>$list,
                "pageInfo"      =>$pageInfo,
                "banner"        =>$banner
            )
        );
        $this->ajaxReturn($backData);
    }

    /**
     * 
     */
    public function detail(){
        if(empty($_GET["id"])){
            $backData = array(
              'code'      => 13000,
              "msg"       => "非法请求"    
            );
            $this->ajaxReturn($backData);     
          }
          $mainModel = M("Service");
          $id = I("get.id/d");
          $info = $mainModel->find($id);
          $imagesBaseUrl = C("UPLOAD_BASE_URL");
          $info["content"] = \str_replace("/lscms/backend/Uploads/images",$imagesBaseUrl,$info["content"]);
          $backData = array(
            "code"  =>200,
            "msg"   =>"ok",
            "data"  =>array(
              "info"  =>$info
            )
          );
          $this->ajaxReturn($backData);
    }



    /********************************* */
}