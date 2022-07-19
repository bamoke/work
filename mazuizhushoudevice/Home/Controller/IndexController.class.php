<?php
namespace Home\Controller;
// use Think\Controller;
use Home\Common\AuthController;
class IndexController extends AuthController {
    public function index(){

        $this->assign("curAcName","index");
        $this->display();
    }

    /**
     * 本商家优惠券
     */
    public function coupon(){
        $model = M("Coupon");
        $condition = array(
            "b_id"  =>session("bid")
        );
                // paging set
        $count = $model->where($condition)->count();
        $curPage = I("get.p/d",1);
        $pageSize = 10;
        $page = new \Think\Page($count,$pageSize);
        $page->setConfig('next','下一页');
        $page->setConfig('prev','上一页');
        $paging = $page->show();

        $list = $model
        ->where($condition)
        ->page($curPage.','.$pageSize)
        ->fetchSql(false)
        ->select();

        $this->assign("list",$list);
        $this->assign("paging",$paging);
        $this->assign("curAcName","coupon");
        $this->display();
    }

    /**
     * 核销记录
     */
    public function log(){
        $mainModel =  M("CouponRecord");
        $condition = array(
            "CL.b_id"  =>session("bid")
        );

        $curStage = I("get.stage/d",-1);
        if($curStage > -1) {
            $condition["CL.stage"] =  $curStage;
        }

        $keyword = I("get.keyword","");
        if($keyword) {
            $condition["CL.code"] = array("like","%".$keyword."%");
        }
                // paging set
        $total = $mainModel->alias("CL")->where($condition)->count();
        $curPage = I("get.p/d",1);
        $pageSize = 10;
        $page = new \Think\Page($total,$pageSize);
        $page->setConfig('next','下一页');
        $page->setConfig('prev','上一页');
        $paging = $page->show();

        $list = $mainModel
        ->alias("CL")
        ->field("CL.*,CARD.realname as username")
        ->join("__TALENT_CARD__ as CARD on CARD.uid= CL.uid")
        ->where($condition)
        ->page($page,$pageSize)
        ->order("CL.id desc")
        ->fetchSql(false)
        ->select();
  

        $this->assign("list",$list);
        $this->assign("paging",$paging);
        $this->assign("curStage",$curStage);
        $this->assign("curAcName","log");
        $this->display();
    }

    /**
     * 
     */
    public function doclosure(){
        $code = I("post.code");
        if(!$code) {
            $backData=array(
                'status'    =>false,
                'msg'       =>"非法操作",
            );
            $this->ajaxReturn($backData);  
        }
        $where = array(
            "code"  =>$code,
            "stage" =>0
        );
        $couponRecordInfo = M("CouponRecord")
        ->where($where)
        ->find();

        if(!$couponRecordInfo) {
            $backData=array(
                'status'    =>false,
                'msg'       =>"优惠券不存在",
            );
            $this->ajaxReturn($backData); 
        }
        $belogBusinessId = session("bid");
        if($couponRecordInfo["b_id"] && $couponRecordInfo["b_id"] != $belogBusinessId){
            $backData=array(
                'status'    =>false,
                'msg'       =>"非本商家优惠券，您无权限核销"
            );
            $this->ajaxReturn($backData);  
        }

        // update
        $updateData = array(
            "stage" =>1,
            "use_business"  =>$belogBusinessId,
            "use_time"      =>date("Y-m-d H:i:s",time())
        );
        $updateWhere = array(
            "id"    =>$couponRecordInfo["id"]
        );
        $result = M("CouponRecord")
        ->where($updateWhere)
        ->data($updateData)
        ->save();

        if(!$result) {
            $backData=array(
                'status'    =>false,
                'msg'       =>"系统错误"
            );
            $this->ajaxReturn($backData);  
        }

        $backData=array(
            'status'    =>true,
            'msg'       =>"操作成功"
        );
        $this->ajaxReturn($backData);  


    }
}