<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class IndexController extends BaseController {
    public function index(){
        $bannerList = array(
            array(
                "id"    =>2,
                "img"   =>C("UPLOAD_BASE_URL")."/banner/index-banner-2.jpg?v=1",
                "url"   =>"/pages/event/detail/index?id=4"
            ),
            array(
                "id"    =>1,
                "img"   =>C("UPLOAD_BASE_URL")."/banner/index-banner-1.jpg?v=1",
                "url"   =>""
            )
        );
        $thumbBase = C("OSS_BASE_URL")."/";
        $articleList = M("Article")
        ->field("A.id,A.title,CONCAT('$thumbBase',A.thumb) as thumb,DATE(A.create_time) as date,M.name as cateName,A.click")
        ->alias("A")
        ->join("__MAIN_CATE__ as M on M.id = A.cate_id")
        ->where(array("A.status"=>1))
        ->limit(5)
        ->order("recommend desc,id desc")
        ->fetchSql(false)
        ->select();
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