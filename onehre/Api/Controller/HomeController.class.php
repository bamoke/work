<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class HomeController extends BaseController {

  /**
   * 课程预约记录
   */
  public function bookinglog(){
    $page = I("get.p/d",1);
    $pageSize = 20;
    $condition = array(
      "CE.uid"  =>$this->uid
    );
    if(isset($_GET['status'])) {
      $condition['CE.status'] = I("get.status");
    }
    $total = M("CourseEnroll")->alias("CE")->where($condition)->fetchSql(false)->count();
    $list =  M("CourseEnroll")
    ->alias("CE")
    ->field("CE.*,C.title as coursename")
    ->join("__COURSE__ as C on CE.course_id=C.id")
    ->where($condition)
    ->page($page,$pageSize)
    ->fetchSql(false)
    ->select();
    $backData = array(
      "code"      =>200,
      "msg"       =>"ok",
      "data"      => array(
        "list"  =>$list,
        "page"  =>$page,
        "total" =>$total,
        "hasMore" => $total > ($page*$pageSize)
      )
    );
    $this->ajaxReturn($backData);
  }

   /**
   * 兼职申请记录
   */
  public function deliverlog(){
    $page = I("get.p/d",1);
    $pageSize = 20;
    $condition = array(
      "PA.uid"  =>$this->uid
    );
    $total = M("ParttimeApply")->alias("PA")->where($condition)->count();
    $list =  M("ParttimeApply")
    ->alias("PA")
    ->field("PA.*,C.title as parttime_name")
    ->join("__PARTTIME__ as PT on PA.pt_id=PT.id")
    ->where($condition)
    ->page($page,$pageSize)
    ->fetchSql(false)
    ->select();
    $backData = array(
      "code"      =>200,
      "msg"       =>"ok",
      "data"      => array(
        "list"  =>$list,
        "page"  =>$page,
        "total" =>$total,
        "hasMore" => $total > ($page*$pageSize)
      )
    );
    $this->ajaxReturn($backData);
  }


  /******************* */
}