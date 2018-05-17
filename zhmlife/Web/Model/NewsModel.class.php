<?php
namespace Web\Model;
use Think\Model;
class NewsModel extends Model {
    public $listField = "id,title,thumb,DATE_FORMAT(create_time,'%m-%d'),click";
    public function getHot($cid=null){
        $where = "1";
        if(!is_null($cid)){
            $where .= " and cid=$cid";
        }
        $list = M('News')->field($this->listField)->where($where)->order("click,id desc")->limit(5)->select();
        return $list;
    }
    //每周热搜
    public function getHotSearch($cid = null){
        $where = "1";
        if(!is_null($cid)){
            $where .= " and cid=$cid";
        }
        $list = M('News')->field($this->listField)->where($where)->order("id desc")->limit(5)->select();
        return $list;
    }
}