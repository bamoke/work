<?php
namespace Api\Controller;
use Think\Controller;
class PolicyController extends Controller {
  /**
   * policy list
   * @condition
   * @page
   */
  public function vlist(){
    if(empty($_GET['cateid'])) {
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $cateId = I("get.cateid/d");
    $page = I("get.page/d",1);
    $pageSize = 10;
    $condition = array(
      "status"  =>1,
      "cate_id" =>$cateId
    );

    $keywords = I("get.keywords");
    if(!empty($keywords)){
      $condition['title'] = array("like","%".$keywords."%");
    }
    $fieldInfo = "id,title,type,date(create_time) as date,(click + click_base) as click";

    $total = M("Policy")->where($condition)->count();
    $list = M("Policy")
    ->field($fieldInfo)
    ->where($condition)
    ->page($page,$pageSize)
    ->order("recommend desc,id desc")
    ->fetchSql(false)
    ->select();


    $cateInfo = M("PolicyCate")->where(array('id'=>$cateId))->find();
    $backData = array(
      "code"      =>200,
      "msg"       =>"ok",
      "data"      => array(
        "list"  =>$list,
        "cateInfo"  =>$cateInfo,
        "pageInfo"  =>array(
          "page"  =>$page,
          "total" =>intval($total),
          "hasMore" => intval($total) - ($page*$pageSize) > 0
        )
      )
    );
    $this->ajaxReturn($backData);
  }


  /**
   * detail
   */
  public function detail(){
    if(empty($_GET['id'])) {
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $condition = array(
      "id"  =>I("get.id/d")
    );
    $fileBase = C("UPLOAD_BASE_URL")."/file/policy/";
    $info = M("Policy")
    ->field("*,DATE(create_time) as date,(click_base + click) as click, IF(file !='',CONCAT('$fileBase',file),file) as file")
    ->where($condition)
    ->find();

    // update view num
    $updateResult = M("Policy")->where($condition)->setInc('click');
    $backData = array(
      "code"  =>200,
      "msg"   =>'success',
      "data"  =>array(
        "info"  =>$info
      )
    );
    $this->ajaxReturn($backData);
  }

  /**
   * 类别
   */
  public function getcate(){
    $condition = array(
      "status"  =>1
    );
    $thumbBase = C("OSS_BASE_URL")."/thumb/";
    $list = M("PolicyCate")
    ->field("*,concat('$thumbBase',icon) as icon")
    ->where($condition)
    ->order("sort asc,id desc")
    ->fetchSql(false)
    ->select();

    $parentList = ['zhuhai'=>"珠海市",'jinwan'=>"金湾区"];

    $newList = array();
    foreach($parentList as $pkey=>$parent) {
      foreach($list as $key=>$val) {
        if($val['parent_name'] == $parent) {
          $newList[$pkey][] = $val;
        }
      }
      
    }
    $backData = array(
      "code"  =>200,
      "msg"   =>'success',
      "data"  =>array(
        "list"  =>$newList
      )     
    );
    $this->ajaxReturn($backData);
  }

  /***============== */
}