<?php
/**
 * Created by PhpStorm.
 * User: wetz1
 * Date: 2017/7/1
 * Time: 7:26
 */

namespace Manage\Controller;
use Manage\Common\Controller\AuthController;

class OrdersController extends AuthController
{

    public function index(){
        $where = array();
        $whereStr = '1=1';
        if(I('get.status') != ''){
            $whereStr .= ' and status ="'.I('get.status').'"';
        }
        if(!empty($_GET['s_date'])){
            $whereStr .= ' and Date(create_time) > '.I('get.s_date');
        }
        if(!empty($_GET['e_date'])){
            $whereStr .= ' and Date(create_time) < '.I('get.e_date');;
        }
        if(!empty($_GET['keyword'])){
            $whereStr .= ' and (member_name ="'.I("get.keyword").'" or order_num ="'.I("get.keyword").'")';
        }
        $where['_string'] =$whereStr;
        $modelOrder = M('Orders');
        $count = $modelOrder->where($where)->count();
        $Page = new \Think\Page($count,15);
        $Page->setConfig("next","下一页");
        $Page->setConfig("prev","上一页");
        $show = $Page->show();

        $orderList = $modelOrder
            ->where($where)
            ->limit($Page->firstRow.','.$Page->listRows)
            ->order('id desc')
            ->select();
        $output['script'] = CONTROLLER_NAME."/index";
        $output['page'] = $show;
        $output['search'] = $whereStr;
        $this->assign('output',$output);
        $this->assign('orderData',$orderList);
        $this->display();
    }

    public function add(){
        $proInfo = M('Product')->field('id,name')->where('status = 1')->select();
        $output['script'] = CONTROLLER_NAME."/add";
        $output['proList'] = $proInfo;
        $this->assign('output',$output);
        $this->display();
    }

    public function find_member($keyword){
        $member = M('Member')->field('id,username')->where('username like %$keyword%')->select();
        $this->ajaxReturn($member);
    }

    public function validate_name($member_name){
        $member = M('Member')->field('id')->where('username = "'.$member_name.'"')->find();
        if($member){
            echo 'true';
        }else {
            echo 'false';
        }
    }

    public function save(){
        if(IS_POST){
            $orderModel = D('Orders');
            $result = $orderModel->create();
            if($result){
                $orderModel->startTrans();
                $inserOrder = $orderModel->add();
                $proInfo = M('Product')->field("ratio_manage","close_limit","limited_buy","sell_end_date")->where("id=".I('post.pro_id'))->find();
                $insertData =array(
                    "member_name"   =>I('post.member_name'),
                    "pro_id"   =>I('post.pro_id'),
                    "pro_name"   =>I('post.pro_name'),
                    "amount"   =>I('post.amount') * (1 - ($proInfo['ratio_manage'] / 100)),
                );

                if($proInfo['limited_buy'] == 1){
                    $endTime = strtotime($proInfo['sell_end_date']) + ($proInfo['close_limit'] * 24*3600);
                    $insertData['start_time'] = date('Ymd',strtotime($proInfo['sell_end_date']));
                    $insertData['end_time'] = date('Ymd',$endTime);
                }else {
                    $after = $proInfo['close_limit']." days";
                    $insertData['start_time'] = date('Ymd');
                    $insertData['end_time'] = date('Ymd',strtotime($after));
                }
                $insertPurchased = M("My_product")->data($insertData)->add();
                if($inserOrder && $insertPurchased){
                    $orderModel->commit();
                    $backData['status'] = 1;
                    $backData['msg'] = "保存成功";
                    $backData['jump'] = U('index');
                }else {
                    $orderModel->rollback();
                    $backData['status'] = 0;
                    $backData['msg'] = "操作失败";
                }
            }else {
                $backData['status'] = 0;
                $backData['msg'] = $orderModel->getError();
            }
            $this->ajaxReturn($backData);
        }
    }

    public function confirm_order($id){
        $data = M("Orders")
            ->alias("O")
            ->join("__PRODUCT__ as P on O.pro_id = P.id")
            ->field("O.*,P.ratio_manage,P.close_limit,P.limited_buy,P.sell_end_date")
            ->where("O.id = ".$id)
            ->find();
        if($data){
            $insertData = array(
                "member_name"       =>$data['member_name'],
                "pro_id"            =>$data['pro_id'],
                "pro_name"          =>$data['pro_name'],
                "amount"          =>$data['amount'] * (1 - ($data['ratio_manage'] / 100 )),
            );

            if($data['limited_buy'] == 1){
                $endTime = strtotime($data['sell_end_date']) + ($data['close_limit'] * 24*3600);
                $insertData['start_time'] = date('Ymd',strtotime($data['sell_end_date']));
                $insertData['end_time'] = date('Ymd',$endTime);
            }else {
                $after = $data['close_limit']." days";
                $insertData['start_time'] = date('Ymd');
                $insertData['end_time'] = date('Ymd',strtotime($after));
            }
            $orderModel = M("Orders");
            $purchasedModel = M("My_product");
            $orderModel->startTrans();
            $updateData = array("status"=>2);
            $update = $orderModel->where("id=".$id)->fetchSql(false)->data($updateData)->save();
            $create_pruchased = $purchasedModel->data($insertData)->fetchSql(false)->add();
            if($update && $create_pruchased){
                $backData = array("status"=>1,"msg"=>"操作成功");
                $orderModel->commit();
            }else {
                $backData = array("status"=>0,"msg"=>"操作失败","sql"=>$update);
                $orderModel->rollback();
            }

        }else {
            $backData = array("status"=>0,"msg"=>"数据错误");
        }
        $this->ajaxReturn($backData);
    }

    /***
     * 创建理财记录
    ***/
    protected function create_purchased($data){
        $model = D('My_product');
        $model->data($data)->add();
    }

}