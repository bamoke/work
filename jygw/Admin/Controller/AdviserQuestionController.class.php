<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 22:48:12
 */
namespace Admin\Controller;
use Admin\Common\Auth;
class AdviserQuestionController extends Auth {

  public function index(){
    $pageSize = 15;
    $mainModel = M("AdviserQuestion");
    $page = I("get.page/d",1);
    $where = array();
    if(!empty($_GET['cate'])) {
      $where["Q.cate_id"] = I("get.cate");
    }
    if(!empty($_GET['keywords'])){
      $where['Q.title'] = array("like","%".$_GET["keywords"]."%");
    }
    $list = $mainModel
    ->alias("Q")
    ->field("Q.*,TRIM('顾问' FROM A.title) as cate_name")
    ->join("__ADVISER__ as A on A.id= Q.cate_id")
    ->where($where)
    ->page($page,$pageSize)
    ->order("Q.id desc")
    ->fetchSql(false)
    ->select();
    $total = $mainModel->alias("Q")->where($where)->count();
    $pageInfo = array(
        "pageSize"  =>$pageSize,
        "page"      =>$page,
        "total"     =>intval($total)
    );
    
    if($total > 0 ){
      foreach($list as $key=>$val) {
        if($val["special"]){
          $tempArr = explode(",",$val["special"]);
          $tempText = '';
          foreach($tempArr as $v){
            $tempText .= $cateList[$v]."/";
          }
          $list[$key]["belong_cate"] = trim($tempText,"/");
        }
      }
    }
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
        "list"  =>$list,
        "cateList"  =>$cateList,
        "pageInfo"  =>$pageInfo
    )
    );
    $this->ajaxReturn($backData);
  }

 

  // 提问详情
  public function edit(){
    if(empty($_GET['id'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $id = I("get.id");
    $info = M("AdviserQuestion")
    ->where(array('id'=>$id))
    ->find();
    if(!$info) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据获取异常"    
      );
      $this->ajaxReturn($backData);
    }
    $backData = array(
      'code'      => 200,
      "msg"       => "success",
      "data"      =>array(
        "info"      =>$info
      )
    );
    $this->ajaxReturn($backData);
  }

  // 数据保存
  public function save(){
    if(!IS_POST){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $mainModel = M("AdviserQuestion");
    $postData = $mainModel->create($this->requestData);
    if(!$postData) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据创建错误"    
      );
      $this->ajaxReturn($backData);   
    }

    $mainModel->verify_user = $this->uid;
    $mainModel->verify_time = date("Y-m-d H:i:s",time());
    if(isset($mainModel->id) && !is_null($mainModel->id)){
      $id = intval($mainModel->id);
      $result = $mainModel->where(array("id"=>$id))->fetchSql(false)->save();
    }else {
      $result = $mainModel->fetchSql(false)->add();
      $id = $result;
    }
    if($result !== false){
      $info = $mainModel
      ->alias("Q")
      ->field("Q.*,TRIM('顾问' FROM A.title) as cate_name")
      ->join("__ADVISER__ as A on A.id= Q.cate_id")
      ->where(array("Q.id"=>$id))
      ->find();
      $backData = array(
        'code'      => 200,
        "msg"       => "success",
        "data"    =>array(
          "info"  =>$info
        )
      );
    }else {
      $backData = array(
        'code'      => 13002,
        "msg"       => "服务器错误",        
      );     
    }
    $this->ajaxReturn($backData);
  }


  /**
   * 
   */
  public function cate(){
    $model = M("Adviser");
    $where = array(
      "isdelete"  =>0,
      "status"    =>1
    );
    $list = $model
    ->field("id,TRIM('顾问' FROM title) as name")
    ->where($where)
    ->fetchSql(false)
    ->order("sort,id desc")
    ->select();
    $backData = array(
      'code'      => 200,
      "msg"       => "success",
      "data"    =>array(
        "list"  =>$list
      )
    );
    $this->ajaxReturn($backData);
  }


  /**
   * 
   */
  public function detail($id){
    $questionId = $id;
    $questionInfo = M("AdviserQuestion")
    ->field()
    ->find($questionId);

    $answerCondition = array(
      "A.question_id" =>$questionId
    );
    $answerList = M("AdviserAnswer")
    ->alias("A")
    ->field("A.*,U.realname as adviser_name,U.description as adviser_description")
    ->join("__ADVISER_USER__ as U on A.respondent = U.id")
    ->where($answerCondition)
    ->fetchSql(false)
    ->select();
    $backData = array(
      'code'      => 200,
      "msg"       => "success",
      "data"    =>array(
        "questionInfo"  =>$questionInfo,
        "answerList"    =>$answerList
      )
    );
    $this->ajaxReturn($backData);

  }



  //==================//
}