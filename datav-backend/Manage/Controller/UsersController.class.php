<?php
/*
 * @Author: Joy wang
 * @Date: 2021-02-16 21:47:06
 * @LastEditTime: 2021-02-28 09:41:04
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */



namespace Manage\Controller;
use Manage\Common\Auth;

class UsersController extends Auth
{

    /***View  Index**/
    public function getlist(){
        $pageSize = 15;
        $requestData = $this->requestData;
        $model = M('Users');
        $page = I("get.p",1);
        $where = array();
        if(!empty($requestData['k']) && !empty($requestData['w'])) {
            $where["U.".$requestData['k']] = array("like","%".$requestData['w']."%");
        }
        $result = $model
        ->alias("U")
        ->field("U.id,U.username,U.nickname,U.role_id,U.status,U.create_time,(select group_concat(name) from datav_user_role R where FIND_IN_SET(R.id,U.role_id)) as role_name")
        ->where($where)
        ->page($page,$pageSize)
        ->fetchSql(false)
        ->select();



        // paging set
        $total = $model->alias("U")->where($where)->count();
        $pageInfo = array(
            "total" =>intval($total),
            "pageSize"  =>$pageSize,
            "page"  =>intval($page)
        );
        $backData = array(
            'code'      => 200,
            "msg"       => "ok",
            'data'      => array(
                "list"  =>$result,
                "pageInfo" =>$pageInfo
            )
        );
        $this->ajaxReturn($backData);
    }


    /***View  edit user page**/
    public function get_detail($id){
        $model = M('Users');
        $result = $model
        ->field("id,username,nickname,status,role_id")
        ->find($id);
        $result["role_id"]  = explode(",",$result["role_id"]);
        $backData = array(
            'code'      => 200,
            "msg"       => "ok",
            'data'      => array(
                "info"  =>$result
            )
        );
        $this->ajaxReturn($backData);
    }


    /***action***/
    public function save(){
        $postData = $this->requestData;
        if(IS_POST){
            $model = D('Users');
            
            if($model->create($postData)){
                // role_id
                $model->role_id = implode(",",$postData["role_id"]);
                if(empty($postData['id'])) {
                    // 检查用户名是否存在
                    $hasCondition = array(
                        "username"  =>$postData["username"]
                    );
                    $hasUser = $model->where($hasCondition)->count();
                    if($hasUser > 0) {
                        $backData = array(
                        'code'      => 13002,
                        "msg"       => "用户名已存在",        
                        );  
                        $this->ajaxReturn($backData);   
                    }
                
                    // 检测密码
                    if($postData["password"] == '') {
                        $backData = array(
                        'code'      => 13002,
                        "msg"       => "密码不能为空",        
                        );  
                        $this->ajaxReturn($backData);   
                    }
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
                $userInfo = $model
                ->alias("U")
                ->field("U.id,U.username,U.nickname,U.role_id,U.status,U.create_time,(select group_concat(name) from datav_user_role R where FIND_IN_SET(R.id,U.role_id)) as role_name")
                ->where("id=$userId")
                ->find();
                if($result !== false){

                    $backData = array(
                        'code'      => 200,
                        "msg"       => "ok",
                        'data'      => array(
                            "info"  =>$userInfo
                        )
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
            $result = M("Users")->delete($id);
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
            $model = D('Users');
            if($model->create($_POST,2)){
                $result = $model->save();
                if($result === false){
                    $backData['code'] = 13001;
                    $backData['msg'] = $model->getError();
                }elseif ($result === 0){
                    $backData['code'] = 200;
                    $backData['msg'] = "没有变动";
                }else {
                    $backData['code'] = 200;
                    $backData['msg'] = 'success';
                }
                $this->ajaxReturn($backData);
            }
        }

    }

    /**密码重置**/
    public function reset($id){
        $model = M('Users');
        $data=array('password'=>md5('abc_0763%*@'));
        $result = $model->where('id = '.$id)->save($data);
        if($result){
            $this->ajaxReturn(array('code'=>200,'msg'=>'success'));
        }else {
            $this->ajaxReturn(array('code'=>13001,'info'=>$model->getError()));
        }
    }

    /***禁用***/
    public function disable($id,$v){
        $model = M('Users');
        $data = array('status'=>$v);
        $result = $model->where('id = '.$id)->save($data);
        if($result){
            $this->ajaxReturn(array('code'=>200,'msg'=>'success'));
        }else {
            $this->ajaxReturn(array('code'=>13001,'msg'=>$model->getError()));
        }
    }


    /**
     * 
     */
    public function get_role_list(){
        $condition = array(
            "status"    =>1
        );
        $list = M("UserRole")
        ->field("id,name")
        ->where($condition)
        ->select();
        $backData = array(
            "code"  =>200,
            "msg"   =>"success",
            "data"  =>array(
                "list"  =>$list
            )
        );
        $this->ajaxReturn($backData);
    }



}