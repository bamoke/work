<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 */

namespace Admin\Controller;


use Admin\Common\Controller\AuthController;

class CategoryController extends AuthController
{


    public function index(){
        $info = M("ContentCate")->where("status=1")->order("sort,id")->select();
        $this->assign("info",$info);
        $this->display();
    }

    public function main($id=null){
        
        $info = $id ? M('ContentCate')->where("id=$id")->find() : array();
        $cate = M('ContentCate')->where("pid=0")->select();

        $output['script'] = CONTROLLER_NAME."/main";
        $output['info'] = $info;
        $this->assign("output",$output);
        $this->assign("cate",$cate);
        $this->display('main');
    }

    public function save_cate(){
        $model = M("ContentCate");
        if(IS_POST){
            if($model->create()){
                if(I("post.id")){
                    $result = $model->save();
                }else {
                    $result = $model->add();
                }
                if($result !== false){
                    if(I('post.type') == 'single' && empty($_POST['id'])){
                        $inserData = array(
                            "cid"   =>$result,
                            "title" =>I("post.title"),
                            "pid"   =>I("post.pid")
                        );
                        $addPage = M("Single")->data($inserData)->add();
                    }
                    $backData = array(
                        "status"    =>1,
                        "msg"       =>"修改成功"
                    );
                }else {
                    $backData = array(
                        "status"    =>0,
                        "msg"       =>$model->getError()
                    );
                }
            }else {
                $backData = array(
                    "status"    =>0,
                    "msg"       =>$model->getError()
                );
            }
            $this->ajaxReturn($backData);
        }
    }


}