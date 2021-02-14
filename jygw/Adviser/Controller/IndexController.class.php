<?php
namespace Adviser\Controller;
// use Think\Controller;
use Adviser\Common\Controller\AuthController;
class IndexController extends AuthController {
    public function index(){
        $loginWhere = array(
            "status"    =>1,
            "username"  =>session("username")
        );
        $loginInfo = M("AdviserLoginLog")
        ->where($loginWhere)
        ->limit("1,1")
        ->fetchSql(false)
        ->order("id desc")
        ->select();

        $userWhere = array(
            "id"    =>session("uid")
        );
        $userInfo = M("AdviserUser")
        ->field("satisfaction_num,dissatisfaction_num,think_num")
        ->where($userWhere)
        ->find();

        $questionWhere = array(
            "stage" =>0
        );

        if(session("special")) {
            
            $questionWhere["cate_id"] = array("in",explode(",",session("special")));
        }
        
        $questionList = M("AdviserQuestion")
        ->where($questionWhere)
        ->limit(10)
        ->fetchSql(false)
        ->select();
        
        ///
        $answerTotal = M("AdviserAnswer")
        ->where(array('respondent'=>session("uid")))
        ->count();
        $this->assign("questionList",$questionList);
        $this->assign("loginInfo",$loginInfo[0]);
        $this->assign("userStatisticInfo",$userInfo);
        $this->assign("answerTotal",$answerTotal);
        $this->display();
    }


}