<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class IndexController extends BaseController {
    public function index(){
        $bannerList = array(
            array(
                "id"    =>1,
                "img"   =>"/static/images/banner-1.jpg",
                "url"   =>""
            )
        );
        $articleList = array(
            array(
                "id"    =>1,
                "title" =>"框架的核心是一个响应的数据绑定系统，可以让数据与视图非常简单地保持同步",
                "thumb" =>"/static/images/banner-1.jpg",
                "cateName"  =>"今日珠海",
                "date"  =>"2019-05-02",
                "click" =>"834"
            ),
            array(
                "id"    =>2,
                "title" =>"视图层就会做相应的更新",
                "thumb" =>"/static/images/banner-1.jpg",
                "cateName"  =>"金湾头条",
                "date"  =>"2019-05-02",
                "click" =>"443"
            )
        );
        $backData = array(
            "code"  =>200,
            "msg"   =>"success",
            "data"  =>array(
                "bannerList"      =>$bannerList,
                "articleList"   =>$articleList,
            )
        );
        $this->ajaxReturn($backData);

    }
    public function index_bf(){
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