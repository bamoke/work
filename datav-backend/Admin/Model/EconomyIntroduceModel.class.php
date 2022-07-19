<?php
namespace Admin\Model;

use Think\Model;

class EconomyIntroduceModel extends Model {
    protected $tableName = 'economy_introduce';



    public function getData($condition){

        $info = $this->field("*")->where($condition)->find();
        return $info;
    }
}