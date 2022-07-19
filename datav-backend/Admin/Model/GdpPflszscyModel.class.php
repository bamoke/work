<?php
namespace Admin\Model;

use \Admin\Common\BaseUploadModel;

class GdpPflszscyModel extends BaseUploadModel {
    protected $tableName = 'gdp_pflszscy';
    protected $dataOffset= 6;
    protected $tableField =array(
        "year"  =>"",
        "month"  =>"",
        "create_by" =>"",
        "data_date" =>"",
        "A" =>"title",
        "B" =>"parent_name",
        "C" =>"jw_gross",
        "D" =>"jw_rise",
        "E" =>"zs_gross",
        "F" =>"zs_rise",
        "G" =>"kfq_gross",
        "H" =>"kfq_rise",
    );


    public function getList($condition,$type="jw"){
        if($type == "all") {
            $tableField = "*";
        }else {
            $tableField = "TRIM(title),".$type."_gross as gross,".$type."_rise as rise,measure";
        }
        $list = $this->field($tableField)->where($condition)->select();
        return array(
            "measure"   =>"亿元",
            "list"  =>$list
        );
    }
}