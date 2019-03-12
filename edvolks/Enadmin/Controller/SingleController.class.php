<?php
namespace Enadmin\Controller;
use Enadmin\Common\Controller\AuthController;

class SingleController extends AuthController {
  public function index ($cid){
    $dataModel = M("Single");
    $data = $dataModel->where("cid=".$cid)->fetchSql(false)->find();
    // 单页面需要输出脚本
    $output['script'] = "Content/main";
    $this->assign('output',$output);
    $this->assign('data',$data);
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
          $model = D("Single");
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





}