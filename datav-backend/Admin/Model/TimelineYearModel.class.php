<?php
namespace Admin\Model;
use \Admin\Common\BaseUploadModel;

class TimelineYearModel extends BaseUploadModel {
    protected $tableName = 'timeline_year';
    protected $dataOffset = 6;
    protected $tableField =array(
        "year"  =>"",
        "create_by" =>"",
        
        "A" =>"title",
        "B" =>"measure",
        "C" =>"jw_gross",
        "D" =>"jw_rise",
        "E" =>"zs_gross",
        "F" =>"zs_rise",
        "G" =>"kfq_gross",
        "H" =>"kfq_rise",
    );


    public function getList($pageInfo){

    }
}