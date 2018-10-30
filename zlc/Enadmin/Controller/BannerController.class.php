<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 * Date: 2017/6/28
 * Time: 15:10
 */

namespace Enadmin\Controller;
use Enadmin\Common\Controller\AuthController;

class BannerController extends AuthController
{

    public function index(){
        $model = M("Banner");
        // $cate = M('Content_cate')->field('id,title')->where('status = 1 and is_nav = 1')->select();
        $cate = $this->_get_banner_position();
        $count = $model->count();
        $Page = new \Think\Page($count,15);
        $Page->setConfig("next","下一页");
        $Page->setConfig("prev","上一页");
        $show = $Page->show();
        $data = $model
            ->where("1=1")
            ->order('sort,id desc')
            ->limit($Page->firstRow.','.$Page->listRows) 
            ->select();

        $output['script'] = CONTROLLER_NAME."/main";    
        $this->assign('pagination',$show);
        $this->assign('info',$data);
        $this->assign('cate',$cate);
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
        $model = M("Banner");
        $cate = M('Content_cate')->field('id,title')->where('status = 1 and is_nav = 1')->select();
        $where = array('id'=>$id);
        $data = $model->where($where)->find();

        $output['script'] = CONTROLLER_NAME."/main";
        $this->assign('data',$data);
        $this->assign('cate',$cate);
        $this->assign('output',$output);
        $this->display();
    }

    /***
     * VIEW
     * 添加列表类型内容
     * @param string 页面类型，对应模型
     ***/
    function add(){
        $output['script'] = CONTROLLER_NAME."/main";
        $cate = M('Content_cate')->field('id,title')->where('status = 1 and is_nav = 1')->select();
        $this->assign('output',$output);
        $this->assign('cate',$cate);
        $this->display();
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
            $page_type = I('post.type');
            $model = M("Banner");
            $info = $model->field('img')->where("id=$id")->find();
            
            $create = $model->create($_POST);
            if($create){
                $upload_conf=array(
                    'maxSize' => 3145728,
                    'rootPath' => ROOT.'/Uploads/',
                    'savePath' => 'banner/',
                    'saveName' => md5(time().I("session.uid")),
                    'exts' => array('jpg', 'gif', 'png', 'jpeg'),
                    'autoSub' => false,
                    'subName' => date("Ym",time())
                );
                //图片上传
                if($_FILES['img']['tmp_name']){
                    //图片处理
                    $upload = new \Think\Upload($upload_conf);
                    $uploadResult = $upload->uploadOne($_FILES['img']);
                    if(!$uploadResult){
                        $backData['status'] = 0;
                        $backData['msg'] = $upload->getError();
                        return $this->ajaxReturn($backData);
                    }else {
                        $model->img = $uploadResult['savename'];
                        //删除旧图片
                        if(isset($_POST['old_img']) && $_POST['old_img'] == ''){
                            unlink($upload_conf['rootPath'].$upload_conf['savePath'].$info['img']);
                        }
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
                    $backData['jump'] = U('index');
                    
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
            if($_FILES['img']['tmp_name']){
                //图片处理
                $upload_conf=array(
                    'maxSize' => 3145728,
                    'rootPath' => ROOT.'/Uploads/',
                    'savePath' => 'banner/',
                    'saveName' => md5(time().I("session.uid")),
                    'exts' => array('jpg', 'gif', 'png', 'jpeg'),
                    'autoSub' => false,
                    'subName' => date("Ym",time())
                );
                $upload = new \Think\Upload($upload_conf);
                $uploadResult = $upload->uploadOne($_FILES['img']);
                if(!$uploadResult){
                    $backData['status'] = 0;
                    $backData['msg'] = $upload->getError();
                    return $this->ajaxReturn($backData);
                }
            }else {
                $backData['status'] = 0;
                $backData['msg'] = "必须上传图片";
                return $this->ajaxReturn($backData);
            }
            
            $model->img = $uploadResult['savename'];
            if($model->add()){
                $backData['status'] = 1;
                $backData['msg'] = "保存成功";
                $backData['jump'] = U('index');
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
            if(isset($info['img']) &&  $info['img']!= ''){
                $file = ROOT."/Uploads/banner/".$info['img'];
                unlink($file);
            }
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

    protected function del_img($tableName,$id){
        $dir = ROOT."/Uploads/images/";
        $result = M($tableName)->field('img')->where('id='.$id)->find();
        @unlink($dir.$result['img']);
    }


    protected function _get_banner_position (){
        $navCate = M("Content_cate")->field("id,title")->where("is_nav = 1")->select();
        $position = array(
            '0'=>'首页'
        );
        foreach($navCate as $key=>$val){
            $position[$val['id']] =$val['title'];
        }
        return $position;
    }




}