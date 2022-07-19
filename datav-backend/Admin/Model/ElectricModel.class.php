<?php
namespace Admin\Model;

use \Admin\Common\BaseUploadModel;

class ElectricModel extends BaseUploadModel {
    protected $tableName = 'electric';
    protected $dataOffset = 6;
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


    public function getList($condition){
        $result = $this
        ->field("title,measure,jw_gross as gross,jw_rise as rise")
        ->where($condition)
        ->select();

        return $result;

    }
}