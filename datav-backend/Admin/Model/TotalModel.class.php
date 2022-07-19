<?php
namespace Admin\Model;
use \Admin\Common\BaseUploadModel;

class TotalModel extends BaseUploadModel {
    protected $tableName = 'total';
    protected $dataOffset = 5;
    protected $tableField =array(
        "year"  =>"",
        "month"  =>"",
        "create_by" =>"",
        "data_date" =>"",
        "A" =>"title",
        "B" =>"parent_name",
        "C" =>"measure",
        "D" =>"jw_gross",
        "E" =>"jw_rise",
        "F" =>"zs_gross",
        "G" =>"zs_rise",
        "H" =>"kfq_gross",
        "I" =>"kfq_rise",
        "J" =>"before_last_rise",
        "K" =>"two_year_rise"
    );



    public function getList($pageInfo){

    }
}