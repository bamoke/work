<?php
namespace Admin\Model;

use \Admin\Common\BaseUploadModel;


class ComKeyModel extends BaseUploadModel
{
    protected $tableName = 'com_key';
    protected $dataOffset = 5;

    // 2021年特殊格式
    protected $tableField_for2021 = array(
        "year" => "",
        "month" => "",
        "create_by" => "",
        "data_date" =>"",

        "B" => "comname",
        "C" => "cate",
        "D" => "cur_gross",
        "E" => "prev_gross",
        "F" => "rise",
        "G" => "before_last_gross",
        "H" => "before_last_rise",
        "I" => "electric_gross",
        "J" => "electric_prev_gross",
        "K" => "electric_rise",
        "L" => "other",
        "M" =>"description"
    );

    protected $tableField = array(
        "year" => "",
        "month" => "",
        "create_by" => "",
        "data_date" =>"",

        "B" => "comname",
        "C" => "cate",
        "D" => "month_gross",
        "E" => "cur_gross",
        "F" => "prev_gross",
        "G" => "rise",


        "H" => "electric_gross",
        "I" => "electric_prev_gross",
        "J" => "electric_rise",
        "K" => "other",
        "L" =>"description"
    );


    public function getList($pageInfo)
    {

    }
}
