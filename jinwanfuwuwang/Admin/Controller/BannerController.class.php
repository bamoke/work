<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 * Date: 2017/6/28
 * Time: 15:10
 */

namespace Admin\Controller;
use Admin\Common\Controller\AuthController;

class BannerController extends AuthController
{

    public function index(){
        $model = M("Banner");
        $condition = array(
            "position_key"  =>1
        );
        $imgBase = BASE_URL.'Uploads/banner/';
        $count = $model->where($condition)->count();

        $Page = new \Think\Page($count,15);
        $Page->setConfig("next","下一页");
        $Page->setConfig("prev","上一页");
        $show = $Page->show();
        $data = $model
            ->field("id,description,url,status,img")
            ->where($condition)
            ->order('sort,id desc')
            ->limit($Page->firstRow.','.$Page->listRows) 
            ->select();

        $output['script'] = "Banner/main";    
        $this->assign('pagination',$show);
        $this->assign('info',$data);
        $this->assign('output',$output);

        $this->display("Banner/index");

    }


    /***
     * VIEW
     * 编辑列表类型内容
     * @param int \ID
     * @param string 页面类型，对应模型
    ***/
    function edit(){
        $id = I("get.id");
        $model = M("Banner");
        $where = array('id'=>$id);
        $data = $model->where($where)->find();

        $output['script'] = "Banner/main";
        $this->assign('data',$data);
        $this->assign('output',$output);
        $this->assign('pageName',"Banner修改");
        $this->display("Banner/edit");
    }

    /***
     * VIEW
     * 添加列表类型内容
     * @param string 页面类型，对应模型
     ***/
    function add(){
        $output['script'] = "Banner/main";
        $this->assign('output',$output);
        $this->display("Banner/add");
    }


    /***
     * ACTION
     * 修改保存
     * @param int \ID
     ***/
    public function update(){
        if(IS_POST){
            $id= I("post.id");
            $backData =array();
            $model = M("Banner");
            $info = $model->field('*')->where("id=$id")->find();
            
            $create = $model->create($_POST);
            if($create){
                $upload_conf=$this->fetch_upload_config();
                //图片上传
                if($_FILES['img']['tmp_name']){
                    //图片处理
                    $upload = new \Think\Upload($upload_conf);
                    $uploadResult = $upload->uploadOne($_FILES['img']);
                    if(!$uploadResult){
                        $backData =array(
                            "status"    =>0,
                            "msg"       =>$upload->getError()
                        );
                        return $this->ajaxReturn($backData);
                    }
                    

                    $model->img = $uploadResult['savename'];

                    //删除旧图片
                    if(isset($_POST['old_img']) && $_POST['old_img'] == ''){
                        $dir = ROOT_DIR."/Uploads/banner/";
                        @unlink($dir.$_POST['old_img']);
                    }

                }else {
                    if(isset($_POST['old_img']) && $_POST['old_img'] == ''){
                        $backData['status'] = 0;
                        $backData['msg'] = "必须上传图片";
                        return $this->ajaxReturn($backData);
                    }

                }

                $result = $model->where('id='.$id)->fetchSql(false)->save();
                if($result !==false){
                    $backData['status'] =1;
                    $backData['msg'] = "修改成功";
                    $backData['sql'] = $model->getLast;
                    $backData['jump'] = U('Banner/index');
                    
                }else {
                    $backData['status'] =0;
                    $backData['msg'] = $model->getError();
                }
            }else {
                $backData['status'] =0;
                $backData['msg'] = $model->getError();
            }

            $this->ajaxReturn($backData);
        }
    }

    /***
     * ACTION
     * 添加保存
     * @param string 对应模型
     ***/
    public function save(){
        if(IS_POST){
            $model = M("Banner");
            $result = $model->create();
            $backData = array();
            if(!$result) {
                $backData['status'] = 0;
                $backData['msg'] = $model->getError();
                return $this->ajaxReturn($backData);
            }

            //图片上传
            if(!$_FILES['img']['tmp_name']){
                //图片处理
                $backData['status'] = 0;
                $backData['msg'] = "必须上传图片";
                return $this->ajaxReturn($backData);
            }
            $upload_conf = $this->fetch_upload_config();
            $upload = new \Think\Upload($upload_conf);
            $uploadResult = $upload->uploadOne($_FILES['img']);
            
            if(!$uploadResult){
                $backData =array(
                    "status"    =>0,
                    "msg"       =>$upload->getError()
                );
                return $this->ajaxReturn($backData);
            }



            $model->img = $uploadResult['savename'];
            
            if($model->add()){
                $backData['status'] = 1;
                $backData['msg'] = "保存成功";
                $backData['jump'] = U('Banner/index');
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
        $model = M("Banner");
        $info = $model->field('img')->where('id = '.$id)->find();
        $resutl = $model->where('id = '.$id)->delete();
        if($resutl){
            $backData['status'] = 1;
            $backData['msg'] = "删除成功";

            $dir = ROOT."/Uploads/banner/";
            @unlink($dir.$info['img']);
        }else {
            $backData['status'] = 0;
            $backData['msg'] = $model->getError();
        }
        $this->ajaxReturn($backData);
    }





    /***
     * 删除图片
     * @param string 模型名称
     * @param int ID
    ***/

    protected function del_img($id){
        $dir = ROOT_DIR."/Uploads/banner/";
        $result = M($tableName)->field('img')->where('id='.$id)->find();
        @unlink($dir.$result['img']);
    }

    /**
     * 设置图片上传配置
     */
    protected function fetch_upload_config(){
        return array(
            'maxSize' => 3145728,
            'rootPath' => ROOT_DIR.'/Uploads/',
            'savePath' => 'banner/',
            'saveName' => md5(time().I("session.uid")),
            'exts' => array('jpg', 'gif', 'png', 'jpeg'),
            'autoSub' => false,
            'subName' => ''
        );
    }






}