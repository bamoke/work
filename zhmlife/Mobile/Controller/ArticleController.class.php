<?php
namespace Mobile\Controller;
use Mobile\Common\WebController;
class ArticleController extends WebController {

    public function index($cid,$page=1){
        //cate
        $cateInfo = M("ContentCate")->where("status=1 and id = $cid")->find();

        //banner
        $bannerList = M("Banner")->where("position_key=$cid and status=1")->order("sort,id desc")->limit(5)->select();
        

        //
        $newsModel = D("News");
        $listField = "id,cid,title,thumb,description,DATE_FORMAT(create_time,'%m-%d') as time,(init_click + click) as click";
        $count = $newsModel->where("cid=".$cid." and status=1")->count();
 
        $mainList = $newsModel
        ->field($listField)
        ->where("status=1 and cid=$cid")
        ->page($page)
        ->limit(10)
        ->order("id desc")
        ->select();
        if(($page-1)*10 + count($mainList) < $count){
            $hasMore = 1;
        }else {
            $hasMore = 0;
        }
        $this->_mainassign($cid);
        $this->assign("banner",$bannerList);
        $this->assign("mainlist",$mainList);
        $this->assign("cateinfo",$cateInfo);
        $this->assign("hasMore",$hasMore);
        $this->display();
    }

    /**
     * ajax fetch data
     */
    public function getlist($cid,$page=1){
        $newsModel = D("News");
        $listField = "id,cid,title,thumb,description,DATE_FORMAT(create_time,'%m-%d') as time,(init_click + click) as click";
        $count = $newsModel->where("cid=".$cid." and status=1")->count();
        $mainList = $newsModel
        ->field($listField)
        ->where("status=1 and cid=$cid")
        ->page($page)
        ->limit(10)
        ->order("id desc")
        ->select();
        if(($page-1)*10 + count($mainList) < $count){
            $hasMore = 1;
        }else {
            $hasMore = 0;
        }
        $backData = array(
            "status"        =>!!1,
            "list"          =>$mainList,
            "hasMore"       =>$hasMore
        );
        $this->ajaxReturn($backData);
    }
    public function detail($cid,$id){
        $update = M()->execute('update __NEWS__ set click = click+1 where id='.$id);
        $info=M("News")
        ->alias("N")
        ->field("N.*,DATE(N.create_time) as time,(N.init_click + N.click) as click,C.title as catename")
        ->join("__CONTENT_CATE__ as C on C.id=N.cid")
        ->where("N.id=$id")
        ->find();
        $recommendList = M("News")->field("id,cid,thumb,title,DATE(create_time) as time,(init_click + click) as click")->where("status=1 and recommend=1")->order("id desc")->limit(3)->select();
        $this->_mainassign($cid);
        $this->assign("info",$info);
        $this->assign("recommend",$recommendList);
        $this->display();
    }

    public function search(){
        $newsModel = D("News");
        $listField = "id,cid,title,thumb,description,DATE_FORMAT(create_time,'%m-%d') as time,(init_click + click) as click";
        $keyword = I("get.keyword");
        $where = "status=1 and title like '%".$keyword."%'";
        $count = $newsModel->where($where)->count();
        $Page = new \Think\Page($count,10);
        $Page->setConfig("next","下一页");
        $Page->setConfig("prev","上一页");
        $show = $Page->show();
        $mainList = $newsModel
        ->field($listField)
        ->where($where)
        ->limit($Page->firstRow.",".$Page->listRows)
        ->order("id desc")
        ->select();
        $this->assign("count",$count);
        $this->assign("mainlist",$mainList);
        $this->_mainassign(null);
        $this->assign("page",$show);
        $this->display();
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