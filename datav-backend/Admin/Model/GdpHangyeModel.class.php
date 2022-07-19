<?php
namespace Admin\Model;

use \Admin\Common\BaseUploadModel;

class GdpHangyeModel extends BaseUploadModel {
    protected $tableName = 'gdp_hangye';
    protected $dataOffset = 6;
    protected $tableField =array(
        "year"  =>"",
        "month"  =>"",
        "create_by" =>"",
        "data_date" =>"",
        "A" =>"title",
        "B" =>"parent_name",
        "C" =>"gross",
        "D" =>"rise",
        "E" =>"proportion",
        "F" =>"gdp_gx",
        "G" =>"gdp_point",
    );


    public function getList($pageInfo){

    }
}