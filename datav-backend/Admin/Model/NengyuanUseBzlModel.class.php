<?php
namespace Admin\Model;

use \Admin\Common\BaseUploadModel;

class NengyuanUseBzlModel extends BaseUploadModel {
    protected $tableName = 'nengyuan_use_bzl';
    protected $dataOffset = 6;
    protected $tableField =array(
        "year"  =>"",
        "month"  =>"",
        "create_by" =>"",
        "data_date" =>"",
        "A" =>"title",
        "B" =>"jw_gross",
        "C" =>"jw_rise",
        "D" =>"zs_gross",
        "E" =>"zs_rise",
        "F" =>"kfq_gross",
        "G" =>"kfq_rise",
    );

    public function getList($condition){
        $list = $this->field("title,jw_gross as gross,jw_rise as rise,measure")->where($condition)->select();
        $columns = array(
            array(
                "title" =>"标准量（吨标准煤，当量值）",
                "key"   =>"title",
            ),
            array(
                "title" =>"总量",
                "key"   =>"gross"
            ),
            array(
                "title" =>"同比(%)",
                "key"   =>"rise"
            ),

        );

        return array(
            "columns"   =>$columns,
            "list"      =>$list
        );
    }
}