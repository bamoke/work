<?php
namespace Admin\Model;

use \Admin\Common\BaseUploadModel;

class GdpNenghaoModel extends BaseUploadModel {
    protected $tableName = 'gdp_nenghao';
    protected $dataOffset = 6;
    protected $tableField =array(
        "year"  =>"",
        "month"  =>"",
        "create_by" =>"",
        "data_date" =>"",
        "A" =>"title",
        "B" =>"measure",
        "C" =>"jw_gross",
        "D" =>"jw_prev_gross",
        "E" =>"jw_rise",
        "F" =>"zs_gross",
        "G" =>"zs_prev_gross",
        "H" =>"zs_rise",
        "I" =>"kfq_gross",
        "J" =>"kfq_prev_gross",
        "K" =>"kfq_rise",
    );


    public function getList($condition){
        $result = $this
        ->field("title,measure,jw_gross,jw_prev_gross,jw_rise")
        ->where($condition)
        ->select();
        return $result;
    }
}