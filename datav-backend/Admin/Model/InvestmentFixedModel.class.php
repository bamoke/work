<?php
namespace Admin\Model;

use \Admin\Common\BaseUploadModel;

class InvestmentFixedModel extends BaseUploadModel {
    protected $tableName = 'investment_fixed';
    protected $dataOffset = 6;
    protected $tableField =array(
        "year"  =>"",
        "month"  =>"",
        "create_by" =>"",
        "data_date" =>"",
        "A" =>"title",
        "B" =>"cate_key",
        "C" =>"jw_gross",
        "D" =>"jw_rise",
        "E" =>"zs_gross",
        "F" =>"zs_rise",
        "G" =>"kfq_gross",
        "H" =>"kfq_rise",
    );


    /**
     * for frontend api
     * 表格模式数据输出
     */
    public function getList($condition){


        $list = $this->field("title,jw_gross as gross,jw_rise as rise")->where($condition)->select();

        $columns = array(
            array(
                "title" =>"指标名称",
                "key"   =>"title",
                "width" =>100
            ),
            array(
                "title" =>"总量(亿元)",
                "key"   =>"gross"
            ),
            array(
                "title" =>"同比(%)",
                "key"   =>"rise"
            ),
            array(
                "title" =>"查看项目",
                "slot"   =>"view"
            )
        );
        return array(
            "measure"   =>"亿元",
            "columns"  =>$columns,
            "list"=>$list
        );
    }
}