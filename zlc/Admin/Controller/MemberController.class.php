<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 * Date: 2017/06/12
 * Time: 10:27
 */

namespace Admin\Controller;


use Admin\Common\Controller\AuthController;

class MemberController extends AuthController
{

    /***View  Index**/
    public function index(){
        $model = M('Member');
        // paging set
        $count = $model->count();
        $page = new \Think\Page($count,20);
        $page->setConfig('next','下一页');
        $page->setConfig('prev','上一页');
        $paging = $page->show();

        $result = $model->page(I('get.p').',20')->select();



        $outData = array(
            'list'      => $result,
            'paging'    => $paging
        );
        $this->assign('output',$outData);
        $this->display();
    }


    /***View  detail page**/
    public function detail($id){
        $model = M('Member');
        $result = $model
            ->alias("a")
            ->field("a.*,b.*")
            ->join("__MEMBER_INFO__ as b ON b.member_id = a.id","LEFT")
            ->where('a.id='.$id)
            ->find();
        $outData['info'] = $result;
        $this->assign('output',$outData);
        $this->display();
    }


    /***Operation 禁用***/
    public function disable($id,$v){
        $model = M('Member');
        $data = array('status'=>$v);
        $result = $model->where('id = '.$id)->save($data);
        if($result){
            $this->ajaxReturn(array('status'=>1,'info'=>'success'));
        }else {
            $this->ajaxReturn(array('status'=>0,'info'=>$model->getError()));
        }
    }











}