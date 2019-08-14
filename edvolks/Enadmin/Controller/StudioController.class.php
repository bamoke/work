<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 * Date: 2017/6/28
 * Time: 15:10
 */

namespace Enadmin\Controller;
use Enadmin\Common\Controller\AuthController;

class StudioController extends AuthController
{

    public function index($cid){
        $dataModel = M("Studio");
        $count = $dataModel->where("cid=".$cid)->count();
        $Page = new \Think\Page($count,15);
        $Page->setConfig("next","下一页");
        $Page->setConfig("prev","上一页");
        $show = $Page->show();
        $data = $dataModel
        ->field("id,en_name")
            ->where("cid=".$cid)
            ->order('id desc')
            ->limit($Page->firstRow.','.$Page->listRows)
            ->select();

        $introduce = M("StudioIntroduce")->limit(1)->select();    
        $output['script'] = CONTROLLER_NAME."/main";
        $this->assign('output',$output);    
        $this->assign('page',$show);
        $this->assign('data',$data);
        $this->assign('introduce',$introduce[0]);
        $this->display();

    }


    /***
     * VIEW
     * 编辑列表类型内容
     * @param int \ID
     * @param string 页面类型，对应模型
    ***/
    function edit($id){
        $model = M("Studio");
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
            $model = D("Studio");
            
            $create = $model->create($_POST);
            if(!$create) {
                $backData['status'] =0;
                $backData['msg'] = $model->getError();
                $this->ajaxReturn($backData);
                return;
            }




            $result = $model->where('id='.$id)->fetchSql(false)->save();
            if($result !==false){
                $backData['status'] =1;
                $backData['msg'] = "success";
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
     * 添加保存,必须有pid,作为返回跳转的路由参数
     * 提交的数据必须有cid,作为返回跳转的路由参数
     * @param string 对应模型
     ***/
    public function save($navid){
        if(IS_POST){
            $model = M("Studio");
            $result = $model->create($_POST);
            $backData = array();
            if(!$result) {
                $backData['status'] = 0;
                $backData['msg'] = $model->getError();
                return $this->ajaxReturn($backData);
            }

 
            if($model->add()){
                $backData['status'] = 1;
                $backData['msg'] = "success";
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
        $tabelName = "Studio";
        $model = M($tabelName);
        $resutl = $model->where('id = '.$id)->delete();
        if($resutl){
            $backData['status'] = 1;
            $backData['msg'] = "success";
        }else {
            $backData['status'] = 0;
            $backData['msg'] = $model->getError();
        }
        $this->ajaxReturn($backData);
    }



    public function introduceupdate(){
        if(IS_POST){
            $model = M("StudioIntroduce");
            $result = $model->create($_POST);
            $backData = array();
            if(!$result) {
                $backData['status'] = 0;
                $backData['msg'] = $model->getError();
                return $this->ajaxReturn($backData);
            }
            $updateResult = $model->save();
 
            if($updateResult !== false){
                $backData['status'] = 1;
                $backData['msg'] = "success";
            }else {
                $backData['status'] = 0;
                $backData['msg'] = $model->getError();
            }
            $this->ajaxReturn($backData);
        }
    }



}