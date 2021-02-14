<?php
namespace Api\Controller;
// use Api\Common\Controller\BaseController;
use Think\Controller;
class EnController extends Controller {
    public function index(){
        $bannerList = array(
            array(
                "id"    =>4,
                "img"   =>C("OSS_BASE_URL")."/banner/en-banner-01.jpg?v=1",
                "url"   =>""
            )
        );

        $thumbBase = C("OSS_BASE_URL")."/";
        $articleCondition = array(
            "status"    =>1,
            "is_en"     =>1
        );
        $articleList = M("Article")
        ->field("id,en_title as title,CONCAT('$thumbBase',thumb) as thumb,DATE_FORMAT(create_time,'%b %D %Y') as date,click")
        ->where($articleCondition)
        ->limit(5)
        ->order("recommend desc,id desc")
        ->fetchSql(false)
        ->select();

        //
        $cateInfo = $this->catelist();
        $policiesInfo = array(
            "name"      =>'Policies Kit',
            "thumb"     =>$thumbBase."thumb/en-thumb-kit.jpg"
        );



        $backData = array(
            "code"  =>200,
            "msg"   =>"success",
            "data"  =>array(
                "bannerList"      =>$bannerList,
                "articleList"   =>$articleList,
                "cateInfo"    =>$cateInfo,
                "policiesInfo"  =>$policiesInfo
            )
        );
        $this->ajaxReturn($backData);

    }

     /**
   * card list
   * @condition
   * @page
   */
  public function vlist(){
    $page = I("get.page/d",1);
    $pageSize = 10;
    $condition = array(
      "status"  =>1,
      "is_en"   =>1
    );
    $cateId = I("get.cate/d",0);
    if($cateId !== 0) {
      $condition['cate_id'] = $cateId;
    }
    $keywords = I("get.kw",'');
    if($keywords) {
        $condition["en_title"] = array("like","%".$keywords."%");
    }
    $thumbBase = C("OSS_BASE_URL")."/";
    $fieldInfo = "id,en_title as title,recommend,concat('$thumbBase',thumb) as thumb,DATE_FORMAT(create_time,'%b %D %Y') as date,click";

    $total = M("Article")->where($condition)->count();
    $list = M("Article")
    ->field($fieldInfo)
    ->where($condition)
    ->page($page,$pageSize)
    ->order("id desc")
    ->fetchSql(false)
    ->select();

    // return;
    if(count($list)){
      foreach($list as $key=>$val){
        $click = rand(200,300) + $val['click'];
        $list[$key]["click"] = $click;
      }
    }

    $cateArr = $this->catelist();
    $cateFirst = array(
      "name"  =>"All",
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
    $info = M("Article")->field("*,en_title as title,IFNULL(en_content,content) as content,DATE_FORMAT(create_time,'%b %D %Y') as date,concat('$thumbBase',thumb) as thumb")->where($condition)->find();

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


    /**
     * 
     */
    protected function catelist(){
        $condition = array(
            "status"    =>1,
            "pid"       =>1
        );
        $thumbBase = C("OSS_BASE_URL")."/";
        $list = M("MainCate")
        ->field("*,en_name as name,IF(thumb != '',CONCAT('$thumbBase',thumb),'') as thumb")
        ->where($condition)
        ->order("sort,id")
        ->select();
        return $list;
    }

}