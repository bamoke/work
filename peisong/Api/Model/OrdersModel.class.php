<?php
namespace Api\Model;
class OrdersModel extends \Think\Model {
    /**
     * 关闭数据库连接
     */
    protected $autoCheckFields = false;


    /**
     * fetch order list
     * @cateid
     * @page
     * @pagesize
     */
    public function getList($condition=array(),$page=1,$pageSize=20){
        $YB = new \Common\Common\YbApi();
        $condition = array(
            "pageInfo"=>array(
                "isUseRowIndex" =>false,
                "pageCount"     =>1,
                "pageIndex"     =>$page-1,
                "pageSize"      =>$pageSize,
                "rowIndex"      =>0
            ),
            "filter"    =>$condition
        );
        $ybResult = $YB->getMainData("请购单","post",$condition);

        if(!isset($ybResult->results)) {
            return false;
        }
        $list = array();

        // 字段转换
        if(count($ybResult->results)) {
            foreach($ybResult->results as $key=>$val){
                $status = $val->单据状态 == '已配送' ? 2 : 1;
                $list[]  =array(
                    "id" =>$val->objectId,
                    "order_no" =>$val->单据号,
                    "create_date"  =>$val->申购日期,
                    "ps_date"  =>$val->单据日期,
                    "status"  =>$status,
                    "status_name"  =>$val->单据状态,
                    "description"  =>$val->请购备注,
                    "original" =>$val,
                    "total"     =>$val->合计金额
                );
            }
        }
        return array(
            "list"  =>$list,
            "pageInfo"  =>array(
                "page"  =>$page,
                "pageSize"  =>$pageSize,
                "total" =>$ybResult->pageInfo->total               
            )
        );
    }


    /**
     * 订单详情
     */
    public function getInfo($objectId){
        $YB = new \Common\Common\YbApi();
        $ybResult = $YB->getone("请购单",$objectId);
        if(!isset($ybResult->objectId)) {
            return false;
        }
        
        // 字段转换
        $status = $val->单据状态 == '已配送' ? 2 : 1;
        $baseInfo = array(
            "id" =>$ybResult->objectId,
            "order_no" =>$ybResult->单据号,
            "create_date"  =>$ybResult->申购日期,
            "ps_date"  =>$ybResult->单据日期,
            "status"  =>$status,
            "status_name"  =>$ybResult->单据状态,
            "description"  =>$ybResult->请购备注,
            "total"     =>$ybResult->合计金额
        );

        $goods = array();

        foreach($ybResult->明细 as $key=>$val) {
            $goods[] = array(
                "title" =>$val->物品名称,
                "sg_num"    =>$val->数量,
                "ps_num"    =>$val->配送数量,
                "price"     =>$val->采购单价?$val->采购单价:$val->单价,
                "amount_total"     =>$val->采购金额?$val->采购金额:$val->金额
            );
        }
        return array(
            "base"  =>$baseInfo,
            "goods" =>$goods
        );

    }



}