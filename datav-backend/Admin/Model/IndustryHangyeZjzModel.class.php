<?php
namespace Admin\Model;

use \Admin\Common\BaseUploadModel;

class IndustryHangyeZjzModel extends BaseUploadModel {
    protected $tableName = 'industry_hangye_zjz';
    protected $dataOffset = 6;
    protected $tableField =array(
        "year"  =>"",
        "month"  =>"",
        "create_by" =>"",
        "data_date" =>"",
        "A" =>"title",
        "B" =>"comnum",
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
        $selfWhere = array(
            "title" =>array("neq","合计")
        );
        $where = array_merge($selfWhere,$condition);

        $list = $this->field("title,comnum,CEIL(jw_gross) as gross,jw_rise as rise")->where($where)->select();

        $columns = array(
            array(
                "title" =>"行业",
                "key"   =>"title"
            ),
            array(
                "title" =>"企业数",
                "key"   =>"comnum"
            ),
            array(
                "title" =>"总量(万元)",
                "key"   =>"gross"
            ),
            array(
                "title" =>"同比(%)",
                "key"   =>"rise"
            )
        );
        return array(
            "measure"   =>"万元",
            "columns"  =>$columns,
            "list"=>$list
        );
    }
}