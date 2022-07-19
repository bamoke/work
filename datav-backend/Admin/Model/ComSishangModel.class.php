<?php
namespace Admin\Model;

use \Admin\Common\BaseUploadModel;

class ComSishangModel extends BaseUploadModel {
    protected $tableName = 'com_sishang';
    protected $dataOffset = 5;
    protected $tableField =array(
        "year"  =>"",
        "month"  =>"",
        "create_by" =>"",
        "data_date" =>"",
        "B" =>"comname",
        "C" =>"cate",
        "D" =>"gross_name",
        "E" =>"cur_gross",
        "F" =>"lj_gross",
        "G" =>"prev_year_gross",
        "H" =>"lj_rise",
        "I" =>"nenghao_gross",
        "J" =>"nenghao_rise",
        "K" =>"electric_gross",
        "L" =>"electric_rise",
        "M" =>"cy_cate",
        "N" =>"town",
        "O" =>"other",
    );


    public function getList($pageInfo){

    }
}