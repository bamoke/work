<?php
namespace Web\Model;
use Think\Model;
class NewsModel extends Model {
    public $listField = "id,cid,title,thumb,DATE_FORMAT(create_time,'%m-%d') as time,(init_click + click) as click";

    //推荐
    public function getRecommend($cid=null,$num=3){
        $where = "recommend=1";
        if(!is_null($cid)){
            $where .= " and cid=$cid";
        }
        $list = M('News')
        ->field($this
        ->listField)
        ->where($where)
        ->order("id desc")
        ->limit($num)
        ->select();
        return $list;  
    }
    //人气排行
    public function getHot($cid=null,$num=5){
        $where = "otherset=1";
        if(!is_null($cid)){
            $where .= " and cid=$cid";
        }
        $list = M('News')->field($this->listField)->where($where)->order("id desc")->limit($num)->select();
        return $list;
    }
    //每周热搜
    public function getHotSearch($cid = null,$num=5){
        $where = "otherset=2";
        if(!is_null($cid)){
            $where .= " and cid=$cid";
        }
        $list = M('News')->field($this->listField)->where($where)->order("id desc")->limit($num)->select();
        return $list;
    }
}