<?php
namespace Api\Controller;
use Api\Common\Auth;
class OrdersController extends Auth {

    /**
     * 订单列表
     */
    public function vlist(){
        $accountInfo = $this->accountInfo;
        $page = I("get.page/d",1);
        $pageSize = 15;
        $filter = array(
            array(
                "expressionList"    =>array(
                    array(
                    "operator"  =>'$e',
                    "isAnd"     =>true,
                    "value"     =>$accountInfo["phone"]
                    )
                ),
                "filterField"=>"联系手机"
            )
        );
        $status = I("get.status",'');
        if($status != '') {
            if($status == '已配送'){
                $filter[] = array(
                    "expressionList"    =>array(
                        array(
                        "operator"  =>'$e',
                        "isAnd"     =>true,
                        "value"     =>$status
                        )
                    ),
                    "filterField"=>"单据状态"
                );
            }else {
                $filter[] = array(
                    "expressionList"    =>array(
                        array(
                        "operator"  =>'$ne',
                        "isAnd"     =>true,
                        "value"     =>"已配送"
                        )
                    ),
                    "filterField"=>"单据状态"
                );
            }
        }
        $orderModel = D("Orders");
        $orderListResult = $orderModel->getList($filter,$page,$pageSize);
        if($orderListResult === false) {
            $backData = array(
                "code"   =>13001,
                "msg"    =>"系统错误"
            );
            $this->ajaxReturn($backData);
        }
        $orderList = $orderListResult["list"];
        $pageInfo = $orderListResult["pageInfo"];

        $backData = array(
            "code"   =>200,
            "msg"    =>"success",
            "data"=>array(
                 "orderList"  =>$orderList,
                 "pageInfo"  =>$pageInfo
             )
         );
        $this->ajaxReturn($backData);
    }


    /**
     * 订单详情
     */
    public function detail(){
        $id = I("get.id");
        if(empty($id) || $id== 'undefined') {
            $backData = array(
                "code" =>10001,
                "msg"  =>'非法操作',
                'info'  =>$insertResult
            );
            $this->ajaxReturn($backData);  
        }
        $orderModel = D("Orders");

        $orderInfo = $orderModel->getInfo($id);
        if($orderInfo === false) {
            $backData = array(
                "code"   =>13001,
                "msg"    =>"系统错误"
            );
            $this->ajaxReturn($backData);
        }

        
        $backData = array(
            "code"   =>200,
            "msg"    =>"success",
            "data"  =>$orderInfo
        );
        $this->ajaxReturn($backData);    
    }




}