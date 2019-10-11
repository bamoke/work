<?php
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-08-07 00:20:27 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-08-13 00:27:26
 */

namespace Organization\Controller;
use Organization\Common\Auth;

class UserController extends Auth
{

    /***View  Index**/
    public function ulist(){
        $pageSize = 15;
        $requestData = $this->requestData;
        $model = M('Admin');
        $page = (int)$requestData['p'];
        $where = array();
        if(!empty($requestData['k']) && !empty($requestData['w'])) {
            $where["U.".$requestData['k']] = array("like","%".$requestData['w']."%");
        }
        $result = $model
        ->alias("U")
        ->join("__ADMIN_GROUPS__ as G on U.group_id = G.id","LEFT")
        ->field("U.id,U.username,U.realname,U.group_id,Date(U.create_time) as create_time,U.status,G.name as group_name")
        ->where($where)
        ->page($page,$pageSize)
        ->fetchSql(false)
        ->select();

        // paging set
        $count = $model->alias("U")->where($where)->count();

        $backData = array(
            'code'      => 200,
            "msg"       => "ok",
            'info'      => array(
                "list"  =>$result,
                "total" =>intval($count),
                "pageSize"=>$pageSize
            )
        );
        $this->ajaxReturn($backData);
    }

    public function groups(){
        $result = M("AdminGroups")->field("id,name")->select();
        $backData = array(
            'code'      => 200,
            "msg"       => "ok",
            'info'      => $result
        );
        $this->ajaxReturn($backData);
    }

    /***View  edit user page**/
    public function edit($id){
        $outData['script']= CONTROLLER_NAME."/add";
        $model = M('user');
        $result = $model->field('id,username,email,realname')->where('id='.$id)->find();
        $outData['info'] = $result;
        $this->assign("pageName",'编辑用户');
        $this->assign('output',$outData);
        $this->display();
    }


    /***action***/
    public function save(){
        $postData = $this->requestData;
        if(IS_POST){
            $model = D('Admin');
            if($model->create($postData)){
                if(empty($postData['id'])) {
                    $model->password = md5($postData['password']);
                    $result = $model->add();
                    $userId = $result;
                }else {
                    $userId = $postData['id'];
                    $where = array(
                        "id"    =>$userId
                    );
                    $result = $model->where($where)->fetchSql(false)->save();
                }
                if($result !== false){
                    $userInfo = $model
                    ->alias("U")
                    ->join("__ADMIN_GROUPS__ as G on U.group_id = G.id","LEFT")
                    ->field("U.id,U.username,U.realname,U.group_id,Date(U.create_time) as create_time,U.status,G.name as group_name")
                    ->where("U.id=$userId")
                    ->fetchSql(false)
                    ->find();
                    $backData = array(
                        'code'      => 200,
                        "msg"       => "ok",
                        'info'      => $userInfo
                    );
                    $this->ajaxReturn($backData);
                }
            }else {
                $backData = array(
                    'code'      => 13001,
                    "msg"       => "数据参数错误"
                );
                $this->ajaxReturn($backData);
            }
  
        }

    }

    public function deleteone(){
        if(empty($_GET["id"])){
            $backData = array(
                'code'      => 13001,
                "msg"       => "参数未定义"
            );
        }else {
            $id = $_GET['id'];
            $result = M("Admin")->delete($id);
            if($result !== false) {
                $backData = array(
                    'code'      => 200,
                    "msg"       => "ok"
                );
            }else {
                $backData = array(
                    'code'      => 13001,
                    "msg"       => "服务器错误"
                );
            }
        }
        $this->ajaxReturn($backData);  
    }

    public function update(){
        $backData = array();
        if(IS_POST){
            $model = D('Admin');
            if($model->create($_POST,2)){
                $result = $model->save();
                if($result === false){
                    $backData['status'] = 0;
                    $backData['info'] = $model->getError();
                }elseif ($result === 0){
                    $backData['status'] = 1;
                    $backData['info'] = "没有变动";
                }else {
                    $backData['status'] = 1;
                    $backData['info'] = 'ok';
                }
                $this->ajaxReturn($backData);
            }
        }

    }

    /**密码重置**/
    public function reset($id){
        $model = M('Admin');
        $data=array('password'=>md5('123456'));
        $result = $model->where('id = '.$id)->save($data);
        if($result){
            $this->ajaxReturn(array('status'=>1,'info'=>'success'));
        }else {
            $this->ajaxReturn(array('status'=>0,'info'=>$model->getError()));
        }
    }

    /***禁用***/
    public function disable($id,$v){
        $model = M('Admin');
        $data = array('status'=>$v);
        $result = $model->where('id = '.$id)->save($data);
        if($result){
            $this->ajaxReturn(array('status'=>1,'info'=>'success'));
        }else {
            $this->ajaxReturn(array('status'=>0,'info'=>$model->getError()));
        }
    }



}