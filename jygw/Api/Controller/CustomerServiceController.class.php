<?php
namespace Api\Controller;
use Think\Controller;
class CustomerServiceController extends Controller {
    /**
     * 
     */
    public function index(){
        $condition = array(
            "recommend"=>1
        );
        $list = M("CustomerService")
        ->field("id,question")
        ->where($condition)
        ->limit(3)
        ->fetchSql(false)
        ->select();
        $backData = array(
            "code"  =>200,
            "msg"   =>"success",
            "data"  =>array(
                "list"      =>$list
            )
        );
        $this->ajaxReturn($backData);
    }

    /**
     * 
     */
    public function search_result(){
        $keyword = I("get.keyword");
        $list = array();

        if($keyword != '') {
            $condition = array(
                "question"=>array("like","%".$keyword."%"),
                "keywords"=>array("like","%".$keyword."%"),
                "_logic"    =>"OR"
            );
            $list = M("CustomerService")
            ->field("id as value,question as text")
            ->where($condition)
            ->limit(10)
            ->fetchSql(false)
            ->select();
        }

        $backData = array(
            "code"  =>200,
            "msg"   =>"success",
            "data"  =>array(
                "list"      =>$list
            )
        );
        $this->ajaxReturn($backData);

    }

    /**
     * 
     */
    public function detail(){
        if(empty($_GET['id'])) {
            $backData = array(
                "code"  => 10002,
                "msg"   => "访问参数错误"
            );  
            $this->ajaxReturn($backData);
        }
        $id = I("get.id");
        $info = M("CustomerService")->where("id=$id")->find();
        $backData = array(
            "code"  =>200,
            "msg"   =>"success",
            "data"  =>array(
                "info"      =>$info
            )
        );
        $this->ajaxReturn($backData);
    }


    public function log(){
        var_dump("log");
    }

    /****========== Controller End ============**** */
}