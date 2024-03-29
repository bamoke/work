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
        $Page->setConfig("next","<i class='fa fa-angle-right'></i>");
        $Page->setConfig("prev","<i class='fa fa-angle-left'></i>");
        $show = $Page->show();

        $jobsList = M("Jobs")
        ->field("id,title,company,addr,link,type,wage,IF(person_limit=0,'不限',person_limit) as person_limit,end_date,DATE(create_time) as date")
        ->where($where)
        ->order('id desc')
        ->limit($Page->firstRow.','.$Page->listRows)
        ->select();

        foreach($jobsList as $key=>$val) {
            $url = U('Jobs/detail',array('id'=>$val['id']));
            if($val['link'] != '') {
                $url = $val['link'];
            }
            $jobsList[$key]["realurl"] = $url;
        }

        $outData['page'] = $show;
        $this->assign('outData',$outData);
        $this->assign('jobsList',$jobsList);
        $this->assign('pageName',"招聘职位");
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