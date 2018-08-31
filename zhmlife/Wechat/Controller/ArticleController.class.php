<?php
namespace Wechat\Controller;
use Wechat\Common\WebController;
class ArticleController extends WebController {

    public function index($cid,$page=1){

        //banner
        $bannerList = M("Banner")->where("position_key=$cid and status=1")->order("sort,id desc")->limit(5)->select();
        

        //
        $newsModel = D("News");
        $listField = "id,cid,title,thumb,description,DATE_FORMAT(create_time,'%m-%d') as time,(init_click + click) as click";
        $count = $newsModel->where("cid=".$cid)->count();
        $mainList = $newsModel
        ->field($listField)
        ->where("status=1 and cid=$cid")
        ->limit(10)
        ->page($page)
        ->order("id desc")
        ->select();
        if(($page-1)*10 + count($mainList) < $count){
            $hasMore = !!1;
        }else {
            $hasMore = !!0;
        }
        $backData = array(
            "Code"      =>'10000',
            "info"      =>array(
                "hasMore"   =>$hasMore,
                "banner"    =>$bannerList,
                "list"      =>$mainList,
                "nav"       =>$this->navList
            )
        );
        $this->ajaxReturn($backData);
    }
    public function detail($id){
        $update = M()->execute('update __NEWS__ set click = click+1 where id='.$id);
        $info=M("News")
        ->alias("N")
        ->field("N.*,DATE(N.create_time) as time,(N.init_click + N.click) as click")
        ->where("N.id=$id")
        ->find();
        $recommendList = M("News")->field("id,cid,thumb,title,DATE(create_time) as time,(init_click + click) as click")->where("status=1 and recommend=1")->order("id desc")->limit(3)->select();
        if($info['content']){
            $info['content'] = str_replace('="/Uploads/images','="http://www.zhmlife.com/Uploads/images',$info['content']);
        }
        $backData = array(
            "Code"      =>'10000',
            "info"      =>array(
                "detail"   =>$info,
                "recommend"    =>$recommendList
            )
        );
        $this->ajaxReturn($backData);
    }

    public function search(){
        $where = array(
            "status"    =>1
        );
        if(!empty($_GET['kw'])){
            $where['title'] = array("like","%".I('get.kw')."%");
        }
        $page = intval(I("get.page","1"));
        $newsModel = D("News");
        $listField = "id,cid,title,thumb,description,DATE_FORMAT(create_time,'%m-%d') as time,(init_click + click) as click";
        $count = $newsModel->where($where)->count();
        $mainList = $newsModel
        ->field($listField)
        ->where($where)
        ->limit(10)
        ->page($page)
        ->order("id desc")
        ->fetchSql(false)
        ->select();
        if(($page-1)*10 + count($mainList) < $count){
            $hasMore = !!1;
        }else {
            $hasMore = !!0;
        }
        $backData = array(
            "Code"      =>'10000',
            "info"      =>array(
                "total"     =>$count,
                "hasMore"   =>$hasMore,
                "list"      =>$mainList
            )
        );
        $this->ajaxReturn($backData);

    }
    protected function _mainassign($cid){
        $listField = "id,cid,title,thumb,description,DATE_FORMAT(create_time,'%m-%d') as time,(init_click + click) as click";
        $newsModel = D("News");
        $hotList = $newsModel->getHot($cid);
        $hotSearchList = $newsModel->getHotSearch($cid);
        //advertisement
        $adModel = M("Advertisement");
        $adList = $adModel->where("status=1")->order("id desc")->select();
        $this->assign("hot",$hotList);
        $this->assign("hotsearch",$hotSearchList);
        $this->assign("adlist",$adList);
    }
}