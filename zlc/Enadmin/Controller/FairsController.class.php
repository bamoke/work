<?php
namespace Enadmin\Controller;
use Enadmin\Common\Controller\AuthController;

class FairsController extends AuthController {
  public function index ($cid){
    $curModel = M("Fairs");
    $condition = array(
      "cid" =>$cid
    );
    $count = $curModel->where($condition)->count();
    $Page = new \Think\Page($count,15);
    $Page->setConfig("next","下一页");
    $Page->setConfig("prev","上一页");
    $show = $Page->show();
    $data = $curModel
        ->where($condition)
        ->order('recommend desc,id desc')
        ->limit($Page->firstRow.','.$Page->listRows)
        ->select();
    $this->assign('page',$show);
    $this->assign('data',$data);
    $output['script'] = CONTROLLER_NAME."/main";
    $this->assign('output',$output);
    $this->display();
  }


    /***
     * VIEW
     * 编辑列表类型内容
     * @param int \ID
     * @param string 页面类型，对应模型
    ***/
    function edit($id){
      $model = M("Fairs");
      $where = array('id'=>$id);
      $data = $model->where($where)->find();

      $output['script'] = CONTROLLER_NAME."/main";
      $this->assign('data',$data);
      $this->assign('output',$output);
      $this->display();
  }

  /***
   * VIEW
   * 添加列表类型内容
   * @param string 页面类型，对应模型
   ***/
  function add($cid){
      $output['script'] = CONTROLLER_NAME."/main";
      $this->assign('output',$output);
      $this->display();
  }


  /***
   * ACTION
   * 修改保存
   * @param int \ID
   ***/
  public function update($navid,$id){
      if(IS_POST){
          $backData = array();
          $model = D("Fairs");
          $info = $model->field('thumb')->where("id=$id")->find();
          
          $create = $model->create($_POST);
          if(!$create) {
              $backData['status'] =0;
              $backData['msg'] = $model->getError();
              $this->ajaxReturn($backData);
              return;
          }

          $upload_conf=array(
              'maxSize' => 3145728,
              'rootPath' => ROOT.'/Uploads/',
              'savePath' => 'thumb/',
              'saveName' => time().I("session.uid"),
              'exts' => array('jpg', 'gif', 'png', 'jpeg'),
              'autoSub' => false,
              'subName' => date("Ym",time())
          );
          //图片上传
          if($_FILES['thumb']['tmp_name']){
              //图片处理
              $upload = new \Think\Upload($upload_conf);
              $uploadResult = $upload->uploadOne($_FILES['thumb']);
              if(!$uploadResult){
                  $backData['status'] = 0;
                  $backData['msg'] = $upload->getError();
                  return $this->ajaxReturn($backData);
              }else {
                  $model->thumb = $uploadResult['savename'];
                  //删除旧图片
                  unlink($upload_conf['rootPath'].$upload_conf['savePath'].$info['thumb']);
              }

          }else {
              // 删除旧图片
              if(isset($_POST['old_img']) && $_POST['old_img'] == ''){
                  $model->thumb = '';
                  @unlink($upload_conf['rootPath'].$upload_conf['savePath'].$info['thumb']);
              }
          }

          $result = $model->where('id='.$id)->fetchSql(false)->save();
          if($result !==false){
              $backData['status'] =1;
              $backData['msg'] = "修改成功";
              $backData['sql'] = $model->getLast;
              $backData['jump'] = U('index',array('navid'=>$navid,'cid'=>I('post.cid')));
          }else {
              $backData['status'] =0;
              $backData['msg'] = $model->getError();
          }

          $this->ajaxReturn($backData);
      }
  }

  /***
   * ACTION
   * 添加保存,必须有navid,作为返回跳转的路由参数
   * 提交的数据必须有cid,作为返回跳转的路由参数
   * @param string 对应模型
   ***/
  public function save($navid){
      if(IS_POST){
          
          // 3.常规页面操作
          $tableName = "Fairs";
          $model = M($tableName);
          $result = $model->create($_POST);
          $backData = array();
          if(!$result) {
              $backData['status'] = 0;
              $backData['msg'] = $model->getError();
              return $this->ajaxReturn($backData);
          }

          //图片上传
          if($_FILES['thumb']['tmp_name']){
              //图片处理
              $upload_conf=array(
                  'maxSize' => 3145728,
                  'rootPath' => ROOT.'/Uploads/',
                  'savePath' => 'thumb/',
                  'saveName' => time().I("session.uid"),
                  'exts' => array('jpg', 'gif', 'png', 'jpeg'),
                  'autoSub' => false,
                  'subName' => date("Ym",time())
              );
              $upload = new \Think\Upload($upload_conf);
              $uploadResult = $upload->uploadOne($_FILES['thumb']);
              if(!$uploadResult){
                  $backData['status'] = 0;
                  $backData['msg'] = $upload->getError();
                  return $this->ajaxReturn($backData);
              }else {
                  $model->thumb = $uploadResult['savename'];
              }
          }
          $model->init_click = mt_rand(200,500);
          if($model->add()){
              $backData['status'] = 1;
              $backData['msg'] = "保存成功";
              $backData['jump'] = U('index',array('navid'=>$navid,'cid'=>I('post.cid')));
          }else {
              $backData['status'] = 0;
              $backData['msg'] = $model->getError();
          }
          $this->ajaxReturn($backData);
      }
  }


  /***
   * del
   * @param int ID
   * @param string
  ***/
  public function del($id){
      $tabelName = "Fairs";
      $model = M($tabelName);
      $info = $model->field('id,title,thumb')->where('id = '.$id)->find();
      $resutl = $model->where('id = '.$id)->delete();
      if($resutl){
          $backData['status'] = 1;
          $backData['msg'] = "删除成功";
          $backData['test'] = $info['thumb'];
          if(isset($info['thumb']) &&  $info['thumb']!= ''){
              $file = ROOT."/Uploads/thumb/".$info['thumb'];
              unlink($file);
          }
      }else {
          $backData['status'] = 0;
          $backData['msg'] = $model->getError();
      }
      $this->ajaxReturn($backData);
  }



}