<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class IndexController extends BaseController {
    public function index(){
        $isCollected = true;
        $isLike = true;
        $condition = array(
            "uid"   =>$this->uid
        );
        $info = M("Card")->where($condition)->find();

        if(isset($_GET['fromid']) && $info && I("get.fromid") != $info['id']) {
            $fromId = I('get.fromid');
            $fromUid = M("Card")->where(array('id'=>$fromId))->getField("uid");
            if($fromUid > $this->uid){
                $firstUid = $this->uid;
                $secondUid = $fromUid;
            }else {
                $firstUid = $fromUid;
                $secondUid = $this->uid;
            }
            $data = array(
                "f_uid" =>$firstUid,
                "s_uid" =>$secondUid
            );
            $isExist = M("MycardFolder")->where($data)->count();
            if(!$isExist) {
                $insertReusult = M("MycardFolder")->data($data)->add();
            }
        }

        if(!$info) {
            $backData = array(
                "code"  =>200,
                "msg"   =>"success",
                "data"  =>array(
                    "cardInfo"  =>array()
                )
            );
            $this->ajaxReturn($backData);
        }
        $totalCondition = array(
            "card_id"   =>$info['id']
        );
        $collectedTotal = M("Collection")->where($totalCondition)->count();
        $likeTotal = M("Like")->where($totalCondition)->count();
        $backData = array(
            "code"  =>200,
            "msg"   =>"success",
            "data"  =>array(
                "cardInfo"      =>$info,
                "isCollected"   =>true,
                "isLike"        =>true,
                "collectedTotal"    =>$collectedTotal,
                "likeTotal"     =>$likeTotal
            )
        );
        $this->ajaxReturn($backData);
    }
}