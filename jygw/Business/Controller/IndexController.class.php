<?php
namespace Business\Controller;
// use Think\Controller;
use Business\Common\Controller\AuthController;
class IndexController extends AuthController {
    public function index(){
        $where = array(
            "id"    =>session("bid")
        );
        $ossBase = C("OSS_BASE_URL")."/";
        $businessInfo = M("Welfare")
        ->field("id,title,start_date,end_date,create_time,CONCAT('$ossBase',thumb) as thumb")
        ->where($where)
        ->find();
        $this->assign("businessInfo",$businessInfo);
        $this->assign("curAcName","index");
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
                'msg'       =>"无权限核销"
            );
            $this->ajaxReturn($backData);  
        }

        // update
        $updateData = array(
            "stage" =>1,
            "use_business"  =>$belogBusinessId,
            "use_time"      =>date("Y-m-d H:i:s",time())
        );
        $result = M("CouponRecord")
        ->where()
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