<?php
namespace Adviser\Controller;
// use Think\Controller;
use Adviser\Common\Controller\AuthController;
class QuestionController extends AuthController {


    public function index(){

        $curStage = I("get.stage",0);
        if($curStage != '2') {
            $questionWhere = array(
                "stage" =>$curStage
            );
        }
        if(session("special")) {
            $questionWhere["cate_id"] = array("in",explode(",",session("special")));
        }

        $total = M("AdviserQuestion")->where($questionWhere)->count();
        $Page = new \Think\Page($total,10);
        $Page->setConfig("next","下一页");
        $Page->setConfig("prev","上一页");
        $show = $Page->show();

        $questionList = M("AdviserQuestion")
        ->where($questionWhere)
        ->limit($Page->firstRow.','.$Page->listRows)
        ->select();
        $this->assign("questionList",$questionList);
        $this->assign("curStage",$curStage);
        $this->assign("page",$show);
        $this->display("list");
    }

    public function reply($qid){
        $questionInfo = M("AdviserQuestion")
        ->find($qid);
        $this->assign("questionInfo",$questionInfo);
        $this->display();
    }

    /**
     * 
     */
    public function doreply(){
        if(!IS_POST){
            $backData=array(
                'status'    =>false,
                'msg'       =>"非法请求"
            );
            $this->ajaxReturn($backData);   
        }
        if(!$_POST["id"]){
            $insertData = array(
                "question_id"   =>I("post.qid"),
                "respondent"    =>session("uid"),
                "content"       =>I("post.content","","htmlspecialchars")
            );
            $operationResult = M("AdviserAnswer")->data($insertData)->add();
            $jump = U("Answer/index");
        }else {
            $updateData = array(
                "content"       =>I("post.content","","htmlspecialchars"),
                "is_read"       =>0,
                "last_update"   =>date("Y-m-d H:i:s") 
            );
            $operationResult = M("AdviserAnswer")->where(array("id"=>I("post.id")))->data($updateData)->fetchSql(false)->save();
            $jump = U("Answer/detail",array("aid"=>I("post.id")));
        }
        if($operationResult !== false) {
            $backData=array(
                'status'    =>true,
                "msg"       =>"操作成功",
                'jump'       =>$jump
            );
            $this->ajaxReturn($backData);   
        }else {
            $backData=array(
                'status'    =>false,
                'msg'       =>"操作失败"
            );
            $this->ajaxReturn($backData);   
        }
    }


}