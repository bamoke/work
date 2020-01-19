<?php
namespace Miniprogram\Controller;
use Think\Controller;
class ContactController extends Controller {
    public function index(){
        $mainModel = M("Contact");
        $page=I("get.page/d",1);
        $pageSize = 20;
        $condition = array(
            "status"    =>1
        );
        $uploadsBase = C("UPLOAD_BASE_URL")."/";
        $total = $mainModel->where($condition)->count();
        $list = $mainModel
        ->field("*,CONCAT('$uploadsBase',avatar) as avatar")
        ->where($condition)
        ->page($page,$pageSize)
        ->select();
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
                "pageInfo"      =>$pageInfo
            )
        );
        $this->ajaxReturn($backData);
    }




    /********************************* */
}