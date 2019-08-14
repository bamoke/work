<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class ArticleController extends BaseController {
  /**
   * card list
   * @condition
   * @page
   */
  public function vlist(){
    $page = I("get.page/d",1);
    $pageSize = 10;
    $condition = array(
      "status"  =>1
    );
    $cateId = I("get.cate/d",0);
    if($cateId !== 0) {
      $condition['cate_id'] = $cateId;
    }
    $thumbBase = C("OSS_BASE_URL")."/";
    $fieldInfo = "id,title,recommend,concat('$thumbBase',thumb) as thumb,date(create_time) as date,click";

    $total = M("Article")->where($condition)->count();
    $list = M("Article")
    ->field($fieldInfo)
    ->where($condition)
    ->page($page,$pageSize)
    ->order("recommend desc,id desc")
    ->fetchSql(false)
    ->select();

    // return;
    if(count($list)){
      foreach($list as $key=>$val){
        $click = rand(200,300) + $val['click'];
        $list[$key]["click"] = $click;
      }
    }

    $cateArr = M("MainCate")->where(array('pid'=>1))->order("sort,id")->select();
    $cateFirst = array(
      "name"  =>"全部",
      "id"    =>0
    );
    array_unshift($cateArr,$cateFirst);
    $backData = array(
      "code"      =>200,
      "msg"       =>"ok",
      "data"      => array(
        "list"  =>$list,
        "cate"  =>$cateArr,
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
    $thumbBase = C("OSS_BASE_URL")."/";
    $info = M("Article")->field("*,DATE(create_time) as date,concat('$thumbBase',thumb) as thumb")->where($condition)->find();

    // update view num
    $updateResult = M("Article")->where($condition)->setInc('click');
    $backData = array(
      "code"  =>200,
      "msg"   =>'success',
      "data"  =>array(
        "info"  =>$info
      )
    );
    $this->ajaxReturn($backData);
  }

  /***============== */
}