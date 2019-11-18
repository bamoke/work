<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 * Date: 2017/6/7
 * Time: 17:58
 */

namespace Web\Controller;
use Web\Common\Controller\BaseController;

class NewsController extends BaseController
{
    public function index($cid=null) {
        $outData = array();
        $outData['banner'] = 'banner_profit.png?v=1';
        $where = array(
            "status" => 1
        );
        if($cid !==null){
            $where['cid'] =$cid;
        }
        $newsCate = M('Content_cate')->field('id,title')->where('pid=8 and status=1')->order('id asc')->select();

        $count = M("News")->where($where)->count();
        $Page = new \Think\Page($count,15);
        $Page->setConfig("next","下一页");
        $Page->setConfig("prev","上一页");
        $show = $Page->show();

        $newsList = M("News")
            ->field("id,cid,description,title,EXTRACT(YEAR from create_time) as year,LPAD(EXTRACT(MONTH from create_time),2,0) as month,LPAD(EXTRACT(DAY from create_time),2,0) as day")
            ->where($where)
            ->order('recommend desc,id desc')
            ->limit($Page->firstRow.','.$Page->listRows)
            ->select();
        $outData['news'] = $newsList;
        $outData['cate'] = $newsCate;
        $outData['page'] = $show;
        $this->assign('outData',$outData);
        $this->display('Main/news');
    }

    /*********************/
    public function detail($id){
        $detail = M('News')->where('id='.$id)->find();
        $outData = array();
        $outData['news'] = $detail;
        $this->assign('outData',$outData);
        $this->display('Main/news-detail');
    }

}