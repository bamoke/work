<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 * Date: 2017/6/8
 * Time: 14:28
 */

namespace Web\Controller;
use Web\Common\Controller\BaseController;

class JobsController extends BaseController
{

    public function index(){
        $where = array(
            "status"    =>1
        );
        $count = M("Jobs")->where($where)->count();
        $Page = new \Think\Page($count,15);
        $Page->setConfig("next","下一页");
        $Page->setConfig("prev","上一页");
        $show = $Page->show();

        $jobsList = M("Jobs")
        ->field("id,title,company,wage,IF(person_limit=0,'不限',person_limit) as person_limit,end_date,DATE(create_time) as create_time")
        ->where($where)
        ->order('id desc')
        ->limit($Page->firstRow.','.$Page->listRows)
        ->select();
        $outData['page'] = $show;
        $this->assign('outData',$outData);
        $this->assign('jobsList',$jobsList);
        $this->assign('pageName',"岗位信息");
        $this->display();
    }


    public function scroll(){
        // 滚动设置
        $scrollInfo = M("Scroll")
        ->where("id=1")
        ->find();
        $where = array(
            "status"    =>1
        );
        $jobsList = M("Jobs")
        ->field("*,IF(person_limit=0,'不限',person_limit) as person_limit,DATE(create_time) as create_time")
        ->where($where)
        ->order("sort,id desc")
        ->limit(0,100)
        ->select();
        $this->assign('jobsList',$jobsList);
        $this->assign('scrollInfo',$scrollInfo);
        $this->display();
    }

    public function detail($id){
        $where = array(
            "id" =>$id,
        );
        $jobInfo = M("Jobs")
        ->field("*,IF(person_limit=0,'不限',person_limit) as person_limit,DATE(create_time) as create_time")
        ->where($where)
        ->find();
        $this->assign('jobInfo',$jobInfo);
        $this->assign('pageName',"职位详情");
        $this->display();
    }
}