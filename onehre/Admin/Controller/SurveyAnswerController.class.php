<?php 
/*
 * 调查问卷
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-21 23:42:10
 */
namespace Admin\Controller;
use Admin\Common\Auth;
// use Think\Controller;
class SurveyAnswerController extends Auth {

  // 编辑
  public function insert(){
    if(!IS_POST){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $postData = $this->requestData;

    $insertData = array(
      "question_id" =>$postData["question_id"],
      "content" =>$postData['content'],
      "sort"    =>$postData['sort']
    );
    $insertId = M("SurveyAnswer")->fetchSql(false)->add($insertData);
    if(!$insertId) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据保存失败"    
      );
      $this->ajaxReturn($backData);
    }
    $info = M("SurveyAnswer")->where(array('id'=>$insertId))->fetchSql(false)->find();
    $backData = array(
      'code'      => 200,
      "msg"       => "success",
      "data"      =>array(
        "info"      =>$info
      )
    );
    $this->ajaxReturn($backData);
  }


  /**
   * update answer
   */
  public function update(){
    if(!IS_POST){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $postData = $this->requestData;
    $condition = array(
      "id"      =>$postData['id']
    );
    $data = array(
      "content" =>$postData['content'],
      "sort"    =>$postData['sort']
    );
    $updateResult = M("SurveyAnswer")->where($condition)->save($data);
    if($updateResult === false) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据保存失败"    
      );
      $this->ajaxReturn($backData);
    }
    $info = M("SurveyAnswer")->where($condition)->find();
    $backData = array(
      'code'      => 200,
      "msg"       => "success",
      "data"      =>array(
        "info"  =>$info
      )    
    );
    $this->ajaxReturn($backData);
  }


  /**
   * delete
   */
  public function delone(){
    if(empty($_GET["id"])){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);     
    }
    $id = I("get.id");
    $del = M("SurveyAnswer")->delete($id);
    if($del !== false) {
      $backData = array(
        'code'      => 200,
        "msg"       => "success"    
      );
    }else {
      $backData = array(
        'code'      => 13001,
        "msg"       => "操作失败"    
      );
    }
    $this->ajaxReturn($backData);
  }
  


  /**
   * update question and answer
   */
  public function update_bf(){
    if(!IS_POST){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $postData = $this->requestData;
    $questionConditon = array(
      "id"  =>$postData['id']
    );
    $questionSaveData = array(
      "type"  =>$postData['type'],
      "ask"   =>$postData['ask'],
      "sort"  =>$postData['sort']
    );
    $model = M();
    $model->startTrans();
    $questionUpdataResult = M('SurveyQuestion')->where($questionConditon)->save($questionSaveData);

    // 若修改未填空查询该问题下是否有选择题，有则删除
    if($postData['type'] == 3) {
      $delResult = M("SurveyAnswer")->where(array('question_id'=>$postData['id']))->delete();
    }
    
    if($questionUpdataResult !== false && $delResult !== false) {
      $model->commit();
      $backData = array(
        'code'      => 200,
        "msg"       => "ok",
        "data"      =>array(
          "info"    =>$postData
        )    
      );
      $this->ajaxReturn($backData);
    }else {
      $model->rollback();
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据保存失败"    
      );
      $this->ajaxReturn($backData);
    }
    
  }
  







  //==================//
}