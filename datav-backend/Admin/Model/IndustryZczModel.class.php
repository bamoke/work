<?php
namespace Admin\Model;

use \Admin\Common\BaseUploadModel;

class IndustryZczModel extends BaseUploadModel {
    protected $tableName = 'industry_zcz';
    protected $dataOffset = 6;
    protected $tableField =array(
        "year"  =>"",
        "month"  =>"",
        "create_by" =>"",
        "data_date" =>"",
        "A" =>"title",
        "B" =>"cate_key",
        "C" =>"comnum",
        "D" =>"jw_gross",
        "E" =>"jw_rise",
        "F" =>"zs_gross",
        "G" =>"zs_rise",
        "H" =>"kfq_gross",
        "I" =>"kfq_rise",
    );


    public function getList($pageInfo){

    }
}