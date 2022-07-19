<?php
namespace Admin\Model;

use \Admin\Common\BaseUploadModel;

class HarbourGoodsModel extends BaseUploadModel {
    protected $tableName = 'harbour_goods';
    protected $dataOffset = 4;
    protected $tableField =array(
        "year"  =>"",
        "month"  =>"",
        "create_by" =>"",
        "data_date" =>"",
        "A" =>"title",
        "B" =>"gross",
        "C" =>"rise",
        "D" =>"proportion",

    );


    /**
     * for frontend api
     * 表格模式数据输出
     */
    public function getList($condition){


        $list = $this->field("title,gross,rise,proportion")->where($condition)->select();

        $columns = array(
            array(
                "title" =>"指标名称",
                "key"   =>"title",
                "width" =>100
            ),
            array(
                "title" =>"总量(万吨)",
                "key"   =>"gross"
            ),
            array(
                "title" =>"同比(%)",
                "key"   =>"rise"
            ),
            array(
                "title" =>"比重(%)",
                "key"   =>"proportion"
            )
        );
        return array(
            "measure"   =>"万吨",
            "columns"  =>$columns,
            "list"=>$list
        );
    }
}