<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 * Date: 2017/6/26
 * Time: 16:59
 */

namespace Manage\Controller;
use Manage\Common\Controller\AuthController;

class ProductController extends AuthController
{

    public function index(){
        $modelPro = M("Product");
        // paging set
        $count = $modelPro->count();
        $page = new \Think\Page($count,20);
        $page->setConfig('next','下一页');
        $page->setConfig('prev','上一页');
        $paging = $page->show();

        $proList = M("Content_cate")
            ->alias("C")
            ->join("__PRODUCT__ as P on P.parent_id = C.id")
            ->field('C.title as cate_name,P.id,P.name,P.ratio,P.start_amount,P.close_limit,P.create_time,P.status')
            ->where("C.pid = 2")
            ->page(I('get.p').',20')
            ->select();
        $outData = array(
            'list'      => $proList,
            'paging'    => $paging
        );
        $this->assign('output',$outData);
        $this->display();
    }

    /***编辑 View**/
    public function edit($id){
        $proInfo = M("Product")->where('id ='.$id)->find();
        $cateInfo = M("Content_cate")->where('pid = 2')->select();
        $outData = array(
            'proInfo'      => $proInfo,
            'cateInfo'    => $cateInfo,
            "script"=>CONTROLLER_NAME."/main"
        );
        $this->assign('output',$outData);
        $this->display();

    }

    /***View Cate**/
    public function add(){
        $cate = M("Content_cate")->field('id,title')->where('pid=2')->select();
        $outData = array(
            "script"=>CONTROLLER_NAME."/main",
            "cate"  =>$cate
        );
        $this->assign('output',$outData);
        $this->display();
    }



    /***action ****/
    public function a_update($id){
        if(IS_POST){
            $backData = array();
            $model = D("Product");
            $uploadDir = ROOT_DIR.'/Upload/';
            $result = $model->create($_POST);
            if($result){
                if($_FILES['thumb']['tmp_name']){
                    //图片处理
                    $upload_conf=array(
                        'maxSize' => 3145728,
                        'rootPath' => $uploadDir,
                        'savePath' => 'thumb/',
                        'saveName' => md5(time().I("session.uid")),
                        'exts' => array('jpg', 'gif', 'png', 'jpeg'),
                        'autoSub' => false,
                        'subName' => date("Ym",time())
                    );
                    $upload = new \Think\Upload($upload_conf);
                    $uploadResult = $upload->uploadOne($_FILES["thumb"]);
                    if(!$uploadResult){
                        $backData['imgErr'] = $upload->getError();
                    }else {
                        $model->thumb = $thumb = $uploadResult['savename'];
                        $this->del_thumb($id);
                    }
                }else {
                    // 删除旧图片
                    if(isset($_POST['oldthumb']) && $_POST['oldthumb'] == ''){
                        $model->thumb = '';
                        $this->del_thumb($id);
                    }
                }

                if(I('post.limited_buy') == 0){
                    $model->sell_start_date = null;
                    $model->sell_end_date = null;
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


    public function a_add(){
        if(IS_POST){
            $backData = array();
            $model = D("Product");
            $uploadDir = ROOT_DIR.'/Upload/';
            $result = $model->create($_POST);
            if($result){
                if($_FILES['thumb']['tmp_name']){
                    //图片处理
                    $upload_conf=array(
                        'maxSize' => 3145728,
                        'rootPath' => $uploadDir,
                        'savePath' => 'thumb/',
                        'saveName' => md5(time().I("session.uid")),
                        'exts' => array('jpg', 'gif', 'png', 'jpeg'),
                        'autoSub' => false,
                        'subName' => date("Ym",time())
                    );
                    $upload = new \Think\Upload($upload_conf);
                    $uploadResult = $upload->uploadOne($_FILES["thumb"]);
                    if(!$uploadResult){
                        $backData['imgErr'] = $upload->getError();
                    }else{
                        $model->thumb = $uploadResult['savename'];
                    }
                }
                $add = $model->add();
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


    protected function del_thumb($pid){
        $dir = ROOT_DIR."/Upload/thumb/";
        $result = M("Product")->field("thumb")->where('id='.$pid)->find();
        @unlink($dir.$result['thumb']);
    }






    /*=============================*/
}