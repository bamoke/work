<?php
namespace Api\Controller;
use Think\Controller;
class NewsController extends Controller {
  /**
   * News list
   * @condition
   * @page
   */
  public function index(){
    $page = I("get.p/d",1);
    $pageSize = 20;
    $condition = array(
      "status"  =>1
    );
    $total = M("News")->where($condition)->count();

    $cate = M("NewsCate")->where(array("status"=>1))->order("sort asc,id desc")->select();
    $list = M("News")
    ->field("id,title,thumb,date(create_time) as date,description,view_num")
    ->where($condition)
    ->page($page,$pageSize)
    ->fetchSql(false)
    ->select();

    if(count($list)){
      foreach ($list as $k=>$v){
        if($v['thumb']) {
          $list[$k]["thumb"] = C("OSS_BASE_URL")."/thumb/".$v["thumb"];
        }
      }
    }

    $backData = array(
      "code"      =>200,
      "msg"       =>"ok",
      "data"      => array(
        "list"  =>$list,
        "page"  =>$page,
        "total" =>$total,
        "hasMore" => $total - ($page*$pageSize) > 0,
        "cate"  =>$cate
      )
    );
    $this->ajaxReturn($backData);  
  }

  public function vlist(){
    $page = I("get.p/d",1);
    $pageSize = 20;
    $condition = array(
      "status"  =>1
    );
    if(isset($_GET['cid'])) {
      $condition['cid'] = I("get.cid");
    }
    $total = M("News")->where($condition)->count();

    $list = M("News")
    ->field("id,title,thumb,date(create_time) as date,description,view_num")
    ->where($condition)
    ->page($page,$pageSize)
    ->fetchSql(false)
    ->select();

    if(count($list)){
      foreach ($list as $k=>$v){
        if($v['thumb']) {
          $list[$k]["thumb"] = C("OSS_BASE_URL")."/thumb/".$v["thumb"];
        }
      }
    }

    $backData = array(
      "code"      =>200,
      "msg"       =>"ok",
      "data"      => array(
        "list"  =>$list,
        "page"  =>$page,
        "total" =>$total,
        "hasMore" => $total - ($page*$pageSize) > 0
      )
    );
    $this->ajaxReturn($backData);
  }


  /**
   * Detail
   * @id
   */
  public function detail(){
    if(empty($_GET["id"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }

    $condition = array(
      "id"  =>I('get.id/d')
    );
    $newsId = I("get.id/d");
    $mainInfo = M("News")
    ->where($condition)
    ->fetchSql(false)
    ->find();
 
    $updateResult = M("News")->where($condition)->setInc("view_num");

    $backData = array(
        "code"      =>200,
        "msg"       =>"ok",
        "mainInfo"    => $mainInfo
    );
    $this->ajaxReturn($backData);
  }

}