<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class AdviserController extends BaseController {
  /**
   * 顾问服务
   * @condition
   * @page
   */
  public function index (){
    // 检测是否拥有人才卡

    $talentCondition = array(
      "uid" =>$this->uid
    );
    $hasTalent =true;
    $talentId = null;
    $talentInfo = M("TalentCard")
    ->field("id,end_date")
    ->where($talentCondition)
    ->fetchSql(false)
    ->find();

    if(!$talentInfo) {
      $hasTalent = false;
    }else {
      $talentId = $talentInfo["id"];
    }

    if(strtotime($talentInfo['end_date']) < time()) {
      $hasTalent = false;
    }

    $adviserCondition = array(
      "status"  =>1,
      "isdelete"=>0
    );
    $thumbBase = C("OSS_BASE_URL")."/";
    $list = M("Adviser")
    ->field("*,CONCAT('$thumbBase',thumb) as thumb")
    ->where($adviserCondition)
    ->order("sort,id")
    ->fetchSql(false)
    ->select();
    $backData = array(
      "code"  =>200,
      "msg"   =>'success',
      "data"  =>array(
        "list"  =>$list,
        "hasTalent" =>$hasTalent
      )
    );
    $this->ajaxReturn($backData);
  }

  /**
   * 顾问团成员
   */
  public function user(){

    $spcialWhere =array();
    if(!empty($_GET['cateid'])){
      $cateId = I("get.cateid");
      $spcialWhere['special'] =array("like","%,$cateId,%");
      $spcialWhere['special'] =array("like","$cateId,%");
      $spcialWhere['special'] =array("like","%,$cateId%");
      $spcialWhere['special'] =$cateId;
      $spcialWhere['_logic'] ="OR";
    }
    $where = array(
      "status"  =>1,
      "_complex"  =>$spcialWhere
    );
    $thumbBase = C("OSS_BASE_URL")."/";
    $total = M("AdviserUser")->where($where)->count();
    $page = I("get.page/d",1);
    $pageSize = 15;
    $list = M("AdviserUser")
    ->alias("U")
    ->where($where)
    ->field("U.id,U.realname,U.description,IF(U.avatar,CONCAT('$thumbBase',U.avatar),CONCAT('$thumbBase','avatar/default_avatar.jpg')) as avatar,U.company,U.satisfaction_num,U.think_num,(select count(id) from x_adviser_answer where respondent=U.id) as answer_num")
    ->fetchSql(false)
    ->order("U.id")
    ->page($page,$pageSize)
    ->select();
    $backData = array(
      "code"  =>200,
      "msg"   =>'success',
      "data"  =>array(
        "list"  =>$list,
        "pageInfo" =>array(
          "total"   =>intval($total),
          "page"    =>$page,
          "pageSize"  =>$pageSize
        )
      )
    );
    $this->ajaxReturn($backData);
  }
 
  /***============== */
}