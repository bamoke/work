<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 * Date: 2017/6/26
 * Time: 16:59
 */

namespace Admin\Controller;
use Admin\Common\Auth;

class TicketController extends Auth
{

    public function vlist(){
        // paging set
        $ticketModel = M("Ticket");
        $pageSize = 15;
        $page = empty($_GET["p"]) ? 1 : (int)$_GET["p"];
        $where = array();
        if(!empty($_GET['keywords'])){
            $where['T.code'] = array('like','%'.I('get.keywords').'%');
        }
        $total = $ticketModel->alias("T")->where($where)->count();
        $list = $ticketModel
            ->alias("T")
            ->join("__RESUME__ as R on T.member_id = R.uid")
            ->field("R.realname,R.sex,R.phone,T.id,T.create_time as date,T.code")
            ->where($where)
            ->page($page,$pageSize)
            ->order("id desc")
            ->fetchSql(false)
            ->order('id desc')
            ->select();
        if($list === false){
            $backData = array(
                'code'      => 13001,
                "msg"       => "系统错误"    
              );
            $this->ajaxReturn($backData);
        }

        // 
        if(count($list)) {
            $sexNameArr = C('DATA_SEX_NAME');
            $eduNameArr = C('DATA_EDU_NAME');
            $expNameArr = C('DATA_EXP_NAME');
            foreach($list as $key=>$val){
              $list[$key]['sex_name'] = $sexNameArr[$val['sex']];
            }
        }

        $backData = array(
            'code'      => 200,
            "msg"       => "ok",
            'data'      => array(
                "list"  =>$list,
                "total" =>intval($total),
                "pageSize"  =>$pageSize
            )
          );
        $this->ajaxReturn($backData);
    }



    /*=============================*/
}