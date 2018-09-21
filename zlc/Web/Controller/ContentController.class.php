<?php
namespace Web\Controller;
use Web\Common\WebController;
class ContentController extends WebController {
  public function index($pid,$cid=null){
    $parentInfo = M("ContentCate")->field("id,type,title")->where("id=$pid")->find();
    // ==
    $childCate = M("ContentCate")
    ->field("id,pid,title,type,controller_name,action_name")
    ->where(array('pid'=>$pid,'status'=>1))
    ->order("sort,id")
    ->select();
    $banner = M("Banner")->where(array("position_key"=>$pid,"status"=>1))->find();


    // 获取当前子类信息
    if(is_null($cid)){
      if(count($childCate)) {
        $curCateInfo = $childCate[0];
        $curCateId = $childCate[0]["id"];
      }
    }else {
        $curCateId = $cid;
    }
    
    foreach($childCate as $k=>$v){
      // set class name
      if($curCateId == $v["id"]) {
          $className = 'current';
          $curCateInfo = $v;
      }else {
          $className = '';
      }
      $url = U("index",array("pid"=>$pid,"cid"=>$v['id']));
      $childNavHtml .= '<li><a href="'. $url .'" class="'.$className.'">'. $v['title'] .'</a></li>';
    }

    $this->assign("banner",$banner);
    $this->assign("pageName",$parentInfo['title']);
    $this->assign("curCateName",$curCateInfo['title']);
    $this->assign("childNavHtml",$childNavHtml);
    $this->_showTpl($curCateInfo);
  }


  protected function _showTpl($cateInfo){
    $cid = $cateInfo["id"];
    $tableName = ucfirst($cateInfo['type']);
    $data =array();
    switch ($cateInfo['type']){
      case 'custom':
        $controllerName = ucfirst($cateInfo["controller_name"]);
        $actionName = $cateInfo["action_name"];
        A($controllerName)->$actionName();
        $this->display($controllerName."/".$actionName);
        break;
      case 'single':
          $dataModel = M($tableName);
          $data = $dataModel->where("cid=".$cid)->fetchSql(false)->find();
          // 单页面需要输出脚本
          $output['script'] = CONTROLLER_NAME."/main";
          $this->assign('output',$output);
          $this->assign('data',$data);
          $this->display("Single/index");
          break;
      case 'news':
          $dataModel = M($tableName);
          $count = $dataModel->where("cid=".$cid)->fetchSql(true)->count();
          $Page = new \Think\Page($count,15);
          $Page->setConfig("next","下一页");
          $Page->setConfig("prev","上一页");
          $show = $Page->show();
          $data = $dataModel
              ->where("cid=".$cid)
              ->order('recommend desc,id desc')
              ->limit($Page->firstRow.','.$Page->listRows)
              ->select();
          $this->assign('page',$show);
          $this->assign('data',$data);
          $this->display("Article/index");
          break;
    }
  }


}