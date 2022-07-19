<?php
namespace Admin\Model;

use \Admin\Common\BaseUploadModel;

class EconomyDomesticModel extends BaseUploadModel {
    protected $tableName = 'economy_domestic';
    protected $dataOffset = 5;
    protected $tableField =array(
        "year"  =>"",
        "month"  =>"",
        "create_by" =>"",
        "data_date" =>"",
        "A" =>"area",
        "B" =>"title",
        "C" =>"measure",
        "D" =>"gross",
        "E" =>"rise"
    );

    public function getList($pageInfo){

    }
}