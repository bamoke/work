<?php
namespace Admin\Model;

use \Admin\Common\BaseUploadModel;

class GdpChanyeHistoryModel extends BaseUploadModel {
    protected $tableName = 'gdp_chanye_history';
    protected $dataOffset = 4;
    protected $tableField =array(
        "year"  =>"",
        "create_by" =>"",

        "A" =>"gdp_gross",
        "B" =>"one_gross",
        "C" =>"two_gross",
        "D" =>"three_gross",
        "E" =>"industry_gross",
        "F" =>"one_proportion",
        "G" =>"two_proportion",
        "H" =>"three_proportion",
        "I" =>"industry_proportion",
    );


    public function getList($condition){
        $list = $this->where()->select();
    }
}