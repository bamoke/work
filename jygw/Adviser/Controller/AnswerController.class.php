<?php
namespace Adviser\Controller;
// use Think\Controller;
use Adviser\Common\Controller\AuthController;
class AnswerController extends AuthController {


    /**
     * 我的回答
     */
    public function index(){



        $where = array(
            "A.respondent" =>session("uid")
        );

        $total = M("AdviserAnswer")->alias("A")->where($where)->count();
        $Page = new \Think\Page($total,10);
        $Page->setConfig("next","下一页");
        $Page->setConfig("prev","上一页");
        $show = $Page->show();
        $list = M("AdviserAnswer")
        ->alias("A")
        ->field("Q.title as question_title,A.*,IF(CHAR_LENGtH(A.content)>50,CONCAT(LEFT(A.content,50),'...'),A.content) as content")
        ->join("__ADVISER_QUESTION__ as Q on Q.id = A.question_id")
        ->where($where)
        ->order('A.id desc')
        ->limit($Page->firstRow.','.$Page->listRows)
        ->select();
        $this->assign('answerList',$list);
        $this->assign('page',$show);
        $this->display();

    }

    /**
     * 
     */
    public function detail($aid){
        
        $answerWhere = array(
            "id"  =>$aid
        );
        $answerInfo = M("AdviserAnswer")
        ->where($answerWhere)
        ->find();

        $questionWhere = array(
            "id"    =>$answerInfo["question_id"]
        );
        $questionInfo = M("AdviserQuestion")
        ->where($questionWhere)
        ->find();
        $this->assign("answerInfo",$answerInfo);
        $this->assign("questionInfo",$questionInfo);
        $this->display();
    }


}