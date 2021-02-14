<?php
namespace Api\Controller;
use Think\Controller;
class HomeController extends Controller {

    public function index(){


        $pageInfo = array();
        $orderList = array();
        $AccountControl = A("Account");
        $userInfo = $AccountControl->getUserinfo();

        if($userInfo['object_id']) {
            $page = I("get.page/d",1);
            $pageSize = 15;
            $filter = array(
                array(
                    "expressionList"    =>array(
                        array(
                        "operator"  =>'$e',
                        "isAnd"     =>true,
                        "value"     =>$userInfo["phone"]
                        )
                    ),
                    "filterField"=>"联系手机"
                )
            );
            $orderModel = D("Orders");
            $orderListResult = $orderModel->getList($filter,$page,$pageSize);
            $orderList = $orderListResult["list"];
            $pageInfo = $orderListResult["pageInfo"];

        }
       $backData = array(
           "code"   =>200,
           "msg"    =>"success",
           "data"=>array(
                "userInfo"  =>$userInfo,
                "orderList"  =>$orderList,
                "pageInfo"  =>$pageInfo
            )
        );
       $this->ajaxReturn($backData);
    }


    /**
     * 获取类别
     */

}