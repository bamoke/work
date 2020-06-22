<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 * Date: 2017/6/26
 * Time: 16:59
 */

namespace Admin\Controller;
use Admin\Common\Controller\AuthController;

class JobsController extends AuthController
{

    public function index(){
        // paging set
        $condition = array();
        if(!empty($_GET['keyword'])){
          $keyWord = I("get.keyword");
          $condition['title'] = array("like","%$keyWord%");
        }
        $model = M("Jobs");
        $count = $model->where($condition)->count();
        $page = new \Think\Page($count,15);
        $page->setConfig('next','下一页');
        $page->setConfig('prev','上一页');
        $paging = $page->show();

        $list = $model
          ->field("*,IF(person_limit = 0 ,'不限',person_limit) as person_limit")
          ->where($condition)
          ->limit($page->firstRow.','.$page->listRows)
          ->fetchSql(false)
          ->select();
        $outData = array(
            'list'      => $list,
            'paging'    => $paging
        );
        $this->assign('output',$outData);
        $this->display();
    }

    /***编辑 View**/
    public function edit($id){
        $mainInfo = M("Jobs")->where('id ='.$id)->find();
        $outData = array(
            "script"=>CONTROLLER_NAME."/main"
        );
        $this->assign('output',$outData);
        $this->assign('mainInfo',$mainInfo);
        $this->assign('pageName',"修改岗位");
        $this->display();

    }

    /***View add**/
    public function add(){
        $outData = array(
            "script"=>CONTROLLER_NAME."/main"
        );
        $this->assign('output',$outData);
        $this->assign('pageName',"添加岗位");
        $this->display();
    }




    /***action ****/
    public function do_update(){
        if(IS_POST){
            $id= I("post.id/d");
            $backData = array();
            $model = D("Jobs");
            $result = $model->create($_POST);
            if($result){
                if(isset($_POST["no_limit_person"])) {
                    $model->person_limit = 0;
                }
                $update = $model->where('id='.$id)->fetchSql(false)->save();
                if($update !== false){
                    $backData['status'] = 1;
                    $backData['msg'] = $update === 0 ? "数据没有变动":"修改成功";
                    $backData['jump'] = U('index');
//                    $backData['data'] = $result;

                }else {
                    $backData['status'] = 0;
                    $backData['msg'] = $model->getError();
                }

            }else {
                $backData['status'] = 0;
                $backData['msg'] = $model->getError();
            }


            $this->ajaxReturn($backData);

        }
    }


    public function do_add(){
        if(IS_POST){
            $backData = array();
            $model = D("Jobs");
            $result = $model->create($_POST);
            if($result){
                if(isset($_POST["no_limit_person"])) {
                    $model->person_limit = 0;
                }
                $add = $model->fetchSql(false)->add();

                if($add){
                    $backData['status'] = 1;
                    $backData['msg'] = "添加成功";
                    $backData['jump'] = U('index');

                }else {
                    $backData['status'] = 0;
                    $backData['msg'] = $model->getError();
                }

            }else {
                $backData['status'] = 0;
                $backData['msg'] = $model->getError();
            }


            $this->ajaxReturn($backData);

        }
    }







    /*=============================*/
}