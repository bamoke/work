<?php 
namespace Api\Common\Controller;
use Think\Controller;
class TalentAuthController extends Controller
{


    /**
   * 
   */
  public function checkTalentInfo($uid,$dataType="ajax"){
    // 检测是否拥有人才卡

        $talentCondition = array(
        "uid" =>$uid
        );

        $talentInfo = M("TalentCard")
        ->field("*")
        ->where($talentCondition)
        ->fetchSql(false)
        ->find();


        $backData = $talentInfo;
        if(!$talentInfo) {
            $backData = array(
                "code" =>13001,
                "msg"  =>'您还不是人才卡用户',
            );
        
        }elseif(strtotime($talentInfo['end_date']) < time()) {
            $backData = array(
                "code" =>13002,
                "msg"  =>'您的人才卡已过期',
            );
        }


        // 输出不同
        if($dataType == 'ajax') {
            return $this->ajaxReturn($backData);
        }else {
            return $backData;
        }
     
    }
}