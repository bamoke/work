<?php
namespace Api\Controller;
use Api\Common\Auth;
class CarController extends Auth {

    /**
     * 购物车
     */
    public function index(){
        exit();
    }


    /**
     * 提交订单
     */
    public function doorder(){
        if(!IS_POST) {
            $backData = array(
                "code" =>10001,
                "msg"  =>'非法操作',
                'info'  =>$insertResult
            );
            $this->ajaxReturn($backData);  
        }
        $goods = json_decode($_POST["goods"],true);
        // yunbiao
        $accountInfo = $this->accountInfo;



        $YB = new \Common\Common\YbApi();
        $ybAccountInfo = $YB->ybInfo;

        $insertDetailData = array();
        foreach($goods as $key=>$val) {
            $insertDetailData[$key] =array(
                "物品名称"      =>$val['title'],
                "物品编码"      =>$val['code'],
                "申购单位"      =>$val["unitname"],
                "数量"      =>intval($val['buynum']),
                "单价"      =>$val["price"],
                "金额"      =>(intval($val['buynum']) * floatval($val["price"]))

            );
        }

        $insertData = array(
            // "经手人"        =>$baseInfo['operator'],
            "制单人"        =>$accountInfo['name'],
            "申购日期"      =>date("Y-m-d",time()),
            "单据日期"      =>date("Y-m-d",strtotime("+ 1 days")),
            "单据状态"      =>"未提交",
            "单据类别"      =>"请购单",
            "单据类别ID"    =>"SQ",
            // "来源终端"      =>"小程序",

            // com info
            "请购机构"      =>$accountInfo['belong_comname'],
            "请购单位"      =>$accountInfo['comname'],
            "联系手机"      =>$accountInfo['phone'],

            // 
            // "明细数据行"    =>count($insertDetailData),
            "明细"      =>$insertDetailData
        );
        
        $insertResult = $YB->insert('请购单',$insertData);
        if(!isset($insertResult->objectId)){
            $backData = array(
                "code" =>13002,
                "msg"  =>'数据保存错误',
                'info'  =>$insertResult
            );
            $this->ajaxReturn($backData);  
        }
        
        $backData = array(
            "code"   =>200,
            "msg"    =>"success"
        );
        $this->ajaxReturn($backData);    
    }




}