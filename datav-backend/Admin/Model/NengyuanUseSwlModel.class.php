<?php
namespace Admin\Model;

use \Admin\Common\BaseUploadModel;

class NengyuanUseSwlModel extends BaseUploadModel {
    protected $tableName = 'nengyuan_use_swl';
    protected $dataOffset = 6;
    protected $tableField =array(
        "year"  =>"",
        "month"  =>"",
        "create_by" =>"",
        "data_date" =>"",
        "A" =>"title",
        "B" =>"measure",
        "C" =>"jw_gross",
        "D" =>"jw_rise",
        "E" =>"zs_gross",
        "F" =>"zs_rise",
        "G" =>"kfq_gross",
        "H" =>"kfq_rise",
    );


    public function getList($condition){
        $list = $this->field("title,jw_gross as gross,jw_rise as rise,measure")->where($condition)->select();
        $columns = array(
            array(
                "title" =>"实物量",
                "key"   =>"title",
            ),
            array(
                "title" =>"计量单位",
                "key"   =>"measure"
            ),
            array(
                "title" =>"总量",
                "key"   =>"gross"
            ),
            array(
                "title" =>"同比(%)",
                "key"   =>"rise"
            ),

        );

        return array(
            "columns"   =>$columns,
            "list"      =>$list
        );
    }
}