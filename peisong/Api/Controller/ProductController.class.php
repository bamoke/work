<?php
namespace Api\Controller;
use Think\Controller;
class ProductController extends Controller {
    protected $tableName = array(
        "类别"  =>"自定义类设置；where:自定义类型=配件类别",
        "产品"  =>"物品管理"
    );

    public function index(){
        $productModel = D("Product");
        // 获取类别
       $cateList =  $productModel->getCate();

        //获取产品
        $cateName = I("get.cate",'');
        $proInfo = $productModel->getList($cateName,"1","15");
       if($proInfo === false) {
            $backData = array(
                "code"   =>13001,
                "msg"    =>"系统错误"
            );
            $this->ajaxReturn($backData);
        }
        $backData = array(
            "code"   =>200,
            "msg"    =>"success",
            "data"=>array(
                "proList"  =>$proInfo["list"],
                "cateList"  =>$cateList,
                "pageInfo"  =>$proInfo["pageInfo"]
            )
        );
        $this->ajaxReturn($backData);
    }


    /**
     * 产品列表
     */
    public function vlist(){
        $page = I("get.page/d",1);
        $cateName = I("get.cate",'');
        $keywords = I("get.keyword",'');
        $proModel = D("Product");
        //获取产品
        if($keywords != '') {
            $proInfo = $proModel->search($keywords);
        }else {
            $proInfo = $proModel->getList($cateName,$page,"15");
        }
       if($proInfo === false) {
            $backData = array(
                "code"   =>13001,
                "msg"    =>"系统错误"
            );
            $this->ajaxReturn($backData);
        }
        $backData = array(
            "code"   =>200,
            "msg"    =>"success",
            "data"=>array(
                "proList"  =>$proInfo["list"],
                "pageInfo"  =>$proInfo["pageInfo"],
                "cate"      =>$cateName
            )
        );
        $this->ajaxReturn($backData);    
    }


}